<?php
/**
 * Example Service
 *
 * @since     Aug 2015
 * @author    Haydar KULEKCI <haydarkulekci@gmail.com>
 */
namespace Core\Service;

use Core\Traits\CacheAwareTrait;
use Core\Service\Interfaces\CacheAwareInterface;
use Core\Service\Interfaces\RedisAwareInterface;

class Example implements CacheAwareInterface, RedisAwareInterface{
    use CacheAwareTrait;

    public function getCache()
    {
        return $this->getRedis();
    }

    public function helloWorld()
    {
        $text = $this->getCache()->getItem('helloWorld');
        if ($text) {
            return $text . ' - from cache';
        }
        $text = 'Hello World!';
        $this->getCache()->setItem('helloWorld', $text);
        return $text;
    }
}