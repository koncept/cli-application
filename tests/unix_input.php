<?php declare(strict_types=1);

use Koncept\ConsoleApp\Console\UnixConsoleHandler;


if (realpath($_SERVER["SCRIPT_FILENAME"]) !== realpath(__FILE__)) {
    echo "This test is not intended to be required.", PHP_EOL;
    die;
}

if (PHP_SAPI !== 'cli') {
    echo "This test is only for CLI environment.", PHP_EOL;
    die;
}

if (PHP_OS === 'WINNT' || PHP_OS === 'WIN32') {
    echo "UnixConsoleHandler is not supported on the current OS.", PHP_EOL;
    die;
}

require(__DIR__ . '/../vendor/autoload.php');

$handler = new UnixConsoleHandler();

echo 'Type "test": ';
$ret = $handler->prompt(true);

if ($ret === 'test') {
    echo 'Test passed.', PHP_EOL;
} else {
    echo 'Test failed.', PHP_EOL;
}
