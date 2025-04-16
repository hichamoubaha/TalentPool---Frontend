const ApplicationsAPI = {
    /**
     * Récupère les candidatures de l'utilisateur connecté
     * @returns {Promise} Promesse résolue avec les données des candidatures
     */
    async getMyApplications() {
        try {
            const response = await fetch('/api/applications/me',
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
            console.error('Erreur lors de la récupération des candidatures:', error);
            throw error;
        }
    },

    /**
     * Récupère les candidatures pour une annonce spécifique (recruteur)
     * @param {number} announcementId L'identifiant de l'annonce
     * @returns {Promise} Promesse résolue avec les données des candidatures
     */
    async getApplicationsForAnnouncement(announcementId) {
        try {
            const response = await fetch(`/api/announcements/${announcementId}/applications`,
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
            console.error(`Erreur lors de la récupération des candidatures pour l'annonce ${announcementId}:`, error);
            throw error;
        }
    },

    /**
     * Envoie une candidature pour une annonce
     * @param {number} announcementId L'identifiant de l'annonce
     * @param {FormData} formData Les données du formulaire (cv, lettre de motivation)
     * @returns {Promise} Promesse résolue avec la candidature créée
     */
    async applyToAnnouncement(announcementId, formData) {
        try {
            // Ne pas ajouter Content-Type car FormData le définit automatiquement
            const options = AuthAPI.withAuth({
                method: 'POST',
                body: formData
            });

            // Supprimer Content-Type pour laisser le navigateur définir la boundary
            if (options.headers && options.headers['Content-Type']) {
                delete options.headers['Content-Type'];
            }

            const response = await fetch(`/api/announcements/${announcementId}/apply`, options);

            AuthAPI.handleAuthErrors(response);

            if (!response.ok) {
                const errorData = await response.json();
                throw new Error(errorData.message || `Erreur ${response.status}: ${response.statusText}`);
            }

            return await response.json();
        } catch (error) {
            console.error(`Erreur lors de l'envoi de la candidature pour l'annonce ${announcementId}:`, error);
            throw error;
        }
    },

    /**
     * Met à jour le statut d'une candidature
     * @param {number} applicationId L'identifiant de la candidature
     * @param {string} status Le nouveau statut (pending, reviewed, accepted, rejected)
     * @returns {Promise} Promesse résolue avec la candidature mise à jour
     */
    async updateApplicationStatus(applicationId, status) {
        try {
            const response = await fetch(`/api/applications/${applicationId}/status`,
                AuthAPI.withAuth({
                    method: 'PUT',
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ status })
                })
            );

            AuthAPI.handleAuthErrors(response);

            if (!response.ok) {
                const errorData = await response.json();
                throw new Error(errorData.message || `Erreur ${response.status}: ${response.statusText}`);
            }

            return await response.json();
        } catch (error) {
            console.error(`Erreur lors de la mise à jour du statut de la candidature ${applicationId}:`, error);
            throw error;
        }
    },

    /**
     * Retire une candidature
     * @param {number} applicationId L'identifiant de la candidature à retirer
     * @returns {Promise} Promesse résolue si le retrait est réussi
     */
    async withdrawApplication(applicationId) {
        try {
            const response = await fetch(`/api/applications/${applicationId}`,
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
            console.error(`Erreur lors du retrait de la candidature ${applicationId}:`, error);
            throw error;
        }
    }
};

// public/js/api/statistics.js

/**
 * Module de gestion des statistiques
 */
const StatisticsAPI = {
    /**
     * Récupère les statistiques du recruteur
     * @returns {Promise} Promesse résolue avec les statistiques
     */
    async getRecruiterStatistics() {
        try {
            const response = await fetch('/api/statistics/recruiter',
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
            console.error('Erreur lors de la récupération des statistiques recruteur:', error);
            throw error;
        }
    },

    /**
     * Récupère les statistiques administrateur
     * @returns {Promise} Promesse résolue avec les statistiques
     */
    async getAdminStatistics() {
        try {
            const response = await fetch('/api/statistics/admin',
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
            console.error('Erreur lors de la récupération des statistiques admin:', error);
            throw error;
        }
    }
};

