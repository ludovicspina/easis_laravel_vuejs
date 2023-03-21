import axios from 'axios';

const apiClient = axios.create({
    baseURL: 'http://api.etheron.fr/api',
    withCredentials: true,
});


export default {
    login(email, password) {
        return apiClient.post('/login', {email, password});
    },

    // Ajoutez d'autres appels API ici

    // Exemple : récupérer les données d'un utilisateur
    getUser(id) {
        return apiClient.get(`/users/${id}`);
    },
};