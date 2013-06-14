<?php
/*
 * This file is part of WPCore project.
 *
 * (c) Louis-Michel Raynauld <louismichel@pweb.ca>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace WPCore;

use Composer\Autoload\ClassLoader;

/**
 * WP plugin loader
 *
 * @author Louis-Michel Raynauld <louismichel@pweb.ca>
 */

class WPpluginLoader extends ClassLoader
{

  protected $prefixes = array();
  protected $fallbackDirs = array();
  protected $useIncludePath = false;
  protected $classMap = array();

  /**
     * Finds the path to the file where the class is defined.
     *
     * @param string $class The name of the class
     *
     * @return string|false The path if found, false otherwise
     */
    public function findFile($class)
    {
      $this->prefixes       = $this->getPrefixes();
      $this->fallbackDirs   = $this->getFallbackDirs();
      $this->useIncludePath = $this->getUseIncludePath();
      $this->classMap       = $this->getClassMap();

        if ('\\' == $class[0]) {
            $class = substr($class, 1);
        }

        if (isset($this->classMap[$class])) {
            return $this->classMap[$class];
        }

        if (false !== $pos = strrpos($class, '\\')) {
            // namespaced class name
            $classPath = str_replace('\\', DIRECTORY_SEPARATOR, substr($class, 0, $pos)) . DIRECTORY_SEPARATOR;
            $className = substr($class, $pos + 1);
        } else {
            // PEAR-like class name
            $classPath = null;
            $className = $class;
        }

        $classPath .= str_replace('_', DIRECTORY_SEPARATOR, $className) . '.php';

        //new for WP chagnes
        //here
        $classPathWP = substr(stristr($classPath,"/"),1);

        foreach ($this->prefixes as $prefix => $dirs) {
            if (0 === strpos($class, $prefix)) {
                foreach ($dirs as $dir) {
                    if (file_exists($dir . DIRECTORY_SEPARATOR . $classPath)) {
                        return $dir . DIRECTORY_SEPARATOR . $classPath;
                    }
                    //here
                    if (file_exists($dir . DIRECTORY_SEPARATOR . $classPathWP)) {
                        return $dir . DIRECTORY_SEPARATOR . $classPathWP;
                    }
                }
            }
        }

        foreach ($this->fallbackDirs as $dir) {
            if (file_exists($dir . DIRECTORY_SEPARATOR . $classPath)) {
                return $dir . DIRECTORY_SEPARATOR . $classPath;
            }
        }

        if ($this->useIncludePath && $file = stream_resolve_include_path($classPath)) {
            return $file;
        }

        return $this->classMap[$class] = false;
    }
}