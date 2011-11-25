<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
  protected function _initAppAutoload() 
  {

	  $moduleLoad = new Zend_Application_Module_Autoloader(array(
         'namespace' => '',
         'basePath'   => APPLICATION_PATH 
		
      ));

	  $this->bootstrap('View');
	  
        $view = $this->getResource('View');
		// Set the initial title and separator:
        $view->headTitle('My Event Dashboard')
             ->setSeparator(' | ');
			 $view->doctype('XHTML1_STRICT'); //can set the doc type here
	   $view->headMeta()->appendHttpEquiv('Content-type', 'text/html;charset=utf-8') //utf-8 enabled
           ->appendName('description', 'My Event Dashboard')
            ->appendName('keywords', 'event')  ;	
  Zend_Controller_Action_HelperBroker::addPath(
        APPLICATION_PATH .'/../library/Med/Controller/Action/Helper');
  }
	


  protected function _initDoctrine()
  {
     $this->getApplication()
           ->getAutoloader()
           ->pushAutoloader(array('Doctrine', 'autoload'));
      spl_autoload_register(array('Doctrine', 'modelsAutoload'));

      $doctrineConfig = $this->getOption('doctrine');

      $manager = Doctrine_Manager::getInstance();
      $manager->setAttribute(Doctrine::ATTR_AUTO_ACCESSOR_OVERRIDE, true);
      $manager->setAttribute(
          Doctrine::ATTR_MODEL_LOADING,
          $doctrineConfig['model_autoloading']
      );

      Doctrine::loadModels($doctrineConfig['models_path']);

      $conn = Doctrine_Manager::connection($doctrineConfig['dsn'], 'doctrine');
      $conn->setAttribute(Doctrine::ATTR_USE_NATIVE_ENUM, true);
      $conn->setAttribute(Doctrine::ATTR_USE_NATIVE_SET, true);
      return $conn;
  }
    
  protected function _initDojo()
  {
    $this->bootstrap('View');
 
    $view = $this->getResource('View');
    Zend_Dojo::enableView($view);
    $viewRenderer = Zend_Controller_Action_HelperBroker::getStaticHelper('viewRenderer');
    $viewRenderer->setView($view);
  }

  protected function _initRoutes()
  {
    $front = Zend_Controller_Front::getInstance();
    $router = $front->getRouter();
    $restRoute = new Zend_Rest_Route($front, array(), array('api'));
    $router->addRoute('api', $restRoute);
  }

protected function _initNavigationConfig()
    {
   	
	$this->bootstrap(array('frontController'));
    $frontController = $this->getResource('frontController');
 
    $navigationPlugin = new Med_Plugin_WarpturnNavigation();
    $frontController->registerPlugin($navigationPlugin);
 
    return $navigationPlugin->getNavigation();
    }
 
  protected function _initCache()
  {
    $this->bootstrap('cachemanager');
    $manager = $this->getResource('cachemanager');
    $memoryCache = $manager->getCache('memory');
    Zend_Locale::setCache($memoryCache);
    Zend_Translate::setCache($memoryCache);
  }
 protected function _initLayoutHelper()
    {
        $this->bootstrap('frontController');
        $layout = Zend_Controller_Action_HelperBroker::addHelper(
            new ModuleLayoutLoader());
    }
  protected function _initSidebar()

    {
        $this->bootstrap('View');
        $view = $this->getResource('View');
        $view->placeholder('sidebar')
             ->setPrefix("<div class=\"sidebar\">\n    <div class=\"block\">\n")
             ->setSeparator("</div>\n    <div class=\"block\">\n")
             ->setPostfix("</div>\n</div>");

    }
	
	 /*protected function _initPlugins() {
	    	 $helper= new Med_My_Controller_Helper_Acl();
    $helper->setRoles();
	
    $helper->setResources();
    $helper->setPrivilages();
    $helper->setAcl();
     $frontController = Zend_Controller_Front::getInstance();
	 
    $frontController->registerPlugin(new Med_My_Controller_Plugin_Acl());


	    }*/
	 
  public function _initResources()
{
    $someservice = $this->getOption('doctrine');
    Zend_Registry::set('doctrine', $someservice);
}
		
  protected function _initSession()
  {
    Zend_Session::start();
    $session = new Zend_Session_Namespace('Med.auth');
	$registry = Zend_Registry::getInstance();
	
    if (Zend_Auth::getInstance()->hasIdentity()) {
	 $identity = Zend_Auth::getInstance()->getIdentity();
	 if($session->user_type =='client_admin' ||$session->user_type =='super_user'  ||$session->user_type =='super_admin' )
	 {
		 $registry->set('sess_user_id', Zend_Auth::getInstance()->getIdentity()); 
		 $registry->set('Med_Admin', $session->user_type);
		}
		else
		{
	    $registry->set('sess_user_id', Zend_Auth::getInstance()->getIdentity()); 
		$registry->set('Med_User', 'user');
		}
    }
    
  }

}
class ModuleLayoutLoader extends Zend_Controller_Action_Helper_Abstract
// looks up layout by module in application.ini
{
    public function preDispatch()
    {
        $bootstrap = $this->getActionController()
                          ->getInvokeArg('bootstrap');
        $config = $bootstrap->getOptions();
         $module = $this->getRequest()->getModuleName();
         if (isset($config[$module]['resources']['layout']['layout'])) {
            $layoutScript = $config[$module]['resources']['layout']['layout'];
            $this->getActionController()
            ->getHelper('layout')
            ->setLayout($layoutScript);
        }
    }
}



