<?php

namespace Frikishaan\Autonumber\Models;

use Illuminate\Database\Eloquent\Model;

class Autonumber extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'table_name', 'column_name', 'prefix', 'suffix', 'min_digits', 'next_number',
    ];
}
