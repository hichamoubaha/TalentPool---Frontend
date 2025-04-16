@extends('layouts.app')

@section('title', 'Accueil')

@section('content')
    <div class="mb-6">
        <!-- Hero Section page -->
        <div class="bg-gradient-to-r from-blue-600 to-blue-800 text-white py-16 px-4 sm:px-6 mb-8 rounded-lg shadow-lg">
            <div class="max-w-3xl mx-auto text-center">
                <h1 class="text-4xl md:text-5xl font-bold mb-4">Trouvez les meilleurs talents ou votre emploi idéal</h1>
                <p class="text-xl mb-8">TalentPool connecte les candidats qualifiés aux entreprises qui recrutent.</p>
                <div class="flex flex-col sm:flex-row justify-center space-y-4 sm:space-y-0 sm:space-x-4">
                    @guest
                        <a href="{{ route('register') }}?role=candidate" class="bg-white text-blue-700 px-6 py-3 rounded-lg font-semibold shadow hover:bg-gray-100 transition duration-200">
                            Je suis un candidat
                        </a>
                        <a href="{{ route('register') }}?role=recruiter" class="bg-transparent border-2 border-white text-white px-6 py-3 rounded-lg font-semibold hover:bg-white hover:text-blue-700 transition duration-200">
                            Je suis un recruteur
                        </a>
                    @else
                        <a href="{{ route('dashboard') }}" class="bg-white text-blue-700 px-6 py-3 rounded-lg font-semibold shadow hover:bg-gray-100 transition duration-200">
                            Accéder à mon tableau de bord
                        </a>
                    @endguest
                </div>
            </div>
        </div>

        <!-- Features Section -->
        <div class="max-w-6xl mx-auto mb-16">
            <h2 class="text-3xl font-bold text-center mb-12">Une plateforme conçue pour un recrutement efficace</h2>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Feature 1 a -->
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Gestion des annonces</h3>
                    <p class="text-gray-600">Créez, modifiez et supprimez des annonces en quelques clics. Suivez toutes vos offres d'emploi depuis votre tableau de bord.</p>
                </div>

                <!-- Feature 2 -->
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Candidatures simplifiées</h3>
                    <p class="text-gray-600">Postulez facilement en joignant votre CV et lettre de motivation. Suivez l'état de vos candidatures en temps réel.</p>
                </div>

                <!-- Feature 3 -->
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Statistiques détaillées</h3>
                    <p class="text-gray-600">Recevez des statistiques sur vos annonces et candidatures pour optimiser votre processus de recrutement.</p>
                </div>
            </div>
        </div>

        <!-- How it works Section -->
        <div class="max-w-6xl mx-auto mb-16">
            <h2 class="text-3xl font-bold text-center mb-12">Comment ça marche ?</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
                <!-- For Recruiters -->
                <div class="bg-white p-8 rounded-lg shadow-md">
                    <h3 class="text-2xl font-semibold mb-6 text-blue-700">Pour les recruteurs</h3>
                    <ul class="space-y-6">
                        <li class="flex">
                            <div class="flex-shrink-0 w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center mr-4">
                                <span class="text-lg font-bold text-blue-600">1</span>
                            </div>
                            <div>
                                <h4 class="font-semibold mb-1">Créez un compte recruteur</h4>
                                <p class="text-gray-600">Inscrivez-vous en quelques secondes et démarrez votre campagne de recrutement.</p>
                            </div>
                        </li>
                        <li class="flex">
                            <div class="flex-shrink-0 w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center mr-4">
                                <span class="text-lg font-bold text-blue-600">2</span>
                            </div>
                            <div>
                                <h4 class="font-semibold mb-1">Publiez des offres d'emploi</h4>
                                <p class="text-gray-600">Créez des annonces détaillées pour attirer les candidats qualifiés.</p>
                            </div>
                        </li>
                        <li class="flex">
                            <div class="flex-shrink-0 w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center mr-4">
                                <span class="text-lg font-bold text-blue-600">3</span>
                            </div>
                            <div>
                                <h4 class="font-semibold mb-1">Gérez les candidatures</h4>
                                <p class="text-gray-600">Évaluez les candidats et suivez leur progression tout au long du processus.</p>
                            </div>
                        </li>
                    </ul>
                    <div class="mt-8 text-center">
                        <a href="{{ route('register') }}?role=recruiter" class="inline-block bg-blue-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-blue-700 transition">
                            Commencer comme recruteur
                        </a>
                    </div>
                </div>

                <!-- For Candidates -->
                <div class="bg-white p-8 rounded-lg shadow-md">
                    <h3 class="text-2xl font-semibold mb-6 text-green-700">Pour les candidats</h3>
                    <ul class="space-y-6">
                        <li class="flex">
                            <div class="flex-shrink-0 w-10 h-10 rounded-full bg-green-100 flex items-center justify-center mr-4">
                                <span class="text-lg font-bold text-green-600">1</span>
                            </div>
                            <div>
                                <h4 class="font-semibold mb-1">Créez votre profil</h4>
                                <p class="text-gray-600">Inscrivez-vous et préparez vos documents pour postuler facilement.</p>
                            </div>
                        </li>
                        <li class="flex">
                            <div class="flex-shrink-0 w-10 h-10 rounded-full bg-green-100 flex items-center justify-center mr-4">
                                <span class="text-lg font-bold text-green-600">2</span>
                            </div>
                            <div>
                                <h4 class="font-semibold mb-1">Parcourez les annonces</h4>
                                <p class="text-gray-600">Trouvez les offres qui correspondent à vos compétences et aspirations.</p>
                            </div>
                        </li>
                        <li class="flex">
                            <div class="flex-shrink-0 w-10 h-10 rounded-full bg-green-100 flex items-center justify-center mr-4">
                                <span class="text-lg font-bold text-green-600">3</span>
                            </div>
                            <div>
                                <h4 class="font-semibold mb-1">Postulez et suivez</h4>
                                <p class="text-gray-600">Envoyez votre candidature et suivez son évolution en temps réel.</p>
                            </div>
                        </li>
                    </ul>
                    <div class="mt-8 text-center">
                        <a href="{{ route('register') }}?role=candidate" class="inline-block bg-green-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-green-700 transition">
                            Commencer comme candidat
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- CTA Section -->
        <div class="bg-gray-100 rounded-lg p-8 text-center">
            <h2 class="text-2xl font-bold mb-4">Prêt à commencer votre aventure ?</h2>
            <p class="text-lg text-gray-700 mb-6">Rejoignez des milliers d'utilisateurs qui trouvent leur match parfait sur TalentPool.</p>
            <div class="flex flex-col sm:flex-row justify-center space-y-4 sm:space-y-0 sm:space-x-4">
                <a href="{{ route('announcements.index') }}" class="bg-blue-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-blue-700 transition">
                    Voir les annonces
                </a>
                @guest
                    <a href="{{ route('register') }}" class="bg-gray-800 text-white px-6 py-3 rounded-lg font-semibold hover:bg-gray-900 transition">
                        Créer un compte
                    </a>
                @endguest
            </div>
        </div>
    </div>
@endsection
