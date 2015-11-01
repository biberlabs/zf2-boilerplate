<?php
/**
 * Abstract Search Service
 *
 * @since     Oct 2015
 * @author    Haydar KULEKCI <haydarkulekci@gmail.com>
 */
namespace Search\Query\Service;

use Elastica\Query as ElasticaQuery;
use Elastica\QueryBuilder;
use Elastica\ResultSet;
use Search\Paginator\Adapter\ElasticsearchAdapter;
use Search\Service\AbstractSearchService;
use Zend\Paginator\Paginator;

class AbstractQueryService extends AbstractSearchService
{
    const VIEW_LIST   = 'list';
    const VIEW_SHORT  = 'short';
    const VIEW_DETAIL = 'detail';

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
     * @return Resultset
     */
    public function doSearch(ElasticaQuery $query, $page, $itemsPerPage, $type = self::VIEW_LIST, $version = 1)
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

        return $this->getSearcher()
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
