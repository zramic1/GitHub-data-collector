<?php


namespace App\Storage;


use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;

class StorageFileHandler
{

    /**
     * Method used to store a file at a specified path.
     *
     * @param string $path
     * @param $content
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeFile(string $path, $content)
    {
        if(Storage::exists($path))
            Storage::delete($path);
        Storage::put($path, $content);

        return Redirect::back()->with('success', 'Changes saved successfully!');
    }

    /**
     * Method used to download a file from the specified path.
     *
     * @param string $path
     * @return \Illuminate\Http\RedirectResponse|\Symfony\Component\HttpFoundation\StreamedResponse
     */
    public function downloadFile(string $path)
    {
        if(Storage::exists($path))
            return Storage::download($path);

        return Redirect::back()->with('error', 'JSON file does not exist!');
    }
}
