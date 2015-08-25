<?php
/**
 * User service
 *
 * @since     Jul 2015
 * @author    M. Yilmaz SUSLU <yilmazsuslu@gmail.com>
 */
namespace Core\Service;

use Core\Entity\User;
use DoctrineModule\Persistence\ObjectManagerAwareInterface;
use Core\Traits\ObjectManagerAwareTrait;

class UserService extends AbstractService implements ObjectManagerAwareInterface
{
    use ObjectManagerAwareTrait;

    public function changeLocaleByUser(User $user, $newLocale)
    {
        $user->setLanguage($newLocale);
        
        $this->getObjectManager()->flush($user);

        return true;
    }
}
