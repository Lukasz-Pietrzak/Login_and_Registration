<?php

class ErrorLogger
{
    /**
     * @param string $errorMessage
     * @param string $logFilePath
     * @return void
     */
    public static function logError(string $errorMessage, string $logFilePath): void
    {
        $date = date('Y-m-d H:i:s');
        $logMessage = "[$date] $errorMessage\n\n";
        $logMessage .= str_repeat("-", 40) . "\n\n";
        error_log($logMessage, 3, $logFilePath);
    }
}