<?php
namespace App\Http\Controllers;

use App\Models\Paiement;
use App\Models\Salle;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalPaiements = Paiement::where('status', 'valide')->sum('montant');
        $paiementsJournaliers = Paiement::where('status', 'valide')
            ->whereDate('valide_le', today())
            ->sum('montant');
        $paiementsHebdomadaires = Paiement::where('status', 'valide')
            ->whereBetween('valide_le', [now()->startOfWeek(), now()->endOfWeek()])
            ->sum('montant');
        $paiementsMensuels = Paiement::where('status', 'valide')
            ->whereMonth('valide_le', now()->month)
            ->sum('montant');

        $salles = Salle::withCount(['paiements' => function($query) {
            $query->where('status', 'valide');
        }])->get();

        return view('admin.dashboard', compact(
            'totalPaiements',
            'paiementsJournaliers',
            'paiementsHebdomadaires',
            'paiementsMensuels',
            'salles'
        ));
    }

    public function listePaiements($salleId = null)
    {
        $query = Paiement::where('status', 'valide')->with(['etudiant', 'salle', 'delegue']);
        
        if ($salleId) {
            $query->where('salle_id', $salleId);
        }

        $paiements = $query->get();
        $salles = Salle::all();

        return view('admin.liste-paiements', compact('paiements', 'salles'));
    }

    public function creerSalle(Request $request)
    {
        $request->validate(['nom' => 'required|string|unique:salles']);
        
        Salle::create($request->only('nom'));
        
        return redirect()->back()->with('success', 'Salle créée avec succès.');
    }

    public function nommerDelegue(Request $request)
    {
        $request->validate([
            'etudiant_id' => 'required|exists:users,id',
            'salle_id' => 'required|exists:salles,id'
        ]);

        User::where('salle_id', $request->salle_id)->update(['is_delegue' => false]);
        
        $etudiant = User::find($request->etudiant_id);
        $etudiant->update([
            'salle_id' => $request->salle_id,
            'is_delegue' => true
        ]);

        return redirect()->back()->with('success', 'Délégué nommé avec succès.');
    }
public function telechargerListePaiements($salleId = null)
{
    $query = Paiement::where('status', 'valide')
        ->with(['etudiant', 'salle', 'delegue']);
    
    if ($salleId) {
        $query->where('salle_id', $salleId);
        $salle = Salle::findOrFail($salleId);
        $filename = 'liste-paiements-' . $salle->nom . '.pdf';
    } else {
        $filename = 'liste-paiements-tous.pdf';
    }

    $paiements = $query->orderBy('created_at', 'desc')->get();
    $salles = Salle::all();

    $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.pdf.liste-paiements', compact('paiements', 'salles', 'salleId'));
    
    return $pdf->download($filename);
}
    
}
