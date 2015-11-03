<?php
/*
 * This file is part of the Mamasu Framework package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mmf\Autoloader;

class Autoloader implements AutoloaderInterface {

    /**
     * URL From autoloader load the libs.
     *
     * @var string
     */
    protected $urlBase;

    /**
     * Internal  Structure, Ex; controllers, models, entities.
     *
     * @var array
     */
    protected $internalStructure = array();

    /**
     * @param array        $internalStructure
     * @param string|false $urlBase
     */
    public function __construct($internalStructure = array('controllers', 'models', 'entities') ,
                                $urlBase = false) {
        $this->internalStructure = $internalStructure;
        $this->urlBase = ($urlBase)?$urlBase:dirname(__FILE__);
    }

    /**
     * Return the array of  Structure.
     *
     * @return array
     */
    public function getStructure() {
        return $this->internalStructure;
    }

    /**
     * Set the  Structure.
     *
     * @param array $internalStructure
     */
    public function setStructure($internalStructure = array('controllers', 'models', 'entities')) {
        $this->internalStructure = $internalStructure;
    }

    /**
     * Return the URL base as String.
     *
     * @return string
     */
    public function getURLBase() {
        return $this->urlBase;
    }

    /**
     * Add the path, include in the var $autoloadPath, into the search path of
     * the system.
     *
     * @param string $autoloadPath
     * @param bool | string $notUseURLBase
     */
    public function addNewAutoloadPath($autoloadPath, $notUseURLBase = false) {
        $autoloader = new AutoloaderPath((string)$autoloadPath,
                                            $this->internalStructure,
                                            (!$notUseURLBase)?$this->urlBase:'');
        $autoloader->includePath();
    }

    /**
     * Add the path, include in the var $autoloadPath, into the search path of
     * the system. Will include controllers/, models/ entities/.
     *
     * @param string $autoloadPath
     * @param bool | string $notUseURLBase
     */
    public function addNewMmfAutoloadPath($autoloadPath, $notUseURLBase = false) {
        $autoloader = new AutoloaderPath((string)$autoloadPath,
                                            $this->internalStructure,
                                            (!$notUseURLBase)?$this->urlBase:'');
        $autoloader->includeMmfPath();
    }
}
