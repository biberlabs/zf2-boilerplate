<?php
/**
 * Redis Adapter Service
 *
 * @since     Nov 2015
 * @author    M. Yilmaz SUSLU <yilmazsuslu@gmail.com>
 */
namespace Api\OAuth\Storage\Adapter;

use OAuth2\Storage\Redis as RedisStorage;

/**
 *  Redis Adapter Class
 *   We use Redis currently following grant_types:
 *      - access_token,
 *      - authorization_code,
 *      - refresh_token,
 *
 *  @see Api/config/module.config.php > $['zf-oauth2']['storage']
 *
 */
class Redis extends RedisStorage
{
    public function getUserData($username)
    {
        return $this->getValue($this->config['user_data_cache_key'].$username);
    }

    public function setUserData($username, $userInfo)
    {
        return $this->setValue($this->config['user_data_cache_key'].$username, $userInfo);
    }

    public function expireUserData($username)
    {
        return $this->expireValue($this->config['user_data_cache_key'].$username);
    }
}
