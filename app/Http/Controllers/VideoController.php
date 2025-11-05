<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class VideoController extends Controller
{
    public function stream($filename, Request $request)
    {
        $path = storage_path('app/public/videos/' . $filename);

        if (!file_exists($path)) {
            abort(404, 'Video tidak ditemukan.');
        }

        $size = filesize($path);
        $start = 0;
        $end = $size - 1;

        // Cek jika ada HTTP_RANGE (seek bar)
        if ($request->headers->has('range')) {
            $range = $request->header('range');
            if (preg_match('/bytes=(\d+)-(\d*)/', $range, $matches)) {
                $start = intval($matches[1]);
                if (!empty($matches[2])) {
                    $end = intval($matches[2]);
                }
            }
            http_response_code(206); // Partial Content
        }

        $length = $end - $start + 1;
        $stream = fopen($path, 'rb');
        fseek($stream, $start);

        $headers = [
            'Content-Type' => 'video/mp4',
            'Content-Length' => $length,
            'Accept-Ranges' => 'bytes',
            'Content-Range' => "bytes $start-$end/$size",
            'Content-Disposition' => 'inline', // Penting agar video tidak di-download
        ];

        return response()->stream(function () use ($stream, $length) {
            $buffer = 1024 * 8; // 8 KB per chunk
            $bytesSent = 0;
            while (!feof($stream) && $bytesSent < $length) {
                $read = min($buffer, $length - $bytesSent);
                echo fread($stream, $read);
                flush();
                $bytesSent += $read;
            }
            fclose($stream);
        }, 206, $headers);
    }
}