<?php

namespace app\models;

use Exception;

class helpers
{
    public static function log_error(Exception $e)
    {
        $myfile = fopen("ErrorLogs.txt", "w") or die("Unable to open file!");
        fwrite($myfile, $e);
        fwrite($myfile, "/n");
        fclose($myfile);
    }
}
