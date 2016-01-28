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
 * Proxy class for extending aaparser command class.
 *
 * @copyright   copyright (c) 2016 by Harald Lapp
 * @author      Harald Lapp <harald@octris.org>
 */
class Command
{
    /**
     * Command instance.
     *
     * @type    \Aaparser\Command
     */
    protected $command;

    /**
     * Constructor.
     *
     * @param   \Aaparser\Command       $command            Instance of a command.
     */
    public function __construct(\Aaparser\Command $command)
    {
        $this->command = $command;
    }

    /**
     * Define a new command.
     *
     * @param   string      $name           Name of command.
     * @param   array       $settings       Optional additional settings.
     * @return  \Octris\Cli\App\Command     Instance of new command.
     */
    public function addCommand($name, array $settings = array())
    {
        $instance = new Command($this->command->addCommand($name, $settings));

        return $instance;
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
     * Method proxy.
     *
     * @param   string                  $name               Name of method to call.
     * @param   array                   $args               Arguments for method.
     * @return  mixed                                       Return value of proxied method.
     */
    public function __call($name, array $args)
    {
        return $this->command->{$name}(...$args);
    }
}
