<?php declare(strict_types=1);

namespace Koncept\ConsoleApp\Console;


/**
 * [Interface] ANSI Console Handler
 *
 * @author Showsay You <akizuki.c10.l65@gmail.com>
 * @copyright 2018 Koncept. All Rights Reserved.
 * @package koncept/console-appliation
 * @since v1.0.0
 *
 * @see http://ascii-table.com/ansi-escape-sequences.php
 */
interface ANSIConsoleHandlerInterface
    extends ConsoleHandlerInterface
{
    /**
     * Moves the cursor up by the specified number of lines without changing columns.
     * If the cursor is already on the top line, ANSI.SYS ignores this sequence.
     *
     * @param int $n
     */
    public function moveCursorUp(int $n = 1): void;

    /**
     * Moves the cursor down by the specified number of lines without changing columns.
     * If the cursor is already on the bottom line, ANSI.SYS ignores this sequence.
     *
     * @param int $n
     */
    public function moveCursorDown(int $n = 1): void;

    /**
     * Moves the cursor forward by the specified number of columns without changing lines.
     * If the cursor is already in the rightmost column, ANSI.SYS ignores this sequence.
     *
     * @param int $n
     */
    public function moveCursorForward(int $n = 1): void;

    /**
     * Moves the cursor back by the specified number of columns without changing lines.
     * If the cursor is already in the leftmost column, ANSI.SYS ignores this sequence.
     *
     * @param int $n
     */
    public function moveCursorBackward(int $n = 1): void;

    /**
     * Moves the cursor to the specified position (coordinates).
     * If you do not specify a position, the cursor moves to the home position
     *   at the upper-left corner of the screen (line 0, column 0).
     *
     * @param int $line
     * @param int $column
     */
    public function setCursorPosition(int $line = 0, int $column = 0): void;

    /**
     * Saves the current cursor position.
     * You can move the cursor to the saved cursor position by using the Restore Cursor Position sequence.
     */
    public function saveCursorPosition(): void;

    /**
     * Returns the cursor to the position stored by the Save Cursor Position sequence.
     */
    public function restoreCursorPosition(): void;

    /**
     * Clears the screen and moves the cursor to the home position (line 0, column 0).
     */
    public function eraseDisplay(): void;

    /**
     * Clears all characters from the cursor position to the end of the line
     *   (including the character at the cursor position).
     */
    public function eraseLine(): void;

    public const GRAPHIC_OFF                = 0;
    public const GRAPHIC_BOLD               = 1;
    public const GRAPHIC_UNDERSCORE         = 4;
    public const GRAPHIC_BLINK              = 5;
    public const GRAPHIC_REVERSE            = 7;
    public const GRAPHIC_CONCEALED          = 8;
    public const GRAPHIC_FOREGROUND_BLACK   = 30;
    public const GRAPHIC_FOREGROUND_RED     = 31;
    public const GRAPHIC_FOREGROUND_GREEN   = 32;
    public const GRAPHIC_FOREGROUND_YELLOW  = 33;
    public const GRAPHIC_FOREGROUND_BLUE    = 34;
    public const GRAPHIC_FOREGROUND_MAGENTA = 35;
    public const GRAPHIC_FOREGROUND_CYAN    = 36;
    public const GRAPHIC_FOREGROUND_WHITE   = 37;
    public const GRAPHIC_BACKGROUND_BLACK   = 40;
    public const GRAPHIC_BACKGROUND_RED     = 41;
    public const GRAPHIC_BACKGROUND_GREEN   = 42;
    public const GRAPHIC_BACKGROUND_YELLOW  = 43;
    public const GRAPHIC_BACKGROUND_BLUE    = 44;
    public const GRAPHIC_BACKGROUND_MAGENTA = 45;
    public const GRAPHIC_BACKGROUND_CYAN    = 46;
    public const GRAPHIC_BACKGROUND_WHITE   = 47;

    /**
     * Calls the graphics functions specified by constants defined in this interface.
     * These specified functions remain active until the next occurrence of this escape sequence.
     * Graphics mode changes the colors and attributes of text (such as bold and underline) displayed on the screen.
     *
     * @param int[] ...$attributes
     */
    public function setGraphicAttributes(int ...$attributes): void;
}