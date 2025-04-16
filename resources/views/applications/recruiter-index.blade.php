@extends('layouts.app')

@section('title', 'Candidatures reçues')

@section('content')
    <div class="mb-6">
        <h1 class="text-3xl font-bold mb-4">Candidatures reçues</h1>

        <div class="bg-white rounded-lg shadow overflow-hidden">
            <!-- Filtres -->
            <div class="p-4 bg-gray-50 border-b">
                <form action="{{ route('applications.recruiter') }}" method="GET" class="flex flex-wrap gap-4">
                    <div class="flex-grow">
                        <label for="announcement_id" class="block text-sm font-medium text-gray-700 mb-1">Filtrer par annonce</label>
                        <select name="announcement_id" id="announcement_id" onchange="this.form.submit()"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-500">
                            <option value="">Toutes les annonces</option>
                            @foreach($announcements as $announcement)
                                <option value="{{ $announcement->id }}" {{ request('announcement_id') == $announcement->id ? 'selected' : '' }}>
                                    {{ $announcement->title }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="flex-grow">
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Filtrer par statut</label>
                        <select name="status" id="status" onchange="this.form.submit()"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-500">
                            <option value="">Tous les statuts</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>En attente</option>
                            <option value="reviewed" {{ request('status') == 'reviewed' ? 'selected' : '' }}>En cours d'évaluation</option>
                            <option value="accepted" {{ request('status') == 'accepted' ? 'selected' : '' }}>Acceptées</option>
                            <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Refusées</option>
                        </select>
                    </div>
                </form>
            </div>

            <!-- Liste des candidatures -->
            @if($applications->count() > 0)
                <div class="divide-y divide-gray-200">
                    @foreach($applications as $application)
                        <div class="p-6 hover:bg-gray-50 transition duration-150">
                            <div class="flex justify-between items-start">
                                <div>
                                    <h2 class="text-xl font-semibold text-gray-800">{{ $application->user->name }}</h2>
                                    <p class="text-gray-600 mt-1">Candidature pour : {{ $application->announcement->title }}</p>
                                    <div class="mt-3 flex items-center">
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
                                        <span class="text-sm text-gray-500 ml-2">
                                        Reçue le {{ $application->created_at->format('d/m/Y') }}
                                    </span>
                                    </div>
                                    <div class="mt-3 flex space-x-4">
                                        <a href="{{ Storage::url($application->cv_path) }}" target="_blank" class="text-blue-600 hover:underline">
                                            Voir le CV
                                        </a>
                                        <a href="{{ Storage::url($application->motivation_letter_path) }}" target="_blank" class="text-blue-600 hover:underline">
                                            Voir la lettre de motivation
                                        </a>
                                    </div>
                                </div>
                                <div>
                                    <button type="button" class="status-update-btn bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition"
                                            data-application-id="{{ $application->id }}" data-current-status="{{ $application->status }}">
                                        Changer le statut
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="p-4 bg-gray-50 border-t">
                    {{ $applications->appends(request()->except('page'))->links() }}
                </div>
            @else
                <div class="p-6 text-center">
                    <p class="text-gray-500">Aucune candidature ne correspond à vos critères de recherche.</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Modal de changement de statut (caché par défaut) -->
    <div id="statusModal" class="fixed inset-0 flex items-center justify-center z-50 hidden">
        <div class="fixed inset-0 bg-black opacity-50"></div>
        <div class="bg-white rounded-lg p-6 w-full max-w-md z-10">
            <h3 class="text-xl font-semibold mb-4">Mettre à jour le statut</h3>

            <form id="statusUpdateForm" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label for="modal_status" class="block text-gray-700 mb-2">Nouveau statut</label>
                    <select name="status" id="modal_status" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-500">
                        <option value="pending">En attente</option>
                        <option value="reviewed">En cours d'évaluation</option>
                        <option value="accepted">Acceptée</option>
                        <option value="rejected">Refusée</option>
                    </select>
                </div>

                <div class="flex justify-end space-x-3">
                    <button type="button" id="cancelStatusUpdate" class="bg-gray-200 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-300 transition">
                        Annuler
                    </button>
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition">
                        Mettre à jour
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const modal = document.getElementById('statusModal');
            const form = document.getElementById('statusUpdateForm');
            const statusSelect = document.getElementById('modal_status');

            // Ouvrir la modal
            document.querySelectorAll('.status-update-btn').forEach(button => {
                button.addEventListener('click', function() {
                    const applicationId = this.getAttribute('data-application-id');
                    const currentStatus = this.getAttribute('data-current-status');

                    form.action = '/applications/' + applicationId + '/status';
                    statusSelect.value = currentStatus;

                    modal.classList.remove('hidden');
                });
            });

            // Fermer la modal
            document.getElementById('cancelStatusUpdate').addEventListener('click', function() {
                modal.classList.add('hidden');
            });

            // Cliquer en dehors pour fermer
            window.addEventListener('click', function(event) {
                if (event.target === modal) {
                    modal.classList.add('hidden');
                }
            });
        });
    </script>
@endsection
