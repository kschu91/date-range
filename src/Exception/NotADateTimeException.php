<?php

namespace Aeq\DateRange\Exception;

use Throwable;

class NotADateTimeException extends \Exception
{
    public function __construct($val, int $code = 0, Throwable $previous = null)
    {
        parent::__construct(
            sprintf('Given %s date is not a \DateTime object, it´s a %s', var_export($val, true), gettype($val)),
            $code,
            $previous
        );
    }
}
