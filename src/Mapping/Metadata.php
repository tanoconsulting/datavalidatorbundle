<?php

namespace TanoConsulting\DataValidatorBundle\Mapping;

use TanoConsulting\DataValidatorBundle\Constraint;

abstract class Metadata
{
    /**
     * @var Constraint[]
     *
     * @internal This property is public in order to reduce the size of the
     *           class' serialized representation. Do not access it. Use
     *           {@link getConstraints()} and {@link findConstraints()} instead.
     */
    public $constraints = [];

    /**
     * @var array
     *
     * @internal This property is public in order to reduce the size of the
     *           class' serialized representation. Do not access it. Use
     *           {@link findConstraints()} instead.
     */
    //public $constraintsByGroup = [];

    /**
     * The strategy for cascading objects.
     *
     * By default, objects are not cascaded.
     *
     * @var int
     *
     * @see CascadingStrategy
     *
     * @internal This property is public in order to reduce the size of the
     *           class' serialized representation. Do not access it. Use
     *           {@link getCascadingStrategy()} instead.
     */
    //public $cascadingStrategy = CascadingStrategy::NONE;

    /**
     * The strategy for traversing traversable objects.
     *
     * By default, traversable objects are not traversed.
     *
     * @var int
     *
     * @see TraversalStrategy
     *
     * @internal This property is public in order to reduce the size of the
     *           class' serialized representation. Do not access it. Use
     *           {@link getTraversalStrategy()} instead.
     */
    //public $traversalStrategy = TraversalStrategy::NONE;

    /**
     * Is auto-mapping enabled?
     *
     * @var int
     *
     * @see AutoMappingStrategy
     *
     * @internal This property is public in order to reduce the size of the
     *           class' serialized representation. Do not access it. Use
     *           {@link getAutoMappingStrategy()} instead.
     */
    //public $autoMappingStrategy = AutoMappingStrategy::NONE;

    /**
     * Returns the names of the properties that should be serialized.
     *
     * @return string[]
     */
    public function __sleep()
    {
        return [
            'constraints',
            //'constraintsByGroup',
            //'cascadingStrategy',
            //'traversalStrategy',
            //'autoMappingStrategy',
        ];
    }

    /**
     * Clones this object.
     */
    public function __clone()
    {
        $constraints = $this->constraints;

        $this->constraints = [];
        $this->constraintsByGroup = [];

        foreach ($constraints as $constraint) {
            $this->addConstraint(clone $constraint);
        }
    }

    /**
     * Adds a constraint.
     *
     * If the constraint {@link Valid} is added, the cascading strategy will be
     * changed to {@link CascadingStrategy::CASCADE}. Depending on the
     * $traverse property of that constraint, the traversal strategy
     * will be set to one of the following:
     *
     *  - {@link TraversalStrategy::IMPLICIT} if $traverse is enabled
     *  - {@link TraversalStrategy::NONE} if $traverse is disabled
     *
     * @return $this
     *
     * @throws ConstraintDefinitionException When trying to add the
     *                                       {@link Traverse} constraint
     */
    public function addConstraint(Constraint $constraint)
    {
        /*if ($constraint instanceof Traverse) {
            throw new ConstraintDefinitionException(sprintf('The constraint "%s" can only be put on classes. Please use "Symfony\Component\Validator\Constraints\Valid" instead.', get_debug_type($constraint)));
        }

        if ($constraint instanceof Valid && null === $constraint->groups) {
            $this->cascadingStrategy = CascadingStrategy::CASCADE;

            if ($constraint->traverse) {
                $this->traversalStrategy = TraversalStrategy::IMPLICIT;
            } else {
                $this->traversalStrategy = TraversalStrategy::NONE;
            }

            return $this;
        }

        if ($constraint instanceof DisableAutoMapping || $constraint instanceof EnableAutoMapping) {
            $this->autoMappingStrategy = $constraint instanceof EnableAutoMapping ? AutoMappingStrategy::ENABLED : AutoMappingStrategy::DISABLED;

            // The constraint is not added
            return $this;
        }*/

        $this->constraints[] = $constraint;

        //foreach ($constraint->groups as $group) {
        //    $this->constraintsByGroup[$group][] = $constraint;
        //}

        return $this;
    }

    /**
     * Adds an list of constraints.
     *
     * @param Constraint[] $constraints The constraints to add
     *
     * @return $this
     */
    public function addConstraints(array $constraints)
    {
        foreach ($constraints as $constraint) {
            $this->addConstraint($constraint);
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getConstraints()
    {
        return $this->constraints;
    }

    /**
     * Returns whether this element has any constraints.
     *
     * @return bool
     */
    public function hasConstraints()
    {
        return \count($this->constraints) > 0;
    }
}
