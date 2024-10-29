<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nilai extends Model
{
    use HasFactory;

    protected $table = 'nilai';
    protected $fillable = ['alternatif_id','kriteria_id','subkriteria_id','nilai'];

    public function alternatif()
    {
        return $this->belongsTo(Alternatif::class);
    }

    public function subkriteria()
    {
        return $this->belongsTo(SubKriteria::class);
    }
}
