<?php

// realpath() is nice in that it normalizes the spelling of pathnames to remove
// symbolic links and "/." and "/.." segments.  But unfortunately on Windows
// it produces Windows-style paths with backslash separators.  So when we append
// stuff with forward-slash separators we get mixed paths that some code handles
// okay, but other code doesn't.  In particular getimagefromjpeg() doesn't like
// mixed paths.  So wherever we use realpath, we wrap it in a str_replace to change
// the backslashes to forward slashes.  Ugly overkill, but hopefully all the routines
// we use on Windows will accept 100% forward-slashes, and on Linux there will be
// no filenames actually containing backslash characters.

// Define path to application directory
defined('APPLICATION_PATH')
    || define('APPLICATION_PATH', str_replace('\\', '/', realpath(dirname(__FILE__) . '/../../application')));

// Define application environment
defined('APPLICATION_ENV')
    || define('APPLICATION_ENV', (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'doctrineCLI'));

// Define database connection string based on simple name of application directory's parent
if ( ! defined('APPLICATION_DSN') ) {
    $appname = explode('/', str_replace('\\', '/', realpath(APPLICATION_PATH . '/..')));
    $db = strtoupper($appname[count($appname) - 1]);
    define('APPLICATION_DSN', "mysql://$db:$db@myeventdashboard/$db");
}

// Define session namespace string based on simple name of application directory's parent
if ( ! defined('APPLICATION_SESSION_NAME') ) {
    $appname = explode('/', str_replace('\\', '/', realpath(APPLICATION_PATH . '/..')));
    $name = strtoupper($appname[count($appname) - 1]);
    define('APPLICATION_SESSION_NAME', "$name");
}

// Some things (e.g. Zend Framework email and address validation) are a little different on Windows
if (preg_match('/^linux/i', php_uname('s'))) {
  define('APPLICATION_LINUX_HOSTED', true);
  $_ENV['MAGIC'] = '/usr/share/misc/magic';
}
else {
  define('APPLICATION_LINUX_HOSTED', false);
  $_ENV['MAGIC'] = '/cygwin/usr/share/misc/magic.mgc';
}



// Ensure library/ is on include_path
set_include_path(implode(PATH_SEPARATOR, array(
    realpath(APPLICATION_PATH . '/../library'),
    get_include_path()
)));

/** Zend_Application */
require_once 'Zend/Application.php';

// Create application, bootstrap, and run
$application = new Zend_Application(
    APPLICATION_ENV,
    APPLICATION_PATH . '/configs/application.ini'
);

$application->getBootstrap()->bootstrap('doctrine');

$config = $application->getOption('doctrine');

$cli = new Doctrine_Cli($config);
$cli->run($_SERVER['argv']);
