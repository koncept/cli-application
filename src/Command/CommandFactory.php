<?php declare(strict_types=1);

namespace Koncept\ConsoleApp\Command;

use Koncept\DI\Utility\RecursiveFactory;
use ReflectionClass;
use ReflectionException;


/**
 * [Class] Command Factory
 *
 * @author Showsay You <akizuki.c10.l65@gmail.com>
 * @copyright 2018 Koncept. All Rights Reserved.
 * @package koncept/console-appliation
 * @since v1.0.0
 *
 * @internal
 */
class CommandFactory
    extends RecursiveFactory
{
    public function supports(string $type): bool
    {
        if (!parent::supports($type)) return false;

        try {
            $rc = new ReflectionClass($type);
        } catch (ReflectionException $e) {
            return false;
        }

        if ($rc->isAbstract()) return false;
        if ($rc->isSubclassOf(CommandInterface::class)) return true;
        return false;
    }
}