import axios from 'axios';
import store from './store.js'

const $axios = axios.create({
    baseURL: '/api',
    headers: {
        // Authorization: localStorage.getItem('token') != 'null' ? 'Bearer ' + localStorage.getItem('token'):'',
        'Content-Type': 'application/json'
    }
});

// MEMANIPULASI OBJECT REQUEST SEBELUM / SETELAH DI KIRIM KE SERVER
$axios.interceptors.request.use (
    // DALAM KONTEKS INI CONFIG MERUJUK SEBAGAI OBJECT REQUEST
    function (config) {
        const token = store.state.token
        if (token) config.headers.Authorization = `Bearer ${token}`;
        return config;
    },
    function (error) {
        return Promise.reject (error);
    }
);
  
export default $axios;