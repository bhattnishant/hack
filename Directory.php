<?php
class Directory
{
    /**
     * Provide a list of directory contents minus the top directory.
     *
     * @param  string $path
     * @return array
     */
    public static function listContents($path)
    {
        return array_diff(scandir($path), ['.', '..']);
    }

    /**
     * Provide an associative array of directory contents ['dir' => 'dir'].
     *
     * @param  string $path
     * @return array
     */
    public static function listAssocContents($path)
    {
        $files = self::listContents($path);

        return array_combine($files, $files);
    }

    /**
     * Provide a list of only directories.
     *
     * @param  string $path
     * @return array
     */
    public static function listDirectories($path)
    {
        $directories = self::listContents($path);

        foreach ($directories as $key => $directory)
        {
            if (!is_dir($path . '/' . $directory))
            {
                unset($directories[$key]);
            }
        }

        return $directories;
    }


    public static function listFolderFiles($path)
    {
        $fileInfo     = scandir($path);
        $allFileLists = [];

        foreach ($fileInfo as $folder) {
            if ($folder !== '.' && $folder !== '..') {
                if (is_dir($path . DIRECTORY_SEPARATOR . $folder) === true) {
                    $allFileLists[$folder] = self::listFolderFiles($path . DIRECTORY_SEPARATOR . $folder);
                } else {
                    $allFileLists[$folder] = $folder;
                }
            }
        }

        return $allFileLists;
    }//end listFolderFiles()

}
?>
