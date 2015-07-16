<?php
/**
 * Simplifed copy of the official skeleton app's init_auutoloader.php.
 * Removed deffensive checks, always uses composer autoloading.
 */
if (file_exists('vendor/autoload.php')) {
    $loader = include 'vendor/autoload.php';
}

if (class_exists('Zend\Loader\AutoloaderFactory')) {
    return;
}

if (!class_exists('Zend\Loader\AutoloaderFactory')) {
    throw new RuntimeException('Unable to load ZF2. Run `php composer.phar install`');
}
