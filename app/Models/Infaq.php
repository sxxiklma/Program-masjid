<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Infaq extends Model
{
    use HasFactory;

    public function Jamaah()
    {
    return $this->hasMany(Jamaah::class);
    }
}
