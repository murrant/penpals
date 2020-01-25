<?php

namespace App\Http\Controllers;

use File;
use Image;
use Str;

class ImageRequestController extends Controller
{
    private $filename;

    public function image($filename)
    {
        $this->authorize('approve-requests');
        $this->filename = $filename;

        $path = $this->getImagePath();
        $this->checkImage($path);

        return $this->buildImageResponse($path);
    }

    public function smallImage($filename)
    {
        $this->authorize('approve-requests');
        $this->filename = $filename;

        return $this->fetchSmallerImage('small_', 300);
    }

    public function tinyImage($filename)
    {
        $this->authorize('approve-requests');
        $this->filename = $filename;

        return $this->fetchSmallerImage('tiny_', 100, 80);
    }

    private function checkImage($path)
    {
        if (!File::exists($path)) {
            abort(404);
        }
   }

    private function getImagePath($prefix = ''): string
    {
        return storage_path('app/requests/' . $prefix . $this->filename);
    }

    private function buildImageResponse(string $path)
    {
        $file = File::get($path);
        $type = File::mimeType($path);

        $response = response($file, 200);
        $response->header("Content-Type", $type);
        return $response;
    }

    private function resizeImage(string $prefix, int $height = 300, $quality = null): string
    {
        $input = $this->getImagePath();
        $output = $this->getImagePath($prefix);
        if (!File::exists($output)) {
            $image = Image::make($input);

            // don't enlarge the image
            if ($image->height() < $height) {
                return $input;
            }

            $image->resize(null, $height, function ($constraint) {
                $constraint->aspectRatio();
            });
            $image->save($output, $quality);
        }

        return $output;
    }

    private function fetchSmallerImage($prefix, $height, $quality = null)
    {
        $path = $this->getImagePath();
        $this->checkImage($path);

        // small file not generated yet, generate now
        $small_path = $this->resizeImage($prefix, $height, $quality);
        $this->checkImage($small_path);

        return $this->buildImageResponse($small_path);
    }
}
