<?php

namespace imagable;

use ymaker\imagable\helpers\FileHelper;
use ymaker\imagable\name\CRC32Name;
use Faker\Provider\File;

class ImagableTest extends \yii\codeception\TestCase
{

    public $appConfig = '@tests/unit/_config.php';
    private $pathToOrigin = '@tests/_data/images/origin';
    private $path = '@tests/_data/images';

    /**
     * @var \UnitTester
     */
    protected $tester;

    protected function _before()
    {
        $path = &$this->pathToOrigin;
        $path = \Yii::getAlias($path);
        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }
    }

    protected function _after()
    {

    }

    public function testImagableCreate()
    {
        $nameClass = new CRC32Name();

        $imagable = \Yii::createObject([
            'class' => 'ymaker\imagable\Imagable',
            'imagesPath' => '@tests/_data/images',
            'nameClass' => $nameClass->className(),
            'categories' => [
                'origin' => true,
                'category' => [
                    'galery' => [
                        'origin' => true,
                        'size' => [
                            'big' => [
                                'width' => 400,
                                'height' => 400,
                            ]
                        ]
                    ]
                ]
            ],
            'imageClass' => 'ymaker\imagable\instances\CreateImageImagine',
        ]);
        $path = \Yii::getAlias($this->pathToOrigin);
        $path = implode(DIRECTORY_SEPARATOR, [$path, 'testImage.jpg']);
        $name = 'testImage';
        $name = $nameClass->generate($name);
        //return name
        $this->assertEquals($imagable->create('galery', $path), $name);

        $this->assertTrue(file_exists(\Yii::getAlias("@tests/_data/images/galery/$name-small.jpg")));
        $this->assertTrue(file_exists(\Yii::getAlias("@tests/_data/images/galery/$name-origin.jpg")));
        $this->assertTrue(file_exists(\Yii::getAlias("@tests/_data/images/galery/$name-big.jpg")));
        $this->assertTrue(file_exists(\Yii::getAlias("@tests/_data/images/galery/$name-thumb.jpg")));
    }

    public function testImagableGet()
    {
        $nameClass = new CRC32Name();
        $imagable = \Yii::createObject([
            'class' => 'ymaker\imagable\Imagable',
            'imagesPath' => '@tests/_data/images',
            'nameClass' => $nameClass->className(),
            'imageClass' => 'ymaker\imagable\instances\CreateImageImagine',
        ]);

        //image name
        $name = 'testImage';
        $name = $nameClass->getName($name);
        $path = &$this->path;
        $pathToGalery = implode(DIRECTORY_SEPARATOR, [$path, 'galery']);
        $pathToGalery = FileHelper::normalizePath(\Yii::getAlias($pathToGalery));
        //return full path. Example: /var/www/site/images/galery/5cc22de8-small.jpg
        $this->assertEquals($imagable->get('galery', 'small', $name),
            $pathToGalery . \DIRECTORY_SEPARATOR . $name . '-small.jpg');

        //return full path. Example: /var/www/site/images/galery/5cc22de8-small.jpg
        $this->assertEquals($imagable->getSmall('galery', $name),
            $pathToGalery . \DIRECTORY_SEPARATOR . $name . '-small.jpg');

        //return full path. Example: /var/www/site/images/galery/5cc22de8-big.jpg
        $stream = null;
        $this->assertEquals($imagable->getBig('galery', $name), $pathToGalery . \DIRECTORY_SEPARATOR . $name . '-big.jpg');
//        \Codeception\Util\Debug::debug($imagable->getOriginal('galery', $name, $stream));
        //return full path. Example: /var/www/site/images/galery/5cc22de8-original.jpg
        $this->assertEquals($imagable->getOriginal('galery', $name), $pathToGalery . \DIRECTORY_SEPARATOR . $name . '-origin.jpg');

        //return full path. Example: /var/www/site/images/galery/5cc22de8-thumb.jpg
        $this->assertEquals($imagable->getThumb('galery', $name), $pathToGalery . \DIRECTORY_SEPARATOR . $name . '-thumb.jpg');
    }

}
