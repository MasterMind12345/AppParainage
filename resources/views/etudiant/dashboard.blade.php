@extends('layouts.app')

@section('content')
<style>
:root {
  --primary-violet: #6d28d9;
  --secondary-violet: #8b5cf6;
  --light-violet: #c4b5fd;
  --ultra-light-violet: #ede9fe;
  --dark-violet: #5b21b6;
  --text-dark: #1f2937;
  --text-light: #6b7280;
  --white: #ffffff;
  --success: #10b981;
  --warning: #f59e0b;
}

/* Styles pour le dashboard étudiant */
.dashboard-container {
  font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
  background: linear-gradient(135deg, #f5f3ff 0%, #f0eaff 100%);
  min-height: 100vh;
}

.card-modern {
  background: var(--white);
  border-radius: 16px;
  box-shadow: 0 8px 25px rgba(109, 40, 217, 0.1);
  border: none;
  overflow: hidden;
  transition: all 0.3s ease;
  margin-bottom: 1.5rem;
}

.card-modern:hover {
  box-shadow: 0 15px 35px rgba(109, 40, 217, 0.15);
  transform: translateY(-3px);
}

.card-header-modern {
  background: linear-gradient(135deg, var(--primary-violet), var(--secondary-violet));
  color: var(--white);
  padding: 1.5rem 2rem;
  border-bottom: none;
  position: relative;
}

.card-header-modern::after {
  content: '';
  position: absolute;
  bottom: 0;
  left: 0;
  width: 100%;
  height: 3px;
  background: linear-gradient(90deg, transparent, rgba(255,255,255,0.5), transparent);
}

.btn-violet {
  background: linear-gradient(135deg, var(--primary-violet), var(--secondary-violet));
  color: var(--white);
  border: none;
  border-radius: 12px;
  padding: 0.875rem 2rem;
  font-weight: 600;
  transition: all 0.3s ease;
  box-shadow: 0 4px 15px rgba(109, 40, 217, 0.3);
  position: relative;
  overflow: hidden;
}

.btn-violet::before {
  content: '';
  position: absolute;
  top: 0;
  left: -100%;
  width: 100%;
  height: 100%;
  background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
  transition: left 0.5s;
}

.btn-violet:hover::before {
  left: 100%;
}

.btn-violet:hover {
  background: linear-gradient(135deg, var(--dark-violet), var(--primary-violet));
  color: var(--white);
  transform: translateY(-2px);
  box-shadow: 0 8px 25px rgba(109, 40, 217, 0.4);
}

.table-modern {
  border-collapse: separate;
  border-spacing: 0;
  width: 100%;
  border-radius: 12px;
  overflow: hidden;
  box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
  background: var(--white);
}

.table-modern thead {
  background: linear-gradient(135deg, var(--primary-violet), var(--secondary-violet));
  color: var(--white);
}

.table-modern thead th {
  border: none;
  padding: 1.25rem 1.5rem;
  font-weight: 600;
  text-transform: uppercase;
  letter-spacing: 0.05em;
  font-size: 0.875rem;
  position: relative;
}

.table-modern thead th:not(:last-child)::after {
  content: '';
  position: absolute;
  right: 0;
  top: 25%;
  height: 50%;
  width: 1px;
  background: rgba(255,255,255,0.3);
}

.table-modern tbody tr {
  transition: all 0.2s ease;
  border-bottom: 1px solid #f1f5f9;
}

.table-modern tbody tr:nth-child(even) {
  background-color: var(--ultra-light-violet);
}

.table-modern tbody tr:hover {
  background-color: var(--light-violet);
  transform: scale(1.01);
}

.table-modern tbody td {
  padding: 1.25rem 1.5rem;
  vertical-align: middle;
  font-weight: 500;
}

.badge {
  padding: 0.5rem 1rem;
  border-radius: 8px;
  font-weight: 600;
  font-size: 0.75rem;
  text-transform: uppercase;
  letter-spacing: 0.05em;
}

.badge-success {
  background: linear-gradient(135deg, var(--success), #34d399);
  color: var(--white);
}

.badge-warning {
  background: linear-gradient(135deg, var(--warning), #fbbf24);
  color: var(--white);
}

.h2-modern {
  color: var(--primary-violet);
  font-weight: 700;
  margin-bottom: 2rem;
  position: relative;
  padding-bottom: 1rem;
  font-size: 2.25rem;
}

.h2-modern::after {
  content: '';
  position: absolute;
  bottom: 0;
  left: 0;
  width: 80px;
  height: 5px;
  background: linear-gradient(135deg, var(--primary-violet), var(--secondary-violet));
  border-radius: 3px;
}

.modal-violet .modal-header {
  background: linear-gradient(135deg, var(--primary-violet), var(--secondary-violet));
  color: var(--white);
  border-bottom: none;
  padding: 1.5rem 2rem;
}

.modal-violet .modal-header .btn-close {
  filter: invert(1);
  opacity: 0.8;
}

.modal-violet .modal-header .btn-close:hover {
  opacity: 1;
}

.modal-violet .modal-body {
  padding: 2rem;
}

.modal-violet .modal-footer {
  border-top: 1px solid #e5e7eb;
  padding: 1.5rem 2rem;
}

.form-control {
  border: 2px solid #e5e7eb;
  border-radius: 8px;
  padding: 0.75rem 1rem;
  transition: all 0.3s ease;
}

.form-control:focus {
  border-color: var(--primary-violet);
  box-shadow: 0 0 0 3px rgba(109, 40, 217, 0.1);
}

.form-label {
  font-weight: 600;
  color: var(--text-dark);
  margin-bottom: 0.5rem;
}

/* Responsive */
@media (max-width: 768px) {
  .table-modern {
    display: block;
    overflow-x: auto;
    font-size: 0.875rem;
  }
  
  .card-modern {
    border-radius: 12px;
    margin-bottom: 1rem;
  }
  
  .btn-violet {
    width: 100%;
    margin-bottom: 1rem;
  }
  
  .h2-modern {
    font-size: 1.75rem;
    text-align: center;
  }
  
  .h2-modern::after {
    left: 50%;
    transform: translateX(-50%);
  }
  
  .table-modern thead th,
  .table-modern tbody td {
    padding: 1rem;
  }
}

@media (max-width: 576px) {
  .modal-violet .modal-body {
    padding: 1.5rem;
  }
  
  .card-header-modern {
    padding: 1.25rem 1.5rem;
  }
  
  .h2-modern {
    font-size: 1.5rem;
  }
}

.empty-state {
  text-align: center;
  padding: 3rem 2rem;
  color: var(--text-light);
}

.empty-state i {
  font-size: 4rem;
  margin-bottom: 1rem;
  opacity: 0.5;
}

.stats-card {
  background: linear-gradient(135deg, var(--primary-violet), var(--secondary-violet));
  color: var(--white);
  border-radius: 16px;
  padding: 1.5rem;
  margin-bottom: 1.5rem;
}

.stats-number {
  font-size: 2.5rem;
  font-weight: 700;
  margin-bottom: 0.5rem;
}

.stats-label {
  opacity: 0.9;
  font-size: 0.875rem;
  text-transform: uppercase;
  letter-spacing: 0.05em;
}
</style>

<div class="dashboard-container">
    <div class="container py-5">
        <div class="d-flex justify-content-between align-items-center mb-5">
            <h2 class="h2-modern">Tableau de bord Étudiant</h2>
            <button class="btn btn-violet" data-bs-toggle="modal" data-bs-target="#paiementModal">
                <i class="fas fa-file-invoice-dollar me-2"></i>Initier Certification Paiement
            </button>
        </div>

        <div class="row mb-4">
            <div class="col-md-3 col-6">
                <div class="stats-card text-center">
                    <div class="stats-number">{{ $paiements->count() }}</div>
                    <div class="stats-label">Total Paiements</div>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="stats-card text-center">
                    <div class="stats-number">{{ $paiements->where('status', 'valide')->count() }}</div>
                    <div class="stats-label">Paiements Validés</div>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="stats-card text-center">
                    <div class="stats-number">{{ $paiements->where('status', '!=', 'valide')->count() }}</div>
                    <div class="stats-label">En Attente</div>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="stats-card text-center">
                    <div class="stats-number">{{ $paiements->sum('montant') }} F</div>
                    <div class="stats-label">Total Versé</div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card-modern">
                    <div class="card-header-modern">
                        <h4 class="mb-0"><i class="fas fa-history me-2"></i>Historique de mes paiements</h4>
                    </div>
                    <div class="card-body p-0">
                        @if($paiements->isEmpty())
                        <div class="empty-state">
                            <i class="fas fa-receipt"></i>
                            <h4>Aucun paiement enregistré</h4>
                            <p>Initiez votre premier paiement pour commencer</p>
                        </div>
                        @else
                        <div class="table-responsive">
                            <table class="table table-modern mb-0">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Montant</th>
                                        <th>Salle</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($paiements as $paiement)
                                    <tr>
                                        <td>
                                            <strong>{{ $paiement->created_at->format('d/m/Y') }}</strong>
                                            <br>
                                            <small class="text-muted">{{ $paiement->created_at->format('H:i') }}</small>
                                        </td>
                                        <td class="fw-bold text-primary">{{ number_format($paiement->montant, 0, ',', ' ') }} FCFA</td>
                                        <td>
                                            <span class="badge bg-light text-dark">{{ $paiement->salle->nom }}</span>
                                        </td>
                                        <td>
                                            <span class="badge badge-{{ $paiement->status == 'valide' ? 'success' : 'warning' }}">
                                                {{ $paiement->status }}
                                            </span>
                                        </td>
                                        <td>
                                            @if($paiement->status == 'valide')
                                            <a href="{{ route('etudiant.telecharger-recu', $paiement->id) }}" class="btn btn-success btn-sm btn-violet">
                                                <i class="fas fa-download me-1"></i>Télécharger
                                            </a>
                                            @else
                                            <span class="text-muted"><i class="fas fa-clock me-1"></i>En attente</span>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade modal-violet" id="paiementModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-file-invoice-dollar me-2"></i>Initier Certification Paiement</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('etudiant.initier-paiement') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Nom complet</label>
                            <input type="text" class="form-control" name="nom" value="{{ auth()->user()->name }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Montant remis au délégué</label>
                            <div class="input-group">
                                <input type="number" class="form-control" name="montant" value="3500" required>
                                <span class="input-group-text">FCFA</span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Numéro de téléphone</label>
                            <input type="text" class="form-control" name="telephone" required placeholder="Ex: 77 123 45 67">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Salle de classe</label>
                            <select class="form-control" name="salle_id" required>
                                @foreach($salles as $salle)
                                <option value="{{ $salle->id }}">{{ $salle->nom }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                    <button type="submit" class="btn btn-violet">
                        <i class="fas fa-paper-plane me-1"></i>Envoyer la demande
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection