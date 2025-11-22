<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>R{{ $paiement->id }}</title>
    <style>
        *{margin:0;padding:0;box-sizing:border-box}body{font-family:'Courier New',monospace;background:#f8fafc;padding:10px;font-size:12px}.receipt{max-width:400px;margin:0 auto;background:white;border:2px solid #1f2937;position:relative}.header{background:#1f2937;color:white;padding:15px;text-align:center;border-bottom:3px double white}.header h1{font-size:16px;font-weight:700;letter-spacing:2px}.content{padding:20px}.section{margin-bottom:15px}.section-title{font-weight:700;color:#1f2937;border-bottom:1px solid #d1d5db;padding-bottom:5px;margin-bottom:8px;font-size:11px;text-transform:uppercase}.info-grid{display:grid;gap:8px}.info-item{display:flex;justify-content:space-between}.info-label{color:#6b7280;font-weight:500}.info-value{font-weight:700;text-align:right}.amount-section{background:#ecfdf5;border:2px solid #10b981;padding:15px;text-align:center;margin:15px 0}.amount{font-size:20px;font-weight:900;color:#059669}.security-code{background:#1f2937;color:#10b981;padding:8px;margin:10px 0;font-family:monospace;font-size:10px;letter-spacing:1px;text-align:center;border:1px dashed #10b981}.footer{background:#1f2937;color:white;padding:10px;text-align:center;font-size:9px}.crypto-mark{position:absolute;top:5px;right:5px;background:black;color:#10b981;padding:3px 6px;font-size:8px;font-family:monospace;border:1px solid #10b981}.watermark{position:absolute;top:50%;left:50%;transform:translate(-50%,-50%) rotate(-45deg);font-size:60px;color:rgba(0,0,0,0.03);font-weight:900;white-space:nowrap;pointer-events:none;font-family:monospace}@media print{body{background:white;padding:0}.receipt{border:none;box-shadow:none}}
    </style>
</head>
<body>
    <div class="receipt">
        <!-- Marque cryptique illisible -->
        <div class="crypto-mark">§{{ substr(hash('sha256', $paiement->id . $paiement->created_at), 0, 8) }}¶</div>
        
        <!-- Filigrane crypté -->
        <div class="watermark">{{ base64_encode($paiement->id . '|' . $paiement->created_at) }}</div>
        
        <!-- En-tête -->
        <div class="header">
            <h1>REÇU CERTIFIÉ</h1>
        </div>
        
        <!-- Contenu -->
        <div class="content">
            <!-- Informations étudiant -->
            <div class="section">
                <div class="section-title">ÉTUDIANT</div>
                <div class="info-grid">
                    <div class="info-item">
                        <span class="info-label">NOM:</span>
                        <span class="info-value">{{ strtoupper($paiement->etudiant->name) }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">SALLE:</span>
                        <span class="info-value">{{ $paiement->salle->nom }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">TEL:</span>
                        <span class="info-value">{{ $paiement->telephone }}</span>
                    </div>
                </div>
            </div>
            
            <!-- Détails transaction -->
            <div class="section">
                <div class="section-title">TRANSACTION</div>
                <div class="info-grid">
                    <div class="info-item">
                        <span class="info-label">DATE:</span>
                        <span class="info-value">{{ \Carbon\Carbon::parse($paiement->created_at)->format('d/m/y H:i') }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">REF:</span>
                        <span class="info-value">#{{ str_pad($paiement->id, 6, '0', STR_PAD_LEFT) }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">VALIDÉ PAR:</span>
                        <span class="info-value">{{ $paiement->delegue ? substr($paiement->delegue->name, 0, 3) . '...' : 'SYS' }}</span>
                    </div>
                </div>
            </div>
            
            <!-- Montant -->
            <div class="amount-section">
                <div class="amount">{{ number_format($paiement->montant, 0, ',', ' ') }} FCFA</div>
                <div style="font-size:9px;color:#059669;margin-top:5px;font-weight:700">PAIEMENT PARRAINAGE</div>
            </div>
            
            <!-- Code de sécurité cryptique -->
            <div class="security-code">
                {{ hash('sha256', $paiement->id . $paiement->etudiant->id . $paiement->created_at) }}
            </div>
            
            <!-- Signatures compactes -->
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:15px;margin-top:15px;font-size:9px">
                <div style="text-align:center">
                    <div style="border-bottom:1px solid #d1d5db;padding-bottom:12px"></div>
                    <div style="color:#6b7280;margin-top:3px">ÉTUDIANT</div>
                </div>
                <div style="text-align:center">
                    <div style="border-bottom:1px solid #d1d5db;padding-bottom:12px"></div>
                    <div style="color:#6b7280;margin-top:3px">DÉLÉGUÉ</div>
                </div>
            </div>
        </div>
        
        <!-- Pied de page crypté -->
        <div class="footer">
            <div style="margin-bottom:5px;color:#10b981;font-family:monospace;letter-spacing:1px">
                {{ base64_encode(hash('sha512', $paiement->id . config('app.name'))) }}
            </div>
            <div>REÇU CERTIFIÉ NUMÉRIQUEMENT • {{ \Carbon\Carbon::now()->format('d/m/y H:i:s') }}</div>
        </div>
    </div>
</body>
</html>