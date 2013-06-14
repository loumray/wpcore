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

/**
 * WP plugin
 *
 * @author Louis-Michel Raynauld <louismichel@pweb.ca>
 */
abstract class WPplugin extends WPfeature
{

  static $instance;

  public function __construct($file, $name, $slug)
  {
    parent::__construct($name, $slug);

    $this->setBaseUrl(plugin_dir_url($file));
    $this->setBasePath(plugin_dir_path($file));

    register_activation_hook( $file, array($this, 'install') );
  }

  abstract public function install();



}