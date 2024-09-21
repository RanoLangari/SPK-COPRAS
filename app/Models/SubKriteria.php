<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubKriteria extends Model
{
    use HasFactory;
    protected $table = 'subkriteria';
    protected $fillable = ['nama_subkriteria', 'kriteria_id', 'bobot'];

    public function kriteria()
    {
        return $this->belongsTo(Kriteria::class);
    }

    
}
