<?php

namespace ymaker\imagable\behaviors;

use ymaker\imagable\BaseImagable;
use ymaker\imagable\helpers\FileHelper;
use ymaker\imagable\name\BaseName;
use ymaker\imagable\helpers\DirectoryHelper;
use ymaker\imagable\interfaces\CreateImageInterface;
use yii\base\Behavior;
use yii\base\Exception;

/**
 * Description of CreateImageBehavior
 *
 * @author Ruslan Saiko <ruslan.saiko.dev@gmail.com>
 */
class CreateImageBehavior extends Behavior
{
    /**
     * @var BaseHashName
     */
    private $name = null;

    /**
     * @var CreateImageInterface
     */
    private $imageCreator = null;

    /**
     * CreateImageBehavior constructor.
     * @param BaseName $name name generator
     * @param CreateImageInterface $imageCreator image resizer
     * @param array $config
     */
    public function __construct(BaseName $name, CreateImageInterface $imageCreator, $config = array())
    {
        parent::__construct($config);

        $this->name = $name;
        $this->imageCreator = $imageCreator;
    }

    /** @inheritdoc */
    public function attach($owner)
    {
        if (!is_subclass_of($owner, BaseImagable::className())) {
            throw new Exception("The owner must be inherited from " . BaseImagable::className());
        }
        parent::attach($owner);
    }

    /**
     * @param string $category category name
     * @param string $path path to image
     * @return string return image name
     */
    public function create($category, $path)
    {
        $imageName = $this->name->getName(FileHelper::getFileName($path));
        $this->saveImageInCategory($category, $path, $imageName);
        return $imageName;
    }

    /**
     * @param array $categories
     * @param string $path
     */
    public function createMultiply(array $categories, $path)
    {
        $imageName = $this->name->getName(FileHelper::getFileName($path));
        foreach ($categories as $category) {
            $this->saveImageInCategory($category, $path, $imageName);
        }
        return $imageName;
    }

    protected function saveImageInCategory($category, $path, $name)
    {
        // Path to image
        $saveImagePath = $this->owner->imagesPath;

        $categoryOptions = $this->owner->categories;

        $defaultCategoriesSize = $this->owner->baseTemplate;
        if (!array_key_exists($category, $categoryOptions['category'])) {
            throw new \UnexpectedValueException(" Category with name $category not specified.");
        }
        // New path to image
        $newPath = implode(DIRECTORY_SEPARATOR, [$saveImagePath, $category]);

        // Specifies the full path to the category, for the derived class from BaseName
        $this->name->pathToCatory = $newPath;

        // New image name created with class BaseName
        $imageName = $name;
        DirectoryHelper::create($newPath, true);
        $image = '';
        $categoryOption = $categoryOptions['category'][$category];

        $categorySizes = $categoryOption['size'];
        if (empty($categorySizes)) {
            $categorySizes = $defaultCategoriesSize;
        }
        $saveOrigin = false;
        if (isset($categoryOptions['origin'])) {
            $saveOrigin = $categoryOptions['origin'];
        }

        if (isset($categoryOption['origin'])) {
            $saveOrigin = $categoryOption['origin'];
        }

        if ($saveOrigin) {
            list($width, $height) = getimagesize($path);
            $categorySizes['origin'] = [
                'width' => $width,
                'height' => $height,
            ];
        }

        foreach ($categorySizes as $sizeName => $size) {
            $image = "$imageName-$sizeName." . FileHelper::getFileType($path);
            if(property_exists($this->imageCreator, 'dataProvider')){
                $this->imageCreator->dataProvider = $this->owner->dataProvider;
            }
            $this->imageCreator->thumbnail($path, $size['width'], $size['height']);
            $this->imageCreator->save(implode(DIRECTORY_SEPARATOR, [$newPath, $image]));
        }

        return $imageName;
    }
}
