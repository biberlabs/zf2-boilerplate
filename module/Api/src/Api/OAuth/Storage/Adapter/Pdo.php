<?php
/**
 * PDO Adapter
 *
 * @since     Nov 2015
 * @author    Haydar KULEKCI  <haydarkulekci@gmail.com>
 */
namespace Api\OAuth\Storage\Adapter;

use Api\OAuth\Storage\Adapter\Redis as RedisAdapter;
use OAuth2\Storage\Pdo as PdoStorage;

/**
 * Following grant_types implemented
 *
 *      - user_credentials
 *      - scope
 *
 * Database Table Scripts:
 *   CREATE TABLE oauth_scopes (scope TEXT, is_default BOOLEAN);
 *   CREATE TABLE oauth_clients (client_id VARCHAR(80) NOT NULL, client_secret VARCHAR(80), redirect_uri VARCHAR(2000) NOT NULL, grant_types VARCHAR(80), scope VARCHAR(100), user_id VARCHAR(80), CONSTRAINT clients_client_id_pk PRIMARY KEY (client_id));
 *
 * Example Data:
 *
 *   INSERT INTO oauth_scopes (scope, is_default) VALUES ('default', 1);
 *   INSERT INTO oauth_clients (client_id, client_secret, redirect_uri, grant_types, scope, user_id)
 *      VALUES ('TestClient', 'TestSecret', 'http://api.boilerplate.local', 'password client_credentials, refresh_token', 'default', 'admin@boilerplate.local');
 *
 * Redis Data Example Run on Command Line Interface:
 *
 *   SET oauth_clients:TestClient '{"client_id":"TestClient","client_secret":"TestSecret","username":"test","password":"pass"}'
 *
 */
class Pdo extends PdoStorage
{
    /**
     *
     *  @var RedisAdapter Redis Adapter
     */
    protected $redis;

    public function setRedis($redis)
    {
        $this->redis  = $redis;
    }

    public function getRedis()
    {
        return $this->redis;
    }

    public function checkUserCredentials($username, $password)
    {
        if ($user = $this->getUser($username)) {
            return $this->checkPassword($user, $password);
        }

        return false;
    }

    /**
     * {@inheritdoc}
     */
    protected function checkPassword($user, $password)
    {
        return \Core\Service\RegistrationService::verifyRawPassword($user['password'], $password);
    }

    /**
     * {@inheritdoc}
     */
    public function getUser($username)
    {
        $userInfo = $this->getRedis()->getUserData($username);
        if ($userInfo) {
            $userInfo['from_cache'] = true;

            return array_merge(array(
                'user_id' => $username
            ), $userInfo);
        }

        $stmt = $this->db->prepare('SELECT id, email, password, language, registration_date from users where email = :username');
        $stmt->execute(array('username' => $username));

        if (!$userInfo = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            return false;
        }

        $this->getRedis()->setUserData($username, $userInfo);
        // the default behavior is to use "username" as the user_id
        $userInfo['from_cache'] = false;

        return array_merge(array(
            'user_id' => $username
        ), $userInfo);
    }

    public function setUser($username, $password, $firstName = null, $lastName = null)
    {
        throw new \Exception('You can not create user this way.');
    }
}
