<?php

namespace Thruster\Bundle\ActionsBundle;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * Class ThrusterActionsBundle
 *
 * @package Thruster\Bundle\ActionsBundle
 * @author  Aurimas Niekis <aurimas@niekis.lt>
 */
class ThrusterActionsBundle extends Bundle
{
    /**
     * @inheritDoc
     */
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(
            new class implements CompilerPassInterface
            {
                /**
                 * @inheritDoc
                 */
                public function process(ContainerBuilder $container)
                {
                    $executorId         = 'thruster_actions.executor';
                    $executorDefinition = new Definition('Thruster\Component\Actions\Executor');

                    $container->setDefinition($executorId, $executorDefinition);

                    foreach ($container->findTaggedServiceIds('thruster_action_executor') as $id => $tags) {
                        $definition = $container->getDefinition($id);
                        $name       = call_user_func([$definition->getClass(), 'getSupportedAction']);

                        $executorDefinition->addMethodCall('addExecutor', [$name, new Reference($id)]);
                    }
                }
            }
        );
    }
}
