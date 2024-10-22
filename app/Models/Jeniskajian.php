<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JenisKajian extends Model
{
    protected $table = 'jeniskajians'; // Ensure this matches your table name
    protected $fillable = ['name'];

    public function kajians()
    {
        return $this->hasMany(Kajian::class);
    }
}
