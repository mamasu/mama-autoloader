<?php
/*
 * This file is part of the Mamasu Framework package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mmf\Autoloader;

/**
 * The Autoloader and AutoloaderPath give a way to include the files need for
 * the execution in the Framework. We register the new path using the function
 * spl_autoload_register.
 *
 * @author Xavier Casahuga <xavier.casahuga@mamasu.es>
 *
 */
class AutoloaderPath {

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
     *
     * @var string
     */
    protected $autoloadPath;

    /**
     * Add new path, included in the var $autoloadPath, into the search path of
     * the system
     *
     * @param string       $autoloadPath
     * @param array        $internalStructure
     * @param string|false $urlBase
     */
    public function __construct($autoloadPath,
                                $internalStructure = array('controllers', 'models', 'entities'),
                                $urlBase = false) {
        $this->internalStructure = $internalStructure;
        $this->urlBase = ($urlBase !== false)?$urlBase:dirname(__FILE__);
        $this->autoloadPath = (string)$autoloadPath;
    }

    /**
     * Include the path as a new path to search new classes.
     */
    public function includePath() {
        spl_autoload_register(function ($class) {
            if(!class_exists($class)) {
                $this->includeTheFile($this->autoloadPath . '/' . $class . '.php');
            }
        });
    }

    /**
     * Include the path as  path. This means that will be ready the classes
     * under the path controllers/, models/ entities/, with the extended
     * classes.
     *
     */
    public function includeMmfPath() {
        spl_autoload_register(function ($class) {
            if(!class_exists($class)) {
                $this->includeControllersModelsEntities($class);
            }
        });
    }


    /**
     * Include the common directories of .
     *
     * @param string $class
     */
    protected function includeControllersModelsEntities($class) {
        //Include the Extended Classes
        foreach ($this->internalStructure as $Directory) {
            if($this->includeTheFile( $this->autoloadPath . '/'.$Directory.'/' . $class . '.php' )) {
                return true;
            }
        }

        //Include the None Extended Classes
        foreach ($this->internalStructure as $Directory) {
            if($this->includeTheFile( $this->autoloadPath . '/'.$Directory.'/' . $this->strLastReplace('Extended','',$class) . '.php' )) {
                return true;
            }
        }

    }

    /**
     * Include the file if exists
     *
     * @param string $path
     */
    protected function includeTheFile($path) {
        $path = $this->urlBase    .$path;
        if(file_exists($path)) {
            /** @noinspection PhpIncludeInspection */
            require_once ($path);

            return true;
        }
    }

    /**
     * Replace the last ocurrence of search
     *
     * @param string $search
     * @param string $replace
     * @param string $subject
     * @return string
     */
    protected function strLastReplace($search, $replace, $subject) {
        $pos = strrpos($subject, $search);

        if($pos !== false) {
            $subject = substr_replace($subject, $replace, $pos, strlen($search));
        }

        return $subject;
    }
}