<!doctype html>
<html lang="fr">
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width,initial-scale=1" />
<title>Reçu - Parrainage</title>
    <style>
        * { box-sizing: border-box; }
        a { color:#0b4a7a; text-decoration:none; }
        body { font-family: "Helvetica Neue", Arial, sans-serif; margin: 0; color:#222; }
        .page { max-width: 800px; margin: 0 auto; background: #fff; border-radius: 8px; padding: 28px; box-shadow: 0 6px 20px rgba(18,25,40,0.06); }
        header { display:flex; align-items:center; justify-content:space-between; gap:16px; }
        .brand { display:flex; align-items:center; gap:16px; }
        .brand img { height:64px; width:auto; object-fit:contain; border-radius:8px; background:#fff; padding:6px; }
        .brand .title { font-size:20px; line-height:1; font-weight:700; color:#0b4a7a; }
        .brand .subtitle { font-size:12px; color:#577388; margin-top:4px; }

        .meta { text-align:right; }
        .meta .id { font-weight:700; color:#0b4a7a; }
        .meta .date { font-size:12px; color:#6b7b8c; margin-top:6px; }

        hr.sep { border: none; height:1px; background: linear-gradient(90deg, rgba(11,74,122,0.06), rgba(11,74,122,0.04)); margin:20px 0; }

        .grid { display:grid; grid-template-columns: 1fr 260px; gap:20px; align-items:start; }
        .block { background: #fbfdff; padding:16px; border-radius:8px; border:1px solid #eef4fb; }
        .block h3 { margin:0 0 6px 0; font-size:13px; color:#0b4a7a; }
        .small { font-size:12px; color:#586b7e; margin-top:4px; margin-left: 5px;}

        .items { margin-top:10px; border-collapse:collapse; width:100%; }
        .items th, .items td { padding:10px 8px; border-bottom:1px dashed #e6eef6; text-align:left; font-size:13px; }
        .items th { font-size:12px; color:#4f6a84; font-weight:700; background:transparent; border-bottom:2px solid rgba(11,74,122,0.04); }
        .items .right { text-align:right; }

        .total-row { background: linear-gradient(90deg, rgba(11,74,122,0.03), rgba(11,74,122,0.01)); font-weight:700; }
        .amount { font-size:22px; color:#0b4a7a; }

        .qr { display:flex; flex-direction:column; align-items:center; gap:8px; padding:12px; border-radius:8px; background:#fff; border:1px solid #e6eef6; }
        .qr img { width:180px; height:180px; object-fit:contain; background:#fff; padding:8px; }
        .small-muted { font-size:11px; color:#8b99a8; }

        footer { margin-top:20px; display:flex; justify-content:space-between; gap:12px; align-items:center; flex-wrap:wrap; }
        .notes { font-size:12px; color:#5b6e7f; max-width:60%; }
        .contact { text-align:right; font-size:12px; color:#5b6e7f; }
        .watermark {
            position: fixed;
            top: 45%;
            left: 55%;
            transform: translate(-50%, -50%) rotate(-40deg);
            font-size: 40px;
            font-weight: 700;
            color: rgba(0,0,0,0.06);
            letter-spacing: 8px;
            white-space: nowrap;
            pointer-events: none;
            z-index: 0;
            user-select: none;
        }


        @media print {
            body { background: #fff; }
            .page { box-shadow:none; border:none; margin:0; border-radius:0; padding:16mm; }
        }

        /* small screens */
        @media (max-width:720px) {
            .grid { grid-template-columns: 1fr; }
            .meta { text-align:left; margin-top:10px; }
            .brand .title { font-size:18px; }
            .brand img { height:56px; }
            .qr img { width:140px; height:140px; }
            footer .notes { max-width:100%; }
        }
    </style>
</head>
<body>
    <div class="page">
        <header>
            <div class="brand">
                <img src="{{ $logoBase64 }}" alt="Logo évènement">
                <div>
                    <div class="title">Ceremonie de parrainage — Reçu de paiement</div>
                    <div class="subtitle">L’innovation au cœur de l’entrepreneuriat</div>
                </div>
            </div>

            <div class="meta" style="margin-bottom: 20px">
                <div class="id">Reçu #<span id="receipt-id">GI_PA_{{ $paiement->id }}</span></div>
                <div class="date"><span id="receipt-date">Valide par : {{ $paiement->delegue->name }}</span></div>
            </div>
        </header>


        <div class="grid">
            <div>
                <div class="block">
                    <h3>Informations de l'étudiant</h3>
                    <div class="small"><strong>Nom :</strong> <span id="attendee-name">{{  $paiement->name }}</span></div>
                    <div class="small"><strong>Salle :</strong> <span id="attendee-email">{{ $paiement->salle->nom }}</span></div>
                    <div class="small"><strong>Téléphone :</strong> <span id="attendee-phone">{{ $paiement->telephone }}</span></div>
                    <div style="height:6px"></div>
                    <h3>Événement</h3>
                    <div class="small"><strong>Événement :</strong> <span id="event-name">Ceremonie de parrainage GI</span></div>
                    <div class="small"><strong>Date :</strong> <span id="event-date">15 décembre 2025</span></div>
                    <div class="small"><strong>Lieu :</strong> <span id="event-location">IUT de Douala - Amphi 200</span></div>
                </div>

                <div style="height:14px"></div>

                <div class="block">
                    <h3>Détails du paiement</h3>
                    <table class="items" role="table" aria-label="Détails">
                        <thead>
                        <tr>
                            <th>Description</th>
                            <th class="right">Montant</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>Ticket d'accès - Ceremonie de parrainage</td>
                            <td class="right">XAF <span id="amount-1">3 500</span></td>
                        </tr>
                        @if ($paiement->montant > 3500)
                            <tr>
                                <td>Supplément</td>
                                <td class="right">XAF <span id="amount-2">{{ $paiement->montant - 3500 }}</span></td>
                            </tr>
                        @endif
                        <tr class="total-row">
                            <td>Total payé</td>
                            <td class="right amount">XAF <span id="total-amount">{{ $paiement->montant }}</span></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <hr class="sep" style="border-top: none; border-bottom: 4px dashed #000; margin: 20px 0;">
            <aside>
                <div class="qr" role="figure" aria-label="QR code du billet">
                    <img src="{{ $qrBase64 }}" alt="QR code">
                    <div class="small-muted">Présentez ce QR à l'entrée</div>
                </div>
            </aside>
        </div>

        <footer>
            <div class="notes">
                <strong>Remarques :</strong>
                <div style="height:6px"></div>
                <div>Ce reçu vaut preuve d’inscription a la Ceremonie de parrainage. Merci de vous munir d'une copie imprimée. Si vous avez des questions, ecrivez-nous au <a href="mailto:contact@gdg-devfest.cm">iutclubgi@gmail.com</a>.</div>
            </div>

            <div class="contact" style="margin: 10px 0;">
                <div><strong>La cellule informatique</strong></div>
                <div class="small">iutclubgi@gmail.com</div>
            </div>
        </footer>
    </div>
    <div class="watermark"> GI-{{ $paiement->code }} </div>
</body>
</html>
