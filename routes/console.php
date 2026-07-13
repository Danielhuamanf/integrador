<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
<<<<<<< HEAD
=======
use App\Services\IncidenciaCorreoImporter;
>>>>>>> dev

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');
<<<<<<< HEAD
=======

Artisan::command('incidencias:importar-correos', function (IncidenciaCorreoImporter $importer) {
    $total = $importer->importar();
    $this->info("Correos importados: {$total}");
})->purpose('Importar correos de soporte y crear incidencias');
>>>>>>> dev
