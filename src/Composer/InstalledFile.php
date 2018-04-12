<?php
/*
 * This file is part of WPCore project.
 *
 * (c) Louis-Michel Raynauld <louismichel@pweb.ca>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace WPCore\Composer;

/*
*   class InstalledFile
*
*   Extract package dependancies of package fomr installed.json file created by composer
*/
class InstalledFile
{
    protected $path;
    protected $content;

    public function __construct($path)
    {
        $this->path = $path;
    }

    public function content()
    {
        if (!empty($this->content)) {
            return $this->content;
        }

        if (!file_exists($this->path)) {
            throw new \Exception('installed.json file is missing '.$this->path);
        }

        return $this->content = json_decode(file_get_contents($this->path), true);
    }

    public function getInfo($packageName)
    {
        foreach ($this->content() as $package) {
            if ($package['name'] == $packageName) {
                return $package;
            }
        }
    }

    public function getRequires($packageName)
    {
        $depandancies = array();

        $info = $this->getInfo($packageName);

        if (empty($info['require'])) {
            return array();
        }

        foreach ($info['require'] as $name => $version) {
            //If dep is php version or php extension or no / found skip
            if ($name == 'php' || strpos($name, 'ext-') === 0 || strpos($name, '/') === false) {
                continue;
            }

            if (in_array($name, $depandancies)) {
                continue;
            }

            $depandancies[] = $name;
            //Add package subsdepandacies
            $depandancies = array_merge($depandancies, $this->getRequires($name));
        }

        return $depandancies;
    }

    public function getNamespaces($packageName)
    {
        $namespaces = array();

        $info = $this->getInfo($packageName);
        if (empty($info['autoload'])) {
            $info['autoload'] = array();
        }
        
        foreach ($info['autoload'] as $format => $autoload) {
            if ($format == 'files') {
                continue;
            }

            //Skip if not loading of psr-4 and psr 0
            if ($format != 'psr-0' && $format != 'psr-4') {
                continue;
            }

            $namespaces[$packageName] = array_merge($namespaces, $autoload);
        }

        //Add dependancies namespaces
        $deps = $this->getRequires($packageName);

        foreach ($deps as $dep) {
            $namespaces = array_merge($namespaces, $this->getNamespaces($dep));
        }
        

        return $namespaces;
    }
}
