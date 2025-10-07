<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'file_path',
        'cover_path',    // untuk thumbnail / cover opsional
        'category',      // images, music, videos, docs
        'doc_type',
        'province',      // provinsi
        'file_category', // kategori budaya
        'user_id'
    ];

    // Relasi dengan tabel Likes
    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    // Relasi dengan tabel Comments
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}