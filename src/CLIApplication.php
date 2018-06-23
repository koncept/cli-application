<?php declare(strict_types=1);

namespace Koncept\ConsoleApp;

use Koncept\ConsoleApp\Command\CommandDictionaryInterface;
use Koncept\ConsoleApp\Command\CommandFactory;
use Koncept\ConsoleApp\Command\CommandInterface;
use Koncept\ConsoleApp\Command\CommandName;
use Koncept\ConsoleApp\Console\ConsoleHandlerInterface;
use Koncept\ConsoleApp\Console\LegacyWindowsConsoleHandler;
use Koncept\ConsoleApp\Console\UnixConsoleHandler;
use Koncept\ConsoleApp\Exceptions\ConsoleInputExceptionInterface;
use Koncept\ConsoleApp\Exceptions\MalformedArgumentsException;
use Koncept\ConsoleApp\Exceptions\UnsupportedOperatingSystemException;
use Koncept\ConsoleApp\Exceptions\UnsupportedPrimaryCommandException;
use Koncept\ConsoleApp\Utilities\Arguments;
use Koncept\ConsoleApp\Utilities\ScalarArgumentParser;
use Koncept\DI\Exceptions\UnsupportedTypeException;
use Koncept\DI\Utility\AggregateTypeMap;
use Koncept\DI\Utility\ObjectContainer;
use Koncept\Kernel\KernelInterface;
use LogicException;
use Psr\Log\LoggerInterface;
use ReflectionException;
use ReflectionObject;
use Strict\Collection\Vector\Scalar\Vector_string;
use Throwable;


/**
 * [Abstract Class] CLI Application Base
 *
 * @author Showsay You <akizuki.c10.l65@gmail.com>
 * @copyright 2018 Koncept. All Rights Reserved.
 * @package koncept/console-appliation
 * @since v1.0.0
 */
class CLIApplication
    implements CLIApplicationInterface
{
    /** @var KernelInterface */
    private $kernel;

    /** @var ConsoleHandlerInterface */
    private $handler;

    /** @var CommandDictionaryInterface */
    private $dictionary;

    /**
     * CLIApplication constructor.
     *
     * @param KernelInterface $kernel
     * @param CommandDictionaryInterface $dictionary
     * @param string $os
     */
    public function __construct(
        KernelInterface $kernel,
        CommandDictionaryInterface $dictionary,
        string $os = PHP_OS
    ) {
        $this->kernel     = $kernel;
        $this->handler    = $this->getConsoleHandler($os);
        $this->dictionary = $dictionary;
    }

    public function invoke2(string ...$argv)
    {
        $arguments = new Arguments(new Vector_string(...$argv));

        if (is_null($commandName = $arguments->getCommandName())) {
            $this->outputMessage();
            return;
        }

        $this->execute($commandName, $arguments->getArguments());
    }

    private function execute(CommandName $command, Vector_string $argv): void
    {

    }

    private function launch(string $executeFile, string $command, Vector_string $argv): void
    {
        $commandName = new CommandName($command);

        $primary   = $commandName->getPrimary();
        $secondary = $commandName->getSecondary();

        if (is_null($cmdClsName = $this->dictionary->get($primary)))
            throw new UnsupportedPrimaryCommandException($primary);

        $factory = new CommandFactory(new AggregateTypeMap(
            $this->kernel->getCommonServiceProvider(),
            $this->kernel->getConfigFactory(),
            $this->kernel->getLogicFactory(),
            (new ObjectContainer)
                ->with($this->handler, ConsoleHandlerInterface::class)
                ->with($commandName)
        ));

        $commandObject = $factory->get($cmdClsName);
        $methodName    = is_null($secondary) ? '__invoke' : self::ConvertSecondaryCommandToMethodName($secondary);

        try {
            $reflectionMethod = (new ReflectionObject($commandObject))
                ->getMethod($methodName);
        } catch (ReflectionException $exception) {

        }

        if (!$reflectionMethod->isPublic() || $reflectionMethod->getName() !== $methodName) {

        }
    }

    /**
     * Invoke application.
     *
     * @param string ...$argv
     */
    public function __invoke(string ...$argv): void
    {
        $argv = new Vector_string(...$argv);

        $executeFile = $argv->shift();

        $org = $executeFile . ' "' . implode('" "', $argv->getArray()) . '"';

        if ($argv->empty()) {
            $this->outputMessage();
            return;
        }

        try {
            $signature        = new SignatureParser($argv->shift());
            $primaryCommand   = $signature->getPrimaryCommand();
            $secondaryCommand = $signature->getSecondaryCommand();

            if (is_null($commandClassName = $this->dictionary->get($primaryCommand))) {
                throw new UnsupportedPrimaryCommandException($primaryCommand);
            }

            $factory = new CommandFactory(new AggregateTypeMap(
                $this->kernel->getCommonServiceProvider(),
                $this->kernel->getConfigFactory(),
                $this->kernel->getLogicFactory(),
                (new ObjectContainer)
                    ->with($this->handler, ConsoleHandlerInterface::class)
                    ->with(new CommandName($primaryCommand))
            ));

            try {
                /** @var CommandInterface $commandClass */
                $commandClass = $factory->get($commandClassName);
            } catch (UnsupportedTypeException $exception) {
                throw new LogicException(
                    "The class {$commandClassName} returned by CommandDictionary is not supported by CommandFactory.",
                    0, $exception
                );
            }
            $methodName = is_null($secondaryCommand) ? '__invoke' : self::ConvertSecondaryCommandToMethodName($secondaryCommand);

            $refObj = new ReflectionObject($commandClass);
            try {
                $method = $refObj->getMethod($methodName);
                if (!$method->isPublic() || $method->getName() !== $methodName) $method = null;
            } catch (ReflectionException $exception) {
                $method = null;
            }

            if (is_null($method)) {
                if ($methodName === '__invoke') {
                    $this->printLn("The command {$primaryCommand} does not support direct call (`php {$executeFile} {$primaryCommand}`).");
                    $this->printLn("Call like `php {$executeFile} {$primaryCommand}:some-order`.");
                } else {
                    $this->printLn("The command {$primaryCommand} does not support {$primaryCommand}:{$secondaryCommand}.");
                }
                $this->callHelp($executeFile, $primaryCommand);
                return;
            }

            $sap = new ScalarArgumentParser($method);
            try {
                $args = $sap->format(...$argv);
            } catch (MalformedArgumentsException $malformedArgumentsException) {
                $this->printLn('The set of arguments seems wrong.');
                $this->callHelp($executeFile, $primaryCommand, $secondaryCommand);
                return;
            }
            $method->invoke($commandClass, ...$args);
            return;
        } catch (ConsoleInputExceptionInterface $inputException) {
            foreach ($inputException->explain() as $line) $this->printLn($line);
        } catch (Throwable $throwable) {
            $csp = $this->kernel->getCommonServiceProvider();
            if ($csp->supports(LoggerInterface::class)) {
                /** @var LoggerInterface $logger */
                $logger  = $csp->get(LoggerInterface::class);
                $logging = function (string $message) use ($logger): void {
                    $logger->critical($message);
                };
                $logger->critical("Uncaught Exception in CLIApplication:");
                $logger->critical($org);
                $logger->critical((string)$throwable);
                $logger->critical(var_dump($throwable));
            } else {
                $logging = function (string $message): void {
                    error_log($message);
                };
                error_log((string)$throwable);
                error_log(var_dump($throwable));
            }
        }
    }

    private function callHelp(string $executeFile, string $primaryCommand, ?string $secondaryCommand = null): void
    {
        if (is_null($secondaryCommand)) {
            $this->printLn("The result of `{$primaryCommand}:help` will be shown below.");
            $this->__invoke($executeFile, "{$primaryCommand}:help");
        } else {
            $this->printLn("The result of `{$primaryCommand}:help {$secondaryCommand}` will be shown below.");
            $this->__invoke($executeFile, "{$primaryCommand}:help", $secondaryCommand);
        }
    }

    /**
     * Acquire a console handler.
     *
     * @param string $os
     *
     * @return ConsoleHandlerInterface
     */
    private function getConsoleHandler(string $os): ConsoleHandlerInterface
    {
        if ($os === 'WIN32' || $os === 'WINNT') {
            return new LegacyWindowsConsoleHandler;
        }

        if ($os === 'Darwin' || $os === 'Linux' || $os === 'CYGWIN_NT-5.1' || $os === 'FreeBSD' || $os === 'OpenBSD' || $os === 'NetBSD') {
            return new UnixConsoleHandler;
        }

        throw UnsupportedOperatingSystemException::FromUName();
    }

    /**
     * Output framework message.
     */
    private function outputMessage(): void
    {
        $this->printLn('The Koncept PHP Framework');
        $this->printLn('    -Console Application-');
        return;
    }

    /**
     * Output message and new-line code.
     *
     * @param string $message
     */
    private function printLn(string $message = ''): void
    {
        $this->handler->print($message);
        $this->handler->print(PHP_EOL);
        return;
    }

    public static function ConvertSecondaryCommandToMethodName(string $secondaryCommand): string
    {
        return lcfirst(str_replace('-', '', ucwords($secondaryCommand, '-')));
    }
}