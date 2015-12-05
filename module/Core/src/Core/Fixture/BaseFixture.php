<?php
/**
 * Base data fixture class.
 *
 * @since     Aug 2015
 * @author    M. Yilmaz SUSLU <yilmazsuslu@gmail.com>
 */
namespace Core\Fixture;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorAwareTrait;

/**
 * All derived child fixtures should implement their own
 * getOrder() method if necessary.
 */
class BaseFixture extends AbstractFixture implements OrderedFixtureInterface, ServiceLocatorAwareInterface
{
    use ServiceLocatorAwareTrait;

    /**
     * @Gedmo
     */
    const FIXTURE_ORDER = array(
        'Core\Fixture\LoadUserData' => 1,
    );

    /**
     * Translator repository for DB level translations.
     * @var string
     */
    const TRANSLATOR_REPOSTIORY = 'Core\\I18n\\Translatable\\Entity\\Translation';

    /**
     * Implement OrderedFixtureInterface
     *
     * @return int
     */
    public function getOrder()
    {
        $className = get_class($this);

        if (array_key_exists($className, self::FIXTURE_ORDER)) {
            return self::FIXTURE_ORDER[$className];
        }

        return 0;
    }

    /**
     * Overrided by all derived childs.
     *
     * @param  ObjectManager $manager
     * @return void
     */
    public function load(ObjectManager $manager)
    {
        return;
    }
}
