<?php
/**
 * User Resource Factory
 *
 * @since     Nov 2015
 * @author    Haydar KULEKCI <haydarkulekci@gmail.com>
 */
namespace Api\V1\User;

class UserResourceFactory
{
    public function __invoke($sm)
    {
        return new UserResource(
            $sm->get('core.service.user'),
            $sm->get('search.query.user')
        );
    }
}
