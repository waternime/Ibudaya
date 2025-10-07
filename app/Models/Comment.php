<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'post_id',
        'user_id',
        'content',
        'parent_id', // WAJIB biar reply tersimpan
    ];

    // Relasi ke Post
    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi replies (child comments)
    public function replies()
    {
        return $this->hasMany(Comment::class, 'parent_id')
                    ->with('user', 'replies');
    }

    // Relasi parent (opsional)
    public function parent()
    {
        return $this->belongsTo(Comment::class, 'parent_id');
    }

    // Hapus semua reply ketika komentar dihapus
    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($comment) {
            $comment->replies()->delete();
        });
    }
}