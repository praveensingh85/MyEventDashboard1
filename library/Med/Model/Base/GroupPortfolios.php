<?php
// Connection Component Binding
Doctrine_Manager::getInstance()->bindComponent('Med_Model_GroupPortfolios', 'doctrine');

/**
 * Med_Model_Base_GroupPortfolios
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $gp_id
 * @property integer $gp_group_id
 * @property integer $gp_pf_id
 * @property date $gp_date
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class Med_Model_Base_GroupPortfolios extends Doctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('group_portfolios');
        $this->hasColumn('gp_id', 'integer', 4, array(
             'type' => 'integer',
             'length' => 4,
             'fixed' => false,
             'unsigned' => true,
             'primary' => true,
             'autoincrement' => true,
             ));
        $this->hasColumn('gp_group_id', 'integer', 4, array(
             'type' => 'integer',
             'length' => 4,
             'fixed' => false,
             'unsigned' => true,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             ));
        $this->hasColumn('gp_pf_id', 'integer', 4, array(
             'type' => 'integer',
             'length' => 4,
             'fixed' => false,
             'unsigned' => true,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             ));
        $this->hasColumn('gp_date', 'date', null, array(
             'type' => 'date',
             'fixed' => false,
             'unsigned' => false,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        
    }
}