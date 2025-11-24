<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Liste des Paiements - {{ $salleId ? $salles->find($salleId)->nom : 'Toutes les salles' }}</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            line-height: 1.4;
            color: #333;
            font-size: 12px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #333;
            padding-bottom: 15px;
        }
        .header h1 {
            color: #2c3e50;
            margin: 0;
            font-size: 18px;
        }
        .header p {
            margin: 5px 0;
            color: #7f8c8d;
            font-size: 12px;
        }
        .info-section {
            margin-bottom: 15px;
            background: #f8f9fa;
            padding: 10px;
            border-radius: 5px;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }
        .table th {
            background-color: #2c3e50;
            color: white;
            padding: 8px;
            text-align: left;
            font-size: 10px;
            border: 1px solid #ddd;
        }
        .table td {
            padding: 6px;
            border: 1px solid #ddd;
            font-size: 10px;
        }
        .table tr:nth-child(even) {
            background-color: #f8f9fa;
        }
        .total-section {
            margin-top: 20px;
            text-align: right;
            font-weight: bold;
            font-size: 12px;
        }
        .badge {
            padding: 2px 6px;
            border-radius: 10px;
            font-size: 9px;
            font-weight: bold;
        }
        .badge-success {
            background-color: #28a745;
            color: white;
        }
        .badge-info {
            background-color: #17a2b8;
            color: white;
        }
        .statistics {
            /* display: table; */
            grid-template-columns: repeat(3, 1fr);
            gap: 10px;
            margin-bottom: 15px;
        }
        .stat-card {
            background: #e9ecef;
            padding: 10px;
            border-radius: 5px;
            text-align: center;
            display: inline-block
        }
        .stat-number {
            font-size: 16px;
            font-weight: bold;
            color: #2c3e50;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            border-top: 1px solid #bdc3c7;
            padding-top: 10px;
            color: #7f8c8d;
            font-size: 10px;
        }
        .page-break {
            page-break-after: always;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>LISTE DES ÉTUDIANTS AYANT PAYÉ LE PARRAINAGE</h1>
        <p>Système de Gestion des Paiements de Parrainage</p>
        <p>Généré le: {{ \Carbon\Carbon::now()->format('d/m/Y à H:i') }}</p>
        @if($salleId)
        <p><strong>Salle: {{ $salles->find($salleId)->nom }}</strong></p>
        @else
        <p><strong>Toutes les salles</strong></p>
        @endif
    </div>

    <!-- Statistiques -->
    <div class="statistics">
        <div class="stat-card">
            <div class="stat-number">{{ $paiements->count() }}</div>
            <small>Total Paiements</small>
        </div>
        <div class="stat-card">
            <div class="stat-number">{{ number_format($paiements->sum('montant'), 0, ',', ' ') }} FCFA</div>
            <small>Montant Total</small>
        </div>
        <div class="stat-card">
            <div class="stat-number">
                @if($salleId)
                    {{ $salles->find($salleId)->nom }}
                @else
                    {{ $salles->count() }}
                @endif
            </div>
            <small>
                @if($salleId)
                    Salle
                @else
                    Salles
                @endif
            </small>
        </div>
    </div>

    <!-- Tableau des paiements -->
    <table class="table">
        <thead>
            <tr>
                <th>#</th>
                <th>Étudiant</th>
                <th>Code paiement</th>
                <th>Telephone</th>
                <th>Montant</th>
                <th>Téléphone</th>
                <th>Date Validation</th>
                <th>Validé par</th>
            </tr>
        </thead>
        <tbody>
            @foreach($paiements as $index => $paiement)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $paiement->name }}</td>
                <td>{{ $paiement->code }}</td>
                <td>
                    <span class="badge badge-info">{{ $paiement->salle->nom }}</span>
                </td>
                <td style="text-align: right;">{{ number_format($paiement->montant, 0, ',', ' ') }} FCFA</td>
                <td>{{ $paiement->telephone }}</td>
                <td>
                    @if($paiement->valide_le)
                        {{ \Carbon\Carbon::parse($paiement->valide_le)->format('d/m/Y H:i') }}
                    @else
                        N/A
                    @endif
                </td>
                <td>
                    @if($paiement->delegue)
                        {{ $paiement->delegue->name }}
                    @else
                        N/A
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Totaux -->
    <div class="total-section">
        <p>Nombre total d'étudiants: <strong>{{ $paiements->count() }}</strong></p>
        <p>Montant total collecté: <strong>{{ number_format($paiements->sum('montant'), 0, ',', ' ') }} FCFA</strong></p>
    </div>

    <!-- Statistiques par salle si vue globale -->
    @if(!$salleId)
    <div style="margin-top: 30px;">
        <h3 style="color: #2c3e50; border-bottom: 1px solid #bdc3c7; padding-bottom: 5px; font-size: 14px;">
            Statistiques par Salle
        </h3>
        <table class="table">
            <thead>
                <tr>
                    <th>Salle</th>
                    <th>Nombre d'étudiants</th>
                    <th>Montant collecté</th>
                    <th>Pourcentage</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $totalMontant = $paiements->sum('montant');
                @endphp
                @foreach($salles as $salle)
                    @php
                        $paiementsSalle = $paiements->where('salle_id', $salle->id);
                        $countSalle = $paiementsSalle->count();
                        $montantSalle = $paiementsSalle->sum('montant');
                        $pourcentage = $totalMontant > 0 ? ($montantSalle / $totalMontant) * 100 : 0;
                    @endphp
                    @if($countSalle > 0)
                    <tr>
                        <td><strong>{{ $salle->nom }}</strong></td>
                        <td>{{ $countSalle }} étudiants</td>
                        <td style="text-align: right;">{{ number_format($montantSalle, 0, ',', ' ') }} FCFA</td>
                        <td style="text-align: right;">{{ number_format($pourcentage, 1) }}%</td>
                    </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
    </div>
    @endif

    <div class="footer">
        <p>Document généré automatiquement par le système de gestion des paiements</p>
        <p>Page 1/1</p>
    </div>
</body>
</html>
