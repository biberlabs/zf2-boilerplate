<?php
/**
 * Redis Adapter Service Factory
 *
 * @since     Nov 2015
 * @author    M. Yilmaz SUSLU <yilmazsuslu@gmail.com>
 */
namespace Api\OAuth\Storage\Adapter;

use Api\Exception\CacheException;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Redis Adapter Service Factory
 */
class RedisFactory implements FactoryInterface
{
    /**
     * Simply returns Redis Adapter Storage
     *
     * @throws CacheException
     * @return Redis
     */
    public function createService(ServiceLocatorInterface $services)
    {
        $config = $services->get('Config');
        if (!isset($config['caches']['core.cache.redis']['adapter']['options']['server'])) {
            throw new CacheException('Missing redis configuration!');
        }

        try {
            $redisClient = new \Predis\Client($config['caches']['core.cache.redis']['adapter']['options']['server']);

            return new Redis($redisClient, ['user_data_cache_key' => 'user_data_cache:']);
        } catch (\Exception $e) {
            throw new CacheException('Cache client exception', 500, $e);
        }
    }
}
