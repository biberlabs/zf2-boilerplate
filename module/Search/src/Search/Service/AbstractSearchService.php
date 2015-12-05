<?php
/**
 * Abstract Index Service
 *
 * @since     Oct 2015
 * @author    Haydar KULEKCI <haydarkulekci@gmail.com>
 */
namespace Search\Service;

use Search\Client\Interfaces\SearchClientInterface;
use Search\Service\Interfaces\SearchServiceInterface;

class AbstractSearchService implements SearchServiceInterface
{
    /**
     * ElasticsearchClient $client
     */
    protected $client;

    /**
     * @var string|array
     */
    protected $index;

    /**
     * @var string|array
     */
    protected $type;

    /**
     *
     * @param  ElasticsearchClient   $client
     */
    public function __construct(SearchClientInterface $client)
    {
        $this->client = $client;
    }

    public function getClient()
    {
        return $this->client;
    }

    /**
     *  Return client index name
     *
     * @var         int    $version
     * @return      string              client Index Name
     */
    public function getIndexName($version = 1)
    {
        if (is_array($this->index)) {
            if (isset($this->index[$version])) {
                return $this->index[$version];
            } else {
                throw new \Exception('You should select correct version for index name!');
            }
        } else {
            return $this->index[$version];
        }
    }

    /**
     * Return index of index
     *
     * @var         int         $version
     * @return      mixed                  Index of searcher
     */
    public function getIndex($version = 1)
    {
        return $this->getClient()->getIndex($this->getIndexName($version));
    }


    /**
     *  Return searcher index name
     *
     * @var         int    $version
     * @return      string              Searcher Index Name
     */
    public function getTypeName($version = 1)
    {
        if (is_array($this->type)) {
            if (isset($this->type[$version])) {
                return $this->type[$version];
            } else {
                throw new \Exception('You should select correct version for type name!');
            }
        } else {
            return $this->type[$version];
        }
    }


    /**
     * Return type of index
     * @var         int         $version
     * @return      mixed                  type of searcher
     */
    public function getType($version = 1)
    {
        return $this->getCLient()
            ->getIndex($this->getIndexName($version))
            ->getType($this->getTypeName($version));
    }
}
