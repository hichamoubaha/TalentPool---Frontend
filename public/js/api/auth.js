const AuthAPI = {
    /**
     * Stocke le token JWT dans le localStorage
     * @param {string} token Le token JWT à stocker
     */
    setToken(token) {
        localStorage.setItem('auth_token', token);
    },

    /**
     * Récupère le token JWT depuis le localStorage
     * @returns {string|null} Le token JWT ou null si inexistant
     */
    getToken() {
        return localStorage.getItem('auth_token');
    },

    /**
     * Supprime le token JWT du localStorage
     */
    removeToken() {
        localStorage.removeItem('auth_token');
    },

    /**
     * Vérifie si un utilisateur est authentifié
     * @returns {boolean} True si un token est présent, false sinon
     */
    isAuthenticated() {
        return !!this.getToken();
    },

    /**
     * Ajoute le token d'authentification aux en-têtes des requêtes fetch
     * @param {Object} options Les options de la requête fetch
     * @returns {Object} Les options avec l'en-tête Authorization
     */
    withAuth(options = {}) {
        const token = this.getToken();
        if (!token) return options;

        options.headers = options.headers || {};
        options.headers['Authorization'] = `Bearer ${token}`;

        return options;
    },

    /**
     * Gère les erreurs d'authentification dans les réponses
     * @param {Response} response La réponse de fetch à vérifier
     */
    handleAuthErrors(response) {
        if (response.status === 401) {
            // Token expiré ou invalide, déconnecter l'utilisateur
            this.removeToken();
            window.location.href = '/login';
        }
        return response;
    }
};

// public/js/api/announcements.js

/**
 * Module de gestion des annonces
 */
const AnnouncementsAPI = {
    /**
     * Récupère la liste des annonces avec filtres optionnels
     * @param {Object} filters Les filtres à appliquer (search, page, etc.)
     * @returns {Promise} Promesse résolue avec les données des annonces
     */
    async getAnnouncements(filters = {}) {
        // Construire la query string à partir des filtres
        const queryParams = new URLSearchParams();
        Object.entries(filters).forEach(([key, value]) => {
            if (value) queryParams.set(key, value);
        });

        const queryString = queryParams.toString() ? `?${queryParams.toString()}` : '';

        try {
            const response = await fetch(`/api/announcements${queryString}`,
                AuthAPI.withAuth({
                    method: 'GET',
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    }
                })
            );

            AuthAPI.handleAuthErrors(response);

            if (!response.ok) {
                throw new Error(`Erreur ${response.status}: ${response.statusText}`);
            }

            return await response.json();
        } catch (error) {
            console.error('Erreur lors de la récupération des annonces:', error);
            throw error;
        }
    },

    /**
     * Récupère une annonce spécifique
     * @param {number} id L'identifiant de l'annonce
     * @returns {Promise} Promesse résolue avec les données de l'annonce
     */
    async getAnnouncement(id) {
        try {
            const response = await fetch(`/api/announcements/${id}`,
                AuthAPI.withAuth({
                    method: 'GET',
                    headers: {
                        'Accept': 'application/json'
                    }
                })
            );

            AuthAPI.handleAuthErrors(response);

            if (!response.ok) {
                throw new Error(`Erreur ${response.status}: ${response.statusText}`);
            }

            return await response.json();
        } catch (error) {
            console.error(`Erreur lors de la récupération de l'annonce ${id}:`, error);
            throw error;
        }
    },

    /**
     * Crée une nouvelle annonce
     * @param {Object} announcementData Les données de l'annonce à créer
     * @returns {Promise} Promesse résolue avec l'annonce créée
     */
    async createAnnouncement(announcementData) {
        try {
            const response = await fetch('/api/announcements',
                AuthAPI.withAuth({
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(announcementData)
                })
            );

            AuthAPI.handleAuthErrors(response);

            if (!response.ok) {
                const errorData = await response.json();
                throw new Error(errorData.message || `Erreur ${response.status}: ${response.statusText}`);
            }

            return await response.json();
        } catch (error) {
            console.error('Erreur lors de la création de l\'annonce:', error);
            throw error;
        }
    },

    /**
     * Met à jour une annonce existante
     * @param {number} id L'identifiant de l'annonce à mettre à jour
     * @param {Object} announcementData Les nouvelles données de l'annonce
     * @returns {Promise} Promesse résolue avec l'annonce mise à jour
     */
    async updateAnnouncement(id, announcementData) {
        try {
            const response = await fetch(`/api/announcements/${id}`,
                AuthAPI.withAuth({
                    method: 'PUT',
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(announcementData)
                })
            );

            AuthAPI.handleAuthErrors(response);

            if (!response.ok) {
                const errorData = await response.json();
                throw new Error(errorData.message || `Erreur ${response.status}: ${response.statusText}`);
            }

            return await response.json();
        } catch (error) {
            console.error(`Erreur lors de la mise à jour de l'annonce ${id}:`, error);
            throw error;
        }
    },

    /**
     * Supprime une annonce
     * @param {number} id L'identifiant de l'annonce à supprimer
     * @returns {Promise} Promesse résolue si la suppression est réussie
     */
    async deleteAnnouncement(id) {
        try {
            const response = await fetch(`/api/announcements/${id}`,
                AuthAPI.withAuth({
                    method: 'DELETE',
                    headers: {
                        'Accept': 'application/json'
                    }
                })
            );

            AuthAPI.handleAuthErrors(response);

            if (!response.ok) {
                const errorData = await response.json();
                throw new Error(errorData.message || `Erreur ${response.status}: ${response.statusText}`);
            }

            return true;
        } catch (error) {
            console.error(`Erreur lors de la suppression de l'annonce ${id}:`, error);
            throw error;
        }
    }
};
