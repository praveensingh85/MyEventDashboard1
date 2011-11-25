<?php
require_once 'BaseController.php';
class IndexController extends Zend_Controller_Action {

  public function init() {
     if($this->_helper->getHelper('FlashMessenger')->getMessages() !='')
	 {
		
	  $this->view->message = $this->_helper->getHelper('FlashMessenger')->getMessages();
	 }
     $current_id=Zend_Auth::getInstance()->getIdentity();
  }
   public function preDispatch()
    {
  	 $this->view->render('_sidebar-search.phtml');
     
		 
    } 
	// Login Function
  public function indexAction() {
    
   $this->_helper->layout->setLayout('login');
   $registry = Zend_Registry::getInstance();
	$login = $registry['sess_user_id'];
	if(!is_null($login))
	{		
		$this->_redirect('/logout');
	}
   $form = new Med_Form_login;
	
	 $this->view->form = $form;
	 // check for valid input
	 // authenticate using adapter
	 // persist user record to session
	 // redirect to original request URL if present
	 if ($this->getRequest()->isPost()) {
	 if ($form->isValid($this->getRequest()->getPost())) {
	 $values = $form->getValues();
	 $adapter = new Med_Auth_Doctrine(
	 $values['email'], $values['password']
	 );
	 
	 $auth = Zend_Auth::getInstance();
	 $result = $auth->authenticate($adapter);
	 $message_error=$result->getMessages();
	 
	 if ($result->isValid()) {
	
	 $session = new Zend_Session_Namespace('Med.auth');
	 $p= $adapter->getResultArray();
	 
	 $session->user_type = $p['0']['au_type'];
	 // store company id if client admin logged in
	  if($session->user_type=="client_admin")
	 {
	 $session->comp_id = $p['0']['au_cmp_id'];
	 }
	  if($session->user_type!="super_admin" && $session->user_type!="super_user" && $session->user_type!="client_admin")
	 {
	 $session->user_type="user";
	 $session->comp_id = $p['0']['cu_cmp_id'];
	 
	 }
	 // check if login error is exist then delete
	 if(isset($session->login_error) )
	 {
		unset($session->login_error);
		 }
	 // after login send on 
	 
	 if($session->user_type=="super_admin" || $session->user_type=="super_user" || $session->user_type=="client_admin")
	 {
	 $this->_redirect('/admin');
	 }
	 else
	 {
		// put company id in session for simple user
		$session->comp_id = $p['0']['cu_cmp_id'];
		
		 $this->_redirect('/event/listviews');
		 }
	 
	 } else {
		 $session = new Zend_Session_Namespace('Med.auth');
		 
		 $error =$message_error['0'];
		 $session->login_error =  $error ;
		 $this->_helper->getHelper('FlashMessenger')->addMessage($error);
	
	 
	 }
	 }
	 }
     
  } 
   public function logoutAction()
    {
     Zend_Auth::getInstance()->clearIdentity();
     Zend_Session::destroy(true);
     $this->_redirect(MAIN_SITE_URL);
	 exit;
    } 
	
	public function jsonAction()
	{
		$data = array(
            'items'=>array(
                        'firstname'=>'Praveen',
                        'lastname'=>'Kumar',
                        'address'=>'Delhi India'
                        )
            );
			echo json_encode($data); 
		exit;
		}
  
  
 }