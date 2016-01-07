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
     * Application name.
     *
     * @type    string
     */
    protected static $app_name = 'default';
    /**/

    /**
     * Application version.
     *
     * @type    string
     */
    protected static $app_version = '0.0.0';
    /**/

    /**
     * Application version date.
     *
     * @type    string
     */
    protected static $app_version_date = '0000-00-00';
    /**/

    /**
     * Constructor.
     */
    public function __construct()
    {
        parent::__construct(
            self::$app_name,
            [
                'version' => static::$app_version,
                'version_date' => static::$app_version_date
            ]
        );
    }

    /**
     * App initialization, load command plugins.
     */
    protected function initialize()
    {
        $iterator = new \FilesystemIterator(OCTRIS_APP_BASE . '/libs/App/');
        $filter = new \CallbackFilterIterator($iterator, function($cur, $key, $iter) {
            return ($cur->isFile() && strtolower($cur->getExtension() == 'php'));
        });
        
        $ns = __NAMESPACE__ . '\\App\\';
        
        foreach($filter as $file) {
            $class = $ns . basename($file->getFilename(), '.php');
            // $instance = new $class::
            
            print $class . "\n";
        }        
    }

    /**
     * Run main application.
     */
    final public function run()
    {
        $this->initialize();
    }
}
