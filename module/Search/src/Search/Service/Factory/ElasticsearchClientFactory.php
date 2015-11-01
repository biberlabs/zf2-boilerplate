<?php
/**
 * Elastica Client Factory
 *
 * @since     Nov 2015
 * @author    Haydar KULEKCI <haydarkulekci@gmail.com>
 */
namespace Search\Service\Factory;

use Search\Service\ElasticsearchClient;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class ElasticsearchClientFactory implements FactoryInterface
{
    /**
     * Create elastica client
     *
     * @param ServiceLocatorInterface $sm
     * @return ElasticsearchClient
     */
    public function createService(ServiceLocatorInterface $sm)
    {
        $config        = $sm->get('Config');
        $clientConfig  = isset($config['elastica']) ? $config['elastica'] : array();

        return new ElasticsearchClient($clientConfig);
    }
}
