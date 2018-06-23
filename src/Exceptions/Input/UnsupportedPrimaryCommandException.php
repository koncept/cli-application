<?php declare(strict_types=1);

namespace Koncept\ConsoleApp\Exceptions;

use RuntimeException;
use Strict\Collection\Vector\Scalar\Vector_string;


/**
 * [Exception] Unsupported Primary Command
 *
 * @author Showsay You <akizuki.c10.l65@gmail.com>
 * @copyright 2018 []. All Rights Reserved.
 * @package []
 * @since v1.0.0
 */
class UnsupportedPrimaryCommandException
    extends RuntimeException
    implements ConsoleInputExceptionInterface
{
    private $message;

    public function __construct(string $primaryCommand)
    {
        $this->message = "The command {$primaryCommand} is not supported (not listed in the CommandDictionary).";
        parent::__construct($this->message);
    }

    /**
     * Explain the reason why this exception is thrown.
     *
     * @return Vector_string
     */
    public function explain(): Vector_string
    {
        return new Vector_string($this->message . '.');
    }
}