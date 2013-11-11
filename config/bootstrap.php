<?php

require_once __DIR__ .'/../vendor/Smarty/Smarty.class.php';
require_once __DIR__ . '/../vendor/Doctrine/Common/ClassLoader.php';
require_once __DIR__ . '/../vendor/Slim/Slim.php';
require_once __DIR__ . '/autoload.php';

class bootstrap{
	
	protected $_config;
	protected $_doctrine;
	protected $_doctrineConfig;
	protected $_smarty;
	
	protected $_api;
	protected $_entityManager;
	
	private function __construct($config)
	{
		$this->_config = $config;
		
		// Slim init
		\Slim\Slim::registerAutoloader();
		$this->_api = new \Slim\Slim();
		
		// Doctrine init
		$this->_doctrine = new Doctrine\Common\ClassLoader('Doctrine', __DIR__ . '/../vendor');
		$this->_doctrine->register();
		$this->_doctrineConfig = new Doctrine\ORM\Configuration;
		
		// Smarty init
		$this->_smarty = new Smarty;
		$this->_smarty->template_dir = __DIR__ .'/../src/main/views/';
		$this->_smarty->compile_dir = __DIR__ .'/../cache/templates';
		$this->_smarty->config_dir = __DIR__ .'/../config/';
		$this->_smarty->cache_dir = __DIR__ .'/../cache/smarty';
	}
	
	public function loadConfig()
	{
			// Doctrine
			if ($this->_config['debug.mode'])
			{
				$this->_doctrineConfig->setSQLLogger(new Doctrine\DBAL\Logging\EchoSQLLogger);
			}
			$this->_doctrineConfig->setMetadataDriverImpl($this->_doctrineConfig->newDefaultAnnotationDriver(__DIR__ . '/../src/models'));
			$this->_doctrineConfig->setProxyDir(__DIR__ . '/../vendor/Doctrine/proxy');
			$this->_doctrineConfig->setProxyNamespace('Proxies');
			$database = array(
				'driver' => 'pdo_mysql',
				'host' => $this->_config['database.host'],
				'user' => $this->_config['database.user'],
				'password' => $this->_config['database.password'],
				'dbname' => $this->_config['database.name'],
			);
			$this->_entityManager = Doctrine\ORM\EntityManager::create($database, $this->_doctrineConfig);
			
			// Slim
			$this->_api->config('debug', $this->_config['debug.mode']);
			$this->_api->log->setEnabled($this->_config['debug.log']);
						
			// Core init
			steel::setApi($this->_api);
			steel::setOrm($this->_entityManager);
			steel::setConfig($this->_config);
			steel::setSmarty($this->_smarty);
	}
	
	public function getApi()
	{
		return $this->_api;
	}
	
	function loadRoutes()
	{
		 switch ($_SERVER['HTTP_HOST'])
        {
            case $this->_config['api.subdomain']:
                $apiRoutes = new api();
				$apiRoutes->loadRoutes();
                break;		

            default:
                $webRoutes = new www();
				$webRoutes->loadRoutes();
        }
	}
	
	static public function load($config)
	{
		$start = new bootstrap ($config);
		$start->loadConfig();
		$start->loadRoutes();
		return $start->getApi();
	}
	
}

$config = parse_ini_file('config.ini', true);
return bootstrap::load($config['dev']);
