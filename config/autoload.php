<?php
	
	// Function to load all php files on main folder
	function autoloader($className)
	{
		$extensions = array(".php");
        $paths = array('controllers/web', 'controllers/api', 'models', 'core', 'routes');

        foreach ($paths as $path)
        {
                $path = dirname(__DIR__) . DIRECTORY_SEPARATOR .'src' . DIRECTORY_SEPARATOR . 'main' . DIRECTORY_SEPARATOR . $path;
                $filename = $path . DIRECTORY_SEPARATOR . $className;
				
                foreach ($extensions as $ext)
                {
                        if (is_readable($filename . $ext))
                        {				
                                require_once $filename . $ext;
                                break;
                        }
                }
        }	
	}

	spl_autoload_register('autoloader');

?>