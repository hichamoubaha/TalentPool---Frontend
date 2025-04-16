@extends('layouts.app')

@section('title', 'Modifier une annonce')

@section('content')
    <div class="mb-6">
        <div class="flex justify-between items-center mb-4">
            <h1 class="text-3xl font-bold">Modifier l'annonce</h1>
            <a href="{{ route('announcements.recruiter') }}" class="bg-gray-200 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-300 transition">
                Retour aux annonces
            </a>
        </div>

        <div class="bg-white rounded-lg shadow overflow-hidden">
            <form action="{{ route('announcements.update', $announcement) }}" method="POST" id="editAnnouncementForm" class="p-6">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label for="title" class="block text-gray-700 mb-2">Titre de l'annonce</label>
                    <input type="text" name="title" id="title" value="{{ old('title', $announcement->title) }}" required
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-500">
                    @error('title')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="company" class="block text-gray-700 mb-2">Entreprise</label>
                    <input type="text" name="company" id="company" value="{{ old('company', $announcement->company) }}" required
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-500">
                    @error('company')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="location" class="block text-gray-700 mb-2">Localisation</label>
                    <input type="text" name="location" id="location" value="{{ old('location', $announcement->location) }}" required
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-500">
                    @error('location')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="description" class="block text-gray-700 mb-2">Description du poste</label>
                    <textarea name="description" id="description" rows="8" required
                              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-500">{{ old('description', $announcement->description) }}</textarea>
                    @error('description')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="status" class="block text-gray-700 mb-2">Statut</label>
                    <select name="status" id="status" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-500">
                        <option value="active" {{ old('status', $announcement->status) == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="closed" {{ old('status', $announcement->status) == 'closed' ? 'selected' : '' }}>Fermée</option>
                    </select>
                    @error('status')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex space-x-4">
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition">
                        Mettre à jour
                    </button>

                    <button type="button" id="deleteBtn" class="bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-700 transition">
                        Supprimer l'annonce
                    </button>
                </div>
            </form>

            <!-- Formulaire de suppression caché -->
            <form id="deleteForm" action="{{ route('announcements.destroy', $announcement) }}" method="POST" class="hidden">
                @csrf
                @method('DELETE')
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('editAnnouncementForm');

            form.addEventListener('submit', function(e) {
                const title = document.getElementById('title').value.trim();
                const company = document.getElementById('company').value.trim();
                const location = document.getElementById('location').value.trim();
                const description = document.getElementById('description').value.trim();
                let isValid = true;

                // Validation côte client
                if (!title) {
                    isValid = false;
                    document.getElementById('title').classList.add('border-red-500');
                } else {
                    document.getElementById('title').classList.remove('border-red-500');
                }

                if (!company) {
                    isValid = false;
                    document.getElementById('company').classList.add('border-red-500');
                } else {
                    document.getElementById('company').classList.remove('border-red-500');
                }

                if (!location) {
                    isValid = false;
                    document.getElementById('location').classList.add('border-red-500');
                } else {
                    document.getElementById('location').classList.remove('border-red-500');
                }

                if (!description) {
                    isValid = false;
                    document.getElementById('description').classList.add('border-red-500');
                } else {
                    document.getElementById('description').classList.remove('border-red-500');
                }

                if (!isValid) {
                    e.preventDefault();
                    alert('Veuillez remplir tous les champs obligatoires.');
                }
            });

            // Gestion du bouton de suppression
            document.getElementById('deleteBtn').addEventListener('click', function() {
                if (confirm('Êtes-vous sûr de vouloir supprimer cette annonce ? Cette action est irréversible.')) {
                    document.getElementById('deleteForm').submit();
                }
            });
        });
    </script>
@endsection
