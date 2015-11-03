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
interface AutoloaderInterface {
    /**
     * Add the path, include in the var $autoloadPath, into the search path of
     * the system.
     *
     * @param string $autoloadPath path to be include
     * @param bool | string $notUseURLBase
     */
    public function addNewAutoloadPath($autoloadPath, $notUseURLBase=false);

    /**
     * Add the path, include in the var $autoloadPath, into the search path of
     * the system. Will include controllers/, models/ entities/.
     *
     * @param string $autoloadPath path to be include
     * @param bool | string $notUseURLBase
     */
    public function addNewMmfAutoloadPath($autoloadPath, $notUseURLBase=false);

    /**
     * Set the Structure.
     *
     * @param array $internalStructure
     */
    public function setStructure($internalStructure = array('controllers', 'models', 'entities'));


    /**
     * Return the array of  Structure.
     *
     * @return array
     */
    public function getStructure();

    /**
     * Return the URL base as String.
     *
     * @return string
     */
    public function getURLBase();

}