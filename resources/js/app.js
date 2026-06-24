import './bootstrap';
import Lenis from 'lenis';
import Swal from 'sweetalert2';
import Alpine from 'alpinejs';
import collapse from '@alpinejs/collapse';
import gsap from 'gsap';

window.gsap = gsap;

window.Alpine = Alpine;
Alpine.plugin(collapse); 
Alpine.start();

import AOS from 'aos';

window.Swal = Swal;

AOS.init({
    once: true,
    duration: 600,
    offset: 50,
});

const lenis = new Lenis({
    duration: 1.2,
    easing: (t) => Math.min(1, 1.001 - Math.pow(2, -10 * t)), 
    autoRaf: true, 
});

console.log('All libraries loaded via NPM (No CDN)');