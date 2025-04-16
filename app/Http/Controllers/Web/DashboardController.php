<?php
namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Announcement;
use App\Models\Application;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        if (auth()->user()->isRecruiter()) {
            return $this->recruiterDashboard();
        } elseif (auth()->user()->role === 'admin') {
            return $this->adminDashboard();
        } else {
            return $this->candidateDashboard();
        }
    }

    private function candidateDashboard()
    {
        $applications = Application::where('user_id', auth()->id())
            ->with('announcement')
            ->latest()
            ->take(5)
            ->get();

        $totalApplications = Application::where('user_id', auth()->id())->count();
        $pendingApplications = Application::where('user_id', auth()->id())->where('status', 'pending')->count();
        $acceptedApplications = Application::where('user_id', auth()->id())->where('status', 'accepted')->count();

        return view('dashboard.candidate', compact(
            'applications',
            'totalApplications',
            'pendingApplications',
            'acceptedApplications'
        ));
    }

    private function recruiterDashboard()
    {
        $announcements = Announcement::where('user_id', auth()->id())
            ->withCount('applications')
            ->latest()
            ->take(5)
            ->get();

        $totalAnnouncements = Announcement::where('user_id', auth()->id())->count();
        $activeAnnouncements = Announcement::where('user_id', auth()->id())->where('status', 'active')->count();

        $totalApplications = Application::whereHas('announcement', function($q) {
            $q->where('user_id', auth()->id());
        })->count();

        $recentApplications = Application::whereHas('announcement', function($q) {
            $q->where('user_id', auth()->id());
        })
            ->with(['user', 'announcement'])
            ->latest()
            ->take(5)
            ->get();

        $applicationsByStatus = Application::whereHas('announcement', function($q) {
            $q->where('user_id', auth()->id());
        })
            ->select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->get();

        return view('dashboard.recruiter', compact(
            'announcements',
            'totalAnnouncements',
            'activeAnnouncements',
            'totalApplications',
            'recentApplications',
            'applicationsByStatus'
        ));
    }

    private function adminDashboard()
    {
        return $this->adminStatistics();
    }

    public function adminStatistics()
    {
        $totalUsers = User::count();
        $recruiters = User::where('role', 'recruiter')->count();
        $candidates = User::where('role', 'candidate')->count();

        $totalAnnouncements = Announcement::count();
        $activeAnnouncements = Announcement::where('status', 'active')->count();

        $totalApplications = Application::count();

        $applicationsByStatus = Application::select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->get();

        $monthlyApplications = Application::select(
            DB::raw('MONTH(created_at) as month'),
            DB::raw('YEAR(created_at) as year'),
            DB::raw('COUNT(*) as count')
        )
            ->groupBy('year', 'month')
            ->orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->take(6)
            ->get();

        $topRecruiters = User::where('role', 'recruiter')
            ->withCount('announcements')
            ->orderBy('announcements_count', 'desc')
            ->take(5)
            ->get();

        return view('dashboard.admin', compact(
            'totalUsers',
            'recruiters',
            'candidates',
            'totalAnnouncements',
            'activeAnnouncements',
            'totalApplications',
            'applicationsByStatus',
            'monthlyApplications',
            'topRecruiters'
        ));
    }
}
