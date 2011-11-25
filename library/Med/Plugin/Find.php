<?php

class Med_Plugin_Find extends Zend_Controller_Plugin_Abstract {

    protected static $_cliients = null;

    public function find()
    {
      $client = Doctrine_Query::create()
           ->from('Med_Model_Companies c');
      
      $this->_clients = $client->fetchArray();
	  return $this->_clients;   
    }
    public function findcountry($country_id)
    {
      $country = Doctrine_Query::create()
           ->from('Med_Model_Countries c')
		   ->where('c.id = ?',$country_id);
      
      $country_namelist = $country->fetchArray();
	  $country_name = $country_namelist['0']['country_name'];
	  return $country_name;   
    }
	public function findstate($state_id)
    {
      $state = Doctrine_Query::create()
           ->from('Med_Model_States s')
		   ->where('s.st_id = ?',$state_id);
      
      $state_namelist = $state->fetchArray();
	  $state_name = $state_namelist['0']['st_name'];
	  return $state_name;   
    }
   public function findpfname($pf_id,$pf_type)
    {
      $pfname = Doctrine_Query::create()
           ->from('Med_Model_PopulateFields p')
		   ->where('p.pf_id = ?',$pf_id)
		   ->addwhere('p.pf_type = ?',$pf_type);
      
      $pf_namelist = $pfname->fetchArray();
	  $pf_name = $pf_namelist['0']['pf_name'];
	  return $pf_name;   
    }
	public function findalldepartment($pf_type)
    {
      $pfname = Doctrine_Query::create()
           ->from('Med_Model_PopulateFields p')
		   ->where('p.pf_type = ?',$pf_type);
	
      $pf_namelist = $pfname->fetchArray();
	  
	  return $pf_namelist;   
    }
	public function findformat($eid)
    {
      $fid = Doctrine_Query::create()
           ->from('Med_Model_EventFormats f')
		   ->where('f.ef_event_id = ?',$eid);
      
      $fidlist = $fid->fetchArray();
	 
	  return $fidlist;   
    }	
	
	public function findindusry($eid) 
    {
      $industryid = Doctrine_Query::create()
           ->from('Med_Model_EventIndustries f')
		   ->where('f.ei_event_id = ?',$eid);
      
      $industrylist =  $industryid->fetchArray();
	  return  $industrylist;   
    }
	public function findindustryname($eid)
    {
      $industriesid = Doctrine_Query::create()
           ->from('Med_Model_Industries f')
		   ->where('f.ind_id = ?',$eid);
      
      $industrieslist =  $industriesid->fetchArray();
	  $in_name = $industrieslist['0']['ind_name'];
	  return  $in_name;   
    }
	public function findcompanysize($eid)
    {
      $companyid = Doctrine_Query::create()
           ->from('Med_Model_EventCompanySizes f')
		   ->where('f.ecs_event_id = ?',$eid);
      
      $companylist = $companyid->fetchArray();
	  return  $companylist;   
    }
	
	public function findsponsor($eid)
    {
      $sponserid = Doctrine_Query::create()
           ->from('Med_Model_SponsorCompanies f')
		   ->where('f.sc_event_id = ?',$eid);
      
      $sponserlist = $sponserid->fetchArray();
	 
	  return  $sponserlist;   
    }
	
	public function findsponsorname($eid)
    {
      $sponsersid = Doctrine_Query::create()
           ->from('Med_Model_Sponsors f')
		   ->where('f.spn_id = ?',$eid);
      
      $sponsernamelist = $sponsersid->fetchArray();
	  $sponsername = $sponsernamelist['0']['spn_name'];
	  return  $sponsername;   
    }
	
	// for private field functions
	public function fingeography($eid)
    {
      $gid = Doctrine_Query::create()
           ->from('Med_Model_EventGeographies f')
		   ->where('f.eg_emip_id = ?',$eid);
      
      $glist = $gid->fetchArray();
	 
	  return  $glist;   
    }
	
 
} 