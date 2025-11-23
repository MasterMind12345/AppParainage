<?php
namespace App\Http\Controllers;

use App\Models\Paiement;
use App\Models\Salle;
use App\Models\User;
use App\Services\TwoDDocService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class EtudiantController extends Controller
{
    protected $twoDDocService;

    public function __construct(TwoDDocService $twoDDocService)
    {
        $this->twoDDocService = $twoDDocService;
    }

    private function generateUniqueCode()
    {
        do {
            $code = Str::random(10);
        } while (Paiement::where('code', $code)->exists());

        return $code;
    }

    public function dashboard()
    {
        if (!auth()->user()->is_delegue != true) {
            redirect('/delegue/dashboard')->send();
        }
        if (auth()->user()->isAdmin()) {
            redirect('/admin/dashboard')->send();
        }
        $etudiant = Auth::user();
        $paiements = $etudiant->paiements()->with('salle')->get();
        $salles = Salle::all();

        return view('etudiant.dashboard', compact('paiements', 'salles'));
    }

    public function initierPaiement(Request $request)
    {
        if (!auth()->user()->is_delegue != true) {
            if (!auth()->user()->isAdmin()) {
                redirect('/delegue/dashboard')->send();
            }else{
                redirect('/admin/dashboard')->send();
            }
        }
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
            'status' => 'attente de validation',
            'code' => $this->generateUniqueCode(),
            'name' => $request->nom,
        ]);

        return redirect()->back()->with('success', 'Paiement initié avec succès. En attente de validation.');
    }

    public function telechargerRecu($id)
    {
        if (!auth()->user()->is_delegue != true) {
            if (!auth()->user()->isAdmin()) {
                redirect('/delegue/dashboard')->send();
            }else{
                redirect('/admin/dashboard')->send();
            }
        }


        $logoBase64 = null;
        $qrBase64 = null;

        $logoPath = storage_path('app/public/logo.png');
        if (file_exists($logoPath)) {
            $logoData = file_get_contents($logoPath);
            $logoMime = mime_content_type($logoPath);
            $logoBase64 = 'data:' . $logoMime . ';base64,' . base64_encode($logoData);
        }

        $paiement = Paiement::where('etudiant_id', Auth::id())->findOrFail($id);

        $qrCode = $this->twoDDocService->generateQrCode(base64_encode($paiement->code));
        $qrBase64 = 'data:image/png;base64,' . base64_encode($qrCode);


        if ($paiement->status !== 'valide') {
            abort(403, 'Paiement non validé');
        }

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('etudiant.recu', compact('paiement', 'logoBase64', 'qrBase64'));
        return $pdf->download('recu-paiement-' . $paiement->id . '.pdf');
    }
}
