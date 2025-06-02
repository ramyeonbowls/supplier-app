<?php

namespace App\Http\Controllers\Core\Upload;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

class AudioController extends Controller
{
    public function stream($filename)
    {
        $path = "books_draft/" . $filename;

        if (!Storage::exists($path)) {
            abort(404);
        }

        $mimeType = Storage::mimeType($path);
        $file = Storage::get($path);

        return response($file, 200)
            ->header('Content-Type', $mimeType)
            ->header('Content-Disposition', 'inline; filename="'.basename($filename).'"');
    }
}
