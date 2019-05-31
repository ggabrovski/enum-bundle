<?php declare(strict_types=1);

namespace Yokai\Enum\Exception;

use DomainException;

/**
 * @author Yann Eugoné <eugone.yann@gmail.com>
 */
class InvalidEnumException extends DomainException
{
    /**
     * @param string $name
     *
     * @return InvalidEnumException
     */
    public static function nonexistent(string $name): self
    {
        return new self(sprintf('Nonexistent enum with name "%s" in registry', $name));
    }
}
