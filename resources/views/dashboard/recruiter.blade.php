@extends('layouts.app')

@section('title', 'Tableau de bord recruteur')

@section('content')
    <div class="mb-6">
        <h1 class="text-3xl font-bold mb-4">Tableau de bord recruteur</h1>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
            <!-- Statistiques des annonces -->
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-semibold mb-4">Mes annonces</h2>
                <div class="flex items-center mb-4">
                    <div class="w-12 h-12 rounded-full bg-blue-100 flex items-center justify-center mr-4">
                        <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                    </div>
                    <div>
                        <div class="text-3xl font-bold">{{ $totalAnnouncements }}</div>
                        <div class="text-gray-500">Total des annonces</div>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div class="p-3 bg-green-50 rounded-lg">
                        <div class="text-xl font-semibold text-green-800">{{ $activeAnnouncements }}</div>
                        <div class="text-green-600">Actives</div>
                    </div>
                    <div class="p-3 bg-blue-50 rounded-lg">
                        <div class="text-xl font-semibold text-blue-800">{{ $totalApplications }}</div>
                        <div class="text-blue-600">Candidatures</div>
                    </div>
                </div>
                <div class="mt-4">
                    <a href="{{ route('announcements.create') }}" class="block w-full text-center bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition">
                        Ajouter une annonce
                    </a>
                </div>
            </div>

            <!-- Candidatures par statut -->
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-semibold mb-4">Candidatures par statut</h2>

                @if(count($applicationsByStatus) > 0)
                    <div class="space-y-3">
                        @foreach($applicationsByStatus as $statusGroup)
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                <span class="inline-flex items-center justify-center w-8 h-8 rounded-full
                                    @if($statusGroup->status == 'pending') bg-yellow-100 text-yellow-800
                                    @elseif($statusGroup->status == 'reviewed') bg-blue-100 text-blue-800
                                    @elseif($statusGroup->status == 'accepted') bg-green-100 text-green-800
                                    @else bg-red-100 text-red-800 @endif mr-3">
                                    {{ $statusGroup->count }}
                                </span>
                                    <span>
                                    @if($statusGroup->status == 'pending') En attente
                                        @elseif($statusGroup->status == 'reviewed') En cours d'évaluation
                                        @elseif($statusGroup->status == 'accepted') Acceptées
                                        @else Refusées @endif
                                </span>
                                </div>
                                <div class="w-1/2 bg-gray-200 rounded-full h-2">
                                    <div class="h-2 rounded-full
                                    @if($statusGroup->status == 'pending') bg-yellow-500
                                    @elseif($statusGroup->status == 'reviewed') bg-blue-500
                                    @elseif($statusGroup->status == 'accepted') bg-green-500
                                    @else bg-red-500 @endif"
                                         style="width: {{ ($statusGroup->count / $totalApplications) * 100 }}%"></div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500 text-center">Aucune candidature reçue</p>
                @endif

                <div class="mt-4">
                    <a href="{{ route('applications.recruiter') }}" class="block w-full text-center bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition">
                        Gérer les candidatures
                    </a>
                </div>
            </div>

            <!-- Actions rapides -->
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-semibold mb-4">Actions rapides</h2>
                <div class="space-y-3">
                    <a href="{{ route('announcements.create') }}" class="flex items-center p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                        <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center mr-3">
                            <svg class="h-4 w-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                        </div>
                        <span>Créer une nouvelle annonce</span>
                    </a>
                    <a href="{{ route('applications.recruiter', ['status' => 'pending']) }}" class="flex items-center p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                        <div class="w-8 h-8 rounded-full bg-yellow-100 flex items-center justify-center mr-3">
                            <svg class="h-4 w-4 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <span>Voir les candidatures en attente</span>
                    </a>
                    <a href="{{ route('announcements.recruiter') }}" class="flex items-center p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                        <div class="w-8 h-8 rounded-full bg-green-100 flex items-center justify-center mr-3">
                            <svg class="h-4 w-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                        </div>
                        <span>Gérer mes annonces</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Candidatures récentes -->
        <div class="bg-white rounded-lg shadow overflow-hidden mb-6">
            <div class="px-6 py-4 border-b">
                <h2 class="text-xl font-semibold">Candidatures récentes</h2>
            </div>

            @if(count($recentApplications) > 0)
                <div class="divide-y divide-gray-200">
                    @foreach($recentApplications as $application)
                        <div class="p-4 hover:bg-gray-50 transition duration-150">
                            <div class="flex justify-between items-center">
                                <div>
                                    <h3 class="font-semibold">{{ $application->user->name }}</h3>
                                    <p class="text-sm text-gray-600">{{ $application->announcement->title }}</p>
                                </div>
                                <div class="flex items-center">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                    @if($application->status == 'pending') bg-yellow-100 text-yellow-800
                                    @elseif($application->status == 'reviewed') bg-blue-100 text-blue-800
                                    @elseif($application->status == 'accepted') bg-green-100 text-green-800
                                    @else bg-red-100 text-red-800 @endif">
                                    @if($application->status == 'pending') En attente
                                    @elseif($application->status == 'reviewed') En cours d'évaluation
                                    @elseif($application->status == 'accepted') Acceptée
                                    @else Refusée @endif
                                </span>
                                    <span class="text-xs text-gray-500 ml-2">
                                    {{ $application->created_at->format('d/m/Y') }}
                                </span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="p-4 bg-gray-50 border-t">
                    <a href="{{ route('applications.recruiter') }}" class="text-blue-600 hover:underline">
                        Voir toutes les candidatures
                    </a>
                </div>
            @else
                <div class="p-6 text-center">
                    <p class="text-gray-500">Vous n'avez pas encore reçu de candidatures.</p>
                </div>
            @endif
        </div>

        <!-- Annonces récentes -->
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="px-6 py-4 border-b">
                <h2 class="text-xl font-semibold">Mes annonces récentes</h2>
            </div>

            @if(count($announcements) > 0)
                <div class="divide-y divide-gray-200">
                    @foreach($announcements as $announcement)
                        <div class="p-4 hover:bg-gray-50 transition duration-150">
                            <div class="flex justify-between items-center">
                                <div>
                                    <h3 class="font-semibold">{{ $announcement->title }}</h3>
                                    <p class="text-sm text-gray-600">{{ $announcement->company }} • {{ $announcement->location }}</p>
                                </div>
                                <div class="flex items-center">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $announcement->status == 'active' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                    {{ $announcement->status == 'active' ? 'Active' : 'Fermée' }}
                                </span>
                                    <span class="text-xs text-gray-500 ml-2">
                                    {{ $announcement->applications_count ?? '0' }} candidature(s)
                                </span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="p-4 bg-gray-50 border-t">
                    <a href="{{ route('announcements.recruiter') }}" class="text-blue-600 hover:underline">
                        Voir toutes mes annonces
                    </a>
                </div>
            @else
                <div class="p-6 text-center">
                    <p class="text-gray-500">Vous n'avez pas encore créé d'annonces.</p>
                    <a href="{{ route('announcements.create') }}" class="inline-block mt-4 bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition">
                        Créer ma première annonce
                    </a>
                </div>
            @endif
        </div>
    </div>
@endsection
