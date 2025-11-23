@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h2 class="mb-0">
                    <i class="fas fa-file-invoice-dollar me-2"></i>
                    Liste des Paiements Validés
                    @if(request()->route('salle'))
                        - Salle {{ $salles->find(request()->route('salle'))->nom ?? '' }}
                    @endif
                </h2>
                <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-primary">
                    <i class="fas fa-arrow-left me-1"></i>Retour au tableau de bord
                </a>
            </div>
        </div>
    </div>

    <!-- Filtres et statistiques -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <h5 class="mb-3">Filtrer par salle :</h5>
                            <div class="d-flex flex-wrap gap-2">
                                <a href="{{ route('admin.liste-paiements') }}"
                                   class="btn {{ !request()->route('salle') ? 'btn-primary' : 'btn-outline-primary' }}">
                                    Toutes les salles
                                </a>
                                @foreach($salles as $salle)
                                <a href="{{ route('admin.liste-paiements-salle', $salle->id) }}"
                                   class="btn {{ request()->route('salle') == $salle->id ? 'btn-primary' : 'btn-outline-primary' }}">
                                    {{ $salle->nom }}
                                    <span class="badge bg-light text-dark ms-1">
                                        {{ $salle->paiements_count }}
                                    </span>
                                </a>
                                @endforeach
                            </div>
                        </div>
                        <div class="col-md-4 ">
                            <h5 class="mb-3">Statistiques</h5>



                            <div class="d-flex">
                                <div class="text-center p-3 bg-light rounded">
                                    <h4 class="text-primary mb-1">{{ $paiements->where('created_at', '>=', now()->startOfDay())->where('created_at', '<=', now()->endOfDay())->count() }}</h4>
                                    <small class="text-muted">Paiements du jour valides</small>
                                    <br>
                                    <strong class="text-success">
                                        {{ number_format($paiements->where('created_at', '>=', now()->startOfDay())->where('created_at', '<=', now()->endOfDay())->sum('montant'), 0, ',', ' ') }} FCFA
                                    </strong>
                                </div>


                                <div class="text-center p-3 bg-light rounded">
                                    <h4 class="text-primary mb-1">{{ $paiements->where('created_at', '>=', now()->startOfWeek())->where('created_at', '<=', now()->endOfWeek())->count() }}</h4>
                                    <small class="text-muted">Paiements de la semaine validés</small>
                                    <br>
                                    <strong class="text-success">
                                        {{ number_format($paiements->where('created_at', '>=', now()->startOfWeek())->where('created_at', '<=', now()->endOfWeek())->sum('montant'), 0, ',', ' ') }} FCFA
                                    </strong>
                                </div>

                                <div class="text-center p-3 bg-light rounded">
                                    <h4 class="text-primary mb-1">{{ $paiements->count() }}</h4>
                                    <small class="text-muted">Paiements validés</small>
                                    <br>
                                    <strong class="text-success">
                                        {{ number_format($paiements->sum('montant'), 0, ',', ' ') }} FCFA
                                    </strong>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tableau des paiements -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Détails des paiements</h5>
                        <div class="input-group" style="width: 300px;">
                            <input type="text" id="searchInput" class="form-control" placeholder="Rechercher...">
                            <span class="input-group-text">
                                <i class="fas fa-search"></i>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped mb-0" id="paiementsTable">
                            <thead class="table-dark">
                                <tr>
                                    <th>#</th>
                                    <th>Étudiant</th>
                                    <th>Salle</th>
                                    <th>Montant</th>
                                    <th>Téléphone</th>
                                    <th>Date Validation</th>
                                    <th>Validé par</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($paiements as $paiement)
                                <tr>
                                    <td><strong>#{{ $paiement->id }}</strong></td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-circle bg-primary text-white me-2">
                                                {{ substr($paiement->etudiant->name, 0, 1) }}
                                            </div>
                                            <div>
                                                <div class="fw-bold">{{ $paiement->etudiant->name }}</div>
                                                <small class="text-muted">{{ $paiement->etudiant->email }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-info">{{ $paiement->salle->nom }}</span>
                                    </td>
                                    <td>
                                        <span class="fw-bold text-success">
                                            {{ number_format($paiement->montant, 0, ',', ' ') }} FCFA
                                        </span>
                                    </td>
                                    <td>{{ $paiement->telephone }}</td>
                                    <td>
                                        @if($paiement->valide_le)
                                            {{ \Carbon\Carbon::parse($paiement->valide_le)->format('d/m/Y H:i') }}
                                        @else
                                            <span class="text-muted">N/A</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($paiement->delegue)
                                            <span class="badge bg-success">{{ $paiement->delegue->name }}</span>
                                        @else
                                            <span class="text-muted">N/A</span>
                                        @endif
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-info"
                                                data-bs-toggle="tooltip"
                                                title="Voir les détails"
                                                onclick="showPaiementDetails({{ $paiement }})">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="8" class="text-center py-4">
                                        <div class="text-muted">
                                            <i class="fas fa-inbox fa-3x mb-3"></i>
                                            <h5>Aucun paiement validé</h5>
                                            <p>Aucun paiement n'a été validé pour le moment.</p>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- Supprimer la partie pagination -->
            </div>
        </div>
    </div>
</div>

<!-- Modal pour les détails du paiement -->
<div class="modal fade" id="paiementModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">Détails du Paiement</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="paiementDetails">
                <!-- Les détails seront chargés ici -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
            </div>
        </div>
    </div>
</div>

<style>
.avatar-circle {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
    font-size: 14px;
}

.table th {
    border-top: none;
    font-weight: 600;
    text-transform: uppercase;
    font-size: 0.8rem;
    letter-spacing: 0.5px;
}

.table tbody tr:hover {
    background-color: #f8f9fa;
    transform: scale(1.01);
    transition: all 0.2s ease;
}

.card {
    border: none;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    border-radius: 10px;
}

.card-header {
    border-bottom: 1px solid #e3e6f0;
    background-color: #f8f9fc;
}

.badge {
    font-size: 0.75em;
}

@media (max-width: 768px) {
    .table-responsive {
        font-size: 0.875rem;
    }

    .avatar-circle {
        width: 30px;
        height: 30px;
        font-size: 12px;
    }

    .btn-group .btn {
        font-size: 0.75rem;
        padding: 0.25rem 0.5rem;
    }
}
</style>

<script>
function showPaiementDetails(paiement) {
    const detailsHtml = `
        <div class="row">
            <div class="col-md-6">
                <h6>Informations de l'étudiant</h6>
                <p><strong>Nom:</strong> ${paiement.etudiant.name}</p>
                <p><strong>Email:</strong> ${paiement.etudiant.email}</p>
                <p><strong>Téléphone:</strong> ${paiement.telephone}</p>
            </div>
            <div class="col-md-6">
                <h6>Détails du paiement</h6>
                <p><strong>Montant:</strong> ${new Intl.NumberFormat().format(paiement.montant)} FCFA</p>
                <p><strong>Salle:</strong> ${paiement.salle.nom}</p>
                <p><strong>Statut:</strong> <span class="badge bg-success">${paiement.status}</span></p>
                <p><strong>Date d'initiation:</strong> ${new Date(paiement.created_at).toLocaleDateString('fr-FR')}</p>
                ${paiement.valide_le ? `<p><strong>Date de validation:</strong> ${new Date(paiement.valide_le).toLocaleDateString('fr-FR')}</p>` : ''}
                ${paiement.delegue ? `<p><strong>Validé par:</strong> ${paiement.delegue.name}</p>` : ''}
            </div>
        </div>
    `;

    document.getElementById('paiementDetails').innerHTML = detailsHtml;
    new bootstrap.Modal(document.getElementById('paiementModal')).show();
}

// Recherche en temps réel
document.getElementById('searchInput').addEventListener('input', function(e) {
    const searchTerm = e.target.value.toLowerCase();
    const rows = document.querySelectorAll('#paiementsTable tbody tr');

    rows.forEach(row => {
        const text = row.textContent.toLowerCase();
        row.style.display = text.includes(searchTerm) ? '' : 'none';
    });
});

// Initialiser les tooltips
document.addEventListener('DOMContentLoaded', function() {
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
});
</script>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
@endsection
