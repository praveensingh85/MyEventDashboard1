<?php

/**
 * Med_Model_Events
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
class Med_Model_Events extends Med_Model_Base_Events
{
	public function setUp()
	{
		$this->hasOne('Med_Model_Countries', array('local' => 'event_country_id', 'foreign' => 'id'));
		$this->hasOne('Med_Model_EventsMoreInfoPrivate', array('local' => 'event_id', 'foreign' => 'emip_event_id'));
	}

}