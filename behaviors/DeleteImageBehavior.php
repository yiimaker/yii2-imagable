<?php
namespace ymaker\imagable\behaviors;
use ymaker\imagable\BaseImagable;
use yii\base\Behavior;
use yii\base\Exception;

/**
 * Description of DeleteImageBehavior
 *
 * @author Ruslan Saiko <ruslan.saiko.dev@gmail.com>
 */
class DeleteImageBehavior extends Behavior
{
    /**@inheritdoc */
    public function attach($owner)
    {
        if(!is_subclass_of($owner, BaseImagable::className())) {
            throw new Exception("The owner must be inherited from ".BaseImagable::className());
        }
        parent::attach($owner);
    }

    /**
     * @param string $category image category
     * @param string $name image name
     * @return bool return true if all file deleted
     */
    public function delete($category, $name)
    {
        $directory = \Yii::getAlias($this->owner->imagesPath);
        $imagePath = implode(DIRECTORY_SEPARATOR, [$directory, $category]);
        $images = glob(implode(DIRECTORY_SEPARATOR, [$imagePath, "$name-*.*"]));
        // if not found image with name $name
        if (empty($images)) {
            return false;
        }
        return (boolean)array_product(array_map('unlink', $images));
    }
}