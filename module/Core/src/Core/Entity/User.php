<?php
/**
 * User entity.
 *
 * @since     Aug 2015
 * @author    M. Yilmaz SUSLU <yilmazsuslu@gmail.com>
 */
namespace Core\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * BEWARE! - user is a reserved word in many RDBMS.
 *
 * TODO - Use schema name when data-fixtures#192 merged
 * @see https://github.com/doctrine/data-fixtures/pull/192
 *
 * @ORM\Entity(repositoryClass="Core\Entity\Repository\UserRepository")
 * @ORM\Table(name="users")
 */
class User extends Base
{
    /**
     * @var integer $id
     *
     * @ORM\Id
     * @ORM\Column(name="id", type="integer")
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

    /**
     * User's name and surname as string
     *
     * @ORM\Column(name="name_surname", type="string", length=70, nullable=true)
     * @var string
     */
    protected $nameSurname;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=60)
     */
    protected $email;

    /**
     * @ORM\Column(type="string", length=150)
     * @var string
     */
    protected $password;

    /**
     * @ORM\Column(type="string", length=5)
     * @var string
     */
    protected $language;

    /**
     * @ORM\Column(type="datetime", name="registration_date")
     * @var DateTime
     */
    protected $registrationDate;

    /**
     * @ORM\Column(type="datetime", name="last_login_date", nullable=true)
     * @var DateTime
     */
    protected $lastLoginDate;

    /**
     * @ORM\Column(type="string", length=15, name="last_login_from", nullable=true)
     * @var string
     */
    protected $lastLoginFrom;

    /**
     * Constructor
     */
    public function __construct()
    {
        // Set new user's language as our default locale.
        $this->language = Base::DEFAULT_LOCALE;
    }

    /**
     * Returns user's unqiue id.
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get email address
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set email address
     *
     * @return Person
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Gets the name and surname as string.
     *
     * @return string
     */
    public function getNameSurname()
    {
        return $this->nameSurname;
    }

    /**
     * Gets the name and surname as string.
     *
     * @return string
     */
    public function setNameSurname($nameSurname = null)
    {
        $this->nameSurname = $nameSurname;

        return $this;
    }

    /**
     * Returns user's enyrpted password.
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set user's password.
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returns user's registration date.
     *
     * @return \DateTime
     */
    public function getRegistrationDate()
    {
        return $this->registrationDate;
    }

    /**
     * Set user's registration date.
     *
     * @param \DateTime $date
     *
     * @return self
     */
    public function setRegistrationDate(\DateTime $date)
    {
        $this->registrationDate = $date;

        return $this;
    }

    /**
     * Returns user's last sucessful login date.
     *
     * @return \DateTime
     */
    public function getLastLoginDate()
    {
        return $this->lastLoginDate;
    }

    /**
     * Set user's last login date.
     *
     * @param \DateTime $date
     *
     * @return self
     */
    public function setLastLoginDate(\DateTime $date = null)
    {
        $this->lastLoginDate = $date;

        return $this;
    }

    /**
     * Returns user's last login IP address.
     *
     * @return string|null
     */
    public function getLastLoginFrom()
    {
        return $this->lastLoginFrom;
    }

    /**
     * Sets the user's last login IP address.
     *
     * @param string $ipAddress IP addres.
     *
     * @return self
     */
    public function setLastLoginFrom($ipAddress = null)
    {
        $this->lastLoginFrom = $ipAddress;

        return $this;
    }

    /**
     * Returns user's preferred language like en_US
     *
     * @return string
     */
    public function getLanguage()
    {
        return $this->language;
    }

    /**
     * Sets the value of language.
     *
     * @param string $language the language
     *
     * @return self
     */
    public function setLanguage($language)
    {
        $this->language = $language;

        return $this;
    }

    /**
     * Array representation of user entity.
     *
     * @return array
     */
    public function toArray()
    {
        return array(
            'id'               => $this->getId(),
            'nameSurname'      => $this->getNameSurname(),
            'email'            => $this->getEmail(),
            'language'         => $this->getLanguage(),
            'registrationDate' => $this->getRegistrationDate(),
            'lastLoginDate'    => $this->lastLoginDate(),
            'lastLoginFrom'    => $this->getLastLoginFrom(),
            );
    }
}
