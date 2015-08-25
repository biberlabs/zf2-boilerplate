<?php
/**
 * Cache Aware Interface
 *
 * @since     Jul 2015
 * @author    Haydar KULEKCI <haydarkulekci@gmail.com>
 */
namespace Core\Service\Initializers;

use Zend\ServiceManager\InitializerInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Core\Service\Interfaces\CacheAwareInterface;
use Core\Service\Interfaces\RedisAwareInterface;
use Core\Service\Interfaces\ApcAwareInterface;
use Core\Service\Interfaces\MemcachedAwareInterface;

class CacheAwareInitializer implements InitializerInterface
{
    /**
     * Initialize method 
     *
     * @param ServiceLocatorInterface   $sm         Service Manager
     * @param mixed                     $instance   Service Instance
     */
    public function initialize($instance, ServiceLocatorInterface $sm)
    {
        if ($instance instanceof CacheAwareInterface) {
            if ($instance instanceof ApcAwareInterface) {
                $instance->setApc($sm->get('core.cache.apc'));
            }
            if ($instance instanceof MemcachedAwareInterface) {
                $instance->setMemcached($sm->get('core.cache.memcached'));
            }
            if ($instance instanceof RedisAwareInterface) {
                $instance->setRedis($sm->get('core.cache.redis'));
            }
        }
    }
}