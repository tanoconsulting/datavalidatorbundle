<?php

namespace TanoConsulting\DataValidatorBundle\Context;

use TanoConsulting\DataValidatorBundle\ConstraintViolationInterface;
use TanoConsulting\DataValidatorBundle\ConstraintViolationListInterface;
use TanoConsulting\DataValidatorBundle\Violation\ConstraintViolationBuilderInterface;

interface ExecutionContextInterface
{
    const MODE_DRY_RUN = 0;
    const MODE_COUNT = 1;
    const MODE_FETCH = 2;

    /**
     * Adds a violation at the current node of the validation graph.
     *
     * @param string|\Stringable $message The error message as a string or a stringable object
     * @param array              $params  The parameters substituted in the error message
     *
     * NB: modified from upstream
     */
    //public function addViolation(string $message, array $params = []);

    public function addViolation(ConstraintViolationInterface $violation);

    /**
     * Returns a builder for adding a violation with extended information.
     *
     * Call {@link ConstraintViolationBuilderInterface::addViolation()} to
     * add the violation when you're done with the configuration:
     *
     *     $context->buildViolation('Please enter a number between %min% and %max%.')
     *         ->setParameter('%min%', 3)
     *         ->setParameter('%max%', 10)
     *         ->setTranslationDomain('number_validation')
     *         ->addViolation();
     *
     * @param string|\Stringable $message    The error message as a string or a stringable object
     * @param array              $parameters The parameters substituted in the error message
     *
     * @return ConstraintViolationBuilderInterface The violation builder
     */
    //public function buildViolation(string $message, array $parameters = []);

    /**
     * Returns the violations generated by the validator so far.
     *
     * @return ConstraintViolationListInterface The constraint violation list
     */
    public function getViolations();

    /**
     * One for the MODE_ consts.
     * @return int
     */
    public function getOperatingMode();
}
