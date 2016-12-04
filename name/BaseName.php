<?php

namespace ymaker\imagable\name;

/**
 * Base class for name generator
 *
 * @author Ruslan Saiko <ruslan.saiko.dev@gmail.com>
 */
abstract class BaseName extends \yii\base\Object
{
    /**
     * @param $baseName string
     * @return string
     */
    abstract public function generate($baseName);

    /**
     * @var string Full path to the category
     */
    public $pathToCatory;

    /**
     * @param $name string
     * @return string
     */
    public function getName($name)
    {
        return $this->generate($name);
    }
}
