<?php
/**
 * User data fixture for Core\Entity\User
 *
 * @since     Aug 2015
 * @author    M. Yilmaz SUSLU <yilmazsuslu@gmail.com>
 */
namespace Core\Fixture;

use Core\Entity\User as UserEntity;
use Core\Service\RegistrationService;
use Doctrine\Common\Persistence\ObjectManager;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;

class LoadUserData extends BaseFixture
{
    /**
     * Load users.
     *
     * @param  ObjectManager $manager Object manager instance.
     *
     * @return void
     */
    public function load(ObjectManager $manager)
    {
        $users    = $this->getUsersToPopulate();
        $hydrator = new DoctrineHydrator($manager);

        echo 'Creating users..', PHP_EOL;

        $i = 0;
        foreach ($users as $item) {
            $user = $hydrator->hydrate($item, new UserEntity());
            $manager->persist($user);
            echo '.';
            $i++;
        }

        $manager->flush();
        
        echo PHP_EOL, 'Total of ', $i, ' users created.', PHP_EOL;
    }

    /**
     * Returns some users to populate database.
     *
     * @return array
     */
    private function getUsersToPopulate()
    {
        return array(
            array(
                'nameSurname'      => 'John Doe',
                'email'            => 'admin@boilerplate.local',
                'password'         => RegistrationService::hashPassword('TestPass!'),
                'language'         => 'en_US',
                'registrationDate' => new \DateTime('2014-12-30'),
                ),
            array(
                'nameSurname'      => 'Amy Winehouse',
                'email'            => 'amy@boilerplate.local',
                'password'         => RegistrationService::hashPassword('OtherPass!'),
                'language'         => 'en_US',
                'registrationDate' => new \DateTime('2015-04-02'),
                ),
            );
    }
}
