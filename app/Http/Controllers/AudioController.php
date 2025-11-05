<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class AudioController extends Controller
{
    public function stream(Request $request, $filename)
    {
        $path = storage_path('app/public/music/' . $filename);

        if (!file_exists($path)) {
            abort(404);
        }

        $size = filesize($path);
        $start = 0;
        $length = $size;
        $end = $size - 1;

        $headers = [
            'Content-Type' => 'audio/mpeg',
            'Accept-Ranges' => 'bytes',
        ];

        if ($request->headers->has('Range')) {
            $range = $request->header('Range'); // misal: "bytes=1000-"
            if (preg_match('/bytes=(\d+)-(\d*)/', $range, $matches)) {
                $start = intval($matches[1]);
                if (!empty($matches[2])) {
                    $end = intval($matches[2]);
                }
                $length = $end - $start + 1;
                $headers['Content-Range'] = "bytes $start-$end/$size";
                $headers['Content-Length'] = $length;
                $status = 206; // Partial Content
            } else {
                $status = 200;
                $headers['Content-Length'] = $size;
            }
        } else {
            $status = 200;
            $headers['Content-Length'] = $size;
        }

        $stream = function () use ($path, $start, $length) {
            $file = fopen($path, 'rb');
            fseek($file, $start);
            $buffer = 1024 * 8;
            $remaining = $length;

            while ($remaining > 0 && !feof($file)) {
                $read = ($remaining > $buffer) ? $buffer : $remaining;
                echo fread($file, $read);
                flush();
                $remaining -= $read;
            }
            fclose($file);
        };

        return response()->stream($stream, $status, $headers);
    }
}