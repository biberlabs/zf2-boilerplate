<?php
/**
 * Base entity.
 *
 * @since     Aug 2015
 * @author    M. Yilmaz SUSLU <yilmazsuslu@gmail.com>
 */
namespace Core\Entity;

use Core\I18n\Locale as Locales;
use Gedmo\Mapping\Annotation as Gedmo;
use Zend\Stdlib\JsonSerializable;

/**
 * Base entity class to share common functionalities
 * across application-wide derived entities.
 */
class Base implements JsonSerializable
{
    /**
     * !!!!!!!!!!!!!!!!!
     * !!! Important !!!
     * !!!!!!!!!!!!!!!!!
     * NEVER EDIT OR ALTER THIS CONSTANT AND THE $locale VARIABLE BELOW.
     */
    const DEFAULT_LOCALE = Locales::DEFAULT_LOCALE;

    public function getAvailableTranslatableLocales()
    {
        return Locales::getAvailableLocales();
    }

    /**
     * @Gedmo\Locale
     * Used locale to override Translation listener`s locale.
     * This is not a mapped field of entity metadata, just a simple object attribute
     */
    protected $locale = self::DEFAULT_LOCALE;

    /**
     * Returns unique id of the entity.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    public function getLocale()
    {
        return $this->locale;
    }

    public function setLocale($locale)
    {
        $this->locale = $locale;
        
        return $this;
    }


    /**
     * Array representation of entity.
     *
     * @return array
     */
    public function toArray()
    {
        throw new \Exception('All derived entities should implement their own toArray() methods');
    }

    public function getArrayCopy()
    {
        return $this->toArray();
    }

    /**
     * Implement native JsonSerializeable interface.
     *
     * @see http://php.net/manual/en/class.jsonserializable.php
     * 
     * @return array
     */
    public function jsonSerialize()
    {
        return $this->toArray();
    }
}
