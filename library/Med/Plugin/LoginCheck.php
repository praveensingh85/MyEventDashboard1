<?php

class Med_Plugin_LoginCheck extends Zend_Controller_Plugin_Abstract {

  public function preDispatch(Zend_Controller_Request_Abstract $request)
  {
    $registry = Zend_Registry::getInstance();
	$login = $registry['sess_user_id'];
    $user = $registry['Med_User'];
	$admin = $registry['Med_Admin'];
	
	$module = $request->getModuleName();
    if (is_null($login)) {
   $whattodo = $request->getModuleName()
                  . $request->getControllerName()
                  . $request->getActionName();
		
      if ($whattodo != 'defaultindexindex') {
        $url = $this->getRequest()->getRequestUri();
		$session = new Zend_Session_Namespace('Med.auth');
		$session->requestURL = $url;
        $request->setModuleName('default');
        $request->setControllerName('index');
        $request->setActionName('index');
      }
    }
	
	
  }

}