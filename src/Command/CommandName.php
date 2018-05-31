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
 */
class CommandName
{
    use AutoProperty;

    /**
     * @var string
     */
    private $commandName;

    /**
     * CommandName constructor.
     *
     * @param string $commandName
     */
    public function __construct(string $commandName)
    {
        $this->commandName = $commandName;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->commandName;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->commandName;
    }
}