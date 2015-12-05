<?php
/**
 * Abstract Index Service
 *
 * @since     Oct 2015
 * @author    Haydar KULEKCI <haydarkulekci@gmail.com>
 */
namespace Search\Index\Service;

class UserIndexService extends AbstractIndexService
{
    /**
     * @var string|array
     */
    protected $index = [
            1 => 'users'
        ];

    /**
     * @var string|array
     */
    protected $type = [
            1 => 'user'
        ];
}
