<?php
/**
 * Abstract Search Service
 * You can use this abstract class create a QueryServices.
 * This query services search your datas on Elasticsearch.
 *
 * @since     Oct 2015
 * @author    Haydar KULEKCI <haydarkulekci@gmail.com>
 */
namespace Search\Query\Service;

use Elastica\Query as ElasticaQuery;
use Elastica\QueryBuilder;
use Elastica\ResultSet;
use Search\Exception\SearchingException;
use Search\Paginator\Adapter\ElasticsearchAdapter;
use Search\Service\AbstractSearchService;
use Zend\Paginator\Paginator;

class AbstractQueryService extends AbstractSearchService
{
    const VIEW_LIST   = 'list';
    const VIEW_SHORT  = 'short';
    const VIEW_DETAIL = 'detail';

    /**
     * Getting Elastica Document
     *
     * @param  string   $docId
     *
     * @throws SearchingException
     *
     * @return array
     */
    public function getById($docId, $version = 1)
    {
        try {
            return $this->getType($version)
                        ->getDocument($docId)->getData();
        } catch (\Elastica\Exception\ResponseException $e) {
            throw new SearchingException('Throwing exception while getting document!', $e->getCode(), $e);
        } catch (\Exception $e) {
            throw new SearchingException('Document not found with ' . $docId, 404, $e);
        }
    }

    /**
     * Creating a Zend\Paginator\Paginator from Elastica\ResultSet.
     * This paginator can be passed directly zf-hal or whereever you want.
     * This method use ElasticsearchAdapter as ArrayAdapter
     *
     * @param  ResultSet    $resultSet      Elastica result data
     * @return Paginator    Created paginator from resultset with ElasticsearchAdapter.
     */
    public function buildPaginator(Resultset $resultSet)
    {
        $itemsPerPage = empty($resultSet->getQuery()->getParam('size')) ? $this->getDefaultPageSize() : $resultSet->getQuery()->getParam('size');
        $currentPage  = (int)ceil($resultSet->getQuery()->getParam('size') / $itemsPerPage) + 1;
        
        $results = [];
        foreach ($resultSet->getResults() as $result) {
            $data           = $result->getData();
            $data['_score'] = $result->getScore();
            $results[]      = $data;
        }

        $adapter   = new ElasticsearchAdapter($results, $resultSet->getTotalHits());
        $adapter->setMeta('aggs', $resultSet->getAggregations());

        $paginator = new Paginator($adapter);
        $paginator->setCurrentPageNumber($currentPage);
        $paginator->setItemCountPerPage($itemsPerPage);

        return $paginator;
    }

    /**
     * Search on Elasticsearch
     * Example Usage:
     *
     * With Elastica Query Builder
     *      $qb = new QueryBuilder();
     *      $query = $qb->query()->match_all();
     *      $mainQuery = new \Elastica\Query($query);
     *      $this->doSearch($mainQuery, 1, 10);
     *
     * @param  ElasticaQuery    $query
     * @param  int              $page
     * @param  int              $itemPerPage
     * @param  string           $type           Already defined strings at self.
     * @param  int              $version        Search version for index and type
     * @return Resultset
     */
    protected function doSearch(ElasticaQuery $query, $page, $itemsPerPage, $type = self::VIEW_LIST, $version = 1)
    {
        $query->setFrom(($page - 1) * $itemsPerPage)
              ->setSize($itemsPerPage);
        if ($type === self::VIEW_LIST) {
            if ($this->getListViewFields()) {
                $query->setSource($this->getListViewFields());
            }
        } elseif ($type === self::VIEW_SHORT) {
            if ($this->getShortViewFields()) {
                $query->setSource($this->getShortViewFields());
            }
        } elseif ($type === self::VIEW_DETAIL) {
            if ($this->getDetailViewFields()) {
                $query->setSource($this->getDetailViewFields());
            }
        }

        return $this->getClient()
                    ->getIndex($this->getIndexName($version))
                    ->getType($this->getTypeName($version))
                    ->search($query);
    }

    /**
     *  Return fields on listing Mode
     *  If array is empty, it won't set a _source. And query returns all fields
     *
     *  @return array
     */
    protected function getListViewFields()
    {
        return array();
    }
    /**
     *  Return fields on listing Mode
     *  If array is empty, it won't set a _source. And query returns all fields
     *
     *  @return array
     */
    protected function getShortViewFields()
    {
        return array();
    }
    /**
     *  Return fields on detail Mode
     *  If array is empty, it won't set a _source. And query returns all fields
     *
     *  @return array
     */
    protected function getDetailViewFields()
    {
        return array();
    }

    protected function getDefaultPageSize()
    {
        return 10;
    }
}
