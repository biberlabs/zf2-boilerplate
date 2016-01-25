<?php
/**
 * Abstract Index Service
 *
 * @since     Oct 2015
 * @author    Haydar KULEKCI <haydarkulekci@gmail.com>
 */
namespace Search\Index\Service;

use Elastica\Document;
use Search\Exception\IndexingException;
use Search\Exception\MissingDataException;
use Search\Service\AbstractSearchService;

class AbstractIndexService extends AbstractSearchService
{
    /**
     * Indexing Data
     *
     * @param  array    $data
     * @param  integer  $version
     *
     * @throws IndexingException
     *
     * @return null
     */
    public function index(array $data, $version = 1)
    {
        if (!array_key_exists('id', $data)) {
            throw new MissingDataException('`id` field is requeired to index data');
        }

        //TODO: this creation will be moved to a builder
        $document = new Document($data['id'], $data);
        try {
            $this->getType($version)->addDocument($document);
        } catch (\Exception $e) {
            throw new IndexingException('Throw exception while indexing', $e->getCode(), $e);
        }
    }

    /**
     * Partial Update
     *
     * @param  string  $docId
     * @param  array    $data
     * @param  integer  $version
     *
     * @throws IndexingException
     *
     * @return null
     */
    public function update($docId, array $data, $version = 1)
    {
        $document = new Document();
        $document->setData($data);
        $document->setId($docId);
        $document->setDocAsUpsert(true);
        try {
            $this->getType($version)->updateDocument($document);
        } catch (\Exception $e) {
            throw new IndexingException('Throw exception while updating', $e->getCode(), $e);
        }
    }

    /**
     * Deleting Document by DocId
     *
     * @param  string  $docId
     * @param  integer  $version
     *
     * @throws IndexingException
     *
     * @return null
     */
    public function delete($docId, $version = 1)
    {
        try {
            $this->getType($version)->delete($docId);
        } catch (\Exception $e) {
            throw new IndexingException('Throw exception while updating', $e->getCode(), $e);
        }
    }
}
