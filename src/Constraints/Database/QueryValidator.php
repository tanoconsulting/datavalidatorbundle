<?php

namespace TanoConsulting\DataValidatorBundle\Constraints\Database;

use Doctrine\DBAL\Connection;
use TanoConsulting\DataValidatorBundle\Constraint;
use TanoConsulting\DataValidatorBundle\Constraints\DatabaseValidator;
use TanoConsulting\DataValidatorBundle\ConstraintViolation;
use TanoConsulting\DataValidatorBundle\Context\ExecutionContextInterface;

class QueryValidator extends DatabaseValidator
{
    /**
     * @param string|Connection $value string format: 'mysql://user:secret@localhost/mydb'
     * @param Constraint $constraint
     * @throws \Doctrine\DBAL\Exception
     */
    public function validate($value, Constraint $constraint)
    {
        /** @var Connection $connection */
        $connection = $this->getConnection($value);

        switch($this->context->getOperatingMode()) {
            case ExecutionContextInterface::MODE_COUNT:
                try {
                    $violationCount = $connection->executeQuery('SELECT COUNT(*) AS numrows FROM (' . rtrim($constraint->sql, ';') . ') subquery')->fetchOne();
                    if ($violationCount) {
                        $this->context->addViolation(new ConstraintViolation($constraint->sql, $violationCount, $constraint));
                    }
                } catch (\Exception $e) {
                    $this->context->addViolation(new ConstraintViolation(preg_replace('/\n */', ' ', $e->getMessage()), null, $constraint));
                }
                break;
            case ExecutionContextInterface::MODE_FETCH:
                try {
                    $violationData = $connection->executeQuery($constraint->sql)->fetchAllAssociative();
                    if ($violationData) {
                        $this->context->addViolation(new ConstraintViolation($constraint->sql, $violationData, $constraint));
                    }
                } catch (\Exception $e) {
                    $this->context->addViolation(new ConstraintViolation(preg_replace('/\n */', ' ', $e->getMessage()), null, $constraint));
                }
                break;
            case ExecutionContextInterface::MODE_DRY_RUN:
                $this->context->addViolation(new ConstraintViolation($constraint->sql, null, $constraint));
                break;
        }
    }
}
