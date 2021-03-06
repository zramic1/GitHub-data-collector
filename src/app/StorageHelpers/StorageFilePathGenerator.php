<?php


namespace App\StorageHelpers;


class StorageFilePathGenerator
{
    /**
     * Method used to generate a path on which the files are saved.
     *
     * @param string $nickname
     * @param string $fileName
     * @return string
     */
    public static function path(string $nickname, string $fileName)
    {
        return '/github/' . $nickname . '/' . $fileName;
    }
}
