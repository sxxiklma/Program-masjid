<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jamaah extends Model
{
    use HasFactory;
    public function Infaq()
    {
    return $this->belongsTo(Infaq::class);
    }
    public function user()
    {
    return $this->belongsTo(User::class);
    }
    public function jamaahs()
    {
    return $this->hasMany(Jamaah::class);
    }
    protected $fillable = ['nama', 'nomor', 'alamat', 'nominal', 'infaq_id', 'file_path', 'user_id'];
}
