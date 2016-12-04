<?php

namespace helpers;

use ymaker\imagable\helpers\DirectoryHelper;

/**
 * Class tested helper DirectoryHelper
 */
class DirectoryHelperTest extends \yii\codeception\TestCase
{

    public $appConfig = '@tests/unit/_config.php';

    /**
     * @var \UnitTester
     */
    protected $tester;
    protected $path = '@tests/unit/helpers/testDir';

    /**
     * Create directory with name testDir
     */
    protected function _before()
    {
        $path = &$this->path;
        $path = \Yii::getAlias($path);
        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }
    }

    /**
     * Remove directory testDir
     */
    protected function _after()
    {
        $path = &$this->path;

        if (file_exists($path)) {
            rmdir($path);
        }
    }

    /**
     * testDir creating directory
     */
    public function testDirectoryCreate()
    {
        $path = &$this->path;
        $recursive = true;
        $force = true;
        $this->assertTrue(DirectoryHelper::create($path, $recursive, $force));
    }

    /**
     * testDir existing directory
     */
    public function testDirectoryExist()
    {
        $correctPath = &$this->path;
        $this->assertTrue(DirectoryHelper::exist($correctPath));
        $this->assertFalse(DirectoryHelper::exist('not\correct\path'));
    }

    /**
     * testDir removing directory
     */
    public function testDirectoryRemove()
    {
        $path = &$this->path;
        $this->assertTrue(DirectoryHelper::remove($path));
    }

}
