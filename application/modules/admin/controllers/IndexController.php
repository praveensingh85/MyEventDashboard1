<?php

class Admin_IndexController extends Zend_Controller_Action {

  public function init() {
     if($this->_helper->getHelper('FlashMessenger')->getMessages() !='')
	 {
		
	  $this->view->message = $this->_helper->getHelper('FlashMessenger')->getMessages();
	 }
     $current_id=Zend_Auth::getInstance()->getIdentity();
  }
   public function preDispatch()
    {
  	
		 
    } 
	// Login Function
  public function indexAction() {
   $session = new Zend_Session_Namespace('Med.auth');
   // call clients list
   $clients = new Med_Plugin_Find();
   $clients_result = $clients->find();
   // create option for clients
   foreach($clients_result as $r)
   {
	
	$option .="<option value='$r[cmp_id]'";
	if($session->comp_id==$r['cmp_id']) $option .="selected";
	
	$option .=" >$r[cmp_name]</option>"; 
	   }
	
   $this->view->option = $option;
   
  } 
 
 
  
 }