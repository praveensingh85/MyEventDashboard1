<?php

/**
 * Med_Model_EventsMoreInfoPrivate
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
class Med_Model_EventsMoreInfoPrivate extends Med_Model_Base_EventsMoreInfoPrivate
{
  public function setUp()
	{
		$this->hasOne('Med_Model_EventGeographies', array('local' => 'emip_id', 'foreign' => 'eg_emip_id'));
	}

}