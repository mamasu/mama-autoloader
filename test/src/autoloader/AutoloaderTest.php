<?php

use Mmf\Autoloader\Autoloader;
/*
 * This file is part of the Mamasu Framework package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * The MmfEventManager bla bla...
 *
 * Description
 *
 * @author Xavier Casahuga <xavier.casahuga@mamasu.es>
 *
 */
class AutoloaderTest extends \PHPUnit_Framework_TestCase {

    protected static $prefix;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    public static function setUpBeforeClass() {
        self::$prefix = __DIR__ . '/../';
    }

    /**
     * @group loader
     * @group modules
     * @group development
     * @group production
     */
    public function testMKPFilesystem() {
        $autoloader = new Autoloader(array('controllers', 'models', 'entities'), self::$prefix);

        $autoloader->addNewMmfAutoloadPath('mktfilesystem/custom/reseller1/core');
        $autoloader->addNewMmfAutoloadPath('mktfilesystem/base/core');

        $a = new Prova();
        $b = new Prova2();
        $c = new ProvaExtended();

        $this->assertEquals('custom/prova',  $a->test());
        $this->assertEquals('base/prova2',  $b->test());
        $this->assertEquals('custom/provaextended',  $c->test());

        unset($autoloader);
        unset($a);
        unset($b);
        unset($c);
    }

    /**
     * @group loader
     * @group modules
     * @group development
     * @group production
     */
    public function testMmfFilesystem() {
        $autoloader = new Autoloader(array('controllers', 'models', 'entities'), self::$prefix);
        //$autoloader = new MmfAutoloader();
        $autoloader->addNewMmfAutoloadPath('mmffilesystem/');
        $autoloader->addNewAutoloadPath('mmffilesystem/libs/libtest/');

        $a = new ProvaMmf();
        $b = new ProvaMmfEntities();
        $c = new ProvaLibtest();

        $this->assertEquals('mmf/controllers/prova',  $a->test());
        $this->assertEquals('mmf/entities/prova',  $b->test());
        $this->assertEquals('mmf/libs/ProvaLibtest',  $c->test());

        unset($autoloader);
        unset($a);
        unset($b);
        unset($c);
    }
    
    /**
     * @group loader
     * @group modules
     * @group development
     * @group production
     */
    public function testGetAndSetStructure() {
        $autoloader = new Autoloader();
        $this->assertEquals($autoloader->getStructure(), array('controllers', 'models', 'entities'), 'Get bad structure from constructor');
        $autoloader->setStructure(['test']);
        $this->assertEquals($autoloader->getStructure(), ['test'], 'Get bad test structure when we set it manually');
        $autoloader1 = new Autoloader(['test'], self::$prefix);
        $this->assertEquals($autoloader1->getStructure(), ['test'], 'Get bad test structure when we set it different than usually in constructor');
    }
    
    /**
     * @group loader
     * @group modules
     * @group development
     * @group production
     */
    public function testGetURLBase() {
        $autoloader = new Autoloader([], 'thisistheurlbase');
        $this->assertEquals($autoloader->getURLBase(), 'thisistheurlbase', 'The URL Base is not set correctly in constructor');
        $autoloader1 = new Autoloader();        
        $isSrcAutoloaderInURLBase = strpos($autoloader1->getURLBase(), 'src/autoloader')!==false?true:false;
        $this->assertEquals(true, $isSrcAutoloaderInURLBase, 'The URL Base is not set correctly in constructor when we did not pass');
    }
}
