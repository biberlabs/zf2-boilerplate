<?php
/**
 * User Resource Factory
 *
 * @since     Nov 2015
 * @author    Haydar KULEKCI <haydarkulekci@gmail.com>
 */
namespace Api\V1\User;

use Core\Service\UserService;
use ZF\Rest\AbstractResourceListener;

class UserResource extends AbstractResourceListener
{
    /**
     * @var UserService
     */
    protected $userService = null;

    /**
     * @param UserService   $userService
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * {@inheritdoc}
     */
    public function fetch($id)
    {
        return ['id' => $id, 'foo' => 'bar'];
    }

    /**
     * {@inheritdoc}
     */
    public function fetchAll($params = [])
    {
        // Example usage identity information
        // $identity = $this->getIdentity()->getAuthenticationIdentity();


        return [['foo' => 'bar']];
    }
}
