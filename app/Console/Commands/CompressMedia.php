<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Post;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class CompressMedia extends Command
{
    // Nama perintah di terminal
    protected $signature = 'media:compress {--video}';

    protected $description = 'Kompres gambar & cover postingan (opsional: video)';

    public function handle()
    {
        $this->info('🔧 Memulai kompresi media...');

        // Ambil semua posting yang punya file atau cover
        $posts = Post::whereNotNull('file_path')
            ->orWhereNotNull('cover_path')
            ->get();

        foreach ($posts as $post) {
            // Kompres cover
            if ($post->cover_path && Storage::exists('public/' . $post->cover_path)) {
                $this->compressImage($post->cover_path);
                $this->line("📸 Kompres cover: {$post->cover_path}");
            }

            // Kompres gambar utama
            if ($post->file_path && preg_match('/\.(jpg|jpeg|png|webp)$/i', $post->file_path)) {
                $this->compressImage($post->file_path);
                $this->line("🖼️ Kompres gambar: {$post->file_path}");
            }

            // Kompres video kalau pakai opsi --video
            if ($this->option('video') && $post->file_path && preg_match('/\.(mp4|webm)$/i', $post->file_path)) {
                $this->compressVideo($post->file_path);
                $this->line("🎬 Kompres video: {$post->file_path}");
            }
        }

        $this->info('✅ Selesai semua!');
    }

    protected function compressImage($path)
    {
        $fullPath = storage_path('app/public/' . $path);
        if (!file_exists($fullPath)) return;

        // Buat instance ImageManager (pakai GD driver)
        $manager = new ImageManager(new Driver());
        $img = $manager->read($fullPath);

        // Resize jika terlalu besar
        if ($img->width() > 1920) {
            $img->scaleDown(1920);
        }

        // Simpan dengan kualitas 80%
        $img->save($fullPath, quality: 80);
    }

    protected function compressVideo($path)
    {
        $ffmpegExists = shell_exec(PHP_OS_FAMILY === 'Windows' ? 'where ffmpeg' : 'which ffmpeg');
        if (!$ffmpegExists) {
            $this->warn("⚠️ ffmpeg tidak ditemukan, skip video: {$path}");
            return;
        }

        $fullPath = storage_path('app/public/' . $path);
        $tempPath = $fullPath . '.tmp.mp4';

        exec("ffmpeg -i {$fullPath} -vcodec libx264 -crf 28 -preset veryfast -acodec aac -b:a 128k {$tempPath} -y");

        if (file_exists($tempPath)) {
            rename($tempPath, $fullPath);
        }
    }
}