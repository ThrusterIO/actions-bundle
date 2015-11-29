<?php

namespace Thruster\Bundle\ActionsBundle\Tests;

use Thruster\Bundle\ActionsBundle\ActionsAwareTrait;

class ActionsAwareTraitTest extends \PHPUnit_Framework_TestCase
{
    public function testTraitWithProperty()
    {
        $class = new class {
            use ActionsAwareTrait;

            public $container;
        };

        $input = $this->getMockForAbstractClass('\Thruster\Component\Actions\ActionInterface');

        $exeuctor = $this->getMock('\Thruster\Component\Actions\Executor');

        $exeuctor->expects($this->once())
            ->method('execute')
            ->with($input)
            ->willReturn($input);

        $container = $this->getMock('\Symfony\Component\DependencyInjection\ContainerInterface');
        $container->expects($this->once())
            ->method('get')
            ->with('thruster_actions.executor')
            ->willReturn($exeuctor);

        $class->container = $container;

        $this->assertEquals($input, $class->executeActions($input));
    }

    public function testTraitWithMethod()
    {
        $class = new class {
            use ActionsAwareTrait;

            public $containeris;

            public function getContainer()
            {
                return $this->containeris;
            }
        };

        $input = $this->getMockForAbstractClass('\Thruster\Component\Actions\ActionInterface');

        $exeuctor = $this->getMock('\Thruster\Component\Actions\Executor');

        $exeuctor->expects($this->once())
            ->method('execute')
            ->with($input)
            ->willReturn($input);

        $container = $this->getMock('\Symfony\Component\DependencyInjection\ContainerInterface');
        $container->expects($this->once())
            ->method('get')
            ->with('thruster_actions.executor')
            ->willReturn($exeuctor);

        $class->containeris = $container;

        $this->assertEquals($input, $class->executeActions($input));
    }

    /**
     * @expectedException \LogicException
     * @expectedExceptionMessage ActionsAwareTrait require Symfony Container accessible via property$container or ->getContainer() method
     */
    public function testTraitWithException()
    {
        $class = new class {
            use ActionsAwareTrait;
        };

        $input = $this->getMockForAbstractClass('\Thruster\Component\Actions\ActionInterface');

        $class->executeActions($input);
    }
}
