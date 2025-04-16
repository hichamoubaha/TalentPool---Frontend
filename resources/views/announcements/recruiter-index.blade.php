@extends('layouts.app')

@section('title', 'Mes annonces')

@section('content')
    <div class="mb-6">
        <div class="flex justify-between items-center mb-4">
            <h1 class="text-3xl font-bold">Mes annonces</h1>
            <a href="{{ route('announcements.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition">
                Créer une annonce
            </a>
        </div>

        <div class="bg-white rounded-lg shadow overflow-hidden">
            <!-- Liste des annonces du recruteur -->
            @if($announcements->count() > 0)
                <div class="divide-y divide-gray-200">
                    @foreach($announcements as $announcement)
                        <div class="p-6 hover:bg-gray-50 transition duration-150">
                            <div class="flex justify-between items-start">
                                <div>
                                    <h2 class="text-xl font-semibold text-gray-800">{{ $announcement->title }}</h2>
                                    <p class="text-gray-600 mt-1">{{ $announcement->company }} • {{ $announcement->location }}</p>
                                    <p class="mt-2 text-gray-700 line-clamp-2">{{ Str::limit($announcement->description, 150) }}</p>
                                    <div class="mt-3 flex items-center">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $announcement->status == 'active' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                        {{ $announcement->status == 'active' ? 'Active' : 'Fermée' }}
                                    </span>
                                        <span class="text-sm text-gray-500 ml-2">
                                        Publiée le {{ $announcement->created_at->format('d/m/Y') }}
                                    </span>
                                        <span class="text-sm text-blue-600 ml-4">
                                        {{ $announcement->applications_count ?? '0' }} candidature(s)
                                    </span>
                                    </div>
                                </div>
                                <div class="flex space-x-2">
                                    <a href="{{ route('announcements.edit', $announcement) }}"
                                       class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition">
                                        Modifier
                                    </a>
                                    <a href="{{ route('applications.recruiter', ['announcement_id' => $announcement->id]) }}"
                                       class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700 transition">
                                        Voir candidatures
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="p-4 bg-gray-50 border-t">
                    {{ $announcements->links() }}
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
