<?php

/*
 * This file is part of the 'octris/cli' package.
 *
 * (c) Harald Lapp <harald@octris.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Octris\Cli;

/**
 * Application class.
 *
 * @copyright   copyright (c) 2016 by Harald Lapp
 * @author      Harald Lapp <harald@octris.org>
 */
class App extends \Aaparser\Args
{
    /**
     * Constructor.
     *
     * @param   string          $name           Name of application.
     * @param   array           $settings       Optional settings.
     */
    public function __construct($name, array $settings = array())
    {
        parent::__construct($name, $settings);
    }

    /**
     * Import and add a command from a php script.
     *
     * @param   string      $name               Name of command to import.
     * @param   string      $class              Name of class to import command from, must implent App\ICommand.
     * @param   callable    $default_command    Optional default command (default: help).
     * @return  \Aaparser\Command               Instance of new object.
     */
    public function importCommand($name, $class, array $settings = array(), callable $default_command = null)
    {
        if (!is_subclass_of($class, '\Octris\Cli\App\ICommand')) {
            throw new \InvalidArgumentException('Class is not a valid command "' . (is_object($class) ? get_class($class) : $class) . '".');
        }

        $cmd = $this->addCommand($name);
        $cmd->setAction(function(array $options, array $operands) use ($class) {
            $instance = new $class();
            $instance->run($options, $operands);
        });

        if (is_null($default_command)) {
            $default_command = function() use ($cmd) {
                $this->printHelp($cmd);
            };
        }

        $cmd->setDefaultAction($default_command);

        $class::configure($cmd);

        return $cmd;
    }

    /**
     * App initialization, set default action.
     */
    protected function initialize()
    {
        // Set default action
        $this->setDefaultAction(function() {
            $this->printHelp();
        });
    }

    /**
     * Run main application.
     */
    final public function run()
    {
        $this->initialize();
        $this->parse();
    }
}
