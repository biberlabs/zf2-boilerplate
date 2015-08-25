<?php
/**
 * Object manager aware trait.
 * Provides persistency-related methods like;
 * 
 *  - getObjectManager() - EM or DM instance
 *  - getDoctrineHydrator() - Doctrine object hydrator
 *
 * @since     Wed 2014
 * @author    M. Yilmaz SUSLU <yilmazsuslu@gmail.com>
 */
namespace Core\Traits;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\Query;
use Doctrine\ORM\Tools\Pagination\Paginator as ORMPaginator;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator as DoctrineAdapter;
use Zend\Paginator\Paginator as ZendPaginator;

trait ObjectManagerAwareTrait
{
    protected $objectManager = null;

    /**
     * Set object manager.
     * 
     * @param  ObjectManager $em
     * @return void
     */
    public function setObjectManager(ObjectManager $em)
    {
        $this->objectManager = $em;
    }

    /**
     * Returns object manager.
     *
     * @throws \Exception
     * @return ObjectManager
     */
    public function getObjectManager()
    {
        return $this->objectManager;
    }

    /**
     * Returns doctrine object hydrator.
     *
     * @param  bool             $byValue
     * @internal param Object $entity Entity instance.
     * @return DoctrineHydrator
     */
    protected function getDoctrineHydrator($byValue = true)
    {
        return new DoctrineHydrator($this->getObjectManager(), $byValue);
    }

    /**
     * Prepares and returns a new Zend Pagintor instance by given
     * ORM query instance. Uses doctrine pagination adapter.
     *
     * @access protected
     * @param  \Doctrine\ORM\Query  $query;
     * @return ZendPaginator
     */
    protected function createPaginator(Query $query)
    {
        $adapter = new DoctrineAdapter(new ORMPaginator($query));

        return new ZendPaginator($adapter);
    }

    /**
     * Start transaction for transaction demarcation.
     *
     * @access protected
     * @see http://doctrine-orm.readthedocs.org/en/latest/reference/transactions-and-concurrency.html
     * @return void
     */
    protected function beginTransaction()
    {
        $this->getObjectManager()->getConnection()->beginTransaction();
    }

    /**
     * Roll back.
     *
     * @return void
     */
    protected function rollback()
    {
        $this->getObjectManager()->getConnection()->rollback();
    }

    /**
     * Commit
     *
     * @return void
     */
    protected function commit()
    {
        $this->getObjectManager()->getConnection()->commit();
    }
}
