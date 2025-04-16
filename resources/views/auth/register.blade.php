@extends('layouts.app')

@section('title', 'Inscription')

@section('content')
    <div class="max-w-md mx-auto bg-white rounded-lg shadow p-6">
        <h2 class="text-2xl font-bold mb-6 text-center">Créer un compte</h2>

        <form method="POST" action="{{ route('register') }}" id="registerForm">
            @csrf

            <div class="mb-4">
                <label for="name" class="block text-gray-700 mb-2">Nom complet</label>
                <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-500">
                @error('name')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="email" class="block text-gray-700 mb-2">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-500">
                @error('email')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="role" class="block text-gray-700 mb-2">Je suis un</label>
                <select id="role" name="role" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-500">
                    <option value="">Sélectionnez votre rôle</option>
                    <option value="candidate" {{ old('role') == 'candidate' ? 'selected' : '' }}>Candidat</option>
                    <option value="recruiter" {{ old('role') == 'recruiter' ? 'selected' : '' }}>Recruteur</option>
                </select>
                @error('role')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
                <p class="text-sm text-gray-500 mt-1">Attention : vous ne pourrez pas changer de rôle ultérieurement.</p>
            </div>

            <div class="mb-4">
                <label for="password" class="block text-gray-700 mb-2">Mot de passe</label>
                <input id="password" type="password" name="password" required
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-500">
                @error('password')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="password_confirmation" class="block text-gray-700 mb-2">Confirmer le mot de passe</label>
                <input id="password_confirmation" type="password" name="password_confirmation" required
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-500">
            </div>

            <div class="mb-6">
                <button type="submit" class="w-full bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700 transition duration-200">
                    S'inscrire
                </button>
            </div>

            <div class="text-center">
                <p class="text-gray-600">
                    Déjà inscrit? <a href="{{ route('login') }}" class="text-blue-600 hover:underline">Se connecter</a>
                </p>
            </div>
        </form>
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('registerForm');

            form.addEventListener('submit', function(e) {
                const name = document.getElementById('name').value.trim();
                const email = document.getElementById('email').value.trim();
                const role = document.getElementById('role').value;
                const password = document.getElementById('password').value;
                const passwordConfirmation = document.getElementById('password_confirmation').value;
                let isValid = true;

                // Validation simple côté client
                if (!name) {
                    isValid = false;
                    document.getElementById('name').classList.add('border-red-500');
                } else {
                    document.getElementById('name').classList.remove('border-red-500');
                }

                if (!email || !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
                    isValid = false;
                    document.getElementById('email').classList.add('border-red-500');
                } else {
                    document.getElementById('email').classList.remove('border-red-500');
                }

                if (!role) {
                    isValid = false;
                    document.getElementById('role').classList.add('border-red-500');
                } else {
                    document.getElementById('role').classList.remove('border-red-500');
                }

                if (!password || password.length < 8) {
                    isValid = false;
                    document.getElementById('password').classList.add('border-red-500');
                } else {
                    document.getElementById('password').classList.remove('border-red-500');
                }

                if (password !== passwordConfirmation) {
                    isValid = false;
                    document.getElementById('password_confirmation').classList.add('border-red-500');
                } else {
                    document.getElementById('password_confirmation').classList.remove('border-red-500');
                }

                if (!isValid) {
                    e.preventDefault();
                }
            });
        });
    </script>
@endsection
