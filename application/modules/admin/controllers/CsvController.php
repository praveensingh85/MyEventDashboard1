<?php
 set_time_limit(500);
class Admin_CsvController extends Zend_Controller_Action {
 public $arr_new_indus = array();
 public $arr_new_spons = array();
 public $arr_new_popu = array();
 public function init() {
      if($this->_helper->getHelper('FlashMessenger')->getMessages() !='')
	  {
		
	  $this->view->message = $this->_helper->getHelper('FlashMessenger')->getMessages();
	  }
      $current_id=Zend_Auth::getInstance()->getIdentity();
	  $session = new Zend_Session_Namespace('Med.auth');
	  if($session->user_type !="super_user"){
	      $this->_redirect("/");
	  }
 }
   public function preDispatch()
    {
    }
   public function uploadAction()
   {
   $count=0;
   $form = new Med_Form_csv();
   $this->view->form = $form;
   if ($this->getRequest()->isPost()) {
   $postData = $this->getRequest()->getPost();
   if ($form->isValid($postData)) {
   $statement = Doctrine_Manager::getInstance()->connection();
   $file = fopen($_FILES['csv']['tmp_name'],"r");
		echo "<pre>";
		$arr_error = array();
		$i=0;
		while(!feof($file))
		  {
			  $i++;
			  $addrow = "yes";
			  $ar=fgetcsv($file,7000,",");
              if($i==1) continue;
			  if(trim($ar[0])=="") break;
			  //Start date
			  $ar[4]= trim($ar[4]);
			  if($ar[4]!=''){
			      $date = explode("/",$ar[4]);
				  $ar[4] = date("Y-m-d",mktime(0,0,0,$date[0],$date[1],$date[2]));
			  }else{
			    $addrow = "no";
			  }
			  //End date
			  $ar[5]= trim($ar[5]);
			  if($ar[5]!=''){
			      $date = explode("/",$ar[5]);
				  $ar[5] = date("Y-m-d",mktime(0,0,0,$date[0],$date[1],$date[2]));
			  }else{
			    $addrow = "no";
			  }

			  //Fetching country ID
			  $sql_country ="SELECT id from countries where country_name ='".addslashes(trim($ar[9]))."'";
			  $row_country = $statement->execute($sql_country);
			  $res_country = $row_country->fetchAll();
			  if(count($res_country)==1){
			     $ar[9] = $res_country[0]['id'];
				 //Fetching State
				 $sql_state = "select st_id from states where st_country_id='".$ar[9]."' and st_name='".addslashes(trim($ar[8]))."'";
				 $row_state = $statement->execute($sql_state);
				 $res_state = $row_state->fetchAll();
				 if(count($res_state)==1){
				    $ar[8] = $res_state[0]['st_id'];
				 }
				 else if(trim($ar[8])==""){
				    $ar[8] = '0';
				 }
				 else{
				 $addrow = "no";
				 $arr_error[$i][]= "State Not Exists: $ar[8]";
 				 }
			  }
			  else if(trim($ar[9])==""){
			     $ar[9] ='0'; 
			  }
			  else{
			     $addrow = "no";
				 $arr_error[$i][]= "Country Not Exists: $ar[9]";
			  }
			  //Event Region
			  $ar[10] = $this->adjust_populate_fields(trim($ar[10]),'EVENT_REGION',$i);
			  //In persion virtual
			  $ar[26] = str_replace("In","",$ar[26]);
			  //Call For Paper Open
			  $ar[21]= trim($ar[21]);
			  if($ar[21]!=''){
			      $date = explode("/",$ar[21]);
				  $ar[21] = date("Y-m-d",mktime(0,0,0,$date[0],$date[1],$date[2]));
			  }else{
			     $ar[21] = '0000-00-00';
			  }
              //Call For Paper Deadline
			  $ar[22]= trim($ar[22]);
			  if($ar[22]!=''){
			      $date = explode("/",$ar[22]);
				  $ar[22] = date("Y-m-d",mktime(0,0,0,$date[0],$date[1],$date[2]));
			  }else{
			     $ar[22] = '0000-00-00';
			  }
			  // Exhibit Start Date
			  $ar[27]= trim($ar[27]);
			  if($ar[27]!=''){
			      $date = explode("/",$ar[27]);
				  $ar[27] = date("Y-m-d",mktime(0,0,0,$date[0],$date[1],$date[2]));
			  }else{
			     $ar[27] = '0000-00-00';
			  }
              //Exhibit End Date
			  $ar[28]= trim($ar[28]);
			  if($ar[28]!=''){
			      $date = explode("/",$ar[28]);
				  $ar[28] = date("Y-m-d",mktime(0,0,0,$date[0],$date[1],$date[2]));
			  }else{
			     $ar[28] = '0000-00-00';
			  }

			  //Event Frequency
			  $ar[30] = $this->adjust_populate_fields(trim($ar[30]),'EVENT_FREQUENCY',$i);
			  //Auidence Type
			  $ar[31] = $this->adjust_populate_fields(trim($ar[31]),'AUDIENCE_TYPE',$i);
			  //Auidence Title
			  $ar[33] = $this->adjust_populate_fields(trim($ar[33]),'AUDIENCE_TITLE',$i);

			  if($addrow=="yes"){
			  $sql= "insert into events (event_name,event_co_located_event,	  event_url,event_producer,event_start_date,event_end_date,event_venue,event_city,event_state_id,event_country_id,event_region,event_focus,event_tracks_sessions,event_keynote_speakers,event_other_speakers,event_number_attendees,event_audience_profile,event_analyst_attendees_number,event_analyst_profile,event_sponsor_to_speak,event_paper_open_date,event_paper_deadline_date,event_sponsorship_cost,event_person_virtual,event_exh_start_date,event_exh_end_date,event_prj_total_sponsors,event_frequency,event_audience_type,event_audience_title) values ('".addslashes(trim($ar[0]))."','".addslashes(trim($ar[1]))."','".addslashes(trim($ar[2]))."','".addslashes(trim($ar[3]))."','".addslashes($ar[4])."','".addslashes($ar[5])."','".addslashes(trim($ar[6]))."','".addslashes(trim($ar[7]))."','".addslashes($ar[8])."','".addslashes($ar[9])."','".addslashes($ar[10])."','".addslashes($ar[11])."','".addslashes($ar[12])."','".addslashes($ar[13])."','".addslashes($ar[14])."','".addslashes(trim($ar[15]))."','".addslashes($ar[16])."','".addslashes(trim($ar[18]))."','".addslashes($ar[19])."','".addslashes(trim($ar[20]))."','".addslashes($ar[21])."','".addslashes($ar[22])."','".addslashes($ar[24])."','".addslashes(trim($ar[26]))."','".addslashes($ar[27])."','".addslashes($ar[28])."','".addslashes($ar[29])."','".addslashes($ar[30])."','".addslashes($ar[31])."','".addslashes($ar[33])."');";
			 $statement->execute($sql);
			 $event_id = $statement->lastInsertId();
			  //Industries
			  if(trim($ar[17])!=''){
			    $this->adjust_industries($event_id,trim($ar[17]),$i);
			  }
			 //Top Sponsors
			 if(trim($ar[23])!=''){
			    $this->adjust_sponsors($event_id,trim($ar[23]),$i);
			  }
			 //Event Formats
			 if(trim($ar[25])!=''){
			   $this->adjust_event_formats($event_id,trim($ar[25]),$i);
			 }
			 //Event company Sizes
			 if(trim($ar[32])!=''){
			   $this->adjust_company_sizes($event_id,trim($ar[32]),$i);
			 }
               $count++;
			}
		  }
	fclose($file);
	$this->view->messagerec = "Total $count events are inserted!";
	$this->view->arr_error = $arr_error;
	$this->view->arr_new_indus  = $this->arr_new_indus;
	$this->view->arr_new_spons  = $this->arr_new_spons;
	$this->view->arr_new_popu = $this->arr_new_popu;
   }
   }
  }
   
   public function adjust_populate_fields($value,$type,$rownum)
   {      
	  if($value=='') return;
	  $statement = Doctrine_Manager::getInstance()->connection();
      $sql_pf ="SELECT pf_id from populate_fields where pf_name ='".addslashes($value)."' and pf_type = '$type'";
	  $row_pf = $statement->execute($sql_pf);
      $res_pf = $row_pf->fetchAll();
	  if(count($res_pf)==1){
	     return $res_pf[0]['pf_id'];
	  }else{
	     $this->arr_new_popu[$type][] = array($rownum => $value);
		 $sql_in ="insert into populate_fields (pf_type,pf_name,pf_order) values ('$type','".addslashes($value)."','100')";
		 $row_in = $statement->execute($sql_in);
		 return($statement->lastInsertId());
	  }

   }
   public function adjust_event_formats($event_id,$frr,$row_num){
   	  $statement = Doctrine_Manager::getInstance()->connection();
	  $frr = explode("\n",$frr);
	  foreach($frr as $val){
	     if($val=='') continue;
		 $ef_format_id = $this->adjust_populate_fields(trim($val),'EVENT_FORMAT',$row_num);
		 $sql = "insert into event_formats (ef_event_id,ef_format_id) values ('$event_id','$ef_format_id')";
		 $row =$statement->execute($sql);

	  }

   }
   public function adjust_company_sizes($event_id,$sizes,$row_num){
   	  $statement = Doctrine_Manager::getInstance()->connection();
	  $sizes = explode("\n",$sizes);
	  foreach($sizes as $val){
	     if($val=='') continue;
		 $ecs_company_sizes = $this->adjust_populate_fields(trim($val),'COMPANY_SIZE',$row_num);
		 $sql = "insert into event_company_sizes (ecs_event_id,ecs_company_sizes) values ('$event_id','$ecs_company_sizes')";
		 $row =$statement->execute($sql);

	  }

   }
   public function adjust_industries($event_id,$ind_arr,$row_num){
	  $statement = Doctrine_Manager::getInstance()->connection();
	  $ind_arr = explode("\n",$ind_arr);
	  foreach($ind_arr as $val){
						if($val=='') continue;
						$sql = "select ind_id from industries where ind_name =  '".trim(addslashes($val))."'";
						$row =$statement->execute($sql);
						$res = $row->fetchAll();
						if(count($res) ==1 ){
						   $ei_industry = $res[0]['ind_id'];
						}else{
							$this->arr_new_indus[] = array($row_num=>$val);
							$sql=  "insert into industries (ind_name) values ('".addslashes(trim($val))."')";
							$statement->execute($sql);
							$ei_industry = $statement->lastInsertId();
						}
						$sql_ins=  "insert into event_industries (ei_event_id, ei_industry) values ('$event_id','$ei_industry')  ;";
					    $statement->execute($sql_ins);

	  }
      
   }
   
   public function adjust_sponsors($event_id,$spn_arr,$row_num){
	  $statement = Doctrine_Manager::getInstance()->connection();
	  $spn_arr = explode("\n",$spn_arr);
	  foreach($spn_arr as $val){
						if(trim($val)=='') continue;
						$sql = "select spn_id from sponsors where spn_name =  '".trim(addslashes($val))."'";
						$row =$statement->execute($sql);
						$res = $row->fetchAll();
						if(count($res) ==1 ){
						   $sc_company = $res[0]['spn_id'];
						}else{
							$this->arr_new_spons[] = array($row_num=>$val);
							$sql=  "insert into sponsors (spn_name) values ('".addslashes(trim($val))."')";
							$statement->execute($sql);
							$sc_company = $statement->lastInsertId();
						}
						$sql_ins=  "insert into sponsor_companies (sc_event_id, sc_company) values ('$event_id','$sc_company')  ;";
					    $statement->execute($sql_ins);

	  }
      
   }

 }