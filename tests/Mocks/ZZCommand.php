<?php

namespace Koncept\ConsoleApp\Tests\Mocks;

use Koncept\ConsoleApp\Command\CommandInterface;


class ZZCommand
    implements CommandInterface
{
    /**
     * Options that help MUST implement:
     *   - `help`
     *     List up commands supported.
     *   - `help {name}`
     *     Find commands named like {name} and list up those commands.
     *
     * Recommended switches:
     *   - `-s`
     *     Short description.
     *
     * @param string ...$args
     */
    public function help(string ...$args): void
    {
        // TODO: Implement help() method.
    }
}