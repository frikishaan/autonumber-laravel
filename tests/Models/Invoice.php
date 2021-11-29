<?php

namespace Frikishaan\Autonumber\Tests\Models;

use Frikishaan\Autonumber\Traits\HasAutonumber;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasAutonumber;
    
    protected $fillable = [
        'customer', 'amount'
    ];
}