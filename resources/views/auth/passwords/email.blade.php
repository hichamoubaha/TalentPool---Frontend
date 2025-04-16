@extends('layouts.app')

@section('title', 'Réinitialisation du mot de passe')

@section('content')
    <div class="max-w-md mx-auto bg-white rounded-lg shadow p-6">
        <h2 class="text-2xl font-bold mb-6 text-center">Réinitialisation du mot de passe</h2>

        @if (session('status'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}" id="resetForm">
            @csrf

            <div class="mb-4">
                <label for="email" class="block text-gray-700 mb-2">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-500">
                @error('email')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <button type="submit" class="w-full bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700 transition duration-200">
                    Envoyer le lien de réinitialisation
                </button>
            </div>

            <div class="text-center">
                <a href="{{ route('login') }}" class="text-blue-600 hover:underline">
                    Retour à la connexion
                </a>
            </div>
        </form>
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('resetForm');

            form.addEventListener('submit', function(e) {
                const email = document.getElementById('email').value.trim();
                let isValid = true;

                if (!email || !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
                    isValid = false;
                    document.getElementById('email').classList.add('border-red-500');
                } else {
                    document.getElementById('email').classList.remove('border-red-500');
                }

                if (!isValid) {
                    e.preventDefault();
                }
            });
        });
    </script>
@endsection
