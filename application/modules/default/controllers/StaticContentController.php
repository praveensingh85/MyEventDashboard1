<?php

    class StaticContentController extends Zend_Controller_Action {

    public function init() {
     
	
	}
    public function preDispatch()
    {
  	$this->view->render('_sidebar-left.phtml');
	$this->view->render('_sidebar-left-login.phtml');
    $this->view->render('_sidebar-right.phtml');
	$this->localConfig = new Zend_Config_Ini(APPLICATION_PATH . '/configs/Oshk.ini');
    
    }
  // display static views
    public function displayAction()
   {  
      
	  if($_GET['val']!=""){
      $this->_helper->layout->disableLayout(); 
     $this->view->success_url=$_GET['val'];
     }
	$page = $this->getRequest()->getParam('page');
	 if (file_exists($this->view->getScriptPath(null) .
  "/" . $this->getRequest()->getControllerName() .
  "/$page." . $this->viewSuffix)) {
  $this->render($page);
 } else {
  throw new Zend_Controller_Action_Exception('Page not found',
 404);
 }
    } 
 
  }