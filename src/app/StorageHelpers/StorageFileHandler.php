<?php


namespace App\StorageHelpers;

use Illuminate\Support\Facades\Storage;

class StorageFileHandler
{
    /**
     * Method used to store a file at a specified path.
     *
     * @param string $path
     * @param $content
     */
    public static function storeFile(string $path, $content)
    {
        if(Storage::exists($path))
            Storage::delete($path);

        Storage::put($path, $content);
    }

    /**
     * Method used to download a file from the specified path.
     *
     * @param string $path
     * @return \Illuminate\Http\RedirectResponse|\Symfony\Component\HttpFoundation\StreamedResponse
     */
    public static function downloadFile(string $path)
    {
        if(!Storage::exists($path))
            abort(404);

        return Storage::download($path);
    }
}
