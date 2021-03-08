<?php

namespace TanoConsulting\DataValidatorBundle;

class ConstraintValidatorFactory implements ConstraintValidatorFactoryInterface
{
    protected $validators = [];

    /**
     * @param Constraint $constraint
     * @return ConstraintValidatorInterface
     */
    public function getInstance(Constraint $constraint)
    {
        /// @todo throw on unsupported constraints

        $className = $constraint->validatedBy();

        if (!isset($this->validators[$className])) {
            $this->validators[$className] = new $className();
        }

        return $this->validators[$className];
    }
}
