<?php
/**
 * Elasticsearch Client Service
 *
 * @since     Oct 2015
 * @author    Haydar KULEKCI <haydarkulekci@gmail.com>
 */
namespace Search\Client;

use Elastica\Client as ElasticaClient;
use Search\Client\Interfaces\SearchClientInterface;

class ElasticClient extends ElasticaClient implements SearchClientInterface
{
}
