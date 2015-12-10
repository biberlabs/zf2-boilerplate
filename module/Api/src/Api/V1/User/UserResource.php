<?php
/**
 * User Resource Factory
 *
 * @since     Nov 2015
 * @author    Haydar KULEKCI <haydarkulekci@gmail.com>
 */
namespace Api\V1\User;

use Core\Service\UserService;
use Search\Query\Service\UserQueryService as UserSearchService;
use ZF\ApiProblem\ApiProblem;
use ZF\Rest\AbstractResourceListener;

class UserResource extends AbstractResourceListener
{
    /**
     * @var UserService
     */
    protected $userService = null;

    /**
     * @var UserService
     */
    protected $userSearchService = null;

    /**
     * @param UserService   $userService
     */
    public function __construct(UserService $userService, UserSearchService $userSearchService)
    {
        $this->userService       = $userService;
        $this->userSearchService = $userSearchService;
    }

    /**
     * {@inheritdoc}
     */
    public function fetch($id)
    {
        try {
            $data = $this->userSearchService->getById($id);
        } catch (\Exception $e) {
            return new ApiProblem($e->getCode(), $e->getMessage());
        }

        return $data;
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
