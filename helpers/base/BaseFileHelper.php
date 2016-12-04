<?php

namespace ymaker\imagable\helpers\base;

use yii\base\Object;

/**
 * Description of BaseImageHelper
 *
 * @author Ruslan Saiko <ruslan.saiko.dev@gmail.com>
 */
class BaseFileHelper extends \yii\helpers\BaseFileHelper {
    public static function fileInfo($filePath) {
        $path = static::normalizePath($filePath);
        $math = pathinfo($path);
        return [
            'path' => isset($math['dirname']) ? $math['dirname'] : null,
            'file' => isset($math['basename']) ? $math['basename'] : null,
            'name' => isset($math['filename']) ? $math['filename'] : null,
            'type' => isset($math['extension']) ? $math['extension'] : null,
        ];
    }
    public static function getPath($filePath){
        return static::fileInfo($filePath)['path'];
    }
    public static function getFullName($filePath){
        return static::fileInfo($filePath)['file'];
    }
    public static function getFileName($filePath){
        return static::fileInfo($filePath)['name'];
    }
    public static function getFileType($filePath){
        return static::fileInfo($filePath)['type'];
    }
}
