<?php declare(strict_types=1);

namespace Koncept\ConsoleApp\Command;


/**
 * [Interface] Command Interface
 *
 * @author Showsay You <akizuki.c10.l65@gmail.com>
 * @copyright 2018 Koncept. All Rights Reserved.
 * @package koncept/console-appliation
 * @since v1.0.0
 *
 * *****************************************************************************
 * **** Command Interpretation *************************************************
 * *****************************************************************************
 *
 * Commands are interpreted as shown below.
 *
 * `koncept {command-name}:{sub-command-name} ...{arguments}`
 *
 * sub-command-name to method-name:
 *   lcfirst(str_replace('-', '', ucwords($subCommandName, '-')))
 *
 * Then {method-name}(...{$arguments}) will be called for an instance of {class-name}.
 * If {sub-command-name} is not given, __invoke() will be called.
 *
 *
 *
 * *****************************************************************************
 * **** Requirements for Methods to be called **********************************
 * *****************************************************************************
 *
 * Methods for SubCommands must be public.
 *
 * Methods can require arguments. Arguments are passed as string by default.
 * Using type hinting, you can modify the types of arguments.
 *
 * Type Hint Support:
 *   string:         just pass
 *   bool:           use filter_var
 *   int:            use filter_var
 *   float:          use filter_var
 *
 *
 *
 * *****************************************************************************
 * **** Example ****************************************************************
 * *****************************************************************************
 *
 * class MyCommand implements CommandInterface
 * {
 *     public function register(string ...$names) { ... }
 *     public function getByID(int ...$IDs) { ... }
 *     public function setName(int $ID, string $name) { ... }
 *     public function setFloat(float ...$value) { ... }
 *     public function __invoke(string ...$args) { ... }
 *
 *     private function privateCommand() { ... }
 * }
 *
 * `koncept my-command:register "John" "Matthew" "James"`
 *   => call `register('John', 'Matthew', 'James')`
 *
 * `koncept my-command:get-by-id 3 0x1A 011`
 *   => call `getByID(3, 26, 9)`
 *
 * `koncept my-command:set-name 3 "Johnathan"`
 *   => call `setName(3, 'Johnathan')`
 *
 * `koncept my-command:set-float 3 3.4 3,000.3 1.3e2 1.3e+2 1.3e-2`
 *   => call `setFloat(3.0, 3.4, 3000.3, 130.0, 130.0, 0.013)`
 *
 * `koncept my-command "John" 3 "Lucas"`
 *   => call `__invoke('John', '3', 'Lucas')`
 *
 * `koncept my-command:set-name "Johnathan" 3`
 *   => Invalid Parameter
 *
 * `koncept my-command:unknown-command`
 *   => Command Not Found
 *
 * `koncept my-command:private-command`
 *   => Command Not Found
 */
interface CommandInterface
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
    public function help(string ...$args): void;
}