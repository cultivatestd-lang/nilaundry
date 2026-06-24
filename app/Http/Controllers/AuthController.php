<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Pelanggan;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    // --- ADMIN ---
    public function formLoginAdmin() { return view('auth.login-admin'); }

    public function loginAdmin(Request $request) {
        if (Auth::guard('admin')->attempt(['username' => $request->username, 'password' => $request->password])) {
            return redirect()->intended('/admin/dashboard');
        }
        return back()->with('error', 'Login Gagal!');
    }

    // --- PELANGGAN ---
    public function formLoginUser() { return view('auth.login-user'); }
    
    public function loginUser(Request $request) {
        // 1. RATE LIMITING
        $throttleKey = 'login-user:' . $request->ip();
        
        if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
            $seconds = RateLimiter::availableIn($throttleKey);
            return back()->with('error', "Terlalu banyak percobaan. Tunggu $seconds detik lagi.");
        }

        // 2. CARI USER (Nama atau No HP)
        $credential = $request->input('nama');
        
        $user = Pelanggan::where('nama', $credential)
                ->orWhere('no_hp', $credential)
                ->first();

        // 3. CEK PASSWORD & LOGIN
        if ($user && Hash::check($request->password, $user->password)) {
            
            // --- BAGIAN PENTING REMEMBER ME ---
            // Mengambil nilai checkbox (true jika dicentang, false jika tidak)
            $remember = $request->boolean('remember'); 
            
            // Login manual dengan parameter remember
            // Param 1: Object User
            // Param 2: Boolean (Ingat Saya?)
            Auth::guard('web')->login($user, $remember);
            
            // ----------------------------------
            
            RateLimiter::clear($throttleKey);
            $request->session()->regenerate();

            return redirect('/'); 
        }

        RateLimiter::hit($throttleKey, 60);
        return back()->with('error', 'Akun tidak ditemukan atau Password salah');
    }

    public function registerUser(Request $request) {
        Pelanggan::create([
            'nama' => $request->nama,
            'password' => Hash::make($request->password), 
            'no_hp' => $request->no_hp,
            'alamat' => $request->alamat
        ]);
        return redirect('/login')->with('success', 'Berhasil daftar, silakan login');
    }
    
    public function logout() {
        if(Auth::guard('admin')->check()){
            Auth::guard('admin')->logout();
            return redirect('/admin/login');
        }
        Auth::guard('web')->logout();
        
        // Logout kembali ke halaman utama (karena sekarang halaman utama publik)
        return redirect('/'); 
    }

    public function formForgotPassword() {
        return view('auth.forgot-password');
    }

    // 2. Proses Kirim OTP
    public function sendOtp(Request $request) {
        $request->validate([
            'no_hp' => 'required',
        ]);

        // Cari user berdasarkan No HP
        $user = Pelanggan::where('no_hp', $request->no_hp)->first();

        if (!$user) {
            return back()->with('error', 'Nomor HP tidak terdaftar dalam sistem kami.');
        }

        // Generate 6 digit OTP
        $otp = rand(100000, 999999);

        // Simpan OTP & ID User ke Session (Berlaku 5 menit)
        Session::put('reset_otp', $otp);
        Session::put('reset_user_id', $user->id_pelanggan); // Sesuaikan primary key tabel Anda
        Session::put('reset_expires', now()->addMinutes(5));

        // Pesan WhatsApp
        $message = "*RESET PASSWORD NI LAUNDRY*\n\n";
        $message .= "Halo {$user->nama},\n";
        $message .= "Kode OTP Anda adalah: *{$otp}*\n\n";
        $message .= "Kode ini berlaku selama 5 menit. Jangan berikan kepada siapapun.";

        // Kirim via Fonnte
        $this->kirimPesanFonnte($user->no_hp, $message);

        // Arahkan ke halaman input OTP
        return redirect('/verify-otp')->with('success', 'Kode OTP telah dikirim ke WhatsApp Anda.');
    }

    // 3. Tampilkan Halaman Input OTP & Password Baru
    public function formVerifyOtp() {
        if (!Session::has('reset_otp')) {
            return redirect('/forgot-password')->with('error', 'Sesi habis, silakan ulangi permintaan.');
        }
        return view('auth.verify-otp');
    }

    // 4. Proses Verifikasi & Ganti Password
    public function processResetPassword(Request $request) {
        $request->validate([
            'otp' => 'required|numeric',
            'password' => 'required|min:5'
        ]);

        // Cek Session
        $sessionOtp = Session::get('reset_otp');
        $sessionExpires = Session::get('reset_expires');
        $userId = Session::get('reset_user_id');

        // Validasi
        if (!$sessionOtp || now()->greaterThan($sessionExpires)) {
            return redirect('/forgot-password')->with('error', 'Kode OTP kadaluarsa. Silakan minta ulang.');
        }

        if ($request->otp != $sessionOtp) {
            return back()->with('error', 'Kode OTP salah!');
        }

        // Update Password
        $user = Pelanggan::find($userId);
        if ($user) {
            $user->update([
                'password' => Hash::make($request->password)
            ]);
            
            // Hapus Session
            Session::forget(['reset_otp', 'reset_user_id', 'reset_expires']);

            return redirect('/login')->with('success', 'Password berhasil diubah! Silakan login.');
        }

        return back()->with('error', 'Terjadi kesalahan sistem.');
    }

    // --- FUNGSI PRIVAT FONNTE ---
    private function kirimPesanFonnte($target, $pesan) {
        $token = 'Z4RJR27QU6JaxbXVAt2a'; 

        $curl = curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_URL => 'https://api.fonnte.com/send',
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'POST',
          CURLOPT_POSTFIELDS => array(
            'target' => $target,
            'message' => $pesan,
            'countryCode' => '62',
          ),
          CURLOPT_HTTPHEADER => array(
            "Authorization: $token"
          ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);
        
        return $response;
    }

    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    // 2. Handle balikan dari Google
    public function handleGoogleCallback()
    {
        try {
            // Ambil data user dari Google
            $googleUser = Socialite::driver('google')->user();
            
            // Cek apakah user ini sudah ada di database (berdasarkan google_id atau email)
            $user = Pelanggan::where('google_id', $googleUser->getId())
                            ->orWhere('email', $googleUser->getEmail())
                            ->first();

            if(!$user) {
                // Kalo belum ada, Buat User Baru Otomatis
                $user = Pelanggan::create([
                    'nama' => $googleUser->getName(),
                    'email' => $googleUser->getEmail(),
                    'google_id' => $googleUser->getId(),
                    'password' => Hash::make(Str::random(24)), // Password acak biar aman
                    // 'no_hp' => ... (Google jarang kasih no hp, nanti minta user update profile)
                ]);
            } else {
                // Kalo sudah ada tapi belum punya google_id, kita update
                if (!$user->google_id) {
                    $user->update(['google_id' => $googleUser->getId()]);
                }
            }

            // Login-kan user
            Auth::guard('web')->login($user, true); // true = Remember Me
            
            return redirect()->intended('/');

        } catch (\Exception $e) {
            // Jika user cancel atau error
            return redirect('/login')->with('error', 'Login Google Gagal, silakan coba lagi.');
        }
    }
}