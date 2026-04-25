<?php

namespace App\Services\Internal;

use Mpdf\Mpdf;
use Mpdf\Config\ConfigVariables;
use Mpdf\Config\FontVariables;
use App\Models\SiteSetting;

class PdfService extends BaseInternalService
{
    public static function make(): Mpdf
    {
        $defaultConfig = (new ConfigVariables())->getDefaults();
        $fontDirs = $defaultConfig['fontDir'];

        $defaultFontConfig = (new FontVariables())->getDefaults();
        $fontData = $defaultFontConfig['fontdata'];

        $mpdf = new Mpdf([
            'mode' => 'utf-8',
            'format' => 'A4',
            'margin_top' => 10,
            'margin_bottom' => 30,
            'margin_left' => 10,
            'margin_right' => 10,
            'fontDir' => array_merge($fontDirs, [
                public_path('fonts/Tajawal/ttf'),
            ]),
            'fontdata' => $fontData + [
                'tajawal' => [
                    'R' => 'Tajawal-Regular.ttf',
                    'B' => 'Tajawal-Bold.ttf',
                    'useOTL' => 0xFF,
                    'useKashida' => 75,
                ],
            ],
            'default_font' => 'tajawal',
            'autoScriptToLang' => true,
            'autoLangToFont' => true,
        ]);

        $mpdf->SetDirectionality('rtl');

        return $mpdf;
    }

    public static function getSettings(): array
    {
        return app(\App\Services\SettingService::class)->getLocalizedSettings();
    }
}
