<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use App\Services\IncidenciaCorreoImporter;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('incidencias:importar-correos', function (IncidenciaCorreoImporter $importer) {
    $total = $importer->importar();
    $this->info("Correos importados: {$total}");
})->purpose('Importar correos de soporte y crear incidencias');
