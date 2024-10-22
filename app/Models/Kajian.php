<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kajian extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'description', 'youtube_link', 'image', 'start_time', 'ustadz_id', 'jeniskajian_id',
    ];

    public function ustadz()
    {
        return $this->belongsTo(Ustadz::class);
    }

    public function jeniskajian()
    {
        return $this->belongsTo(Jeniskajian::class);
    }
}
