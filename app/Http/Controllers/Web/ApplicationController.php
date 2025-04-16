<?php
namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Announcement;
use App\Models\Application;
use Illuminate\Support\Facades\Storage;

class ApplicationController extends Controller
{
    public function candidateIndex()
    {
        $applications = Application::where('user_id', auth()->id())
            ->with('announcement')
            ->paginate(10);

        return view('applications.candidate-index', compact('applications'));
    }

    public function recruiterIndex(Request $request)
    {
        $query = Application::whereHas('announcement', function($q) {
            $q->where('user_id', auth()->id());
        })->with(['user', 'announcement']);

        // Filtres
        if ($request->has('status')) {
            $query->where('status', $request->input('status'));
        }

        if ($request->has('announcement_id')) {
            $query->where('announcement_id', $request->input('announcement_id'));
        }

        $applications = $query->paginate(10);
        $announcements = Announcement::where('user_id', auth()->id())->get();

        return view('applications.recruiter-index', compact('applications', 'announcements'));
    }

    public function store(Request $request, Announcement $announcement)
    {
        // Vérifier si l'annonce est active
        if ($announcement->status !== 'active') {
            return back()->with('error', 'Cette annonce n\'est plus disponible.');
        }

        // Vérifier si l'utilisateur a déjà postulé
        $existingApplication = Application::where('user_id', auth()->id())
            ->where('announcement_id', $announcement->id)
            ->first();

        if ($existingApplication) {
            return back()->with('error', 'Vous avez déjà postulé à cette annonce.');
        }

        $validatedData = $request->validate([
            'cv' => 'required|file|mimes:pdf,doc,docx|max:2048',
            'motivation_letter' => 'required|file|mimes:pdf,doc,docx|max:2048'
        ]);

        $cvPath = $request->file('cv')->store('cvs');
        $motivationLetterPath = $request->file('motivation_letter')->store('motivation_letters');

        $application = Application::create([
            'user_id' => auth()->id(),
            'announcement_id' => $announcement->id,
            'cv_path' => $cvPath,
            'motivation_letter_path' => $motivationLetterPath,
            'status' => 'pending'
        ]);

        return redirect()->route('applications.candidate')
            ->with('success', 'Candidature envoyée avec succès.');
    }

    public function updateStatus(Request $request, Application $application)
    {
        // Vérifier que le recruteur est propriétaire de l'annonce
        $this->authorize('updateStatus', $application);

        $validatedData = $request->validate([
            'status' => 'required|in:pending,reviewed,accepted,rejected'
        ]);

        $application->update($validatedData);

        // Ici, vous pourriez ajouter la logique pour envoyer un email au candidat

        return redirect()->back()
            ->with('success', 'Statut de la candidature mis à jour avec succès.');
    }

    public function destroy(Application $application)
    {
        // Vérifier que le candidat est propriétaire de la candidature
        $this->authorize('delete', $application);

        // Supprimer les fichiers
        Storage::delete([$application->cv_path, $application->motivation_letter_path]);

        $application->delete();

        return redirect()->route('applications.candidate')
            ->with('success', 'Candidature retirée avec succès.');
    }
}
