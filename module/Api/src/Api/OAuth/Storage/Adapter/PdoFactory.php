<?php
/**
 * PDO Adapter
 *
 * @since     Nov 2015
 * @author    Haydar KULEKCI  <haydarkulekci@gmail.com>
 */
namespace Api\OAuth\Storage\Adapter;

use Api\Exception\DatabaseException;
use Api\Oauth\Storage\Adapter\Pdo as PdoAdapter;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Pdo Adapter Factory
 */
class PdoFactory implements FactoryInterface
{
    /**
     * Simply returns Pdo Adapter Storage
     *
     * @throws DatabaseException;
     * @return PdoAdapter
     */
    public function createService(ServiceLocatorInterface $services)
    {
        try {
            $pdoAdapter  = new PdoAdapter($services->get('doctrine.entitymanager.orm_default')->getConnection()->getWrappedConnection());
            $pdoAdapter->setRedis($services->get(\Api\OAuth\Storage\Adapter\Redis::class));

            return $pdoAdapter;
        } catch (\Exception $e) {
            throw new DatabaseException('Database connection did not created!', 500, $e);
        }
    }
}
