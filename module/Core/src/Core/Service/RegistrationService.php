<?php
/**
 * Registration service
 *
 * @since     Jul 2015
 * @author    M. Yilmaz SUSLU <yilmazsuslu@gmail.com>
 */
namespace Core\Service;

use Core\Entity\User as UserEntity;
use Core\Traits\ObjectManagerAwareTrait;
use DoctrineModule\Persistence\ObjectManagerAwareInterface;
use Zend\Authentication\AuthenticationService;

class RegistrationService extends AbstractService implements ObjectManagerAwareInterface
{
    use ObjectManagerAwareTrait;

    protected $authService = null;

    public function __construct(AuthenticationService $authService)
    {
        $this->authService = $authService;
    }

    /**
     * Login user with given email address and password.
     *
     * @param  string $email      E-mail address of the user
     * @param  string $password   Password of the user
     * @param  bool   $rememberme
     *
     * @return \Zend\Authentication\Result
     */
    public function login($email, $password, $rememberMe = false)
    {
        $adapter = $this->authService->getAdapter();

        $adapter->setIdentity($email);
        $adapter->setCredential($password);
        
        $authResult = $this->authService->authenticate();

        if ($authResult->isValid()) {
            $user = $authResult->getIdentity();
            $user->setLastLoginDate(new \DateTime());
            try {
                $this->getObjectManager()->flush($user);
            } catch (\Exception $e) {
                $this->getLogger()->err('User last login date update error', ['exception' => $e]);
            }
        }

        return $authResult;
    }

    /**
     * Verifies given password by given user credentials (using password salt)
     * when user trying to login the system first time.
     *
     * Called by doctrinemodule's authentication configuration on login.
     *
     * @static
     *
     * @param  string     $passwordHashed
     * @param  string     $passwordGiven
     *
     * @return boolean
     */
    public static function verifyRawPassword($passwordHashed, $passwordGiven)
    {
        $verified = password_verify($passwordGiven, $passwordHashed);

        if ($verified) {
            // You may also want to check user status here.
            // For example; $user->isBlacklisted() or $user->isVerified() etc..
            return true;
        }

        return false;
    }

    /**
     * Verifies given password by given user credentials (using password salt)
     * when user trying to login the system first time.
     *
     * Called by doctrinemodule's authentication configuration on login.
     *
     * @static
     *
     * @param  UserEntity $user
     * @param  string     $passwordGiven
     *
     * @return boolean
     */
    public static function verifyPassword(UserEntity $user, $passwordGiven)
    {
        return self::verifyRawPassword($user->getPassword(), $passwordGiven);
    }

    /**
     * Properly hashes password using bcrypt.
     *
     * @static
     *
     * @param  string $password Password given by user.
     *
     * @return string Password hash which ready to persist in database.
     */
    public static function hashPassword($password)
    {
        $options = array(
            'cost' => 12,
            'salt' => mcrypt_create_iv(22, MCRYPT_DEV_URANDOM)
            );

        return password_hash($password, PASSWORD_BCRYPT, $options);
    }
}
