import axios from 'axios';

const instance = axios.create({
  baseURL: 'http://localhost:8000', // Reemplaza con la URL y el puerto del servidor de Laravel
});

export default instance;