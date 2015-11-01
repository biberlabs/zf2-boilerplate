<?php
/**
 * Abstract Index Service
 *
 * @since     Oct 2015
 * @author    Haydar KULEKCI <haydarkulekci@gmail.com>
 */
namespace Search\Index\Service;

use Search\Service\AbstractSearchService;

class AbstractIndexService extends AbstractSearchService
{
    /**
     *
     * @param  array    $data
     * @param  integer  $version
     * @return null
     */
    public function index(array $data, $version = 1)
    {
        if (!array_key_exists('id', $data)) {
            throw new MissingDataException('`id` field is requeired to index data');
        }

        //TODO: this creation will be moved to a builder
        $document = new \Elastica\Document($data['id'], $data);
        $this->getType($version)->addDocument($document);
    }
}
