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
class App extends \Octris\Cli\App\Command
{
    /**
     * Constructor.
     *
     * @param   string          $name           Name of application.
     * @param   array           $settings       Optional settings.
     */
    public function __construct($name, array $settings = array())
    {
        parent::__construct($this, new \Aaparser\Args($name, $settings));
    }

    /**
     * Print help.
     *
     * @param   \Octris\Cli\App\Command     $command        Optional command to print help for.
     */
    public function printHelp(\Octris\Cli\App\Command $command = null)
    {
        if (is_null($command)) {
            $command = $this;
        }

        parent::printHelp($command->command);
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
