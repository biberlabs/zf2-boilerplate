<?php
/**
 * Cache Aware Interface
 *
 * @since     Jul 2015
 * @author    Haydar KULEKCI <haydarkulekci@gmail.com>
 */
namespace Core\Service\Interfaces;

interface CacheAwareInterface
{
    public function getCache();
}