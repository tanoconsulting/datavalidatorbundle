<?php

namespace TanoConsulting\DataValidatorBundle;

use TanoConsulting\DataValidatorBundle\Context\ExecutionContextInterface;

abstract class ConstraintValidator implements ConstraintValidatorInterface
{
    /** @var ExecutionContextInterface $context */
    protected $context;

    /**
     * Initializes the constraint validator.
     * @param ExecutionContextInterface $context
     */
    public function initialize(ExecutionContextInterface $context)
    {
        //if (! $context instanceof \TanoConsulting\DataValidatorBundle\Context\ExecutionContext) {
        //    throw new \TypeError(self::class . ' validators can only use a DataValidatorBundle ExecutionContext');
        //}

        $this->context = $context;
    }

    /**
     * Checks if the passed value is valid.
     *
     * @param mixed $value
     * @param Constraint $constraint
     */
    abstract public function validate($value, Constraint $constraint);
}
