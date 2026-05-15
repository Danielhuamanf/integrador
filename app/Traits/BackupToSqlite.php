<?php

namespace App\Traits;

use Illuminate\Support\Facades\DB;

trait BackupToSqlite
{
    protected static function bootBackupToSqlite()
    {
        static::created(function ($model) {

            DB::connection('sqlite_backup')
                ->table($model->getTable())
                ->insert($model->toArray());

        });
    }
}