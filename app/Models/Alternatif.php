<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alternatif extends Model
{
 
    use HasFactory;
    
    protected $table = 'alternatif';
    protected $fillable = ['nama_alternatif','kategori','periode'];

    public function nilai()
    {
        return $this->hasMany(NIlai::class);
    }

    public function rangking()
    {
        return $this->hasOne(Rangking::class, 'alternatif_id');
    }
}
