<?php
/**
 * Elastica Client Factory
 *
 * @since     Nov 2015
 * @author    Haydar KULEKCI <haydarkulekci@gmail.com>
 */
namespace Search\Client\Factory;

use Search\Client\ElasticClient;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class ElasticClientFactory implements FactoryInterface
{
    /**
     * Create elastica client
     *
     * @param ServiceLocatorInterface $sm
     * @return ElasticClient
     */
    public function createService(ServiceLocatorInterface $sm)
    {
        $config        = $sm->get('Config');
        $clientConfig  = isset($config['elastica']) ? $config['elastica'] : array();

        return new ElasticClient($clientConfig);
    }
}
