<?php
require_once 'BaseController.php';
class EventController extends Zend_Controller_Action {
  public function init() {
      if($this->_helper->getHelper('FlashMessenger')->getMessages() !='')
	  {
		
	  $this->view->message = $this->_helper->getHelper('FlashMessenger')->getMessages();
	  }
      $current_id=Zend_Auth::getInstance()->getIdentity();
	  $activeNav = $this->view->navigation()->findByController('event');
            $activeNav->active = true;
            $activeNav->setClass("active");
    }
   public function preDispatch()
    {	
	   $this->view->render('_sidebar-search.phtml');	 
    } 
	
	
	
	public function cviewprocessAction()
		{
			//$this->_helper->layout->setLayout('master');
			$registry = Zend_Registry::getInstance();
			$session  = new Zend_Session_Namespace('Med.auth');	
			$search	= '(e.event_cmp_id  = 0 OR e.event_cmp_id  = '.$session->comp_id.')';
			
			$getValue = $this->getRequest()->getPost();
			if($this->getRequest()->isPost())  
			{
			 
				$getValue = $this->getRequest()->getPost();
				$_SESSION['getValue'] = $getValue;
				 
				
				$keysearch = '';
				if(trim($getValue['keywords'])!="") //if keywords not empty
				{
					$valArr = explode(' ', $getValue['keywords']) ;
					
					//$keyeArr array store events table field that have been use in the keyword serching.
					$keyeArr = array('event_name','event_producer','event_url','event_co_located_event','event_venue', 'event_focus','event_audience_profile','event_analyst_profile','event_tracks_sessions','event_keynote_speakers','event_other_speakers','event_status');
					
					//$keypArr array store events_more_info_private table field that have been use in the keyword serching.
					$keypArr = array('emip_emp_contact_name', 'emip_emp_title', 'emip_emp_email', 'emip_branding_opportunities', 'emip_speaking_opportunities', 'emip_client_speaker', 'emip_key_message', 'emip_demo_plan', 'emip_partner_participation');
					
					foreach($valArr as $val)
					{	
						if(trim($val) !="")
						{
							foreach($keyeArr  as $eval)
							{
								if($keysearch == "")
									 $keysearch .=" e.".$eval." like '%".$val."%'";
								else
									 $keysearch .=" OR e.".$eval." like '%".$val."%'";
							}
							
							foreach($keypArr  as $pval)
							{
								if($keysearch == "")
									 $keysearch .=" p.".$pval." like '%".$val."%'";
								else
									 $keysearch .=" OR p.".$pval." like '%".$val."%'";
							}
						}
						
					}//End foreach
									
				}//End If
				
				$nsearch = '';
				if(trim($getValue['eventname']) !="")
					$nsearch .= " AND e.event_name like '%".$getValue['eventname']."%'";
				
				if(trim($getValue['datepicker'])!="")
				$nsearch.= "AND e.event_start_date >='".$getValue['datepicker']."' AND e.event_start_date !='0000-00-00 00:00:00'";
				
				if(trim($getValue['datepicker2']) !="")
				$nsearch.= " AND e.event_end_date <='".$getValue['datepicker2']."' AND e.event_end_date !='0000-00-00 00:00:00'";
				
				if(trim($getValue['primary_objective']) !="")
					$nsearch .= " AND p.emip_primary_event_objective = '".$getValue['primary_objective']."'";
				
				if(trim($getValue['campaign_alignment']) !="")
					$nsearch .= " AND p.emip_campaign_alignment = '".$getValue['campaign_alignment']."'";
				
				if(trim($getValue['customer_target']) !="")
					$nsearch .= " AND p.emip_customer_target = '".$getValue['customer_target']."'";
				
				if(trim($getValue['business_group']) !="")
					$nsearch .= " AND p.emip_business_unit= '".$getValue['business_group']."'";
				
				if(trim($getValue['industry_sectors']) !="")
					$nsearch .= " AND p.emip_sector_industries= '".$getValue['industry_sectors']."'";
				
				if(trim($getValue['geography']) !="")
					$nsearch .= " AND g.eg_geo_id= '".$getValue['geography']."'";
				
				if(trim($getValue['event_type']) !="")
					$nsearch .= " AND p.emip_event_type= '".$getValue['event_type']."'";
				
				if(trim($getValue['EventStatus']) !="")
					$nsearch .= " AND p.emp_status= '".$getValue['EventStatus']."'";
								
				if(trim($nsearch) !="")
					$search=' (e.event_cmp_id  = 0 OR e.event_cmp_id  = '.$session->comp_id.') '.$nsearch ;
					
				if(trim($keysearch) !="")	
				{
					if(trim($nsearch)!="")
						$search=' ( e.event_cmp_id = 0 OR e.event_cmp_id='.$session->comp_id.') '.$nsearch.' AND ('.$keysearch.')';
					else
						$search=' (e.event_cmp_id  = 0 OR e.event_cmp_id ='.$session->comp_id.') AND ('.$keysearch.') ';
				}
				
				 
				if($getValue['lmonth'] !="" && $getValue['lyear'] !="")
				{
					if($getValue['lmonth'] < 10)
						$getValue['lmonth']='0'.$getValue['lmonth'];
						
					$ym = $getValue['lyear'].$getValue['lmonth'] ;
					
					$search = "( e.event_cmp_id=0 OR e.event_cmp_id='".$session->comp_id."') AND  EXTRACT(YEAR_MONTH FROM e.event_end_date)='".$ym."'" ;
					
					//echo $search ;
				} 
				 
				
			}//End if		
			
			$q  = new Doctrine_Query() ;
			$q->select('e.event_name,e.event_start_date, e.event_end_date, c.country_name, p.emp_status')
			->from('Med_Model_Events e')
			//->leftjoin('e.Med_Model_EventsMoreInfoPrivate p ON (e.event_id = p.emip_event_id)')
->leftjoin('e.Med_Model_EventsMoreInfoPrivate p ON (e.event_id = p.emip_event_id AND p.emip_cmp_id='.$session->comp_id.')') 						
			->leftjoin('p.Med_Model_EventGeographies g ON (p.emip_id = g.eg_emip_id)')
			->leftjoin('e.Med_Model_Countries c ON (e.event_country_id = c.id)')
			->where($search);
			
			$this->_result = $q->fetchArray(); 
			
			$fc = Zend_Controller_Front::getInstance();
			

			$strdata = array();
			$i = 0 ;
			foreach($this->_result as $val)
			{
				$cdata[$i]['id']    =  $val['event_id'] ;
				$cdata[$i]['title'] =  stripslashes($val['event_name']);
				$cdata[$i]['start'] =  $val['event_start_date'] ;		
				$cdata[$i]['end']   =  $val['event_end_date'] ;
				$cdata[$i]['url']   =  $fc->getBaseUrl()."/event/view/eventid/".$val['event_id'] ;
				
				if($val['Med_Model_EventsMoreInfoPrivate']['emp_status'] == 'Considering')
				{
					$cdata[$i]['color'] = 'green' ;
					$cdata[$i]['textColor'] = 'white' ;
				}
				else if($val['Med_Model_EventsMoreInfoPrivate']['emp_status'] == 'Contracted')
				{
					$cdata[$i]['color'] = 'brown' ;
					$cdata[$i]['textColor'] = 'white' ;
				}
				
				$i++ ;
			}
			
			echo $dataste = json_encode($cdata);
			
			exit();
			
			
		}//End View	
		
		/*This function use for calendar view.*/
		
		public function cviewAction()
		{
			$this->_helper->layout->setLayout('master');
			$registry = Zend_Registry::getInstance();
		}//End View
		
		public function listviewsAction()
		{
			$registry = Zend_Registry::getInstance();
			$session  = new Zend_Session_Namespace('Med.auth');			
			$login    = $registry['sess_user_id'];
			
			//$session->comp_id  =1 ;
			$search	= '(e.event_cmp_id  = 0 OR e.event_cmp_id  = '.$session->comp_id.')';
			
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
				
				$keysearch = '';
				if(trim($getValue['keywords'])!="") //if keywords not empty
				{
					$valArr = explode(' ', $getValue['keywords']) ;
					
					//$keyeArr array store events table field that have been use in the keyword serching.
					$keyeArr = array('event_name','event_producer','event_url','event_co_located_event','event_venue', 'event_focus','event_audience_profile','event_analyst_profile','event_tracks_sessions','event_keynote_speakers','event_other_speakers','event_status');
					
					//$keypArr array store events_more_info_private table field that have been use in the keyword serching.
					$keypArr = array('emip_emp_contact_name', 'emip_emp_title', 'emip_emp_email', 'emip_branding_opportunities', 'emip_speaking_opportunities', 'emip_client_speaker', 'emip_key_message', 'emip_demo_plan', 'emip_partner_participation');
					
					foreach($valArr as $val)
					{	
						if(trim($val) !="")
						{
							foreach($keyeArr  as $eval)
							{
								if($keysearch == "")
									 $keysearch .=" e.".$eval." like '%".$val."%'";
								else
									 $keysearch .=" OR e.".$eval." like '%".$val."%'";
							}
							
							foreach($keypArr  as $pval)
							{
								if($keysearch == "")
									 $keysearch .=" p.".$pval." like '%".$val."%'";
								else
									 $keysearch .=" OR p.".$pval." like '%".$val."%'";
							}
						}
						
					}//End foreach
									
				}//End If
				
				$nsearch = '';
				if(trim($getValue['eventname']) !="")
					$nsearch .= " AND e.event_name like '%".$getValue['eventname']."%'";
				
			if(trim($getValue['datepicker'])!="")
			$nsearch.= " AND e.event_start_date >='".$getValue['datepicker']."' AND e.event_start_date !='0000-00-00 00:00:00'";
			
			if(trim($getValue['datepicker2']) !="")
			$nsearch.= " AND e.event_end_date <='".$getValue['datepicker2']."' AND e.event_end_date !='0000-00-00 00:00:00'";
				
				if(trim($getValue['primary_objective']) !="")
					$nsearch .= " AND p.emip_primary_event_objective = '".$getValue['primary_objective']."'";
				
				if(trim($getValue['campaign_alignment']) !="")
					$nsearch .= " AND p.emip_campaign_alignment = '".$getValue['campaign_alignment']."'";
				
				if(trim($getValue['customer_target']) !="")
					$nsearch .= " AND p.emip_customer_target = '".$getValue['customer_target']."'";
				
				if(trim($getValue['business_group']) !="")
					$nsearch .= " AND p.emip_business_unit= '".$getValue['business_group']."'";
				
				if(trim($getValue['industry_sectors']) !="")
					$nsearch .= " AND p.emip_sector_industries= '".$getValue['industry_sectors']."'";
				
				if(trim($getValue['geography']) !="")
					$nsearch .= " AND g.eg_geo_id= '".$getValue['geography']."'";
				
				if(trim($getValue['event_type']) !="")
					$nsearch .= " AND p.emip_event_type= '".$getValue['event_type']."'";
				
				if(trim($getValue['EventStatus']) !="")
					$nsearch .= " AND p.emp_status= '".$getValue['EventStatus']."'";
								
				if(trim($nsearch) !="")
					$search=' (e.event_cmp_id  = 0 OR e.event_cmp_id  = '.$session->comp_id.') '.$nsearch ;
					
				if(trim($keysearch) !="")	
				{
					if(trim($nsearch)!="")
						$search=' ( e.event_cmp_id = 0 OR e.event_cmp_id='.$session->comp_id.') '.$nsearch.' AND ('.$keysearch.')';
					else
						$search='(e.event_cmp_id  = 0 OR e.event_cmp_id ='.$session->comp_id.') AND ('.$keysearch.') ';
				}
				
				 
				if($getValue['lmonth'] !="" && $getValue['lyear'] !="")
				{
					if($getValue['lmonth'] < 10)
						$getValue['lmonth']='0'.$getValue['lmonth'];
						
					$ym = $getValue['lyear'].$getValue['lmonth'] ;
					
					$search = "( e.event_cmp_id=0 OR e.event_cmp_id='".$session->comp_id."') AND  EXTRACT(YEAR_MONTH FROM e.event_end_date)='".$ym."'" ;
				} 
				 
				
			}//End if
		
			//echo $search ;
			//exit();
		
			$q  = new Doctrine_Query() ;
			
			$q->select('e.event_name, event_start_date, event_end_date, c.country_name')
			->from('Med_Model_Events e')
			//->leftjoin('e.Med_Model_EventsMoreInfoPrivate p ON (e.event_id = p.emip_event_id)')
->leftjoin('e.Med_Model_EventsMoreInfoPrivate p ON (e.event_id = p.emip_event_id AND p.emip_cmp_id='.$session->comp_id.')') 			
			->leftjoin('p.Med_Model_EventGeographies g ON (p.emip_id = g.eg_emip_id)')
			->leftjoin('e.Med_Model_Countries c ON (e.event_country_id = c.id)')
			->where("p.emip_cmp_id = $session->comp_id")
			->where($search);
			
			
			$this->_result = $q->fetchArray();
			
			$page=$this->_getParam('page',1);
			$paginator = Zend_Paginator::factory($this->_result);
			$paginator->setItemCountPerPage(10);
			$paginator->setCurrentPageNumber($page);
			$this->view->paginator=$paginator;				  
		
		}// End listviews
  
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