<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Buku;

class Kategoribuku extends Model
{
    use HasFactory;

    protected $table = 'kategoris';
    protected $fillable = [
        'nama'
    ];

    public function buku()
    {
        return $this->hasMany(Buku::class, 'id_kategori', 'id');
    }
}