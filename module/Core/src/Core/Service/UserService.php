<?php
/**
 * User service
 *
 * @since     Jul 2015
 * @author    M. Yilmaz SUSLU <yilmazsuslu@gmail.com>
 */
namespace Core\Service;

use Core\Entity\User;
use Core\Traits\ObjectManagerAwareTrait;
use Core\Entity\Repository\UserRepository;

class UserService extends AbstractService
{
    private $userRepository;

    /**
     * Constructor.
     * 
     * @param UserRepository $userRepository User repository instance.
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Changes given user's default locale.
     * 
     * @param  User   $user      User entity to update
     * @param  string $newLocale
     * 
     * @return boolean
     */
    public function changeLocaleByUser(User $user, $newLocale)
    {
        $user->setLanguage($newLocale);

        $this->userRepository->update($user);

        return true;
    }
}
