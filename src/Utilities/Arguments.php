<?php declare(strict_types=1);

namespace Koncept\ConsoleApp\Utilities;

use Koncept\ConsoleApp\Command\CommandName;
use Strict\Collection\Vector\Scalar\Vector_string;
use Strict\Property\Utility\AutoProperty;


/**
 * [Class] Argument
 *
 * @author Showsay You <akizuki.c10.l65@gmail.com>
 * @copyright 2018 Koncept. All Rights Reserved.
 * @package koncept/console-application
 * @since v1.0.0
 *
 * @property-read string $wholeCommand
 * @property-read string $fileName
 * @property-read Vector_string $argv
 * @property-read CommandName|null $commandName
 */
class Arguments
{
    use AutoProperty;

    /** @var string */
    private $exec;

    /** @var Vector_string */
    private $args;

    /** @var CommandName|null */
    private $commandArg;

    /**
     * Arguments constructor.
     *
     * @param Vector_string $argv
     */
    public function __construct(Vector_string $argv)
    {
        $this->exec = $argv->shift();
        if ($argv->empty()) {
            $this->commandArg = null;
        } else {
            $this->commandArg = new CommandName($argv->shift());
        }
        $this->args = $argv;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->getWholeCommand();
    }

    /**
     * @return string
     */
    public function getWholeCommand(): string
    {
        $ret = [$this->exec];

        if (!is_null($this->commandArg)) {
            $ret[] = $this->commandArg->getName();
        }

        foreach ($this->args as $arg) {
            $ret[] = escapeshellarg($arg);
        }

        return implode(' ', $ret);
    }

    /**
     * @return Vector_string
     */
    public function getArguments(): Vector_string
    {
        return $this->getArgv();
    }

    /**
     * @return Vector_string
     */
    private function getArgv(): Vector_string
    {
        return clone $this->args;
    }

    /**
     * @return string
     */
    public function getFileName(): string
    {
        return $this->exec;
    }

    /**
     * @return CommandName|null
     */
    public function getCommandName(): ?CommandName
    {
        return $this->commandArg;
    }
}