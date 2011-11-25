<?php

class Admin_EventController extends Zend_Controller_Action {

     private $company_specific = 0;
  private $curr_user_login_id =0;
  public function init() {
      if($this->_helper->getHelper('FlashMessenger')->getMessages() !='')
	  {
		
	  $this->view->message = $this->_helper->getHelper('FlashMessenger')->getMessages();
	  }
      $current_id=Zend_Auth::getInstance()->getIdentity();
	  
	  $session = new Zend_Session_Namespace('Med.auth');
	  if($session->user_type =="user"){
	      $this->_redirect("/");
	  }
	 if($session->comp_id > 0){
		   $this->company_specific = $session->comp_id;
	  }
	  $this->curr_user_login_id = $current_id;
	    	$activeNav = $this->view->navigation()->findByController('event');
            $activeNav->active = true;
            $activeNav->setClass("active");
			
    }
   public function preDispatch()
    {
		 
    }
	public function pre_format_date($date){
	// If date is blank then just returning blank 
	   if($date=="0000-00-00") return "";
		else return $date; 
	} 
	public function addAction(){
	  $request = $this->getRequest();
	  /* If this is open in non-company-specific mode, then let us open it in public mode */
	  if(!$this->company_specific){
	        $form = new Med_Form_globalevent();
            $form->set_company_specific($this->company_specific);
	        $form->start_form();
	        $this->view->form = $form;
	   }
	   else{ /* If this is open in company-specific mode, then let us open it in private mode */
	       $form = new Med_Form_event();
           $form->set_company_specific($this->company_specific);
	       $form->start_form();
	       $this->view->form = $form;
	   }
	   if ($this->getRequest()->isPost()) {
		$postData = $this->getRequest()->getPost();
		   $form->event_start_date->setRequired(true);
		   $form->event_end_date->setRequired(true);
		   if ($form->isValid($postData)) {
		    $input = $form->getValues();
			$event_cmp_id = $this->company_specific ;
			$event_au_id =  $this->curr_user_login_id;
			$event = new Med_Model_Events();
			$event->event_cmp_id = $event_cmp_id;
			$event->event_au_id = $event_au_id;
			$event->fromArray($input);
			if($input['event_status'] == '') $event->event_status = 'Unpublish';
			 if(is_array($input['event_person_virtual'])){
			    $event->event_person_virtual = implode(",",$input['event_person_virtual']);
			 }else{
			    $event->event_person_virtual='';
			 }
             $event->save();
			 $event_id = $event->event_id;
			 //inserting event format
			 if(is_array($input['ef_format_id'])){
			     foreach($input['ef_format_id'] as $key=>$val){
				    if($val>0){
					   $ef= new Med_Model_EventFormats();
					   $ef->ef_format_id = $val;
					   $ef->ef_event_id  = $event_id;
					   $ef->save();
					}
				 }
			 }
			 //inserting industries
			 if(is_array($input['ei_industry'])){
			     foreach($input['ei_industry'] as $key=>$val){
				    if($val>0){
					   $ei= new Med_Model_EventIndustries();
					   $ei->ei_industry = $val;
					   $ei->ei_event_id  = $event_id;
					   $ei->save();
					}
				 }
			 }
			 //Inserting company sizes
			 if(is_array($input['ecs_company_sizes'])){
			     foreach($input['ecs_company_sizes'] as $key=>$val){
				    if($val >0){
					    $ecs = new   Med_Model_EventCompanySizes();
					   	$ecs->ecs_event_id =    $event_id;
						$ecs->ecs_company_sizes = $val;
						$ecs->save();
					}
				 }
			 }
			 //Insertinng top sponsors
		   if(is_array($input['sc_company'])){
			     foreach($input['sc_company'] as $key=>$val){
				    if($val >0){
					    $sc = new   Med_Model_SponsorCompanies();
					   	$sc->sc_event_id =    $event_id;
						$sc->sc_company = $val;
						$sc->save();
					}
				 }
			 }
			if($this->company_specific > 0){ //If this is for company specific
				//Inserting private data now
				$emip = new Med_Model_EventsMoreInfoPrivate();
				$emip->fromArray($input);
				$emip->emip_event_id = $event_id;
				$emip->emip_cmp_id = $this->company_specific;
				$emip->save();
				$emip_id = $emip->emip_id;
				//Inserting geographies
				if(is_array($input['eg_geo_id'])){
					 foreach($input['eg_geo_id'] as $key=>$val){
						if($val >0){
							$eg = new   Med_Model_EventGeographies();
							$eg->eg_emip_id =    $emip_id;
							$eg->eg_geo_id = $val;
							$eg->save();
						}
					 }
				 }
			}
			if($_POST['submit_save_addnew']!=''){
				$this->_redirect('/admin/event/add?msg=new');
			}
			if($_POST['submit_save']!=''){
			   $this->_helper->getHelper('FlashMessenger')->addMessage("Event is added successfully!");
			   if($request->getParam('prop')=="yes"){
			      $this->_redirect('admin/event/proprietaryeventlist');
			   }else{
			      $this->_redirect('admin/event/globaleventlist');
			   }
			}
			 
		  }
		  else{
		    //echo "ERROR <pre>";print_r($_POST);  
		  }
	   }


	   echo '<script language="javascript">state_value= "'.$_POST['event_state_id'].'";AutoFillStates(document.getElementById("event_country_id").value);</script>';

	}
	  public function editAction(){
	  $request = $this->getRequest(); 
	  /* If this is open in non-company-specific mode, then let us open it in public mode */
	  if(!$this->company_specific){
	        $form = new Med_Form_globalevent();
            $form->set_company_specific($this->company_specific);
	        $form->start_form();
			$form->removeElement('submit_save_addnew');
	        $this->view->form = $form;
	   }
	   else{ /* If this is open in company-specific mode, then let us open it in private mode */
	       $form = new Med_Form_event();
           $form->set_company_specific($this->company_specific);
	       $form->start_form();
		   $form->removeElement('submit_save_addnew');
	       $this->view->form = $form;
	   }
	    if ($this->getRequest()->isPost()) {
          //if POST request
          //test if input is valid
          //retrieve current record
          //update values and replace in database
          $postData = $this->getRequest()->getPost();
		   $form->event_start_date->setRequired(true);
		   $form->event_end_date->setRequired(true);

		if ($form->isValid($postData)) {
		    $input = $form->getValues();
            $event_id = $request->getParam('event_id');
			//Before updating more information, lets us delete old settings of many multiple dropdowns
			$event = Doctrine::getTable('Med_Model_Events')
                    ->find($event_id);
			$event->fromArray($input);
			 if(is_array($input['event_person_virtual'])){
			    $event->event_person_virtual = implode(",",$input['event_person_virtual']);
			 }else{
			    $event->event_person_virtual='';
			 }
			 if($input['event_status'] == '') $event->event_status = 'Unpublish';
             $event->save();
			 //Deleting old event format settings
			 $old_ef= Doctrine_Query::create()
					->delete('Med_Model_EventFormats old_ef')
                    ->whereIn('old_ef.ef_event_id',$event_id);
             $old_ef->execute();
			 //inserting event format
			 if(is_array($input['ef_format_id'])){
			     foreach($input['ef_format_id'] as $key=>$val){
				    if($val>0){
					   $ef= new Med_Model_EventFormats();
					   $ef->ef_format_id = $val;
					   $ef->ef_event_id  = $event_id;
					   $ef->save();
					}
				 }
			 }

			 //Deleting old industries settings
			 $old_ei= Doctrine_Query::create()
					->delete('Med_Model_EventIndustries old_ei')
                    ->whereIn('old_ei.ei_event_id',$event_id);
             $old_ei->execute();
			 //inserting industries
			 if(is_array($input['ei_industry'])){
			     foreach($input['ei_industry'] as $key=>$val){
				    if($val>0){
					   $ei= new Med_Model_EventIndustries();
					   $ei->ei_industry = $val;
					   $ei->ei_event_id  = $event_id;
					   $ei->save();
					}
				 }
			 }
			 //Deleting old company sizes setting
			 $old_ecs= Doctrine_Query::create()
					->delete('Med_Model_EventCompanySizes ecs')
                    ->whereIn('ecs.ecs_event_id',$event_id);
             $old_ecs->execute();

			 //Inserting company sizes
			 if(is_array($input['ecs_company_sizes'])){
			     foreach($input['ecs_company_sizes'] as $key=>$val){
				    if($val >0){
					    $ecs = new   Med_Model_EventCompanySizes();
					   	$ecs->ecs_event_id =    $event_id;
						$ecs->ecs_company_sizes = $val;
						$ecs->save();
					}
				 }
			 }
		   //Deleting old top sponsors settings
		  $old_sc= Doctrine_Query::create()
					->delete('Med_Model_SponsorCompanies sc')
                    ->whereIn('sc.sc_event_id',$event_id);
             $old_sc->execute();

			 //Insertinng top sponsors
		   if(is_array($input['sc_company'])){
			     foreach($input['sc_company'] as $key=>$val){
				    if($val >0){
					    $sc = new   Med_Model_SponsorCompanies();
					   	$sc->sc_event_id =    $event_id;
						$sc->sc_company = $val;
						$sc->save();
					}
				 }
			 }
			if($this->company_specific > 0){ 
			    //If this is for company specific
               	//  updating private data now
			    $emip = Doctrine::getTable('Med_Model_EventsMoreInfoPrivate')
                      ->findOneByemip_event_idAndemip_cmp_id($event_id,$this->company_specific);
				$emip_id = $emip->emip_id;
				if($emip_id>0) { //Means private data exists for this already, lets update
				$emip->fromArray($input);
				$emip->emip_event_id = $event_id;
				$emip->emip_cmp_id = $this->company_specific;
				$emip->save();
				}else{
				   //private data not exists till yet , lets insert
				   $emip = new Med_Model_EventsMoreInfoPrivate();
				   $emip->fromArray($input);
				   $emip->emip_event_id = $event_id;
				   $emip->emip_cmp_id = $this->company_specific;
				   $emip->save();
				   $emip_id = $emip->emip_id;

				}
				 //Deleting old geographies settings
		         $old_eg= Doctrine_Query::create()
					->delete('Med_Model_EventGeographies eg')
                    ->whereIn('eg.eg_emip_id',$emip_id);
                  $old_eg->execute();
				 //Inserting geographies
				if(is_array($input['eg_geo_id'])){
					 foreach($input['eg_geo_id'] as $key=>$val){
						if($val >0){
							$eg = new   Med_Model_EventGeographies();
							$eg->eg_emip_id =    $emip_id;
							$eg->eg_geo_id = $val;
							$eg->save();
						}
					 }
				 }
			}
			if($_POST['submit_save']!=''){
			   $this->_helper->getHelper('FlashMessenger')->addMessage("Event is updated successfully!");
			   if($request->getParam('prop')=="yes"){
			      $this->_redirect('admin/event/proprietaryeventlist');
			   }else{
			      $this->_redirect('admin/event/globaleventlist');
			   }

			}
			
			
			
			//           ----------------                        //
			//Storing Display settings for this horse [Open & Close Eyes Icons]
			$this->_helper->getHelper('FlashMessenger')->addMessage("Event information is updated successfully!");
		    $this->_redirect('admin/event/globaleventlist');
	    }
		   $input = $form->getValues();
		   $event_id = $input['event_id'];
		   echo '<script language="javascript">state_value= "'.$_POST['event_state_id'].'";AutoFillStates(document.getElementById("event_country_id").value);</script>';

        }else {
        // if GET request
       // set filters and validators for GET input
       // test if input is valid
       // retrieve requested record
       // pre-populate form
	   $filters = array(
		'event_id' => array('HtmlEntities', 'StripTags', 'StringTrim')
		);
        $validators = array(
		'event_id' => array('NotEmpty', 'Int')
		);
    $input = new Zend_Filter_Input($filters, $validators);
    $input->setData($this->getRequest()->getParams());
	if ($input->isValid()) {
        $q = Doctrine_Query::create()
		->from('Med_Model_Events e')
 		->where('e.event_id = ?', $input->event_id);
		$result = $q->fetchArray();
		if (count($result) == 1) {

		if ($this->_helper->getHelper('FlashMessenger')->getMessages()) {
	        $this->view->messages = $this->_helper->getHelper('FlashMessenger')->getMessages();
        }
		if($result[0]['event_person_virtual'] !=''){
		   $arr_person_virtual = explode(",",$result[0]['event_person_virtual']);  
		}else{
		   $arr_person_virtual = array();
		}
		$result[0]['event_start_date'] = $this->pre_format_date(str_replace(" 00:00:00","",$result[0]['event_start_date']));
		$result[0]['event_end_date'] = $this->pre_format_date(str_replace(" 00:00:00","",$result[0]['event_end_date']));
		$result[0]['event_exh_start_date'] = $this->pre_format_date($result[0]['event_exh_start_date']);
		$result[0]['event_exh_end_date'] = $this->pre_format_date($result[0]['event_exh_end_date']);
		$result[0]['event_paper_open_date'] = $this->pre_format_date($result[0]['event_paper_open_date']);
		$result[0]['event_paper_deadline_date'] = $this->pre_format_date($result[0]['event_paper_deadline_date']);
		/* Fetching event formats  */
		$q = Doctrine_Query::create()
		->from('Med_Model_EventFormats ef')
 		->where('ef.ef_event_id = ?', $input->event_id);
		$result_ef = $q->fetchArray();
		$arr_ef  = array();
		if(count($result_ef)>0){
		   foreach($result_ef as $key => $val){
		      $arr_ef[] = $val['ef_format_id'];
		   }
		}

		/* Fetching company sizes  */
		$q = Doctrine_Query::create()
		->from('Med_Model_EventCompanySizes ecs')
 		->where('ecs.ecs_event_id = ?', $input->event_id);
		$result_ecs = $q->fetchArray();
		$arr_ecs  = array();
		if(count($result_ecs)>0){
		   foreach($result_ecs as $key => $val){
		      $arr_ecs[] = $val['ecs_company_sizes'];
		   }
		}
		/* Fetching industry  */
		$q = Doctrine_Query::create()
		->from('Med_Model_EventIndustries ei')
 		->where('ei.ei_event_id = ?', $input->event_id);
		$result_ei = $q->fetchArray();
		$arr_ei  = array();
		if(count($result_ei)>0){
		   foreach($result_ei as $key => $val){
		      $arr_ei[] = $val['ei_industry'];
		   }
		}
		/* Fetching top sponsors */
		$q = Doctrine_Query::create()
		->from('Med_Model_SponsorCompanies sc')
 		->where('sc.sc_event_id = ?', $input->event_id);
		$result_sc = $q->fetchArray();
		$arr_sc  = array();
		if(count($result_sc)>0){
		   foreach($result_sc as $key => $val){
		      $arr_sc[] = $val['sc_company'];
		   }
		}
		$result[0]['event_person_virtual'] = $arr_person_virtual;
		$result[0]['ecs_company_sizes']  = $arr_ecs;
		$result[0]['ei_industry']  =  $arr_ei;
		$result[0]['sc_company']  =   $arr_sc;
		$result[0]['ef_format_id'] =  $arr_ef;
		
        //  -----------------------------   //
		//echo "<pre>";
		$finalresult= $result[0];
		if($this->company_specific){
		//Fetching private data too
		$q = Doctrine_Query::create()
		->from('Med_Model_EventsMoreInfoPrivate emip')
 		->where('emip.emip_event_id = ?', $input->event_id)
		->addWhere('emip.emip_cmp_id = ?',$this->company_specific);
		$result_emip = $q->fetchArray();
		if (count($result_emip) == 1) {
		    /* Fetching geographies  */
		    $q = Doctrine_Query::create()
		     ->from('Med_Model_EventGeographies eg')
 		     ->where('eg.eg_emip_id = ?', $result_emip[0]['emip_id']);
		    $result_geo = $q->fetchArray();
		    $arr_geo  = array();
		   if(count($result_geo)>0){
		    foreach($result_geo as $key => $val){
		      $arr_geo[] = $val['eg_geo_id'];
		   }
		   
		  }
		   $result_emip[0]['eg_geo_id']= $arr_geo;
		   $finalresult = array_merge($finalresult,$result_emip[0]);
		   
		}

		}
		$this->view->form->populate($finalresult);
		$event_id = $input->event_id;
		} else {                                                            
				  $this->_helper->getHelper('FlashMessenger')
		          ->addMessage($this->localConfig->message->access_denied);
		          $this->_redirect('/default/user/failure');
		}
		} else {
				 $this->_helper->getHelper('FlashMessenger')
		          ->addMessage($this->localConfig->message->access_denied);
		          $this->_redirect('/default/user/failure');

		}
	  echo '<script language="javascript">state_value= "'.$finalresult['event_state_id'].'";AutoFillStates(document.getElementById("event_country_id").value);</script>';

	}
	}
 	public function addoptionsAction()
    {
	    $request = $this->getRequest();
		$this->_helper->layout->disableLayout();
        $this->getHelper('viewRenderer')->setNoRender(true);
	    if($this->getRequest()->isXmlHttpRequest()) {
        $value = $request->getParam('value');
		$type = $request->getParam('type');
        //Checking if aleady exists
		$pff = Doctrine_Query::create()
			 ->from('Med_Model_PopulateFields p')
			 ->where('p.pf_type= ?',    $type)
			 ->addWhere('p.pf_name= ?', $value);
		if($this->company_specific >0 ){
		    $pff->andWhere('(p.pf_cmp_id= ?','0');
			$pff->orWhere('p.pf_cmp_id= ?)',$this->company_specific);
			
		}else{
		    $pff->andWhere('p.pf_cmp_id= ?','0');
		}
		$resultp = $pff->fetchArray();
		if(count($resultp)>0)
		{
		  echo "ERROR";
		  return;
		}	
		// -----------       ----------  //
		$pff = new Med_Model_PopulateFields();
		if($this->company_specific > 0){
		    $pff->pf_cmp_id = $this->company_specific;

		}
		$pff->pf_type = $type;
		$pff->pf_name = $value;
		$pff->pf_order = 100;
		$pff->save();
		echo $pff->pf_id;
       }
    }//
	public function addindustryAction()
    {
	    $request = $this->getRequest();
		$this->_helper->layout->disableLayout();
        $this->getHelper('viewRenderer')->setNoRender(true);
	    if($this->getRequest()->isXmlHttpRequest()) {
        $value = $request->getParam('value');
		//Checking if already exists
		$indus = Doctrine_Query::create()
			 ->from('Med_Model_Industries i')
			 ->where('i.ind_name= ?',$value);
		if($this->company_specific >0 ){
		    $indus->andWhere('(i.ind_cmp_id= ?','0');
			$indus->orWhere('i.ind_cmp_id= ?)',$this->company_specific);
			
		}else{
		    $indus->andWhere('i.ind_cmp_id= ?','0');
		}
		$resultp = $indus->fetchArray();
		if(count($resultp)>0)
		{
		  echo "ERROR";
		  return;
		}			 
        $ind = new Med_Model_Industries();
		if($this->company_specific > 0){
		    $ind->ind_cmp_id = $this->company_specific;
		}
		$ind->ind_name = $value;
		$ind->save();
		echo $ind->ind_id;
       }
    }
	public function addsponsorAction()
    {
	    $request = $this->getRequest();
		$this->_helper->layout->disableLayout();
        $this->getHelper('viewRenderer')->setNoRender(true);
	    if($this->getRequest()->isXmlHttpRequest()) {
        $value = $request->getParam('value');
		//Checking if already exists
		$spons = Doctrine_Query::create()
			 ->from('Med_Model_Sponsors s')
			 ->where('s.spn_name= ?',$value);
		if($this->company_specific >0 ){
		    $spons->andWhere('(s.spn_cmp_id= ?','0');
			$spons->orWhere('s.spn_cmp_id= ?)',$this->company_specific);
			
		}else{
		    $spons->andWhere('s.spn_cmp_id= ?','0');
		}
		$resultp = $spons->fetchArray();
		if(count($resultp)>0)
		{
		  echo "ERROR";
		  return;
		}			 
        $spons = new Med_Model_Sponsors();
		if($this->company_specific > 0){
		    $spons->spn_cmp_id = $this->company_specific;
		}
		$spons->spn_name = $value;
		$spons->save();
		echo $spons->spn_id;
       }
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
  
  public function delAction(){
        $request = $this->getRequest();
	    $event_id = $request->getParam('event_id');
        if(!$event_id) return;
		$session = new Zend_Session_Namespace('Med.auth');
		if($session->user_type == "user"  )  return; //For now, Only super user can delete an event.
		$del_ef= Doctrine_Query::create()
					->delete('Med_Model_EventFormats del_ef')
                    ->whereIn('del_ef.ef_event_id',$event_id);
        $del_ef->execute();
             
        $del_ei= Doctrine_Query::create()
					->delete('Med_Model_EventIndustries del_ei')
                    ->whereIn('del_ei.ei_event_id',$event_id);
        $del_ei->execute();
             
		$del_ecs= Doctrine_Query::create()
			 		->delete('Med_Model_EventCompanySizes ecs')
                    ->whereIn('ecs.ecs_event_id',$event_id);
        $del_ecs->execute();

		$del_sc= Doctrine_Query::create()
					->delete('Med_Model_SponsorCompanies sc')
                    ->whereIn('sc.sc_event_id',$event_id);
        $del_sc->execute();
		
		$del_ev= Doctrine_Query::create()
					->delete('Med_Model_Events e')
                    ->whereIn('e.event_id',$event_id);
        $del_ev->execute();
		
			    if($this->company_specific >0){
					//If this is for company specific
					//  updating private data now
					 $emip = Doctrine::getTable('Med_Model_EventsMoreInfoPrivate')
						  ->findOneByemip_event_idAndemip_cmp_id($event_id,$this->company_specific);
					 $emip_id =  $emip->emip_id;
					 if($emip_id){
					 //Deleting old geographies settings
					  $del_eg= Doctrine_Query::create()
						->delete('Med_Model_EventGeographies eg')
						->whereIn('eg.eg_emip_id',$emip_id);
					  $del_eg->execute();
					  
					  $del_emip= Doctrine_Query::create()
						->delete('Med_Model_EventsMoreInfoPrivate emip')
						->whereIn('emip.emip_id',$emip_id);
					   $del_emip->execute();
					 }
				 }

		$this->_helper->getHelper('FlashMessenger')->addMessage("Event is deleted successfully!");
			   if($request->getParam('prop')=="yes"){
			      $this->_redirect('/admin/event/globaleventlist');
			   }else{
			      $this->_redirect($_SERVER['HTTP_REFERER']);
			   }
	
		  }
	// Global Event List 
  public function globaleventlistAction() {
	 
	 $session = new Zend_Session_Namespace('Med.auth');
	// check if super user or super admin does not select comany
	if(isset($_POST['Event']) && $_POST['client']=="")
    {
		$this->_redirect('/admin');
		}
	 
    if(isset($_POST['client']))
    {
	
	$session->comp_id = $_POST['client'];
	 } 
   if($this->_request->getParam('G')=="yes")
   {
	   $session->comp_id ="";
	   }
   // call clients list
   $clients = new Med_Plugin_Find();
   $clients_result = $clients->find();
   $eventname = "";
   // create option for clients
  $option .="<option value='0'  selected=selected >Public Events</option>";
   foreach($clients_result as $r)
   {
	if($r['cmp_id']==$session->comp_id)
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
   $orderby = "";
	
	if(isset($_GET['order']) && isset($_GET['field']))
	
	{
	
	$orderby .= 'e.'.$_GET['field']."  ". $_GET['order'] . "";
			
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
	if($getValue['event_name']!="Event Name")
	
	{
	
	$eventname = trim($getValue['event_name']);		
	}
	if($getValue['country']!="")
	
	{
	
	$countryname = trim($getValue['country']);		
	}
	if($getValue['status']!="")
	
	{
	
	$status = trim($getValue['status']);		
	}
	if($getValue['datepicker']!="" && $getValue['datepicker']!="From")
	
	{
	
	$from = trim($getValue['datepicker']);		
	}
	if($getValue['datepicker2']!="" && $getValue['datepicker2']!="To")
	
	{
	
	$to = trim($getValue['datepicker2']);		
	}
	}
   // Query for events
   $event_query = Doctrine_Query::create()
                  ->from('Med_Model_Events e')
				  ->where('e.event_cmp_id = ?',0);
	if($session->comp_id >0)
	{			  
				 $event_query->addwhere('e.event_status = ?','Publish');
	}
    if($eventname !="")
   {
	   $event_query->addwhere('e.event_name LIKE ?','%'.$eventname.'%');
	   }
   if($countryname !="")
   {
	   $event_query->addwhere('e.event_country_id = ?',$countryname);
	   }
   // check if status is Publish or Unpublish
   if($status != "" && ($status =="Publish" || $status =="Unpublish"))
   {
	   $event_query->addwhere('e.event_status = ?',$status);
	   }
   // check if status is Considering or Contracted
   if($status != "" && ($status =="Considering" || $status =="Contracted"))
   {
	  $event_query->leftjoin('e.Med_Model_EventsMoreInfoPrivate p ON (e.event_id = p.emip_event_id )'); 
	  $event_query->addwhere('p.emp_status = ?',$status);
	   }
	if($from !="")
   {
	   
	   $event_query->addwhere('e.event_start_date >= ?', $from);
	   }  
	if($to !="")
   {
	   
	   $event_query->addwhere('e.event_end_date <= ?', $to);
	   }     	   	   
   if($orderby)
   {
	   $event_query->orderBy($orderby);
	   }
   //echo $event_query->getSqlQuery();	//exit;   				  
   $results_event = $event_query->fetchArray();
   // Paging start
   $page=$this->_getParam('page',1);
   $paginator = Zend_Paginator::factory($results_event);
   $paginator->setItemCountPerPage(10);
   $paginator->setCurrentPageNumber($page);
   $this->view->paginator=$paginator;
 
	// End Pagination	
   $this->view->option = $option;
   
  } 
 
 // Proprietary Event List 
  public function proprietaryeventlistAction() {
  $session = new Zend_Session_Namespace('Med.auth');
  $comp_id = $session->comp_id;	  
 // redirect to global event page if company id is not set	 
 
 if(!$comp_id)
 {
	$this->_redirect('/admin/event/globaleventlist');
	
	 } 
      
  
   $orderby = "";
	
	if(isset($_GET['order']) && isset($_GET['field']))
	
	{
	
	$orderby .= 'e.'.$_GET['field']."  ". $_GET['order'] . "";
			
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
	if($getValue['event_name']!="Event Name")
	
	{
	
	$eventname = trim($getValue['event_name']);		
	}
	if($getValue['country']!="")
	
	{
	
	$countryname = trim($getValue['country']);		
	}
	if($getValue['status']!="")
	
	{
	
	$status = trim($getValue['status']);		
	}
	if($getValue['datepicker']!="" && $getValue['datepicker']!="From")
	
	{
	
	$from = trim($getValue['datepicker']);		
	}
	if($getValue['datepicker2']!="" && $getValue['datepicker2']!="To")
	
	{
	
	$to = trim($getValue['datepicker2']);		
	}
	}
   // Query for events
   $event_query = Doctrine_Query::create()
                  ->from('Med_Model_Events e')
				  ->where('e.event_cmp_id = ?',$comp_id);
   if($eventname !="")
   {
	   $event_query->addwhere('e.event_name LIKE ?','%'.$eventname.'%');
	   }
   if($countryname !="")
   {
	   $event_query->addwhere('e.event_country_id = ?',$countryname);
	   }
   // check if status is Publish or Unpublish
   if($status != "" && ($status =="Publish" || $status =="Unpublish"))
   {
	   $event_query->addwhere('e.event_status = ?',$status);
	   }
   // check if status is Considering or Contracted
   if($status != "" && ($status =="Considering" || $status =="Contracted"))
   {
	  $event_query->leftjoin('e.Med_Model_EventsMoreInfoPrivate p ON (e.event_id = p.emip_event_id )'); 
	  $event_query->addwhere('p.emp_status = ?',$status);
	   }	
	if($from !="")
   {
	   
	   $event_query->addwhere('e.event_start_date >= ?', $from);
	   }  
	if($to !="")
   {
	   
	   $event_query->addwhere('e.event_end_date <= ?', $to);
	   }         	    				 
   if($orderby)
   {
	   $event_query->orderBy($orderby);
	   }
  // echo $event_query->getSqlQuery();	   				  
   $results_event = $event_query->fetchArray();
   // Paging start
   $page=$this->_getParam('page',1);
   $paginator = Zend_Paginator::factory($results_event);
   $paginator->setItemCountPerPage(10);
   $paginator->setCurrentPageNumber($page);
   $this->view->paginator=$paginator;
 
	// End Pagination	
      
  } 

 
  // Publish Global Events
	public function publishglobaleventAction(){
      $session = new Zend_Session_Namespace('Med.auth');
	  if (isset($_POST['status'])) {
		 $countCheck = count($_POST['checkbox']);
         if($countCheck<1)
		 {
			$this->_helper->getHelper('FlashMessenger')
		          ->addMessage('Please select at least one check box');
		          $this->_redirect('/admin/event/globaleventlist'); 
			 }
		 $checkbox = $_POST['checkbox']; 
		 if($session->comp_id > 0 && $_POST['status']!="Publish" && $_POST['status']!="Unpublish")
		 { 
		 
		 foreach($_POST['checkbox'] as $r_id)
		 {
			$event_query = Doctrine_Query::create()
                  ->from('Med_Model_EventsMoreInfoPrivate e')
				  ->where('e.emip_event_id = ?',$r_id)
				  ->addwhere('e.emip_cmp_id = ?',$session->comp_id);
			$results_event = $event_query->fetchArray();
			if(count($results_event) >0)
			{	  
			$update = Doctrine_Query::create()
                ->update('Med_Model_EventsMoreInfoPrivate e')
                ->set('e.emp_status', '?',$_POST['status'])
                ->where('e.emip_event_id = ?',$r_id)
				->addwhere('e.emip_cmp_id = ?',$session->comp_id);
             $update->execute();
			}
			else
			{
				$event_private=new Med_Model_EventsMoreInfoPrivate();
				$event_private->emip_event_id = $r_id;
				$event_private->emip_cmp_id = $session->comp_id;
				$event_private->emp_status = $_POST['status'];
				$event_private->save();
				}
		 }
		 }
		 else
		 {
			
			$update1 = Doctrine_Query::create()
                ->update('Med_Model_Events e')
                ->set('e.event_status', '?',$_POST['status'])
                ->whereIn('e.event_id ',$_POST['checkbox']);
             $update1->execute();
		 }
			  $this->_helper->getHelper('FlashMessenger')
		          ->addMessage('Updated succesfully!');
		          $this->_redirect($_SERVER['HTTP_REFERER']);		
					
		} else {                                                            
				  $this->_helper->getHelper('FlashMessenger')
		          ->addMessage('Access Denied');
		          $this->_redirect('/admin/event/globaleventlist');
		}
		
	}
 
 
 public function viewAction()
	{
	  
	    $request = $this->getRequest();
        $event_id = $request->getParam('eventid');
		$this->view->prop = $request->getParam('prop');
		//$event_id = $_GET['event_id'];
		$emip_id = $request->getParam('emipid');
		$event_public_info = array();
		$event_private_info = array();
		$session = new Zend_Session_Namespace('Med.auth');
		$e = Doctrine_Query::create()
          ->from('Med_Model_Events e')
          ->where('e.event_id= ?',$event_id);
	  $result_e =$e->fetchArray();
	  
	  // query for private array
	  $e_private = Doctrine_Query::create()
          ->from('Med_Model_EventsMoreInfoPrivate e')
          ->where('e.emip_event_id= ?',$event_id)
		  ->addwhere('e.emip_cmp_id= ?',$session->comp_id);
	  $result_eprivate =$e_private->fetchArray();
	  $emp_id = $result_e[0]['emip_id'];
	  // initiate find class
		 $find = new Med_Plugin_Find();
	  if(is_array($result_e[0])){
		 $event_public_info['event_id']=     $result_e[0]['event_id']; 
		 $event_public_info['event_name']=     $result_e[0]['event_name'];
		 $event_public_info['event_producer']= $result_e[0]['event_producer'];
		 $event_public_info['person_virtual']= $result_e[0]['event_person_virtual'];
		 $event_public_info['start_date']=     $result_e[0]['event_start_date'];
		 $event_public_info['end_date']=       $result_e[0]['event_end_date'];
		 $event_public_info['exhibit_start_date']= $result_e[0]['event_exh_start_date'];
		 $event_public_info['exhibit_end_date']= $result_e[0]['event_exh_end_date'];
		 $event_public_info['event_url']=        $result_e[0]['event_url'];
		 $event_public_info['colocated_url']= $result_e[0]['event_co_located_event'];
		 $event_public_info['venue']= $result_e[0]['event_venue'];
		 $event_public_info['city']= $result_e[0]['event_city'];
		 // find state name
		 $event_public_info['state'] = $find->findstate($result_e[0]['event_state_id']);
		 // find country name
		 $event_public_info['country']= $find->findcountry($result_e[0]['event_country_id']);
		 // find region name
		 $event_public_info['region']= $find->findpfname($result_e[0]['event_region'],'EVENT_REGION');
		 $event_public_info['focus']= $result_e[0]['event_focus'];
		 $event_public_info['frequency']= $find->findpfname($result_e[0]['event_frequency'],'EVENT_FREQUENCY');
		 // format
		 $formatlist = $find->findformat($event_id);
		 foreach($formatlist as $r)
		 {
			 $formatname .=$find->findpfname($r['ef_format_id'],'EVENT_FORMAT')."\n";
			 }
		 //remove , from string
		 $formatstr = substr($formatname, 0, strlen($formatname)-1);
		 $event_public_info['format']= $formatstr;
		 $event_public_info['event_attendee']= $result_e[0]['event_number_attendees'];
		 // industry
		 $industrylist = $find->findindusry($event_id);
		 foreach($industrylist as $r)
		 {
			 $industryname .=$find->findindustryname($r['ei_industry'])."\n";
			 }
		 //remove , from string
		 $industrystr = substr($industryname, 0, strlen($industryname)-1);
		 $event_public_info['indusries']= $industrystr;
		 $event_public_info['event_audience_profile']= $result_e[0]['event_audience_profile'];
		 
		 $event_public_info['event_audience_type']= $find->findpfname($result_e[0]['event_audience_type'],'AUDIENCE_TYPE');
		 $event_public_info['event_audience_title']= $find->findpfname($result_e[0]['event_audience_title'],'AUDIENCE_TITLE');
		  // company size
		 $sizelist = $find->findcompanysize($event_id);
		 foreach($sizelist as $r)
		 {
			 $sizename .=$find->findpfname($r['ecs_company_sizes'],'COMPANY_SIZE').',';
			 }
		 //remove , from string
		 $sizestr = substr($sizename, 0, strlen($sizename)-1);
		 $event_public_info['event_company_size']= $sizestr;
		 $event_public_info['event_analyst_attendees_number']= $result_e[0]['event_analyst_attendees_number'];
		 $event_public_info['event_analyst_profile']= $result_e[0]['event_analyst_profile'];
		 $event_public_info['event_sponsor_to_speak']= $result_e[0]['event_sponsor_to_speak'];
		 $event_public_info['event_paper_open_date']= $result_e[0]['event_paper_open_date'];
		 $event_public_info['event_paper_deadline_date']= $result_e[0]['event_paper_deadline_date'];
		 $days_remaining = "";
		 $today = strtotime(date('Y-m-d'));
		 $start = strtotime($event_public_info['event_paper_open_date']);
		 $end = strtotime($event_public_info['event_paper_deadline_date']);
		 // check for not yet open
		 
		 if($start > $today)
		 {
			 $days_remaining = "Not Yet Open";
			 }
		 // check for closed
		 else if($end < $today && $end > 0)
		 {
			 $days_remaining = "Closed";
			 }
		else {	 	
		  if($start >0 && $end > 0)
		  { 
		 // check for remain days
		 $diff = $end - $start;
 		 $days_remaining = round($diff / 86400);
		  }
		  else
		  {
			  $days_remaining = "";
			  }
		  }
		 $event_public_info['days_remaining']= $days_remaining;
		 $event_public_info['event_prj_total_sponsors']= $result_e[0]['event_prj_total_sponsors'];
		 $event_public_info['event_sponsorship_cost']= $result_e[0]['event_sponsorship_cost'];
		  //sponsor
		 $sponsorlist = $find->findsponsor($event_id);
		 foreach($sponsorlist as $r)
		 {
			 $sponsorname .=$find->findsponsorname($r['sc_company'])."\n";
			 }
		 //remove , from string
		 $sponsorstr = substr($sponsorname, 0, strlen($sponsorname)-1);
		 $event_public_info['event_sponsor']= $sponsorstr;
		 $event_public_info['event_tracks_sessions']= $result_e[0]['event_tracks_sessions'];
		 $event_public_info['event_keynote_speakers']= $result_e[0]['event_keynote_speakers'];
		 $event_public_info['event_other_speakers']= $result_e[0]['event_other_speakers'];
		
	  }
	  
	  //private
	  if(is_array($result_eprivate[0])){
		 $event_private_info['emip_id']= $result_eprivate[0]['emip_id']; 
		 $event_private_info['emip_emp_contact_name']= $result_eprivate[0]['emip_emp_contact_name'];
		 $event_private_info['emip_emp_title']= $result_eprivate[0]['emip_emp_title'];
		 $event_private_info['emip_emp_buss_unit']= $find->findpfname($result_eprivate[0]['emip_emp_buss_unit'],'BUSINESS_UNIT');
		 $event_private_info['emip_emp_email']= $result_eprivate[0]['emip_emp_email'];
		 $event_private_info['emip_emp_phone']= $result_eprivate[0]['emip_emp_phone'];
		 $event_private_info['emip_event_type']= $find->findpfname($result_eprivate[0]['emip_event_type'],'EVENT_TYPE');
		 $event_private_info['emip_event_tier']= $result_eprivate[0]['emip_event_tier'];
		 $event_private_info['emip_primary_event_objective']= $find->findpfname($result_eprivate[0]['emip_primary_event_objective'],'PRIMARY_EVENT_OBJECTIVE');
		 $event_private_info['emip_campaign_alignment']= $find->findpfname($result_eprivate[0]['emip_campaign_alignment'],'CAMPAIGN_ALIGNMENT');
		 $event_private_info['emip_customer_target']= $find->findpfname($result_eprivate[0]['emip_customer_target'],'CUSTOMER_TARGET'); 
		 //$event_private_info['emip_campaign_alignment']= $result_eprivate[0]['emip_campaign_alignment'];
		 $event_private_info['emip_sector_industries']= $find->findpfname($result_eprivate[0]['emip_sector_industries'],'SECTOR_INDUSTRY');
		 
		 $event_private_info['emip_contracted']= $result_eprivate[0]['emip_contracted'];
		 $event_private_info['emip_sponsorship_level_cost']= $result_eprivate[0]['emip_sponsorship_level_cost'];
		 $event_private_info['emip_proposed_booth_space']= $result_eprivate[0]['emip_proposed_booth_space'];
		 $event_private_info['emip_branding_opportunities']= $result_eprivate[0]['emip_branding_opportunities'];
		 $event_private_info['emip_speaking_opportunities']= $result_eprivate[0]['emip_speaking_opportunities'];
		 $event_private_info['emip_client_speaker']= $result_eprivate[0]['emip_client_speaker'];
		 $event_private_info['emip_key_message']= $result_eprivate[0]['emip_key_message'];
		 $event_private_info['emip_demo_plan']= $result_eprivate[0]['emip_demo_plan'];
		 $event_private_info['emip_partner_participation']= $result_eprivate[0]['emip_partner_participation'];
		 $event_private_info['emp_status']= $result_eprivate[0]['emp_status'];
		 
		 $event_private_info['emip_booth_space']= $result_eprivate[0]['emip_booth_space'];
		 $event_private_info['emip_sponsorships']= $result_eprivate[0]['emip_sponsorships'];
		 $event_private_info['emip_marketing_opportunities']= $result_eprivate[0]['emip_marketing_opportunities'];
		 $event_private_info['emip_venue_costs']= $result_eprivate[0]['emip_venue_costs'];
		 $event_private_info['emip_production']= $result_eprivate[0]['emip_production'];
		 $event_private_info['emip_housing_transportation_air']= $result_eprivate[0]['emip_housing_transportation_air'];
		 $event_private_info['emip_food_beverage']= $result_eprivate[0]['emip_food_beverage'];
		 $event_private_info['emip_external_speakers']= $result_eprivate[0]['emip_external_speakers'];
		 $event_private_info['emip_experience_design_costs']= $result_eprivate[0]['emip_experience_design_costs'];
		 $event_private_info['emip_audience_generation_costs']= $result_eprivate[0]['emip_audience_generation_costs'];
		 $event_private_info['emip_collateral_costs']= $result_eprivate[0]['emip_collateral_costs'];
		 $tot = ($event_private_info['emip_booth_space']+$event_private_info['emip_sponsorships']+$event_private_info['emip_marketing_opportunities']+$event_private_info['emip_venue_costs']+$event_private_info['emip_production']+$event_private_info['emip_housing_transportation_air']+$event_private_info['emip_food_beverage']+$event_private_info['emip_external_speakers']+$event_private_info['emip_experience_design_costs']+$event_private_info['emip_audience_generation_costs']+$event_private_info['emip_collateral_costs']);
		 $event_private_info['total_costs'] =number_format($tot,2);
		 
		 $event_private_info['emf_number_of_leads']= $result_eprivate[0]['emf_number_of_leads'];
		 $event_private_info['emf_number_of_staff']= $result_eprivate[0]['emf_number_of_staff'];
		 if($event_private_info['total_costs']>0)
		 {
		 $event_private_info['emf_cost_per_lead']=number_format(($tot)/($event_private_info['emf_number_of_leads']),2);
		 $event_private_info['emf_cost_per_attendee']=number_format(($tot)/($event_public_info['event_attendee']),2);
		 $event_private_info['emf_cost_per_event_staff']=number_format(($tot)/($event_private_info['emf_number_of_staff']),2);
		 }
		 else
		 {
		 $event_private_info['emf_cost_per_lead']= 0;
		 $event_private_info['emf_cost_per_attendee']= 0;
		 $event_private_info['emf_cost_per_event_staff']=0;
 
			 }
		 //geography
		 $geographylist = $find->fingeography($result_eprivate[0]['emip_id']);
		 foreach($geographylist as $r)
		 {
			 $geographyname .=$find->findpfname($r['eg_geo_id'],'GEOGRAPHIES')."\n";
			 }
		 //remove , from string
		 $geographystr = substr($geographyname, 0, strlen($geographyname)-1);
		 $event_private_info['emp_geography']= $geographystr;
	  }
        $this->view->publicinfo = $event_public_info;
		$this->view->privateinfo = $event_private_info;
		//print_r($this->view->privateinfo);
	}


 
  
 }