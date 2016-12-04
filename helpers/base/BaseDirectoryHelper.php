<?php

namespace ymaker\imagable\helpers\base;

/**
 * BaseDirectoryHelper provides concrete implementation for [[DirectoryHelper]].
 *
 * Do not use BaseDirectoryHelper. Use [[DirectoryHelper]] instead.
 * 
 * @author RuslanSaiko <ruslan.saiko.dev@gmail.com>
 */
class BaseDirectoryHelper
{

    /**
     * Checks whether a directory exists
     * @param string $path path to directory
     * @return bool return true if directory existed else returned false
     */
    public static function exist($path)
    {
        return isset($path) && file_exists($path);
    }

    /**
     * Creates a directory
     * @param string $path path to directory
     * @param bool $recursive create directory recursive
     * @param integer $mode set mode on directory
     * @param bool $force force directory creation
     * @return bool return true if directory created else returned false
     */
    public static function create($path, $recursive = false, $force = false,
            $mode = 0777)
    {
        $force && self::remove($path);
        return !self::exist($path) ? mkdir($path, $mode, $recursive) : false;
    }

    /**
     * Removes a directory
     * @param string $path path to directory
     * @return bool return true if directory removed else returned false
     */
    public static function remove($path)
    {
        return self::exist($path) ? rmdir($path) : false;
    }

}
