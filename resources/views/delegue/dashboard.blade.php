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
  --danger: #ef4444;
}

/* Styles spécifiques délégué */
.delegue-dashboard {
  background: linear-gradient(135deg, #f8faff 0%, #f0f4ff 100%);
  min-height: 100vh;
}

.alert-pending {
  background: linear-gradient(135deg, #fff3cd, #ffeaa7);
  border: none;
  border-radius: 12px;
  border-left: 4px solid var(--warning);
}

.alert-success {
  background: linear-gradient(135deg, #d1fae5, #a7f3d0);
  border: none;
  border-radius: 12px;
  border-left: 4px solid var(--success);
}

.priority-high {
  border-left: 4px solid var(--danger);
  background: linear-gradient(135deg, #fee2e2, #fecaca);
}

.priority-medium {
  border-left: 4px solid var(--warning);
  background: linear-gradient(135deg, #fef3c7, #fde68a);
}

/* Réutilisation des styles de l'étudiant avec quelques ajustements */
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

.btn-sm-violet {
  padding: 0.5rem 1.25rem;
  font-size: 0.875rem;
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

.stats-card {
  background: linear-gradient(135deg, var(--primary-violet), var(--secondary-violet));
  color: var(--white);
  border-radius: 16px;
  padding: 1.5rem;
  margin-bottom: 1.5rem;
  text-align: center;
  transition: all 0.3s ease;
}

.stats-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 15px 35px rgba(109, 40, 217, 0.3);
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

.empty-state {
  text-align: center;
  padding: 4rem 2rem;
  color: var(--text-light);
}

.empty-state i {
  font-size: 5rem;
  margin-bottom: 1.5rem;
  opacity: 0.3;
}

.empty-state h4 {
  color: var(--text-light);
  margin-bottom: 1rem;
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
    margin-bottom: 0.5rem;
  }
  
  .h2-modern {
    font-size: 1.75rem;
    text-align: center;
  }
  
  .h2-modern::after {
    left: 50%;
    transform: translateX(-50%);
  }
  
  .stats-card {
    margin-bottom: 1rem;
    padding: 1.25rem;
  }
  
  .stats-number {
    font-size: 2rem;
  }
}

@media (max-width: 576px) {
  .card-header-modern {
    padding: 1.25rem 1.5rem;
  }
  
  .h2-modern {
    font-size: 1.5rem;
  }
  
  .table-modern thead th,
  .table-modern tbody td {
    padding: 1rem;
    white-space: nowrap;
  }
  
  .empty-state {
    padding: 3rem 1rem;
  }
  
  .empty-state i {
    font-size: 4rem;
  }
}

.urgent-badge {
  background: linear-gradient(135deg, var(--danger), #f87171);
  color: white;
  padding: 0.25rem 0.75rem;
  border-radius: 20px;
  font-size: 0.75rem;
  font-weight: 600;
}

.user-avatar {
  width: 40px;
  height: 40px;
  border-radius: 50%;
  background: linear-gradient(135deg, var(--primary-violet), var(--secondary-violet));
  display: flex;
  align-items: center;
  justify-content: center;
  color: white;
  font-weight: 600;
  margin-right: 1rem;
}
</style>

<div class="delegue-dashboard">
    <div class="container py-5">
        <div class="d-flex justify-content-between align-items-center mb-5">
            <h2 class="h2-modern">Tableau de bord Délégué</h2>
            <div class="d-flex align-items-center">
                <div class="stats-card me-3">
                    <div class="stats-number">{{ $paiements->count() }}</div>
                    <div class="stats-label">En Attente</div>
                </div>
            </div>
        </div>

        @if($paiements->isNotEmpty())
        <div class="alert alert-pending mb-4">
            <div class="d-flex align-items-center">
                <i class="fas fa-exclamation-triangle fa-2x me-3 text-warning"></i>
                <div>
                    <h5 class="mb-1">Demandes en attente de validation</h5>
                    <p class="mb-0">Vous avez {{ $paiements->count() }} demande(s) de paiement à traiter</p>
                </div>
            </div>
        </div>
        @else
        <div class="alert alert-success mb-4">
            <div class="d-flex align-items-center">
                <i class="fas fa-check-circle fa-2x me-3 text-success"></i>
                <div>
                    <h5 class="mb-1">Toutes les demandes sont traitées</h5>
                    <p class="mb-0">Aucune demande en attente de validation</p>
                </div>
            </div>
        </div>
        @endif

        <div class="row">
            <div class="col-12">
                <div class="card-modern">
                    <div class="card-header-modern">
                        <h4 class="mb-0"><i class="fas fa-clock me-2"></i>Demandes de validation en attente</h4>
                    </div>
                    <div class="card-body">
                        @if($paiements->isEmpty())
                        <div class="empty-state">
                            <i class="fas fa-check-circle text-success"></i>
                            <h4>Aucune demande en attente</h4>
                            <p class="text-muted">Toutes les demandes ont été traitées avec succès</p>
                        </div>
                        @else
                        <div class="table-responsive">
                            <table class="table table-modern mb-0">
                                <thead>
                                    <tr>
                                        <th>Étudiant</th>
                                        <th>Montant</th>
                                        <th>Contact</th>
                                        <th>Date</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($paiements as $paiement)
                                    <tr class="{{ $paiement->created_at->diffInHours(now()) > 24 ? 'priority-high' : 'priority-medium' }}">
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="user-avatar">
                                                    {{ substr($paiement->etudiant->name, 0, 1) }}
                                                </div>
                                                <div>
                                                    <strong>{{ $paiement->etudiant->name }}</strong>
                                                    @if($paiement->created_at->diffInHours(now()) > 24)
                                                    <br><span class="urgent-badge">URGENT</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td class="fw-bold text-primary">{{ number_format($paiement->montant, 0, ',', ' ') }} FCFA</td>
                                        <td>
                                            <i class="fas fa-phone me-1 text-muted"></i>
                                            {{ $paiement->telephone }}
                                        </td>
                                        <td>
                                            <strong>{{ $paiement->created_at->format('d/m/Y') }}</strong>
                                            <br>
                                            <small class="text-muted">{{ $paiement->created_at->format('H:i') }}</small>
                                            <br>
                                            <small class="text-muted">
                                                Il y a {{ $paiement->created_at->diffForHumans() }}
                                            </small>
                                        </td>
                                        <td>
                                            <form action="{{ route('delegue.valider-paiement', $paiement->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-violet btn-sm-violet">
                                                    <i class="fas fa-check me-1"></i>Valider
                                                </button>
                                            </form>
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

        <!-- Statistiques supplémentaires -->
        @if($paiements->isNotEmpty())
        <div class="row mt-4">
            <div class="col-md-4">
                <div class="stats-card" style="background: linear-gradient(135deg, #f59e0b, #fbbf24);">
                    <div class="stats-number">{{ $paiements->where('created_at', '>=', now()->subHours(24))->count() }}</div>
                    <div class="stats-label">Dernières 24h</div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stats-card" style="background: linear-gradient(135deg, #ef4444, #f87171);">
                    <div class="stats-number">{{ $paiements->where('created_at', '>=', now()->subHours(24))->count() }}</div>
                    <div class="stats-label">Urgents</div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stats-card" style="background: linear-gradient(135deg, #10b981, #34d399);">
                    <div class="stats-number">{{ $paiements->sum('montant') }} F</div>
                    <div class="stats-label">Total à valider</div>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection