<?php
// Connection Component Binding
Doctrine_Manager::getInstance()->bindComponent('Med_Model_Groups', 'doctrine');

/**
 * Med_Model_Base_Groups
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $group_id
 * @property integer $group_au_id
 * @property string $group_title
 * @property date $group_date
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class Med_Model_Base_Groups extends Doctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('groups');
        $this->hasColumn('group_id', 'integer', 4, array(
             'type' => 'integer',
             'length' => 4,
             'fixed' => false,
             'unsigned' => true,
             'primary' => true,
             'autoincrement' => true,
             ));
        $this->hasColumn('group_au_id', 'integer', 4, array(
             'type' => 'integer',
             'length' => 4,
             'fixed' => false,
             'unsigned' => true,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             ));
        $this->hasColumn('group_title', 'string', 255, array(
             'type' => 'string',
             'length' => 255,
             'fixed' => false,
             'unsigned' => false,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             ));
        $this->hasColumn('group_date', 'date', null, array(
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