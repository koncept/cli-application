<?php declare(strict_types=1);

namespace Koncept\ConsoleApp\Console;


/**
 * [Class] Modern Windows Console Handler
 *
 * @author Showsay You <akizuki.c10.l65@gmail.com>
 * @copyright 2018 Koncept. All Rights Reserved.
 * @package koncept/console-application
 * @since v1.0.0
 */
class ModernWindowsConsoleHandler
    extends LegacyWindowsConsoleHandler
    implements ANSIConsoleHandlerInterface
{
    use ANSIExtensionTrait;
}