<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Kategoribuku;

class Buku extends Model
{
    use HasFactory;

    /**
     * fillable
     *
     * @var array
     */
    protected $table = 'bukus';
    protected $fillable = [
        'nama',
        'isbn',
        'tahun',
        'jumlah',
        'gambar',
        'id_kategori'
    ];

    public function kategoris()
{
    return $this->belongsTo(Kategoribuku::class, 'id_kategori', 'id'); // Perhatikan urutan parameter
}
}