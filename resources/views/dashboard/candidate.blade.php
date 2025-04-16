@extends('layouts.app')

@section('title', 'Tableau de bord candidat')

@section('content')
    <div class="mb-6">
        <h1 class="text-3xl font-bold mb-4">Tableau de bord candidat</h1>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
            <!-- Statistiques des candidatures -->
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-semibold mb-4">Mes candidatures</h2>
                <div class="flex items-center mb-4">
                    <div class="w-12 h-12 rounded-full bg-blue-100 flex items-center justify-center mr-4">
                        <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <div>
                        <div class="text-3xl font-bold">{{ $totalApplications }}</div>
                        <div class="text-gray-500">Total des candidatures</div>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div class="p-3 bg-yellow-50 rounded-lg">
                        <div class="text-xl font-semibold text-yellow-800">{{ $pendingApplications }}</div>
                        <div class="text-yellow-600">En attente</div>
                    </div>
                    <div class="p-3 bg-green-50 rounded-lg">
                        <div class="text-xl font-semibold text-green-800">{{ $acceptedApplications }}</div>
                        <div class="text-green-600">Acceptées</div>
                    </div>
                </div>
            </div>

            <!-- Conseils pour les candidats -->
            <div class="bg-white rounded-lg shadow p-6 md:col-span-2">
                <h2 class="text-xl font-semibold mb-4">Conseils pour les candidats</h2>
                <ul class="space-y-3">
                    <li class="flex items-start">
                        <svg class="h-5 w-5 text-green-500 mr-2 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span>Personnalisez votre lettre de motivation pour chaque poste</span>
                    </li>
                    <li class="flex items-start">
                        <svg class="h-5 w-5 text-green-500 mr-2 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span>Vérifiez régulièrement les mises à jour de vos candidatures</span>
                    </li>
                    <li class="flex items-start">
                        <svg class="h-5 w-5 text-green-500 mr-2 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span>Mettez à jour votre CV pour mettre en valeur les compétences pertinentes</span>
                    </li>
                    <li class="flex items-start">
                        <svg class="h-5 w-5 text-green-500 mr-2 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span>Faites des recherches sur les entreprises avant de postuler</span>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Candidatures récentes -->
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="px-6 py-4 border-b">
                <h2 class="text-xl font-semibold">Candidatures récentes</h2>
            </div>

            @if(count($applications) > 0)
                <div class="divide-y divide-gray-200">
                    @foreach($applications as $application)
                        <div class="p-4 hover:bg-gray-50 transition duration-150">
                            <div class="flex justify-between items-center">
                                <div>
                                    <h3 class="font-semibold">{{ $application->announcement->title }}</h3>
                                    <p class="text-sm text-gray-600">{{ $application->announcement->company }}</p>
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
                    <a href="{{ route('applications.candidate') }}" class="text-blue-600 hover:underline">
                        Voir toutes mes candidatures
                    </a>
                </div>
            @else
                <div class="p-6 text-center">
                    <p class="text-gray-500">Vous n'avez pas encore postulé à des annonces.</p>
                    <a href="{{ route('announcements.index') }}" class="inline-block mt-4 bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition">
                        Voir les annonces disponibles
                    </a>
                </div>
            @endif
        </div>
    </div>
@endsection
