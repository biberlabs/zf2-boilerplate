<?php
/**
 * PDO Adapter
 *
 * @since     Nov 2015
 * @author    Haydar KULEKCI  <haydarkulekci@gmail.com>
 */
namespace Api\OAuth\Storage\Adapter;

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
 *   SET oauth_clients:TestClient '{"client_id":"TestClient","client_secret":"TestSecret","username":"oytun","password":"tez"}'
 *
 */
class Pdo extends PdoStorage
{
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
        $stmt = $this->db->prepare('SELECT * from users where email = :username');
        $stmt->execute(array('username' => $username));

        if (!$userInfo = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            return false;
        }

        // the default behavior is to use "username" as the user_id
        return array_merge(array(
            'user_id' => $username
        ), $userInfo);
    }

    public function setUser($username, $password, $firstName = null, $lastName = null)
    {
        $firstNameSurname = (!empty($firstName) ? $firstName : '') . (!empty($lastName) ? ' ' .$lastName : '');
        // do not store in plaintext
        $password = sha1($password);

        // if it exists, update it.
        if ($this->getUser($username)) {
            $stmt = $this->db->prepare('UPDATE users SET password=:password, name_surname=:firstNameSurname where email = :username');
        } else {
            $stmt = $this->db->prepare('INSERT INTO users (username, password, name_surname) VALUES (:username, :password, :firstNameSurname)');
        }

        return $stmt->execute(compact('username', 'password', 'firstNameSurname'));
    }
}