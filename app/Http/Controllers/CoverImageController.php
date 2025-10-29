<?php

namespace App\Http\Controllers;

use App\Http\Requests\UploadCoverImageRequest;
use Illuminate\Http\UploadedFile;

class CoverImageController extends Controller
{
    public function store(UploadCoverImageRequest $request) {
        /**
         * @var UploadedFile
         */
        $image = $request->validated('image');
        $path = $image->storePublicly('cover-kanban');
    }

    private function hasImage(): bool {
        return true;
    }
}
