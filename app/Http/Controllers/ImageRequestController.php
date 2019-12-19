<?php

namespace App\Http\Controllers;

use File;

class ImageRequestController extends Controller
{
    public function image($filename)
    {
        $this->authorize('approve-requests');

        $path = storage_path('app/requests/' . $filename);

        if (!File::exists($path)) {
            abort(404);
        }

        $file = File::get($path);
        $type = File::mimeType($path);

        $response = response($file, 200);
        $response->header("Content-Type", $type);

        return $response;
    }
}
