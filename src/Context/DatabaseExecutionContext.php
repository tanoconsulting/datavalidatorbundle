<?php

namespace TanoConsulting\DataValidatorBundle\Context;

use Doctrine\DBAL\Connection;

class DatabaseExecutionContext extends ExecutionContext
{
    /**
     * @param int $operatingMode
     */
    public function __construct($operatingMode = self::MODE_COUNT)
    {
        $this->operatingMode = $operatingMode;

        parent::__construct();
    }
}
