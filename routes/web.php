<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;


Route::get('/', [UserController::class, 'index'])->name('home');
Route::get('/layanan', [UserController::class, 'layanan'])->name('layanan');

Route::get('/login', [AuthController::class, 'formLoginUser'])->name('login');
Route::post('/login', [AuthController::class, 'loginUser'])->middleware('throttle:5,1');
Route::get('/register', function() { return view('auth.register'); })->name('register');
Route::post('/register', [AuthController::class, 'registerUser']);

Route::get('/admin/login', [AuthController::class, 'formLoginAdmin']);
Route::post('/admin/login', [AuthController::class, 'loginAdmin']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/forgot-password', [AuthController::class, 'formForgotPassword']);
Route::post('/forgot-password', [AuthController::class, 'sendOtp']);
Route::get('/verify-otp', [AuthController::class, 'formVerifyOtp']);
Route::post('/reset-password', [AuthController::class, 'processResetPassword']);

Route::get('auth/google', [AuthController::class, 'redirectToGoogle'])->name('google.login');
Route::get('auth/google/callback', [AuthController::class, 'handleGoogleCallback']);

Route::middleware('auth:web')->group(function () {
Route::get('/riwayat', [UserController::class, 'riwayat'])->name('riwayat');
Route::post('/pesan', [UserController::class, 'storePesanan'])->name('pesan.store');
Route::get('/pesanan/bayar/{id}', [App\Http\Controllers\UserController::class, 'bayar'])->middleware('auth');
Route::get('/pesanan/sukses/{id}', [UserController::class, 'paymentSuccess'])->name('pesanan.sukses');
Route::delete('/pesanan/cancel/{id}', [UserController::class, 'cancelPesanan']);
});
Route::middleware('auth:admin')->group(function () {
Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
Route::get('/laporan/export', [AdminController::class, 'exportExcel'])->name('admin.laporan.export');
    
Route::get('/admin/layanan', [AdminController::class, 'layananIndex'])->name('admin.layanan.index'); 
Route::get('/admin/layanan/create', [AdminController::class, 'layananCreate'])->name('admin.layanan.create'); 
Route::post('/admin/layanan', [AdminController::class, 'layananStore'])->name('admin.layanan.store'); 
Route::get('/admin/layanan/{id}/edit', [AdminController::class, 'layananEdit'])->name('admin.layanan.edit'); // Form Edit
Route::put('/admin/layanan/{id}', [AdminController::class, 'layananUpdate'])->name('admin.layanan.update'); // Proses Update
Route::delete('/admin/layanan/{id}', [AdminController::class, 'layananDestroy'])->name('admin.layanan.destroy'); // Proses Hapus

    // Manajemen Pesanan
Route::get('/admin/pesanan', [AdminController::class, 'pesananIndex'])->name('admin.pesanan.index');
Route::get('/admin/pesanan/{id}/edit', [AdminController::class, 'pesananEdit'])->name('admin.pesanan.edit');
Route::put('/admin/pesanan/{id}', [AdminController::class, 'pesananUpdate'])->name('admin.pesanan.update');
Route::delete('/admin/pesanan/{id}', [AdminController::class, 'pesananDestroy'])->name('admin.pesanan.destroy');
Route::post('/admin/pesanan/{id}/update-status', [AdminController::class, 'updateStatus'])->name('admin.pesanan.status');
Route::post('/admin/pesanan/{id}/bayar-tunai', [AdminController::class, 'bayarTunai']);
Route::post('/admin/pesanan/{id}/refund', [AdminController::class, 'processRefund'])->name('admin.pesanan.refund');


Route::get('/admin/users', [AdminController::class, 'userAdminIndex'])->name('admin.users.index');
Route::get('/admin/users/create', [AdminController::class, 'userAdminCreate'])->name('admin.users.create');
Route::post('/admin/users', [AdminController::class, 'userAdminStore'])->name('admin.users.store');
Route::get('/admin/users/{id}/edit', [AdminController::class, 'userAdminEdit'])->name('admin.users.edit');
Route::put('/admin/users/{id}', [AdminController::class, 'userAdminUpdate'])->name('admin.users.update');
Route::delete('/admin/users/{id}', [AdminController::class, 'userAdminDestroy'])->name('admin.users.destroy');

    
Route::get('/admin/diskon', [AdminController::class, 'diskonIndex'])->name('admin.diskon');
Route::post('/admin/diskon/{id}/reset', [AdminController::class, 'resetBonus'])->name('admin.diskon.reset');
});