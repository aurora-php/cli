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
 * Interface definition for application commands.
 *
 * @copyright   copyright (c) 2016 by Harald Lapp
 * @author      Harald Lapp <harald@octris.org>
 */
interface ICommand
{
    /**
     * Configure the command.
     * 
     * @param   \Aaparser\Command       $command            Instance of an aaparser command to configure.
     */
    public static function configure(\Aaparser\Command $command);
}
