<?php

namespace Error;

use InvalidArgumentException;

/**
 * Class Debugger
 * Holds error messages, which will output at the end.
 *
 * @package Error
 */
class Debugger
{
    private static $title = "<p style=\"font-size:10pt;font-family:'Courier New', Monospace;white-space:pre;\">
 ██▀███   █    ██ ▓█████▄ ▓█████                                
▓██ ▒ ██▒ ██  ▓██▒▒██▀ ██▌▓█   ▀                                
▓██ ░▄█ ▒▓██  ▒██░░██   █▌▒███                                  
▒██▀▀█▄  ▓▓█  ░██░░▓█▄   ▌▒▓█  ▄                                
░██▓ ▒██▒▒▒█████▓ ░▒████▓ ░▒████▒                               
░ ▒▓ ░▒▓░░▒▓▒ ▒ ▒  ▒▒▓  ▒ ░░ ▒░ ░                               
  ░▒ ░ ▒░░░▒░ ░ ░  ░ ▒  ▒  ░ ░  ░                               
  ░░   ░  ░░░ ░ ░  ░ ░  ░    ░                                  
   ░        ░        ░       ░  ░                               
                   ░                                            
▓█████▄ ▓█████  ▄▄▄▄    █    ██   ▄████   ▄████ ▓█████  ██▀███  
▒██▀ ██▌▓█   ▀ ▓█████▄  ██  ▓██▒ ██▒ ▀█▒ ██▒ ▀█▒▓█   ▀ ▓██ ▒ ██▒
░██   █▌▒███   ▒██▒ ▄██▓██  ▒██░▒██░▄▄▄░▒██░▄▄▄░▒███   ▓██ ░▄█ ▒
░▓█▄   ▌▒▓█  ▄ ▒██░█▀  ▓▓█  ░██░░▓█  ██▓░▓█  ██▓▒▓█  ▄ ▒██▀▀█▄  
░▒████▓ ░▒████▒░▓█  ▀█▓▒▒█████▓ ░▒▓███▀▒░▒▓███▀▒░▒████▒░██▓ ▒██▒
 ▒▒▓  ▒ ░░ ▒░ ░░▒▓███▀▒░▒▓▒ ▒ ▒  ░▒   ▒  ░▒   ▒ ░░ ▒░ ░░ ▒▓ ░▒▓░
 ░ ▒  ▒  ░ ░  ░▒░▒   ░ ░░▒░ ░ ░   ░   ░   ░   ░  ░ ░  ░  ░▒ ░ ▒░
 ░ ░  ░    ░    ░    ░  ░░░ ░ ░ ░ ░   ░ ░ ░   ░    ░     ░░   ░ 
   ░       ░  ░ ░         ░           ░       ░    ░  ░   ░     
 ░                   ░                                          </p>";
    /**
     * @var string $dumps
     */
    private static $dumps = 'Debug:<br>';

    /**
     * Adds $var with a newline to {@link Debugger::$dumps}.
     * Please use:
     * __METHOD__ or __FILE__ on line __LINE__
     *
     * @param $var
     */
    public static function dump($var, $file = '', $line = '')
    {
        if (gettype($var) == "string") {
            self::$dumps .= "$var";
        } else if (gettype($var) == "array") {
            self::$dumps .= json_encode($var);
        } else
            throw new InvalidArgumentException("type of \$var: " . gettype($var) . " not supported yet.");
        if ($file != '') self::$dumps .= " in <b>" . $file . "</b>";
        if ($line != '') self::$dumps .= " on line <b>" . $line . "</b>";
        self::$dumps .= "<br>";

    }

    /**
     * @return string $dumps
     */
    public static function getDumps()
    {
        return self::$title . self::$dumps . '----------------------------------------<br>';
    }
}