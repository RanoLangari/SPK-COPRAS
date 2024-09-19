<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kriteria extends Model
{
    use HasFactory;

    protected $table = 'kriteria';
    protected $fillable = ['nama_kriteria', 'bobot', 'tipe'];

    public function nilai()
    {
        return $this->hasMany(Nilai::class);
    }

    public function subkriteria()
    {
        return $this->hasMany(SubKriteria::class);
    }
}
