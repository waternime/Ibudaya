<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Post;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class CompressMedia extends Command
{
    /**
     * Jalankan dengan:
     *  php artisan media:compress
     *  php artisan media:compress --video  ← untuk sekalian kompres video
     */
    protected $signature = 'media:compress {--video : Sertakan kompresi video juga}';
    protected $description = 'Kompres semua gambar, cover, dan (opsional) video di storage/public/posts.';

    public function handle()
    {
        $this->info('🔧 Memulai proses kompresi media...');

        // Ambil semua posting yang punya file_path atau cover_path
        $posts = Post::whereNotNull('file_path')
            ->orWhereNotNull('cover_path')
            ->get();

        if ($posts->isEmpty()) {
            $this->warn('⚠️ Tidak ada media ditemukan untuk dikompres.');
            return;
        }

        foreach ($posts as $post) {
            $this->line("\n📝 Post #{$post->id} ({$post->category})");

            // === Kompres cover ===
            if ($post->cover_path && Storage::exists('public/' . $post->cover_path)) {
                $this->compressImage($post->cover_path);
                $newCoverPath = preg_replace('/\.(jpg|jpeg|png)$/i', '.webp', $post->cover_path);

                if ($newCoverPath !== $post->cover_path) {
                    $post->cover_path = $newCoverPath;
                    $post->save();
                }

                $this->line("📸 Cover dikompres → {$post->cover_path}");
            }

            // === Kompres gambar utama ===
            if ($post->file_path && preg_match('/\.(jpg|jpeg|png|webp)$/i', $post->file_path)) {
                $this->compressImage($post->file_path);
                $newFilePath = preg_replace('/\.(jpg|jpeg|png)$/i', '.webp', $post->file_path);

                if ($newFilePath !== $post->file_path) {
                    $post->file_path = $newFilePath;
                    $post->save();
                }

                $this->line("🖼️ Gambar dikompres → {$post->file_path}");
            }

            // === Kompres video (jika opsi --video dipakai) ===
            if ($this->option('video') && $post->file_path && preg_match('/\.(mp4|webm|mkv|mov)$/i', $post->file_path)) {
                $this->compressVideo($post->file_path);
                $this->line("🎬 Video dikompres → {$post->file_path}");
            }
        }

        $this->info("\n✅ Semua media selesai dikompres!");
    }

    /**
     * Kompres & ubah gambar ke WebP
     */
    protected function compressImage($path)
    {
        $fullPath = storage_path('app/public/' . $path);
        if (!file_exists($fullPath) || filesize($fullPath) < 100) {
            $this->warn("⚠️ File gambar tidak valid: {$path}");
            return;
        }

        try {
            $manager = new ImageManager(new Driver());
            $img = $manager->read($fullPath);

            // Resize kalau lebih dari 1920px lebar
            if ($img->width() > 1920) {
                $img->scaleDown(width: 1920);
            }

            // Simpan dalam format WebP (80% kualitas)
            $webpPath = preg_replace('/\.(jpg|jpeg|png)$/i', '.webp', $fullPath);
            $img->toWebp(quality: 80)->save($webpPath);

            // Hapus file lama jika beda ekstensi
            if ($webpPath !== $fullPath) {
                unlink($fullPath);
            }
        } catch (\Exception $e) {
            $this->error("❌ Gagal kompres {$path}: " . $e->getMessage());
        }
    }

    /**
     * Kompres video jika ffmpeg tersedia
     */
    protected function compressVideo($path)
    {
        $ffmpegExists = shell_exec(PHP_OS_FAMILY === 'Windows' ? 'where ffmpeg' : 'which ffmpeg');
        if (!$ffmpegExists) {
            $this->warn("⚠️ ffmpeg tidak ditemukan, lewati video: {$path}");
            return;
        }

        $fullPath = storage_path('app/public/' . $path);
        if (!file_exists($fullPath)) {
            $this->warn("⚠️ File video tidak ditemukan: {$path}");
            return;
        }

        $tempPath = $fullPath . '.tmp.mp4';

        $cmd = sprintf(
            'ffmpeg -i "%s" -vcodec libx264 -crf 28 -preset veryfast -acodec aac -b:a 128k "%s" -y 2>&1',
            $fullPath,
            $tempPath
        );
        exec($cmd, $output, $status);

        if ($status === 0 && file_exists($tempPath)) {
            rename($tempPath, $fullPath);
        } else {
            $this->warn("⚠️ Gagal kompres video: {$path}");
            \Log::warning("FFMPEG gagal untuk {$path}: " . implode("\n", $output));
        }
    }
}