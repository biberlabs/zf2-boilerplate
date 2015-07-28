<?php
/**
 * Abstract application service class for derived logger-enabled services.
 *
 * @since     Feb 2015
 * @author    M. Yilmaz SUSLU <yilmazsuslu@gmail.com>
 */
namespace Core\Service;

use Zend\Log\LoggerAwareTrait;
use Zend\Log\LoggerAwareInterface;

class AbstractService implements LoggerAwareInterface
{
    use LoggerAwareTrait;
}
