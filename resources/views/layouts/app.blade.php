<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TalentPool - @yield('title', 'Plateforme de Recrutement')</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    @yield('styles')
</head>
<body class="bg-gray-100 min-h-screen">
<!-- En-tête de navigation -->
<header class="bg-white shadow">
    <nav class="container mx-auto px-4 py-4 flex justify-between items-center">
        <a href="{{ route('home') }}" class="text-xl font-bold text-blue-600">TalentPool</a>

        <div class="flex space-x-4">
            <a href="{{ route('announcements.index') }}" class="text-gray-700 hover:text-blue-600">Annonces</a>

            @guest
                <a href="{{ route('login') }}" class="text-gray-700 hover:text-blue-600">Connexion</a>
                <a href="{{ route('register') }}" class="text-gray-700 hover:text-blue-600">Inscription</a>
            @else
                <a href="{{ route('dashboard') }}" class="text-gray-700 hover:text-blue-600">Tableau de bord</a>

                @if(auth()->user()->isCandidate())
                    <a href="{{ route('applications.candidate') }}" class="text-gray-700 hover:text-blue-600">Mes candidatures</a>
                @endif

                @if(auth()->user()->isRecruiter())
                    <a href="{{ route('announcements.recruiter') }}" class="text-gray-700 hover:text-blue-600">Mes annonces</a>
                    <a href="{{ route('applications.recruiter') }}" class="text-gray-700 hover:text-blue-600">Candidatures reçues</a>
                @endif

                <div class="relative" id="userMenu">
                    <button id="userMenuBtn" class="text-gray-700 hover:text-blue-600">
                        {{ auth()->user()->name }} ▼
                    </button>
                    <div id="userMenuDropdown" class="absolute right-0 mt-2 py-2 w-48 bg-white rounded-md shadow-lg hidden">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                Déconnexion
                            </button>
                        </form>
                    </div>
                </div>
            @endguest
        </div>
    </nav>
</header>

<!-- Messages de notification -->
@if (session('success'))
    <div id="notification" class="notification success">
        {{ session('success') }}
        <button class="close-btn">&times;</button>
    </div>
@endif

@if (session('error'))
    <div id="notification" class="notification error">
        {{ session('error') }}
        <button class="close-btn">&times;</button>
    </div>
@endif

<!-- Contenu principal -->
<main class="container mx-auto px-4 py-8">
    @yield('content')
</main>

<!-- Pied de page -->
<footer class="bg-white shadow-inner mt-auto">
    <div class="container mx-auto px-4 py-6 text-center text-gray-600">
        <p>&copy; {{ date('Y') }} TalentPool. Tous droits réservés.</p>
    </div>
</footer>

<!-- Scripts JS -->
<script src="{{ asset('js/app.js') }}"></script>
@yield('scripts')

<script>
    // Gestion du menu utilisateur
    document.getElementById('userMenuBtn')?.addEventListener('click', function() {
        document.getElementById('userMenuDropdown').classList.toggle('hidden');
    });

    // Cliquer en dehors du menu pour le fermer
    window.addEventListener('click', function(event) {
        if (!event.target.closest('#userMenu')) {
            const dropdown = document.getElementById('userMenuDropdown');
            if (dropdown && !dropdown.classList.contains('hidden')) {
                dropdown.classList.add('hidden');
            }
        }
    });

    // Fermer les notifications
    document.querySelectorAll('.notification .close-btn').forEach(button => {
        button.addEventListener('click', function() {
            this.parentElement.style.display = 'none';
        });
    });

    // Auto-fermeture des notifications après 5 secondes
    document.querySelectorAll('.notification').forEach(notification => {
        setTimeout(() => {
            notification.style.display = 'none';
        }, 5000);
    });
</script>
</body>
</html>
