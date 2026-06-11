<?php

namespace App\Services\Storage;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class SecureUploadService
{
    public function store(UploadedFile $file, string $directory): array
    {
        $path = $file->storeAs($directory, Str::uuid().'.'.$file->getClientOriginalExtension());

        return [
            'disk' => config('filesystems.default'),
            'path' => $path,
            'mime_type' => $file->getMimeType(),
            'size' => $file->getSize(),
            'checksum' => hash_file('sha256', $file->getRealPath()),
            'exists' => Storage::exists($path),
        ];
    }
}
