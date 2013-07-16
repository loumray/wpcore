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
use Composer\Script\Event;

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

  public static function wrapPackage($installedPackage, $namespacesWrapper)
  {
    $vendorDir = __DIR__.'/../../../../';

    $namespaces = require __DIR__.'/../../../../composer/autoload_namespaces.php';
    $newRootNamespace = $namespacesWrapper;

    echo "----- wrapping package ".$installedPackage." into namespace $newRootNamespace -------". PHP_EOL;
    $supplierstochange = array();
    foreach($namespaces as $namespace => $path)
    {
      $supplier = stristr($namespace, '\\', true);
      if(empty($supplier))
      {
        $supplier = $namespace;
      }
      if(!isset($supplierstochange[$supplier]))
      {
        $supplierstochange[$supplier] = $newRootNamespace.'\\'.$supplier;
      }
    }

    $dir = $vendorDir.'/'.$installedPackage;
    $path = realpath($dir); // Path to your textfiles
    $fileList = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($path), \RecursiveIteratorIterator::SELF_FIRST);
    foreach ($fileList as $item)
    {
      if ($item->isFile() && stripos($item->getExtension(), 'php') !== false)
      {
        if(is_writable($item->getPathName()) === false)
        {
          echo "WPpluginLoader: unable to read/write file ".$item->getPathName(). PHP_EOL;
          continue;
        }

        $file_contents = file_get_contents($item->getPathName());

        foreach($supplierstochange as $supplier => $new)
        {
          $file_contents = str_replace(" $supplier\\"," $new\\",$file_contents);
          $file_contents = str_replace("\"$supplier\\","\"$new\\",$file_contents);
          $file_contents = str_replace("'$supplier\\","'$new\\",$file_contents);
          $file_contents = str_replace(" $supplier;"," $new;",$file_contents);
        }

        file_put_contents($item->getPathName(),$file_contents);
      }
    }
  }

  public static function unwrapPackage($package, $namespacesToUnwrap = array())
  {
    echo "unwrappingPackage $package".PHP_EOL;
    $vendorDir = __DIR__.'/../../../../';

    $dir = $vendorDir.'/'.$package;
    $path = realpath($dir); // Path to your textfiles

    $fileList = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($path), \RecursiveIteratorIterator::SELF_FIRST);
    foreach ($fileList as $item)
    {
      if ($item->isFile() && stripos($item->getExtension(), 'php') !== false)
      {
        if(is_writable($item->getPathName()) === false)
        {
          echo "WPpluginLoader: unable to read/write file ".$item->getPathName(). PHP_EOL;
          continue;
        }

        echo "unwrapping file: ".$item->getFilename(). PHP_EOL;
        $file_contents = file_get_contents($item->getPathName());

        foreach($namespacesToUnwrap as $unwrapNamespace)
        {
          $file_contents = str_replace(" $unwrapNamespace\\"," ",$file_contents);
          $file_contents = str_replace("\"$unwrapNamespace\\","\"",$file_contents);
          $file_contents = str_replace("'$unwrapNamespace\\","'",$file_contents);
        }

        file_put_contents($item->getPathName(),$file_contents);
      }

    }
  }
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