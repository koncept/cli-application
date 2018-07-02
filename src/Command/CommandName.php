<?php declare(strict_types=1);

namespace Koncept\ConsoleApp\Command;

use Koncept\ConsoleApp\Exceptions\InvalidSignatureException;
use Strict\Property\Utility\AutoProperty;


/**
 * [Class] Command Name
 *
 * @author Showsay You <akizuki.c10.l65@gmail.com>
 * @copyright 2018 Koncept. All Rights Reserved.
 * @package koncept/console-appliation
 * @since v1.0.0
 *
 * @property-read string $name
 * @property-read string $primary
 * @property-read null|string $secondary
 */
class CommandName
{
    use AutoProperty;

    /** @var string */
    private $primaryCmd;

    /** @var null|string */
    private $secondaryCmd;

    /**
     * CommandName constructor.
     *
     * @param string $signature
     */
    public function __construct(string $signature)
    {
        if (1 !== preg_match(
                '/^([a-zA-Z0-9]+(-[a-zA-Z0-9]+)*)(:([a-zA-Z0-9]+(-[a-zA-Z0-9]+)*))?$/u',
                $signature, $parsed)) {
            throw new InvalidSignatureException($signature);
        }

        $this->primaryCmd   = $parsed[1];
        $this->secondaryCmd = $parsed[4] ?? null;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        if (is_null($this->secondaryCmd)) {
            return $this->primaryCmd;
        }
        return "{$this->primaryCmd}:{$this->secondaryCmd}";
    }

    /**
     * @return string
     */
    public function getPrimary(): string
    {
        return $this->primaryCmd;
    }

    /**
     * @return null|string
     */
    public function getSecondary(): ?string
    {
        return $this->secondaryCmd;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->getName();
    }
}