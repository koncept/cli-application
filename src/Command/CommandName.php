<?php declare(strict_types=1);

namespace Koncept\ConsoleApp\Command;

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
     * @param string $primary
     * @param null|string $secondary
     */
    public function __construct(string $primary, ?string $secondary = null)
    {
        $this->primaryCmd   = $primary;
        $this->secondaryCmd = $secondary;
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