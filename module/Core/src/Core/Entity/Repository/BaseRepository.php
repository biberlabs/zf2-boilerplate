<?php
/**
 * Base repository to share common functionality with all derived repositories.
 *
 * @since     Nov 2015
 * @author    M. Yilmaz SUSLU <yilmazsuslu@gmail.com>
 */
namespace Core\Entity\Repository;

use Doctrine\ORM\EntityRepository;

class BaseRepository extends EntityRepository
{
    /**
     * Inserts given entity on DB.
     * 
     * @param  object  $entity Entity to save
     * @param  boolean $flush  Immediately flushes after insertion if its TRUE. (Default: TRUE)
     * @return void
     */
    public function save($entity, $flush = true)
    {
        $this->_em->persist($entity);

        if($flush === true) {
            $this->_em->flush($entity);
        }
    }

    /**
     * Updates an existing entity on DB.
     * 
     * @param  object  $entity Entity to update
     * @param  boolean $flush  Immediately flushes after update if TRUE. (Default: TRUE)
     * @return void
     */
    public function update($entity, $flush = true)
    {
        $entity = $this->_em->merge($entity);

        if($flush === true) {
            $this->_em->flush($entity);
        }
    }

    /**
     * Determines whether an entity instance is known by EntityManager.
     *
     * @param object $entity
     *
     * @return boolean TRUE if EntityManager currently manages the given entity, FALSE otherwise.
     */
    public function isManaged($entity)
    {
        return $this->_em->contains($entity);
    }
}