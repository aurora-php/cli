<?php

/*
 * This file is part of the 'octris/cli' package.
 *
 * (c) Harald Lapp <harald@octris.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Octris\Cli\App;

/**
 * Class for console output.
 *
 * @copyright   copyright (c) 2018 by Harald Lapp
 * @author      Harald Lapp <harald@octris.org>
 */
class Output
{
    /**
     * Output stream.
     * 
     * @type    resource
     */
    protected $stream = STDOUT;
    
    /**
     * Interactive terminal.
     * 
     * @type    bool
     */
    protected $interactive = true;
    
    /**
     * Error output instance.
     * 
     * @type    Output
     */
    protected $error;
    
    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->error = new class() extends static {
            protected $stream = STDERR;
            
            public function __construct() {
            }
            
            public function error() {
                return $this;
            }
        };
    }
    
    /**
     * Write a string.
     * 
     * @param   string          $str            String to write.
     * @return  Output                          This instance.
     */
    public function write($str, ...$args)
    {
        fputs($this->stream, sprintf($str, ...$args));
        
        return $this;
    }
    
    /**
     * Return output instance to write to stderr.
     * 
     * @return  Output
     */
    public function error()
    {
        return $this->error;
    }
    
    /**
     * Write line and add carriage-return and line-feed characters.
     * 
     * @param   string          $str            Optional string to write.
     * @return  Output                          This instance.
     */
    public function writeln($str = '', ...$args)
    {
        $this->write($str . PHP_EOL, ...$args);
        
        return $this;
    }
    
    /**
     * Shortcut for writeln().
     *
     * @return  Output                          This instance.
     */
    public function ln()
    {
        $this->write(PHP_EOL);
        
        return $this;
    }
}
