import axios from 'axios';


const apiClient = axios.create({
    baseURL: 'http://LaravelLearning.test/api',
    headers: {
        'Content-Type': 'application/json',
    },
});

const token = localStorage.getItem('token');
if (token) {
    apiClient.defaults.headers.common['Authorization'] = `Bearer ${token}`;
}

export default apiClient;
