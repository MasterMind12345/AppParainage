<?php

namespace App\Services;

use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\Logo\Logo;


class TwoDDocService
{
    public function generateQrCode(string $data): string
    {
        $logoPath = public_path('logo.jpeg');

        // Créer un QR Code
        $qrCode = new QrCode($data);


        // Utiliser un writer pour générer l'image
        $writer = new PngWriter();
        $logo = new Logo($logoPath, 50);
        $result = $writer->write($qrCode, $logo);
        file_put_contents(public_path('qrcode.png'), $result->getString());

        // Retourne l'image en binaire
        return $result->getString();
    }
}
