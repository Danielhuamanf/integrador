<?php
use App\Models\Usuario;
use App\Observers\UsuarioObserver;

public function boot(): void
{
    Usuario::observe(UsuarioObserver::class);
}