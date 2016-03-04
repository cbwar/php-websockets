<?php
/**
 * Created by PhpStorm.
 * User: Raphaël Lisch
 * Date: 03/03/2016
 * Time: 17:10
 */

ini_set('zend.ze1_compatibility_mode', 0);

if (!function_exists('openssl_random_pseudo_bytes')) {
    function openssl_random_pseudo_bytes($length)
    {
        $length_n = (int)$length; // shell injection is no fun
        $handle = popen("/usr/bin/openssl rand $length_n", "r");
        $data = stream_get_contents($handle);
        pclose($handle);
        return $data;
    }
}