<?php declare(strict_types=1);

namespace Koncept\ConsoleApp\Exceptions;

use RuntimeException;
use Strict\Collection\Vector\Scalar\Vector_string;


/**
 * [Exception] Invalid Signature
 *
 * @author Showsay You <akizuki.c10.l65@gmail.com>
 * @copyright 2018 Koncept. All Rights Reserved.
 * @package koncept/console-application
 * @since v1.0.0
 */
class InvalidSignatureException
    extends RuntimeException
    implements ConsoleInputExceptionInterface
{
    /** @var Vector_string */
    private $lines;

    /**
     * InvalidSignatureException constructor.
     *
     * @param string $signature
     */
    public function __construct(string $signature)
    {
        $messages    = [
            "The signature ({$signature}) given is wrong.",
            'The signature should be {lisp-case}:{lisp-case} like `my-command:run-fast` and ',
            'the latter {lisp-case} is optional (e.g. `my-command` is also allowed).',
        ];
        $this->lines = new Vector_string(...$messages);
        parent::__construct(implode(PHP_EOL, $messages));
    }

    /**
     * Explain the reason why this exception is thrown.
     *
     * @return Vector_string
     */
    public function explain(): Vector_string
    {
        return $this->lines;
    }
}