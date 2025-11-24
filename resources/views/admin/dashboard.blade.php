@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <h2 class="mb-4">Tableau de bord Administrateur</h2>
        </div>
    </div>

    <!-- Cartes de statistiques -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 col-4 mb-4">
            <div class="card stat-card bg-primary text-white">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <h5 class="">Total Général</h5>
                            <p class="card-text  mb-0">{{ number_format($totalPaiements, 0, ',', ' ') }} FCFA</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 col-4  mb-4">
            <div class="card stat-card bg-success text-white">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <h5 class="">Aujourd'hui</h5>
                            <p class="card-text  mb-0">{{ number_format($paiementsJournaliers, 0, ',', ' ') }} FCFA</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 col-4  mb-4">
            <div class="card stat-card bg-info text-white">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <h5 class="">Cette semaine</h5>
                            <p class="card-text  mb-0">{{ number_format($paiementsHebdomadaires, 0, ',', ' ') }} FCFA</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Gestion des salles -->
        <div class="col-xl-6 col-lg-12 mb-4">
            <div class="card h-100">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-door-open me-2"></i>Gestion des salles</h5>
                </div>
                <div class="card-body">
                    {{-- <form action="{{ route('admin.creer-salle') }}" method="POST" class="mb-4">
                        @csrf
                        <div class="input-group">
                            <input type="text" name="nom" class="form-control" placeholder="Nom de la nouvelle salle" required>
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-plus me-1"></i>Créer
                            </button>
                        </div>
                    </form> --}}

                    <h6 class="border-bottom pb-2 mb-3">Salles existantes</h6>
                    <div class="salles-list">
                        @foreach($salles as $salle)
                            <div class="salle-item d-flex justify-content-between align-items-center p-2 border rounded mb-2">
                                <div>
                                    <strong>{{ $salle->nom }} - @foreach ($salle->delegues as $delegue) {{ $delegue->name }} @if (!$loop->last), @endif @endforeach</strong>
                                    <small class="text-muted d-block">{{ $salle->paiements_count }}/{{ $salle->paiements->count() }} paiements validés </small>
                                    <small class="text-muted d-block">{{ $salle->paiements->where('status', 'valide')->sum('montant') }} FCFA / {{ $salle->paiements->sum('montant') }} FCFA</small>
                                </div>
                                {{-- <button type="button" class="btn btn-sm btn-primary" data-salle-id="{{ $salle->id }}" data-toggle="modal" data-target="#editSalleModal"><i class="fas fa-edit me-1"></i>Modifier</button> --}}
                                {{-- <button type="button" class="btn btn-sm btn-danger" onclick="if(confirm('Êtes-vous sûr de vouloir supprimer cette salle ?')) { window.location='{{ route('admin.supprimer-salle', $salle->id) }}'; }"><i class="fas fa-trash me-1"></i>Supprimer</button> --}}
                                <a href="{{ route('admin.liste-paiements-salle', $salle->id) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-list me-1"></i>Voir
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- Nommer un délégué -->
        <div class="col-xl-6 col-lg-12 mb-4">
            <div class="card h-100">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0"><i class="fas fa-user-graduate me-2"></i>Nommer un délégué</h5>
                </div>
                <div class="card-body">
                    {{-- <form action="{{ route('admin.nommer-delegue') }}" method="POST" id="delegueForm">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label fw-bold">Rechercher un étudiant</label>
                            <select name="etudiant_id" class="form-control select2-etudiant" required>
                                <option value="">Sélectionner un étudiant</option>
                                @foreach(\App\Models\User::where('role', 'etudiant')->get() as $etudiant)
                                <option value="{{ $etudiant->id }}" data-salle="{{ $etudiant->salle_id }}">
                                    {{ $etudiant->name }} - {{ $etudiant->email }}
                                    @if($etudiant->salle)
                                        ({{ $etudiant->salle->nom }})
                                    @endif
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Salle de classe</label>
                            <select name="salle_id" class="form-control" required id="salleSelect">
                                <option value="">Sélectionner une salle</option>
                                @foreach($salles as $salle)
                                <option value="{{ $salle->id }}">{{ $salle->nom }}</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="btn btn-success w-100">
                            <i class="fas fa-user-check me-1"></i>Nommer délégué
                        </button>
                    </form> --}}
                    <div class="my-4 overflow-scroll ">
                        <h1>Liste des delegues</h1>
                        <table style="width:100">
                            <thead>
                                <tr>
                                    <th style="width: 50%">Nom</th>
                                    <th style="width: 25%">Salle</th>
                                    {{-- <th style="width: 25%">Action</th> --}}
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($delegues as $delegue)
                                    <tr>
                                        <td>{{ $delegue->name }}</td>
                                        <td>{{ $delegue->salle->nom }} </td>
                                        {{-- <td>
                                            <button class="btn btn-danger" onclick="removeDelegue({{ $delegue->id }})">Enlever delegue</button>
                                        </td> --}}
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Liste des paiements et statistiques par salle -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0"><i class="fas fa-file-invoice-dollar me-2"></i>Liste des paiements validés</h5>
                </div>
                <div class="card-body">
                    <div class="d-flex flex-wrap gap-2 mb-4">
                        <a href="{{ route('admin.liste-paiements') }}" class="btn btn-primary">
                            <i class="fas fa-list me-1"></i>Voir tous les paiements
                        </a>

                        @foreach($salles as $salle)
                        <a href="{{ route('admin.liste-paiements-salle', $salle->id) }}" class="btn btn-outline-primary">
                            {{ $salle->nom }}
                            <span class="badge bg-primary ms-1">{{ $salle->paiements_count }}</span>
                        </a>
                        @endforeach
                    </div>

                    <!-- Statistiques par salle -->
                    <div class="row">
                        @foreach($salles as $salle)
                        <div class="col-xl-3 col-md-4 col-sm-6 mb-3">
                            <div class="card salle-stat-card">
                                <div class="card-body text-center ">
                                    <h6 class="">{{ $salle->nom }}</h6>

                                    @php
                                        $montantSalle = \App\Models\Paiement::where('salle_id', $salle->id)
                                            ->where('status', 'valide')
                                            ->sum('montant');
                                    @endphp
                                    <div class="salle-stat d-flex justify-content-center align-items-center">
                                        <div class="d-flex justify-content-center align-items-center me-3 mr-4">
                                            <span class="">{{ $salle->paiements_count }}</span>
                                            <small class="text-muted d-block">paiements</small>
                                        </div>
                                        <strong class="text-success">{{ number_format($montantSalle, 0, ',', ' ') }} FCFA</strong>
                                        <a href="{{ route('admin.liste-paiements-salle', $salle->id) }}" class="btn btn-sm btn-outline-primary ml-20">
                                            <i class="fas fa-eye me-1"></i>Voir
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Section Téléchargement PDF -->
<div class="row mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-warning text-white">
                <h5 class="mb-0"><i class="fas fa-download me-2"></i>Télécharger les Listes</h5>
            </div>
            <div class="card-body">
                <div class="d-flex flex-wrap gap-3">
                    <a href="{{ route('admin.telecharger-liste-paiements') }}" class="btn btn-success">
                        <i class="fas fa-file-pdf me-2"></i>Télécharger liste complète
                    </a>

                    @foreach($salles as $salle)
                    <a href="{{ route('admin.telecharger-liste-paiements-salle', $salle->id) }}" class="btn btn-outline-success">
                        <i class="fas fa-download me-1"></i>{{ $salle->nom }}
                        <span class="badge bg-primary ms-1">{{ $salle->paiements_count }}</span>
                    </a>
                    @endforeach
                </div>
                <small class="text-muted mt-2 d-block">
                    <i class="fas fa-info-circle me-1"></i>
                    Téléchargez la liste des étudiants ayant payé leur parrainage au format PDF
                </small>
            </div>
        </div>
    </div>
    <div class="modal fade" id="editSalleModal" tabindex="-1" aria-labelledby="editSalleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editSalleModalLabel">Modifier la salle</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <form method="POST" action="{{ route('admin.creer-salle') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="salleName" class="form-label">Nom de la salle</label>
                            <input type="text" class="form-control" id="salleName" name="nom" required>
                        </div>
                        <input type="hidden" id="salleId" name="salle_id">
                        <button type="submit" class="btn btn-primary">Enregistrer les modifications</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>
<style>
    .stat-card {
        border: none;
        border-radius: 15px;
        transition: transform 0.3s ease;
    }

    .stat-card:hover {
        transform: translateY(-5px);
    }

    .stat-icon {
        font-size: 2.5rem;
        opacity: 0.7;
    }

    .salle-item {
        transition: all 0.3s ease;
    }

    .salle-item:hover {
        background-color: #f8f9fa;
        transform: translateX(5px);
    }

    .salle-stat-card {
        border: none;
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        transition: all 0.3s ease;
    }

    .salle-stat-card:hover {
        box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        transform: translateY(-3px);
    }

    .stat-number {
        font-size: 1.8rem;
        font-weight: bold;
        color: #2c3e50;
    }

    .select2-etudiant {
        width: 100% !important;
    }

    @media (max-width: 768px) {
        .card-body {
            padding: 1rem;
        }

        .btn {
            margin-bottom: 0.5rem;
        }

        .salle-stat-card {
            margin-bottom: 1rem;
        }
    }

    @media (max-width: 576px) {
        .container-fluid {
            padding: 0 10px;
        }

        .stat-card .card-body {
            padding: 1rem;
        }

        .stat-icon {
            font-size: 2rem;
        }
    }
</style>

<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
<script src="https://kit.fontawesome.com/your-fontawesome-kit.js" crossorigin="anonymous"></script>

<script>
    $(document).ready(function() {
        // Initialiser Select2 pour la recherche d'étudiants
        $('.select2-etudiant').select2({
            placeholder: "Rechercher un étudiant...",
            allowClear: true,
            width: '100%',
            language: {
                noResults: function() {
                    return "Aucun étudiant trouvé";
                }
            }
        });

        // Auto-remplir la salle quand un étudiant est sélectionné
        $('.select2-etudiant').on('change', function() {
            var selectedOption = $(this).find('option:selected');
            var salleId = selectedOption.data('salle');

            if (salleId) {
                $('#salleSelect').val(salleId).trigger('change');
            }
        });

        // Animation des cartes au chargement
        $('.stat-card').each(function(index) {
            $(this).delay(100 * index).animate({
                opacity: 1
            }, 300);
        });
    });

    function removeDelegue(delegueId) {
        if (confirm('Êtes-vous sûr de vouloir enlever ce délégué ?')) {
            fetch(`/admin/enlever-delegue/${delegueId}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                }
            })
            .then(response => {
                if (response.ok) {
                    location.reload();
                } else {
                    alert('Erreur lors de la suppression du délégué.');
                }
            })
            .catch(error => {
                console.error('Erreur:', error);
                alert('Erreur lors de la suppression du délégué.');
            });
        }
    }
</script>

<!-- Remplacez votre-fontawesome-kit.js par votre vrai kit FontAwesome -->
<!-- Ou utilisez la CDN : -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
@endsection
