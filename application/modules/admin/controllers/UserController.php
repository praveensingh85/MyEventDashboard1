<?php
class Admin_UserController extends Zend_Controller_Action {
  private $company_specific = 0;
  private $curr_user_login_id =0;
  public function init() {
      if($this->_helper->getHelper('FlashMessenger')->getMessages() !='')
	  {
		
	  $this->view->message = $this->_helper->getHelper('FlashMessenger')->getMessages();
	  }
      $current_id=Zend_Auth::getInstance()->getIdentity();
	  
	  $session = new Zend_Session_Namespace('Med.auth');
	  if(isset($_POST['client']))
    {
	
	$session->comp_id = $_POST['client'];
	 } 
	  if($session->user_type =="user"){
	      $this->_redirect("/");
	  }
	 if($session->comp_id > 0){
		   $this->company_specific = $session->comp_id;
	  }else{
	     $this->_redirect("/admin"); //This page is only for company specific
	  }
	  $this->curr_user_login_id = $current_id;
	  
    }
   public function preDispatch()
    {
		 
    }
	public function addAction(){
	       $exists = "no";
		   $request = $this->getRequest();
		   $form = new Med_Form_user();
           $form->set_company_specific($this->company_specific);
	       $form->start_form();
	       $this->view->form = $form;
	   	   if ($this->getRequest()->isPost()) {
		    $postData = $this->getRequest()->getPost();
		   if ($form->isValid($postData)) {
		    $input = $form->getValues();
			//Checking if email is already taken
			$au_id = Doctrine::getTable('Med_Model_AdminUsers')
                      ->findOneByau_email(trim($input['cu_email']));
			$au_id = $au_id->au_id;
			if($au_id>0){
			  $exists= "yes";
			}
			$cu_id = Doctrine::getTable('Med_Model_ClientUsers')
                      ->findOneBycu_email(trim($input['cu_email']));
			$cu_id = $cu_id->cu_id;
			if($cu_id>0){
			  $exists= "yes";
			}
            if($exists=="no"){
				$user = new Med_Model_ClientUsers();
				$user->cu_cmp_id = $this->company_specific ;
				$user->cu_date = date("Y-m-d")." 00:00:00";
				$user->fromArray($input);
				$user->save();
				if($_POST['submit_save_addnew']!=''){
					$this->_redirect('/admin/user/add?msg=new');
				}
				if($_POST['submit_save']!=''){
				   $this->_helper->getHelper('FlashMessenger')->addMessage("User is added successfully!");
				   if($request->getParam('prop')=="yes"){
					  $this->_redirect('admin/event/proprietaryeventlist');
				   }else{
					  $this->_redirect('admin/event/globaleventlist');
				   }
				}
			}else{
			  $this->view->already ="yes";
			}
			 
		  }
		  else{
		    //echo "ERROR <pre>";print_r($_POST);  
		  }
	   }


	   echo '<script language="javascript">state_value= "'.$_POST['cu_state_id'].'";AutoFillStates(document.getElementById("cu_country_id").value);</script>';

	}
	  public function editAction(){
	       $exists = "no";
		   $request = $this->getRequest();
		   $form = new Med_Form_user();
           $form->set_company_specific($this->company_specific);
	       $form->start_form();
	       $this->view->form = $form;
	       if ($this->getRequest()->isPost()) {
		    $postData = $this->getRequest()->getPost();
		   if ($form->isValid($postData)) {
		    $input = $form->getValues();
			//Checking if email is already taken
			$au_id = Doctrine::getTable('Med_Model_AdminUsers')
                      ->findOneByau_email(trim($input['cu_email']));
			$au_id = $au_id->au_id;
			if($au_id>0){
			  $exists= "yes";
			}
			$cu_id = Doctrine::getTable('Med_Model_ClientUsers')
                      ->findOneBycu_email(trim($input['cu_email']));
			$cu_id = $cu_id->cu_id;
			if($cu_id>0){
			  $exists= "yes";
			}
            if($exists=="no"){
				$user = new Med_Model_ClientUsers();
				$user->cu_cmp_id = $this->company_specific ;
				$user->cu_date = date("Y-m-d")." 00:00:00";
				$user->fromArray($input);
				$user->save();
				if($_POST['submit_save_addnew']!=''){
					$this->_redirect('/admin/user/add?msg=new');
				}
				if($_POST['submit_save']!=''){
				   $this->_helper->getHelper('FlashMessenger')->addMessage("User is added successfully!");
				   if($request->getParam('prop')=="yes"){
					  $this->_redirect('admin/event/proprietaryeventlist');
				   }else{
					  $this->_redirect('admin/event/globaleventlist');
				   }
				}
			}else{
			  $this->view->already ="yes";
			}
			 
		  }
		  else{
		    //echo "ERROR <pre>";print_r($_POST);  
		  }
	   	   
		   $input = $form->getValues();
		   $cu_id = $input['cu_id'];
		   echo '<script language="javascript">state_value= "'.$_POST['cu_state_id'].'";AutoFillStates(document.getElementById("cu_country_id").value);</script>';

	   }
     else {
	   $filters = array(
		'cu_id' => array('HtmlEntities', 'StripTags', 'StringTrim')
		);
        $validators = array(
		'cu_id' => array('NotEmpty', 'Int')
		);
    $input = new Zend_Filter_Input($filters, $validators);
    $input->setData($this->getRequest()->getParams());
	if ($input->isValid()) {
        $q = Doctrine_Query::create()
		->from('Med_Model_ClientUsers u')
 		->where('u.cu_id = ?', $input->cu_id);
		$result = $q->fetchArray();
		if (count($result) == 1) {

		if ($this->_helper->getHelper('FlashMessenger')->getMessages()) {
	        $this->view->messages = $this->_helper->getHelper('FlashMessenger')->getMessages();
        }
		   $finalresult = $result[0];
		   $finalresult['cu_cnpwd'] = $finalresult['cu_pwd'] ;
		   $this->view->form->populate($finalresult);
		   $cu_id = $input->cu_id;

		}
		} else {                                                            
				  echo "ERROR"; exit;
		}
		echo '<script language="javascript">state_value= "'.$finalresult['cu_state_id'].'";AutoFillStates(document.getElementById("cu_country_id").value);</script>';
		} 
	}
	
	public function listAction(){
	$session = new Zend_Session_Namespace('Med.auth');
	// check if super user or super admin does not select comany
	
	 // call clients list
   $clients = new Med_Plugin_Find();
   $clients_result = $clients->find();
  
   // create option for clients
  $option .="<option value='0'  selected=selected >Public Events</option>";
   foreach($clients_result as $r)
   {
	if($r['cmp_id']==$this->company_specific)
	{
		 $selected = "selected";
		}
	else
	 $selected = "";
	 
	$option .="<option value=$r[cmp_id] ";
	if($selected !=""){
		
	$option .="selected=$selected";
	}
	$option .= ">$r[cmp_name]</option>"; 
	   } 
	 $request = $this->getRequest();
		
       $sl = $request->getParam('sl');
		if($sl == 'n')
		{
			$_SESSION['getValue'] = '';
		}
	if($this->getRequest()->isPost() || $sl == 'y')  
		{
			
			
			if($sl == 'y')
			{
				$getValue = $_SESSION['getValue'];
			}
			else
			{
				$getValue = $this->getRequest()->getPost();
				$_SESSION['getValue'] = $getValue;
			}
	if($getValue['fname']!="First Name")
	
	{
	
	$fname = trim($getValue['fname']);		
	}
	if($getValue['lname']!="Last Name")
	
	{
	
	$lname = trim($getValue['lname']);		
	}
	if($getValue['department']!="")
	
	{
	
	$department = trim($getValue['department']);		
	}
		}
	 $query_user = Doctrine_Query::create()
	               ->from("Med_Model_ClientUsers cu")
				   ->where("cu.cu_cmp_id =?",$this->company_specific);
	  if($fname !="")
   {
	   $query_user->addwhere('cu.cu_fname LIKE ?','%'.$fname.'%');
	   }
	 if($lname !="")
   {
	   $query_user->addwhere('cu.cu_lname LIKE ?','%'.$lname.'%');
	   }  
	  if($department !="")
   {
	   $query_user->addwhere('cu.cu_department LIKE ?','%'.$department.'%');
	   }   			   
	 $result_user = $query_user->fetchArray();
	 // Paging start
   $page=$this->_getParam('page',1);
   $paginator = Zend_Paginator::factory($result_user);
   $paginator->setItemCountPerPage(10);
   $paginator->setCurrentPageNumber($page);
   $this->view->paginator=$paginator;
 
	// End Pagination	
   $this->view->option = $option;		   
	}
	
	public function getdatastatesAction()
    {
	  $request = $this->getRequest();
	  $this->_helper->layout->disableLayout();
      $this->getHelper('viewRenderer')->setNoRender(true);
	  if($this->getRequest()->isXmlHttpRequest()) {
         $id = $request->getParam('id');
		 $q = Doctrine_Query::create()
		     ->from('Med_Model_States s')
             ->where('s.st_country_id= ?',$id)
		     ->orderBy('s.st_name ASC') ;
	     $data = array();
         foreach ($q->fetchArray() as $t) {
		     $data[] = array('st_id' => $t['st_id'],'st_name'=>$t['st_name']);
          }
        //print_r($data);
		$data1 = new Zend_Dojo_Data('st_id', $data);
        header('Content-Type: application/json');
        echo $data1;
        
       }
    }	
  
 }