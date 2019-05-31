<?php declare(strict_types=1);

namespace Yokai\Enum\Tests\Bridge\Symfony\Bundle\DependencyInjection\CompilerPass;

use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\Reference;
use Yokai\Enum\Bridge\Symfony\Bundle\DependencyInjection\CompilerPass\TaggedEnumCollectorCompilerPass;

/**
 * @author Yann Eugoné <eugone.yann@gmail.com>
 */
class TaggedEnumCollectorCompilerPassTest extends TestCase
{
    /**
     * @var TaggedEnumCollectorCompilerPass
     */
    private $compiler;

    protected function setUp(): void
    {
        $this->compiler = new TaggedEnumCollectorCompilerPass;
    }

    protected function tearDown(): void
    {
        unset($this->compiler);
    }

    public function testCollectWhenServiceNotAvailable(): void
    {
        $compiler = $this->prophesize('Symfony\Component\DependencyInjection\ContainerBuilder');
        $compiler->hasDefinition('enum.registry')->shouldBeCalled()->willReturn(false);

        $this->compiler->process($compiler->reveal());
    }

    public function testCollectEnums(): void
    {
        $registry = $this->prophesize('Symfony\Component\DependencyInjection\Definition');
        $registry->addMethodCall('add', [new Reference('enum.gender')])->shouldBeCalled();
        $registry->addMethodCall('add', [new Reference('enum.type')])->shouldBeCalled();

        $compiler = $this->prophesize('Symfony\Component\DependencyInjection\ContainerBuilder');
        $compiler->hasDefinition('enum.registry')->shouldBeCalled()->willReturn(true);
        $compiler->getDefinition('enum.registry')->shouldBeCalled()->willReturn($registry);
        $compiler->findTaggedServiceIds('enum')->shouldBeCalled()->willReturn([
            'enum.gender' => $this->prophesize('Symfony\Component\DependencyInjection\Definition')->reveal(),
            'enum.type' => $this->prophesize('Symfony\Component\DependencyInjection\Definition')->reveal(),
        ]);

        $this->compiler->process($compiler->reveal());
    }
}
