<?php
namespace App\Http\Controllers;

use App\Models\Paiement;
use App\Models\Salle;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EtudiantController extends Controller
{
    public function dashboard()
    {
        $etudiant = Auth::user();
        $paiements = $etudiant->paiements()->with('salle')->get();
        $salles = Salle::all();
        
        return view('etudiant.dashboard', compact('paiements', 'salles'));
    }

    public function initierPaiement(Request $request)
    {
        $request->validate([
            'nom' => 'required|string',
            'montant' => 'required|numeric',
            'telephone' => 'required|string',
            'salle_id' => 'required|exists:salles,id'
        ]);

        Paiement::create([
            'etudiant_id' => Auth::id(),
            'salle_id' => $request->salle_id,
            'montant' => $request->montant,
            'telephone' => $request->telephone,
            'status' => 'attente de validation'
        ]);

        return redirect()->back()->with('success', 'Paiement initié avec succès. En attente de validation.');
    }

    public function telechargerRecu($id)
    {
        $paiement = Paiement::where('etudiant_id', Auth::id())->findOrFail($id);
        
        if ($paiement->status !== 'valide') {
            abort(403, 'Paiement non validé');
        }

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('etudiant.recu', compact('paiement'));
        return $pdf->download('recu-paiement-' . $paiement->id . '.pdf');
    }
}