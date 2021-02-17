<?php
namespace ModulesGarden\Servers\VpsServer\Core\HandlerError\Exceptions;

/**
 * Description of ApiWhmcsException
 *
 * @author Rafał Ossowski <rafal.os@modulesgarden.com>
 */
class ApiException extends MGModuleException
{
    
    function __construct($class, $message, $code = 0, $previous = null)
    {
        parent::__construct($class, $message, $code, $previous);
    }
}
