<?php

namespace App\Components\Traits;

use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

trait StorageImageTrait
{
    public function StorageTraitUpload($request, $fieldName, $folderName)
    {
        if ($request->hasFile($fieldName)) {
            $file = $request->$fieldName;
            $a = Carbon::now()->format('d-m-Y-H-i-s') . '/' . Str::random(30);
            $fileNameHash = $a . '.' . $file->getClientOriginalExtension();
            $filePath = $request->file($fieldName)->storeAs('public/' . $folderName . '/' . auth()->id(), $fileNameHash);
            return Storage::url($filePath);
        }
        return null;
    }

    public function StorageTraitUploadMutiple($file, $folderName)
    {
        $a = Carbon::now()->format('d-m-Y-H-i-s') . '.' . Str::random(30);
        $fileNameHash = $a . '.' . $file->getClientOriginalExtension();
        $filePath = $file->storeAs('public/' . $folderName . '/' . auth()->id(), $fileNameHash);
        return Storage::url($filePath);
    }

    public function StorageTraitImport($file, $folderName)
    {

        $a = Carbon::now()->format('d-m-Y-H-i-s') . '-' . Str::random(30);
        $fileNameHash = $a  . strchr($file, ".");
        $filePath = Storage::putFileAs('public/' . $folderName . '/' . auth()->id(), $file, $fileNameHash);
        return Storage::url($filePath);
    }
}
