<?php declare(strict_types=1);

namespace Yokai\Enum\Tests;

use PHPUnit\Framework\TestCase;
use Yokai\Enum\ConfigurableEnum;

class ConfigurableEnumTest extends TestCase
{
    public function testConfigurability(): void
    {
        $fooEnum = new ConfigurableEnum('foo', ['foo' => 'FOO', 'bar' => 'BAR']);
        $this->assertSame('foo', $fooEnum->getName());
        $this->assertSame(['foo' => 'FOO', 'bar' => 'BAR'], $fooEnum->getChoices());
    }
}
