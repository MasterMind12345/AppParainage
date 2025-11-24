<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Gestion Paiement</title>

        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

        <style>
            body {
                font-family: 'Instrument Sans', sans-serif;
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                min-height: 100vh;
            }
            .welcome-card {
                background: white;
                border-radius: 15px;
                box-shadow: 0 10px 30px rgba(0,0,0,0.1);
                overflow: hidden;
            }
            .welcome-header {
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                color: white;
                padding: 2rem;
                text-align: center;
            }
            .feature-icon {
                width: 60px;
                height: 60px;
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                margin: 0 auto 1rem;
                color: white;
                font-size: 1.5rem;
            }
            .btn-primary {
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                border: none;
                padding: 10px 30px;
                border-radius: 25px;
                font-weight: 500;
            }
            .btn-primary:hover {
                transform: translateY(-2px);
                box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
            }
        </style>
    </head>
    <body>
        <div class="container py-5">
            <div class="row justify-content-center">
                <div class="col-md-10">
                    <div class="welcome-card">
                        <div class="welcome-header">
                            <h1 class="display-4 fw-bold">Gestion Paiement</h1>
                            <p class="lead mb-0">Système de gestion des paiements de parrainage</p>
                        </div>

                        <div class="p-5">
                            <div class="row mb-5">
                                <div class="col-md-4 text-center mb-4">
                                    <div class="feature-icon">
                                        <i class="bi bi-credit-card"></i>
                                    </div>
                                    <h5>Paiement Simplifié</h5>
                                    <p class="text-muted">Initiez facilement vos paiements de 3500 FCFA</p>
                                </div>
                                <div class="col-md-4 text-center mb-4">
                                    <div class="feature-icon">
                                        <i class="bi bi-shield-check"></i>
                                    </div>
                                    <h5>Validation Sécurisée</h5>
                                    <p class="text-muted">Validation par les délégués de classe</p>
                                </div>
                                <div class="col-md-4 text-center mb-4">
                                    <div class="feature-icon">
                                        <i class="bi bi-receipt"></i>
                                    </div>
                                    <h5>Reçu Automatique</h5>
                                    <p class="text-muted">Téléchargez vos reçus après validation</p>
                                </div>
                            </div>

                            <div class="text-center mb-4">
                                @if (Route::has('login'))
                                    <div class="d-grid gap-3 d-md-flex justify-content-center">
                                        @auth
                                            <a href="{{ url('/home') }}" class="btn btn-primary btn-lg">
                                                <i class="bi bi-speedometer2 me-2"></i>Tableau de Bord
                                            </a>
                                        @else
                                            <a href="{{ route('login') }}" class="btn btn-primary btn-lg">
                                                <i class="bi bi-box-arrow-in-right me-2"></i>Connexion
                                            </a>
                                            <a href="{{ route('register') }}" class="btn btn-outline-primary btn-lg">
                                                <i class="bi bi-person-plus me-2"></i>Inscription
                                            </a>
                                        @endauth
                                    </div>
                                @endif
                            </div>

                            @auth
                                <div class="text-center mt-4">
                                    @if(Auth::user()->isAdmin())
                                        <a href="{{ url('/admin/dashboard') }}" class="btn btn-success btn-sm">
                                            <i class="bi bi-gear me-1"></i>Panel Admin
                                        </a>
                                    @elseif(Auth::user()->isDelegue())
                                        <a href="{{ url('/delegue/dashboard') }}" class="btn btn-warning btn-sm">
                                            <i class="bi bi-shield-check me-1"></i>Panel Délégué
                                        </a>
                                    @else
                                        <a href="{{ url('/etudiant/dashboard') }}" class="btn btn-info btn-sm">
                                            <i class="bi bi-person me-1"></i>Panel Étudiant
                                        </a>
                                    @endif
                                </div>
                            @endauth

                            <div class="row mt-5 pt-4 border-top">
                                <div class="col-md-6">
                                    <h6>Pour les étudiants :</h6>
                                    <ul class="list-unstyled text-muted">
                                        <li><i class="bi bi-check-circle text-success me-2"></i>Initier un paiement</li>
                                        <li><i class="bi bi-check-circle text-success me-2"></i>Suivre le statut</li>
                                        <li><i class="bi bi-check-circle text-success me-2"></i>Télécharger le reçu</li>
                                    </ul>
                                </div>
                                <div class="col-md-6">
                                    <h6>Pour les délégués :</h6>
                                    <ul class="list-unstyled text-muted">
                                        <li><i class="bi bi-check-circle text-success me-2"></i>Valider les paiements</li>
                                        <li><i class="bi bi-check-circle text-success me-2"></i>Gérer sa classe</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="text-center mt-4">
                        <p class="text-white mb-0">
                            &copy; {{ date('Y') }} Gestion Paiement - Club GI 2026. Tous droits réservés.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bootstrap JS -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>
