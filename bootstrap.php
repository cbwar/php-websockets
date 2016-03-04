<?php
/**
 * Created by PhpStorm.
 * User: Raphaël Lisch
 * Date: 03/03/2016
 * Time: 17:32
 */

ini_set('display_errors', 1);
error_reporting(E_ALL);
require 'lib/Wrench/compat_52.php';

require dirname(__FILE__) . '/lib/SplClassLoader.php';
$loader = new SplClassLoader();
$loader->register();


