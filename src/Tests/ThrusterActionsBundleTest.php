<?php

namespace Thruster\Bundle\ActionsBundle\Tests;

use Thruster\Bundle\ActionsBundle\ThrusterActionsBundle;

class ThrusterActionsBundleTest extends \PHPUnit_Framework_TestCase
{
    public function testAddCompilerPass()
    {
        $builderMock = $this->getMock('\Symfony\Component\DependencyInjection\ContainerBuilder');

        $builderMock->expects($this->once())
            ->method('addCompilerPass')
            ->will(
                $this->returnCallback(
                    function ($compilerPass) use ($builderMock) {
                        $this->assertInstanceOf(
                            '\Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface',
                            $compilerPass
                        );

                        $compilerPass->process($builderMock);
                    }
                )
            );

        $builderMock->expects($this->once())
            ->method('setDefinition')
            ->will(
                $this->returnCallback(
                    function ($id, $definition) {
                        $this->assertSame('thruster_actions.executor', $id);
                        $this->assertInstanceOf('\Symfony\Component\DependencyInjection\Definition',
                            $definition);
                        $this->assertSame('Thruster\Component\Actions\Executor', $definition->getClass());
                    }
                )
            );

        $builderMock->expects($this->once())
            ->method('getDefinition')
            ->will(
                $this->returnCallback(
                    function ($id) {
                        $this->assertSame('foo_bar', $id);

                        $classDef = new class
                        {
                            public static function getSupportedAction()
                            {
                                return 'name';
                            }
                        };

                        $mock = $this->getMock('\Symfony\Component\DependencyInjection\Definition');
                        $mock->expects($this->once())
                            ->method('getClass')
                            ->willReturn($classDef);

                        return $mock;
                    }
                )
            );

        $builderMock->expects($this->once())
            ->method('findTaggedServiceIds')
            ->will(
                $this->returnCallback(
                    function ($tagName) {
                        $this->assertSame('thruster_action_executor', $tagName);

                        return [
                            'foo_bar' => [[]],
                        ];
                    }
                )
            );

        $bundle = new ThrusterActionsBundle();
        $bundle->build($builderMock);
    }
}
