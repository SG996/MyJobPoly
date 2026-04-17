<?php
$lines = file('c:/laragon/www/KNLV/storage/logs/laravel.log');
$errorLines = [];
foreach ($lines as $line) {
    if (strpos($line, 'local.ERROR') !== false) {
        $errorLines[] = $line;
    }
}
$lastError = end($errorLines);
// Log files have \n, explode by it doesn't work if it's on one line, Laravel logs exceptions on one giant line sometimes?
// No, Laravel logs exceptions on one line until the stack trace. Wait, stack trace is multiple lines.
preg_match('/local\.ERROR: (.*?) {"exception"/', $lastError, $matches);
$err = isset($matches[1]) ? $matches[1] : substr($lastError, 0, 300);
file_put_contents('c:/laragon/www/KNLV/err.txt', $err);
