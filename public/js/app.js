document.addEventListener('DOMContentLoaded', function() {
    // Initialisation des composants
    initNotifications();
    initDropdowns();
    initFormValidation();
    initFileInputs();
});

/**
 * Gestion des notifications
 */
function initNotifications() {
    // Fermer les notifications lorsqu'on clique sur le bouton de fermeture
    document.querySelectorAll('.notification .close-btn').forEach(button => {
        button.addEventListener('click', function() {
            const notification = this.closest('.notification');
            fadeOut(notification);
        });
    });

    // Auto-fermeture des notifications après 5 secondes
    document.querySelectorAll('.notification').forEach(notification => {
        setTimeout(() => {
            fadeOut(notification);
        }, 5000);
    });
}

/**
 * Animation de disparition pour un élément
 */
function fadeOut(element) {
    element.style.opacity = '1';

    (function fade() {
        if ((element.style.opacity -= '.1') < '0') {
            element.style.display = 'none';
        } else {
            requestAnimationFrame(fade);
        }
    })();
}

/**
 * Initialisation des menus déroulants
 */
function initDropdowns() {
    const userMenuBtn = document.getElementById('userMenuBtn');
    const userMenuDropdown = document.getElementById('userMenuDropdown');

    // Si le menu existe
    if (userMenuBtn && userMenuDropdown) {
        // Ouvrir/fermer le menu au clic
        userMenuBtn.addEventListener('click', function(e) {
            e.stopPropagation();
            userMenuDropdown.classList.toggle('hidden');
        });

        // Fermer le menu si on clique ailleurs
        document.addEventListener('click', function(e) {
            if (!userMenuBtn.contains(e.target) && !userMenuDropdown.contains(e.target)) {
                userMenuDropdown.classList.add('hidden');
            }
        });
    }
}

/**
 * Validation des formulaires
 */
function initFormValidation() {
    // Validation du formulaire d'inscription
    const registerForm = document.getElementById('registerForm');
    if (registerForm) {
        registerForm.addEventListener('submit', function(e) {
            const name = document.getElementById('name').value.trim();
            const email = document.getElementById('email').value.trim();
            const role = document.getElementById('role').value;
            const password = document.getElementById('password').value;
            const passwordConfirmation = document.getElementById('password_confirmation').value;
            let isValid = true;

            // Validation du nom
            if (!name) {
                markInvalid('name');
                isValid = false;
            } else {
                markValid('name');
            }

            // Validation de l'email
            if (!validateEmail(email)) {
                markInvalid('email');
                isValid = false;
            } else {
                markValid('email');
            }

            // Validation du rôle
            if (!role) {
                markInvalid('role');
                isValid = false;
            } else {
                markValid('role');
            }

            // Validation du mot de passe
            if (password.length < 8) {
                markInvalid('password');
                isValid = false;
            } else {
                markValid('password');
            }

            // Validation de la confirmation du mot de passe
            if (password !== passwordConfirmation) {
                markInvalid('password_confirmation');
                isValid = false;
            } else {
                markValid('password_confirmation');
            }

            if (!isValid) {
                e.preventDefault();
                showFormError('Veuillez corriger les erreurs dans le formulaire');
            }
        });
    }

    // Validation du formulaire de connexion
    const loginForm = document.getElementById('loginForm');
    if (loginForm) {
        loginForm.addEventListener('submit', function(e) {
            const email = document.getElementById('email').value.trim();
            const password = document.getElementById('password').value;
            let isValid = true;

            // Validation de l'email
            if (!validateEmail(email)) {
                markInvalid('email');
                isValid = false;
            } else {
                markValid('email');
            }

            // Validation du mot de passe
            if (!password) {
                markInvalid('password');
                isValid = false;
            } else {
                markValid('password');
            }

            if (!isValid) {
                e.preventDefault();
                showFormError('Veuillez saisir un email et un mot de passe valides');
            }
        });
    }

    // Validation du formulaire d'annonce
    const announcementForm = document.getElementById('announcementForm');
    if (announcementForm) {
        announcementForm.addEventListener('submit', function(e) {
            const title = document.getElementById('title').value.trim();
            const company = document.getElementById('company').value.trim();
            const location = document.getElementById('location').value.trim();
            const description = document.getElementById('description').value.trim();
            let isValid = true;

            // Validation des champs
            if (!title) { markInvalid('title'); isValid = false; } else { markValid('title'); }
            if (!company) { markInvalid('company'); isValid = false; } else { markValid('company'); }
            if (!location) { markInvalid('location'); isValid = false; } else { markValid('location'); }
            if (!description) { markInvalid('description'); isValid = false; } else { markValid('description'); }

            if (!isValid) {
                e.preventDefault();
                showFormError('Veuillez remplir tous les champs obligatoires');
            }
        });
    }

    // Validation du formulaire de candidature
    const applicationForm = document.getElementById('applicationForm');
    if (applicationForm) {
        applicationForm.addEventListener('submit', function(e) {
            const cv = document.getElementById('cv').files[0];
            const motivationLetter = document.getElementById('motivation_letter').files[0];
            let isValid = true;

            // Validation du CV
            if (!cv) {
                markInvalid('cv');
                isValid = false;
            } else if (!validateFileType(cv) || !validateFileSize(cv)) {
                markInvalid('cv');
                isValid = false;
            } else {
                markValid('cv');
            }

            // Validation de la lettre de motivation
            if (!motivationLetter) {
                markInvalid('motivation_letter');
                isValid = false;
            } else if (!validateFileType(motivationLetter) || !validateFileSize(motivationLetter)) {
                markInvalid('motivation_letter');
                isValid = false;
            } else {
                markValid('motivation_letter');
            }

            if (!isValid) {
                e.preventDefault();
                showFormError('Veuillez fournir des fichiers valides (PDF, DOC, DOCX, max 2MB)');
            }
        });
    }
}

/**
 * Validation de l'email
 */
function validateEmail(email) {
    const re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(String(email).toLowerCase());
}

/**
 * Validation du type de fichier
 */
function validateFileType(file) {
    const validTypes = ['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'];
    return validTypes.includes(file.type);
}

/**
 * Validation de la taille du fichier (max 2MB)
 */
function validateFileSize(file) {
    const maxSize = 2 * 1024 * 1024; // 2MB
    return file.size <= maxSize;
}

/**
 * Marquer un champ comme invalide
 */
function markInvalid(fieldId) {
    const field = document.getElementById(fieldId);
    if (field) {
        field.classList.add('border-red-500');
    }
}

/**
 * Marquer un champ comme valide
 */
function markValid(fieldId) {
    const field = document.getElementById(fieldId);
    if (field) {
        field.classList.remove('border-red-500');
    }
}

/**
 * Afficher une erreur de formulaire
 */
function showFormError(message) {
    // Chercher un conteneur d'erreur existant ou en créer un nouveau
    let errorContainer = document.querySelector('.form-error');

    if (!errorContainer) {
        errorContainer = document.createElement('div');
        errorContainer.className = 'form-error bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4';

        const form = document.querySelector('form');
        form.insertBefore(errorContainer, form.firstChild);
    }

    errorContainer.innerHTML = message;

    // Scroll vers le haut du formulaire
    window.scrollTo({ top: errorContainer.offsetTop - 20, behavior: 'smooth' });
}

/**
 * Initialiser les champs de fichier
 */
function initFileInputs() {
    document.querySelectorAll('.file-input').forEach(input => {
        const label = document.querySelector(`label[for="${input.id}"]`);

        if (label) {
            // Mettre à jour le texte du label quand un fichier est sélectionné
            input.addEventListener('change', function() {
                if (this.files.length > 0) {
                    label.textContent = this.files[0].name;
                } else {
                    label.textContent = label.dataset.default || 'Choisir un fichier';
                }
            });
        }
    });
}

/**
 * Créer une notification dynamiquement
 */
function createNotification(message, type = 'success') {
    // Supprimer les notifications existantes
    document.querySelectorAll('.notification').forEach(notification => {
        notification.remove();
    });

    // Créer la nouvelle notification
    const notification = document.createElement('div');
    notification.className = `notification ${type}`;

    notification.innerHTML = `
        ${message}
        <button class="close-btn">&times;</button>
    `;

    // Ajouter au body
    document.body.appendChild(notification);

    // Ajouter les événements
    notification.querySelector('.close-btn').addEventListener('click', function() {
        fadeOut(notification);
    });

    // Auto-fermeture après 5 secondes
    setTimeout(() => {
        fadeOut(notification);
    }, 5000);
}
