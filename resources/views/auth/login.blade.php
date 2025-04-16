@extends('layouts.app')

@section('title', 'Connexion')

@section('content')
    <div class="max-w-md mx-auto bg-white rounded-lg shadow p-6">
        <h2 class="text-2xl font-bold mb-6 text-center">Connexion</h2>

        <form method="POST" action="{{ route('login') }}" id="loginForm">
            @csrf

            <div class="mb-4">
                <label for="email" class="block text-gray-700 mb-2">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-500">
                @error('email')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="password" class="block text-gray-700 mb-2">Mot de passe</label>
                <input id="password" type="password" name="password" required
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-500">
                @error('password')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4 flex items-center">
                <input type="checkbox" name="remember" id="remember" class="mr-2">
                <label for="remember" class="text-gray-700">Se souvenir de moi</label>
            </div>

            <div class="mb-6">
                <button type="submit" class="w-full bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700 transition duration-200">
                    Se connecter
                </button>
            </div>

            <div class="text-center">
                <a href="{{ route('password.request') }}" class="text-blue-600 hover:underline">
                    Mot de passe oublié?
                </a>
                <p class="mt-2 text-gray-600">
                    Pas encore inscrit? <a href="{{ route('register') }}" class="text-blue-600 hover:underline">Créer un compte</a>
                </p>
            </div>
        </form>
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('loginForm');

            form.addEventListener('submit', function(e) {
                const email = document.getElementById('email').value.trim();
                const password = document.getElementById('password').value;
                let isValid = true;

                // Validation simple côté client
                if (!email || !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
                    isValid = false;
                    document.getElementById('email').classList.add('border-red-500');
                } else {
                    document.getElementById('email').classList.remove('border-red-500');
                }

                if (!password) {
                    isValid = false;
                    document.getElementById('password').classList.add('border-red-500');
                } else {
                    document.getElementById('password').classList.remove('border-red-500');
                }

                if (!isValid) {
                    e.preventDefault();
                }
            });
        });
    </script>
@endsection
