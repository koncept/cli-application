<?php declare(strict_types=1);

namespace Koncept\ConsoleApp\Console;


/**
 * [Trait] ANSI Extension
 *
 * @author Showsay You <akizuki.c10.l65@gmail.com>
 * @copyright 2018 Koncept. All Rights Reserved.
 * @package koncept/console-application
 * @since v1.0.0
 */
trait ANSIExtensionTrait
{
    /**
     * Prints text.
     *
     * @param string $text
     */
    abstract public function print(string $text): void;

    /**
     * Moves the cursor up by the specified number of lines without changing columns.
     * If the cursor is already on the top line, ANSI.SYS ignores this sequence.
     *
     * @param int $n
     */
    public function moveCursorUp(int $n = 1): void
    {
        $this->print("\e[{$n}A");
    }

    /**
     * Moves the cursor down by the specified number of lines without changing columns.
     * If the cursor is already on the bottom line, ANSI.SYS ignores this sequence.
     *
     * @param int $n
     */
    public function moveCursorDown(int $n = 1): void
    {
        $this->print("\e[{$n}B");
    }

    /**
     * Moves the cursor forward by the specified number of columns without changing lines.
     * If the cursor is already in the rightmost column, ANSI.SYS ignores this sequence.
     *
     * @param int $n
     */
    public function moveCursorForward(int $n = 1): void
    {
        $this->print("\e[{$n}C");
    }

    /**
     * Moves the cursor back by the specified number of columns without changing lines.
     * If the cursor is already in the leftmost column, ANSI.SYS ignores this sequence.
     *
     * @param int $n
     */
    public function moveCursorBackward(int $n = 1): void
    {
        $this->print("\e[{$n}D");
    }

    /**
     * Moves the cursor to the specified position (coordinates).
     * If you do not specify a position, the cursor moves to the home position
     *   at the upper-left corner of the screen (line 0, column 0).
     *
     * @param int $line
     * @param int $column
     */
    public function setCursorPosition(int $line = 0, int $column = 0): void
    {
        $this->print("\e[{$line};{$column}H");
    }

    /**
     * Saves the current cursor position.
     * You can move the cursor to the saved cursor position by using the Restore Cursor Position sequence.
     */
    public function saveCursorPosition(): void
    {
        $this->print("\e[s");
    }

    /**
     * Returns the cursor to the position stored by the Save Cursor Position sequence.
     */
    public function restoreCursorPosition(): void
    {
        $this->print("\e[u");
    }

    /**
     * Clears the screen and moves the cursor to the home position (line 0, column 0).
     */
    public function eraseDisplay(): void
    {
        $this->print("\e[2J");
    }

    /**
     * Clears all characters from the cursor position to the end of the line
     *   (including the character at the cursor position).
     */
    public function eraseLine(): void
    {
        $this->print("\e[K");
    }

    /**
     * Calls the graphics functions specified by constants defined in this interface.
     * These specified functions remain active until the next occurrence of this escape sequence.
     * Graphics mode changes the colors and attributes of text (such as bold and underline) displayed on the screen.
     *
     * @param int[] ...$attributes
     */
    public function setGraphicAttributes(int ...$attributes): void
    {
        $options = implode(';', $attributes);
        $this->print("\e[{$options}m");
    }
}