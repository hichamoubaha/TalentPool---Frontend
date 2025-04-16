@extends('layouts.app')

@section('title', 'Tableau de bord administrateur')

@section('content')
    <div class="mb-6">
        <h1 class="text-3xl font-bold mb-4">Tableau de bord administrateur</h1>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
            <!-- Statistiques utilisateurs -->
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-semibold mb-4">Utilisateurs</h2>
                <div class="flex items-center mb-4">
                    <div class="w-12 h-12 rounded-full bg-blue-100 flex items-center justify-center mr-4">
                        <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <div class="text-3xl font-bold">{{ $totalUsers }}</div>
                        <div class="text-gray-500">Total des utilisateurs</div>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div class="p-3 bg-blue-50 rounded-lg">
                        <div class="text-xl font-semibold text-blue-800">{{ $candidates }}</div>
                        <div class="text-blue-600">Candidats</div>
                    </div>
                    <div class="p-3 bg-green-50 rounded-lg">
                        <div class="text-xl font-semibold text-green-800">{{ $recruiters }}</div>
                        <div class="text-green-600">Recruteurs</div>
                    </div>
                </div>
            </div>

            <!-- Statistiques annonces -->
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-semibold mb-4">Annonces</h2>
                <div class="flex items-center mb-4">
                    <div class="w-12 h-12 rounded-full bg-green-100 flex items-center justify-center mr-4">
                        <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                    </div>
                    <div>
                        <div class="text-3xl font-bold">{{ $totalAnnouncements }}</div>
                        <div class="text-gray-500">Total des annonces</div>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div class="p-3 bg-green-50 rounded-lg">
                        <div class="text-xl font-semibold text-green-800">{{ $activeAnnouncements }}</div>
                        <div class="text-green-600">Actives</div>
                    </div>
                    <div class="p-3 bg-gray-50 rounded-lg">
                        <div class="text-xl font-semibold text-gray-800">{{ $totalAnnouncements - $activeAnnouncements }}</div>
                        <div class="text-gray-600">Fermées</div>
                    </div>
                </div>
            </div>

            <!-- Statistiques candidatures -->
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-semibold mb-4">Candidatures</h2>
                <div class="flex items-center mb-4">
                    <div class="w-12 h-12 rounded-full bg-purple-100 flex items-center justify-center mr-4">
                        <svg class="h-6 w-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <div>
                        <div class="text-3xl font-bold">{{ $totalApplications }}</div>
                        <div class="text-gray-500">Total des candidatures</div>
                    </div>
                </div>

                @if(count($applicationsByStatus) > 0)
                    <div class="space-y-2">
                        @foreach($applicationsByStatus as $statusGroup)
                            <div class="flex items-center justify-between">
                            <span>
                                @if($statusGroup->status == 'pending') En attente
                                @elseif($statusGroup->status == 'reviewed') En cours
                                @elseif($statusGroup->status == 'accepted') Acceptées
                                @else Refusées @endif
                            </span>
                                <span class="text-sm font-semibold">{{ $statusGroup->count }}</span>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500 text-center">Aucune candidature</p>
                @endif
            </div>
        </div>

        <!-- Tendance des candidatures -->
        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <h2 class="text-xl font-semibold mb-4">Tendance des candidatures mensuelles</h2>

            @if(count($monthlyApplications) > 0)
                <div class="h-64">
                    <canvas id="monthlyApplicationsChart"></canvas>
                </div>
            @else
                <p class="text-gray-500 text-center">Aucune donnée disponible</p>
            @endif
        </div>

        <!-- Top recruteurs -->
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="px-6 py-4 border-b">
                <h2 class="text-xl font-semibold">Top recruteurs</h2>
            </div>

            @if(count($topRecruiters) > 0)
                <div class="divide-y divide-gray-200">
                    @foreach($topRecruiters as $recruiter)
                        <div class="p-4 hover:bg-gray-50 transition duration-150">
                            <div class="flex justify-between items-center">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center mr-3">
                                        <span class="text-blue-600 font-bold">{{ substr($recruiter->name, 0, 1) }}</span>
                                    </div>
                                    <div>
                                        <h3 class="font-semibold">{{ $recruiter->name }}</h3>
                                        <p class="text-sm text-gray-600">{{ $recruiter->email }}</p>
                                    </div>
                                </div>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                {{ $recruiter->announcements_count }} annonce(s)
                            </span>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="p-6 text-center">
                    <p class="text-gray-500">Aucun recruteur actif</p>
                </div>
            @endif
        </div>
    </div>
@endsection

@section('scripts')
    @if(count($monthlyApplications) > 0)
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const ctx = document.getElementById('monthlyApplicationsChart').getContext('2d');

                // Préparer les données
                const monthNames = ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Juin', 'Juil', 'Août', 'Sep', 'Oct', 'Nov', 'Déc'];
                const monthlyData = @json($monthlyApplications);

                // Formater les données pour Chart.js
                const labels = monthlyData.map(item => monthNames[item.month - 1] + ' ' + item.year);
                const data = monthlyData.map(item => item.count);

                // Créer le graphique
                new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Nombre de candidatures',
                            data: data,
                            backgroundColor: 'rgba(59, 130, 246, 0.5)',
                            borderColor: 'rgba(59, 130, 246, 1)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    precision: 0
                                }
                            }
                        }
                    }
                });
            });
        </script>
    @endif
@endsection
