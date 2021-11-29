<?php

namespace Frikishaan\Autonumber\Traits;

use Frikishaan\Autonumber\Autonumber;
use Illuminate\Database\Eloquent\Model;

trait HasAutonumber
{
    public static function bootHasAutonumber()
    {
        // Function to run when record is creating
        static::creating(function (Model $model) {
            Autonumber::generate($model);
        });

    }
}
