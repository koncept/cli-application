<?php

use Koncept\ConsoleApp\Console\LegacyWindowsConsoleHandler;


if (realpath($_SERVER["SCRIPT_FILENAME"]) !== realpath(__FILE__)) {
    echo "This test is not intendend to be required.", PHP_EOL;
    die;
}

if (PHP_SAPI !== 'cli') {
    echo "This test is only for CLI environment.", PHP_EOL;
    die;
}

if (PHP_OS !== 'WINNT' && PHP_OS !== 'WIN32') {
    echo "LegacyWindowsConsoleHandler is not supported on the current OS.", PHP_EOL;
    die;
}

require(__DIR__ . '/../vendor/autoload.php');

$handler = new LegacyWindowsConsoleHandler();

echo 'Type "test": ';
$ret = $handler->prompt(true);

if ($ret === 'test') {
    echo 'Test passed.', PHP_EOL;
} else {
    echo 'Test failed.', PHP_EOL;
}
