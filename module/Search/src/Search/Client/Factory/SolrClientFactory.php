<?php
/**
 * Solra Client Factory
 *
 * @since     Nov 2015
 * @author    Haydar KULEKCI <haydarkulekci@gmail.com>
 */
namespace Search\Client\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class SolrClientFactory implements FactoryInterface
{
    /**
     * Create Solr client
     *
     * @param ServiceLocatorInterface $sm
     * @return SolrClient
     */
    public function createService(ServiceLocatorInterface $sm)
    {
        //TODO: Return a new Solr Client here
        // return new SolrClient($clientConfig);
    }
}
