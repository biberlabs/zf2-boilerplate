<?php
/**
 * Abstract Search Service
 *
 * @since     Oct 2015
 * @author    Haydar KULEKCI <haydarkulekci@gmail.com>
 */
namespace Search\Query\Service;

class UserQueryService extends AbstractQueryService
{
    /**
     * @var string|array
     */
    protected $index = [
            1 => 'users'
        ];

    /**
     * @var string|array
     */
    protected $type = [
            1 => 'user'
        ];

    /**
     *
     * User searcher method.
     * Example Usage :
     *      $userSearcher = $this->getServiceLocator()->get('search.query.user');
     *      $result       = $userSearcher->search(['name' => 'Haydar']);
     *
     * @param   array       $params
     * @return  array
     */
    public function search(array $params)
    {
        $qb        = new \Elastica\QueryBuilder();
        $query     = new \Elastica\Query(
            $qb->query()
                    ->match_all()
        );
        $resultSet = $this->doSearch($query, 1, 10);
        $paginator = $this->buildPaginator($resultSet);

        return $paginator;
    }

    public function getFieldWhitelistForQueries()
    {
        return [
            'name' => [
                'type'  => 'term',
                'field' => 'name',
            ]
        ];
    }
}
