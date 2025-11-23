<?php
namespace App\Http\Controllers;

use App\Models\Paiement;
use App\Models\Salle;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DelegueController extends Controller
{
    public function dashboard()
    {
        if (!auth()->user()->is_delegue) {
            if (!auth()->user()->isAdmin()) {
                redirect('/etudiant/dashboard')->send();
            }else{
                redirect('/admin/dashboard')->send();
            }
        }

        $delegue = Auth::user();
        $paiements = Paiement::where('salle_id', $delegue->salle_id)
            ->where('status', 'attente de validation')
            ->with('etudiant')
            ->get();

        $paiementsDone = Paiement::where('salle_id', $delegue->salle_id)
            ->where('status', 'valide')
            ->with('etudiant')
            ->get();

        $allpaiements = $paiements->merge($paiementsDone);

        return view('delegue.dashboard', compact('paiements', 'paiementsDone', 'allpaiements'));
    }

    public function validerPaiement(Request $request, $id)
    {
        if (!auth()->user()->is_delegue) {
            if (!auth()->user()->isAdmin()) {
                redirect('/etudiant/dashboard')->send();
            }else{
                redirect('/admin/dashboard')->send();
            }
        }
        $paiement = Paiement::where('salle_id', Auth::user()->salle_id)
            ->where('status', 'attente de validation')
            ->findOrFail($id);

        $paiement->update([
            'status' => 'valide',
            'valide_par' => Auth::id(),
            'valide_le' => now()
        ]);

        return redirect()->back()->with('success', 'Paiement validé avec succès.');
    }
}
