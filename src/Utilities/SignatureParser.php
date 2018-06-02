<?php declare(strict_types=1);

namespace Koncept\ConsoleApp\Utilities;

use Koncept\ConsoleApp\Exceptions\InvalidSignatureException;


/**
 * [Class] Signature Parser
 *
 * @author Showsay You <akizuki.c10.l65@gmail.com>
 * @copyright 2018 Koncept. All Rights Reserved.
 * @package koncept/console-application
 * @since v1.0.0
 *
 * @internal
 */
class SignatureParser
{
    /** @var string */
    private $primary;
    /** @var null|string */
    private $secondary;

    /**
     * SignatureParser constructor.
     * @param string $signature
     */
    public function __construct(string $signature)
    {
        if (1 !== preg_match(
                '/^([a-zA-Z0-9]+(-[a-zA-Z0-9]+)*)(:([a-zA-Z0-9]+(-[a-zA-Z0-9]+)*)){0,1}$/u',
                $signature, $parsed)) {
            throw new InvalidSignatureException($signature);
        }

        $this->primary   = $parsed[1];
        $this->secondary = $parsed[4] ?? null;
    }

    /**
     * @return string
     */
    public function getPrimaryCommand(): string
    {
        return $this->primary;
    }

    /**
     * @return null|string
     */
    public function getSecondaryCommand(): ?string
    {
        return $this->secondary;
    }
}