<?php
class BaseController extends Zend_Controller_Action
{	
	public function searchpopulate()
	{
		$q    = Doctrine_Query::create()->from('Med_Model_PopulateFields p');			
		$data = $q->fetchArray();
		
		$pArr = array();
		$pe = 0;
		$ca = 0;
		$ct = 0;
		$bu = 0;
		$bi = 0;
		$ge = 0;
		$et = 0;
		$si = 0;
		
		foreach($data as $val)
		{	
			if($val['pf_type'] == 'PRIMARY_EVENT_OBJECTIVE')
			{
				$pArr['primary_objective'][$pe]['id']   = $val['pf_id'] ;
				$pArr['primary_objective'][$pe]['name'] = $val['pf_name'] ;
				$pe++;
			}

			if($val['pf_type'] == 'CAMPAIGN_ALIGNMENT')
			{
				$pArr['campaign_alignment'][$ca]['id']    = $val['pf_id'] ;
				$pArr['campaign_alignment'][$ca]['name']  = $val['pf_name'] ;
				$ca++;
			}

			if($val['pf_type'] == 'CUSTOMER_TARGET')
			{
				$pArr['customer_target'][$ct]['id'] 	 = $val['pf_id'] ;
				$pArr['customer_target'][$ct]['name']   = $val['pf_name'] ;
				$ct++;
			}



			if($val['pf_type'] == 'BUSINESS_UNIT')
			{
				$pArr['business_group'][$bi]['id'] = $val['pf_id'] ;
				$pArr['business_group'][$bi]['name']   = $val['pf_name'] ;
				$bi++;
			}
			
			if($val['pf_type'] == 'SECTOR_INDUSTRY')
			{
				$pArr['industry_sectors'][$si]['id'] = $val['pf_id'] ;
				$pArr['industry_sectors'][$si]['name']   = $val['pf_name'] ;
				$si++;
			}
			
			
			if($val['pf_type'] == 'GEOGRAPHIES')
			{
				$pArr['geography'][$ge]['id'] = $val['pf_id'] ;
				$pArr['geography'][$ge]['name']   = $val['pf_name'] ;
				$ge++;

			}

			if($val['pf_type'] == 'EVENT_TYPE')
			{
				$pArr['event_type'][$et]['id'] = $val['pf_id'] ;
				$pArr['event_type'][$et]['name']   = $val['pf_name'];
				$et++;
			}
				
		}
		
		return $pArr;
		exit ;
		
	}//End ticker
}
