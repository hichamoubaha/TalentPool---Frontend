@extends('layouts.app')

@section('title', 'Réinitialiser le mot de passe')

@section('content')
    <div class="max-w-md mx-auto bg-white rounded-lg shadow p-6">
        <h2 class="text-2xl font-bold mb-6 text-center">Réinitialiser le mot de passe</h2>

        <form method="POST" action="{{ route('password.update') }}" id="passwordResetForm">
            @csrf

            <input type="hidden" name="token" value="{{ $token }}">

            <div class="mb-4">
                <label for="email" class="block text-gray-700 mb-2">Email</label>
                <input id="email" type="email" name="email" value="{{ $email ?? old('email') }}" required readonly
                       class="w-full px-3 py-2 border border-gray-300 rounded-md bg-gray-100">
                @error('email')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="password" class="block text-gray-700 mb-2">Nouveau mot de passe</label>
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

            <div class="mb-4">
                <button type="submit" class="w-full bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700 transition duration-200">
                    Réinitialiser le mot de passe
                </button>
            </div>
        </form>
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('passwordResetForm');

            form.addEventListener('submit', function(e) {
                const password = document.getElementById('password').value;
                const passwordConfirmation = document.getElementById('password_confirmation').value;
                let isValid = true;

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
