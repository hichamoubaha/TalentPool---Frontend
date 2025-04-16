@extends('layouts.app')

@section('title', 'Annonces disponibles')

@section('content')
    <div class="mb-6">
        <h1 class="text-3xl font-bold mb-4">Annonces disponibles</h1>

        <div class="bg-white rounded-lg shadow overflow-hidden">
            <!-- Barre de recherche -->
            <div class="p-4 bg-gray-50 border-b">
                <form action="{{ route('announcements.index') }}" method="GET" class="flex items-center">
                    <input type="text" name="search" placeholder="Rechercher..." value="{{ request('search') }}"
                           class="flex-grow px-4 py-2 border border-gray-300 rounded-l-md focus:outline-none focus:border-blue-500">
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-r-md hover:bg-blue-700">
                        Rechercher
                    </button>
                </form>
            </div>

            <!-- Liste des annonces -->
            @if($announcements->count() > 0)
                <div class="divide-y divide-gray-200">
                    @foreach($announcements as $announcement)
                        <div class="p-6 hover:bg-gray-50 transition duration-150">
                            <div class="flex justify-between items-start">
                                <div>
                                    <h2 class="text-xl font-semibold text-gray-800">{{ $announcement->title }}</h2>
                                    <p class="text-gray-600 mt-1">{{ $announcement->company }} • {{ $announcement->location }}</p>
                                    <p class="mt-2 text-gray-700 line-clamp-2">{{ Str::limit($announcement->description, 150) }}</p>
                                    <div class="mt-3">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        Active
                                    </span>
                                        <span class="text-sm text-gray-500 ml-2">
                                        Publiée le {{ $announcement->created_at->format('d/m/Y') }}
                                    </span>
                                    </div>
                                </div>
                                <a href="{{ route('announcements.show', $announcement) }}"
                                   class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition">
                                    Voir détails
                                </a>
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
                    <p class="text-gray-500">Aucune annonce ne correspond à votre recherche.</p>
                </div>
            @endif
        </div>
    </div>
@endsection
