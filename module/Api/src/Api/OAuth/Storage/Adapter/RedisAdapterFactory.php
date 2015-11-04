<?php
/**
 * Authentication service factory
 *
 * @since     Jul 2015
 * @author    M. Yilmaz SUSLU <yilmazsuslu@gmail.com>
 */
namespace Api\OAuth\Storage\Adapter\Factory;

use Api\OAuth\Storage\Adapter\RedisAdapter;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Authentication service factory
 */
class RedisAdapterFactory implements FactoryInterface
{
    /**
     * Simply returns Redis Adapter Storage
     *
     * @return RedisAdapter
     */
    public function createService(ServiceLocatorInterface $services)
    {
        $redisConfig = $sm->get('Config');
        if (!isset($redisConfig['caches']['core.cache.redis']['adapter']['options']['server'])) {
            throw new \Exception('Missing redis configuration!');
        }

        $redisClient = new \Predis\Client($redisConfig['caches']['core.cache.redis']['adapter']['options']['server'])

        return new RedisAdapter($redisClient);
    }
}
