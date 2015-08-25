<?php
/**
 * Cache Aware Traits
 *
 * @since     Jul 2015
 * @author    Haydar KULEKCI <haydarkulekci@gmail.com>
 */
namespace Core\Traits;

use Zend\Cache\Storage\Adapter\Apc as ApcStorage;
use Zend\Cache\Storage\Adapter\Memcached as MemcachedStorage;
use Zend\Cache\Storage\Adapter\Redis as RedisStorage;

trait CacheAwareTrait
{
    /**
     * Apc storage adapter instance
     * @var ApcStorage
     */
    protected $apc = null;
    
    /**
     * Memcache storage adapter instance
     * @var MemcachedStorage
     */
    protected $memcached = null;
    
    /**
     * Redis storage adapter instance
     * @var RedisStorage
     */
    protected $redis = null;

    /**
     * Gets the Apc storage adapter instance.
     *
     * @return ApcStorage
     */
    public function getApc()
    {
        return $this->apc;
    }
    /**
     * Sets the Apc storage adapter instance.
     *
     * @param Apc $apc the apc
     * @return self
     */
    public function setApc(ApcStorage $apc)
    {
        $this->apc = $apc;
        return $this;
    }
    /**
     * Gets the Memcache storage adapter instance.
     *
     * @return MemcachedStorage
     */
    public function getMemcached()
    {
        return $this->memcached;
    }
    /**
     * Sets the Memcache storage adapter instance.
     *
     * @param MemcachedStorage $memcached the memcached
     * @return self
     */
    public function setMemcached(MemcachedStorage $memcached)
    {
        $this->memcached = $memcached;
        return $this;
    }
    /**
     * Gets the Redis storage adapter instance.
     *
     * @return RedisStorage
     */
    public function getRedis()
    {
        return $this->redis;
    }
    /**
     * Sets the memcache storage adapter instance.
     *
     * @param RedisStorage $redis the redis
     * @return self
     */
    public function setRedis(RedisStorage $redis)
    {
        $this->redis = $redis;
        return $this;
    }
}