import axios from 'axios';
import Alpine from 'alpinejs'

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
document.addEventListener('DOMContentLoaded', () => {
    window.axios = axios;
    window.Alpine = Alpine;
    Alpine.start();
});