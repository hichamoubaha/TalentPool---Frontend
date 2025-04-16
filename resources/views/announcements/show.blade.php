@extends('layouts.app')

@section('title', $announcement->title)

@section('content')
    <div class="mb-6">
        <div class="flex justify-between items-center mb-4">
            <h1 class="text-3xl font-bold">{{ $announcement->title }}</h1>
            @if(auth()->check() && auth()->user()->isCandidate())
                <a href="#apply-section" class="bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700 transition">
                    Postuler
                </a>
            @endif
        </div>

        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="p-6">
                <div class="flex items-center mb-4">
                    <div class="bg-blue-100 p-3 rounded-full mr-4">
                        <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-xl font-semibold">{{ $announcement->company }}</h2>
                        <p class="text-gray-600">{{ $announcement->location }}</p>
                    </div>
                </div>

                <div class="mb-6">
                    <h3 class="text-lg font-semibold mb-2">Description du poste</h3>
                    <div class="text-gray-700 prose max-w-none">
                        {{ $announcement->description }}
                    </div>
                </div>

                <div class="flex items-center text-sm text-gray-500">
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 mr-2">
                    Active
                </span>
                    <span>Publiée le {{ $announcement->created_at->format('d/m/Y') }}</span>
                </div>
            </div>

            @if(auth()->check() && auth()->user()->isCandidate())
                <div id="apply-section" class="p-6 bg-gray-50 border-t">
                    <h3 class="text-xl font-semibold mb-4">Postuler à cette annonce</h3>

                    <form action="{{ route('applications.store', $announcement) }}" method="POST" enctype="multipart/form-data" id="applicationForm">
                        @csrf

                        <div class="mb-4">
                            <label for="cv" class="block text-gray-700 mb-2">CV (PDF, DOC, DOCX, max 2MB)</label>
                            <input type="file" name="cv" id="cv" required
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md">
                            @error('cv')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="motivation_letter" class="block text-gray-700 mb-2">Lettre de motivation (PDF, DOC, DOCX, max 2MB)</label>
                            <input type="file" name="motivation_letter" id="motivation_letter" required
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md">
                            @error('motivation_letter')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition">
                            Envoyer ma candidature
                        </button>
                    </form>
                </div>
            @endif
        </div>
    </div>
@endsection

@section('scripts')
    @if(auth()->check() && auth()->user()->isCandidate())
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const form = document.getElementById('applicationForm');

                form.addEventListener('submit', function(e) {
                    const cv = document.getElementById('cv').files[0];
                    const motivationLetter = document.getElementById('motivation_letter').files[0];
                    let isValid = true;

                    // Validation des fichiers
                    if (!cv) {
                        isValid = false;
                        document.getElementById('cv').classList.add('border-red-500');
                    } else {
                        const validTypes = ['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'];
                        if (!validTypes.includes(cv.type) || cv.size > 2 * 1024 * 1024) {
                            isValid = false;
                            document.getElementById('cv').classList.add('border-red-500');
                        } else {
                            document.getElementById('cv').classList.remove('border-red-500');
                        }
                    }

                    if (!motivationLetter) {
                        isValid = false;
                        document.getElementById('motivation_letter').classList.add('border-red-500');
                    } else {
                        const validTypes = ['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'];
                        if (!validTypes.includes(motivationLetter.type) || motivationLetter.size > 2 * 1024 * 1024) {
                            isValid = false;
                            document.getElementById('motivation_letter').classList.add('border-red-500');
                        } else {
                            document.getElementById('motivation_letter').classList.remove('border-red-500');
                        }
                    }

                    if (!isValid) {
                        e.preventDefault();
                        alert('Veuillez vérifier les fichiers. Seuls les formats PDF, DOC, DOCX sont acceptés (max 2MB).');
                    }
                });
            });
        </script>
    @endif
@endsection
