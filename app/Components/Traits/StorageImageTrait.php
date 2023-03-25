<?php

namespace App\Components\Traits;

use Illuminate\Support\Facades\Storage;

trait StorageImageTrait
{
    public function StorageTraitUpload($request, $fieldName, $folderName)
    {
        if ($request->hasFile($fieldName)) {
            $file = $request->$fieldName;
            $fileName = $file->getClientOriginalName();
            $filePath = $request->file($fieldName)->storeAs('public/' . $folderName . '/' . auth()->id(), $fileName);
            return Storage::url($filePath);
        }
        return null;
    }

    public function StorageTraitUploadMutiple($file, $folderName)
    {
        $fileName = $file->getClientOriginalName();
        $filePath = $file->storeAs('public/' . $folderName . '/' . auth()->id(), $fileName);
        return Storage::url($filePath);
    }
}
