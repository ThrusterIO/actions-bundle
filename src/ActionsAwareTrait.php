<?php

namespace Thruster\Bundle\ActionsBundle;

use Thruster\Component\Actions\ActionInterface;

/**
 * Trait ActionsAwareTrait
 *
 * @package Thruster\Bundle\ActionsBundle
 * @author  Aurimas Niekis <aurimas@niekis.lt>
 */
trait ActionsAwareTrait
{
    public function executeActions(ActionInterface $action)
    {
        if (property_exists($this, 'container')) {
            return $this->container->get('thruster_actions.executor')->execute($action);
        } elseif (method_exists($this, 'getContainer')) {
            return $this->getContainer()->get('thruster_actions.executor')->execute($action);
        }

        throw new \LogicException(
            'ActionsAwareTrait require Symfony Container accessible via property' .
            '$container or ->getContainer() method'
        );
    }
}
