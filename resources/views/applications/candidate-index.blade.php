@extends('layouts.app')

@section('title', 'Mes candidatures')

@section('content')
    <div class="mb-6">
        <h1 class="text-3xl font-bold mb-4">Mes candidatures</h1>

        <div class="bg-white rounded-lg shadow overflow-hidden">
            @if($applications->count() > 0)
                <div class="divide-y divide-gray-200">
                    @foreach($applications as $application)
                        <div class="p-6 hover:bg-gray-50 transition duration-150">
                            <div class="flex justify-between items-start">
                                <div>
                                    <h2 class="text-xl font-semibold text-gray-800">{{ $application->announcement->title }}</h2>
                                    <p class="text-gray-600 mt-1">{{ $application->announcement->company }} • {{ $application->announcement->location }}</p>
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
                                        Postulée le {{ $application->created_at->format('d/m/Y') }}
                                    </span>
                                    </div>
                                    <div class="mt-3 flex space-x-4">
                                        <a href="{{ Storage::url($application->cv_path) }}" target="_blank" class="text-blue-600 hover:underline">
                                            Voir mon CV
                                        </a>
                                        <a href="{{ Storage::url($application->motivation_letter_path) }}" target="_blank" class="text-blue-600 hover:underline">
                                            Voir ma lettre de motivation
                                        </a>
                                    </div>
                                </div>
                                <div>
                                    <button type="button" class="withdraw-btn bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-700 transition"
                                            data-application-id="{{ $application->id }}">
                                        Retirer ma candidature
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="p-4 bg-gray-50 border-t">
                    {{ $applications->links() }}
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

    <!-- Formulaire de suppression caché -->
    <form id="withdrawForm" method="POST" class="hidden">
        @csrf
        @method('DELETE')
    </form>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Gestion des boutons de retrait de candidature
            document.querySelectorAll('.withdraw-btn').forEach(button => {
                button.addEventListener('click', function() {
                    const applicationId = this.getAttribute('data-application-id');

                    if (confirm('Êtes-vous sûr de vouloir retirer cette candidature ? Cette action est irréversible.')) {
                        const form = document.getElementById('withdrawForm');
                        form.action = '/applications/' + applicationId;
                        form.submit();
                    }
                });
            });
        });
    </script>
@endsection
