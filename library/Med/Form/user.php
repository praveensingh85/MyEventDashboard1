<?php 
class Med_Form_user extends Zend_Form
{
	protected $company_specific ;
	public function init()  
    {  
  
    }
	public function set_company_specific($val)  
    {  
      //set the variable  
      $this->company_specific = $val;  
    }  
	public function start_form()
	{		
		// initialize form
		$this->setAttribs(array(
		'class' => 'form',
		'id' => 'user'
		))
		->setMethod('post');
        $heading_starts = new heading_starts_tags('Heading_starts');
		// create text input for cu_email
		$cu_email = new Zend_Form_Element_Text('cu_email');
		$cu_email->setLabel(' <span>Email/User Name<b class="mandatory">*</b></span>')
		->setRequired(true)
		->addValidator('NotEmpty', true,array(
		'messages' => array(
		Zend_Validate_NotEmpty::IS_EMPTY
		=> "Please enter email"
		)
		))
		->addValidator('EmailAddress', true)
		->setOptions(array('class' => 'listform-field'))
		->addFilter('HtmlEntities')
		->addFilter('StringTrim');
		$cu_email->setDecorators(array(
                   'ViewHelper',
				   array('Errors',array('tag'=>'p')),
				   array('Label', array('escape' => false)),
				   array(array('row'=>'HtmlTag'),array('tag'=>'p'))
        ));
		// create text input for cu_pwd 
		$cu_pwd = new Zend_Form_Element_Text('cu_pwd');
		$cu_pwd->setLabel(' <span>Password</span>')
		->setOptions(array('class' => 'listform-field'))
		->addFilter('HtmlEntities')
		->addFilter('StringTrim');
		$cu_pwd->setDecorators(array(
                   'ViewHelper',
				   'Errors',
				   array('Label', array('escape'=>false)),
				   array(array('row'=>'HtmlTag'),array('tag'=>'p'))
           ));
		// create text input for cu_cnpwd 
		$cu_cnpwd = new Zend_Form_Element_Text('cu_cnpwd');
		$cu_cnpwd->setLabel(' <span>Confirm Password</span>')
		->setOptions(array('class' => 'listform-field'))
		->addValidator('Identical', false, array('token' => 'cu_pwd',
				'messages' => array(
				Zend_Validate_Identical::NOT_SAME
				=> "The passwords you entered do not match. Please try again."
				)
			  )) 
		->addFilter('HtmlEntities')
		->addFilter('StringTrim');
		$cu_cnpwd->setDecorators(array(
                   'ViewHelper',
				   'Errors',
				   array('Label', array('escape'=>false)),
				   array(array('row'=>'HtmlTag'),array('tag'=>'p'))
           ));
		$end_login_info_block = new end_block('end_login_info_block');
		$heading_contact_tags = new heading_contact_tags('heading_contact_tags');
		// create text input for 	cu_fname 
		$cu_fname = new Zend_Form_Element_Text('cu_fname');
		$cu_fname->setLabel(' <span>First Name</span>')
		->setOptions(array('class' => 'listform-field'))
		->addFilter('HtmlEntities')
		->addFilter('StringTrim');
		$cu_fname->setDecorators(array(
                   'ViewHelper',
				   'Errors',
				   array('Label', array('escape'=>false)),
				   array(array('row'=>'HtmlTag'),array('tag'=>'p'))
           ));
		// create text input for 	cu_lname 
		$cu_lname = new Zend_Form_Element_Text('cu_lname');
		$cu_lname->setLabel(' <span>Last Name</span>')
		->setOptions(array('class' => 'listform-field'))
		->addFilter('HtmlEntities')
		->addFilter('StringTrim');
		$cu_lname->setDecorators(array(
                   'ViewHelper',
				   'Errors',
				   array('Label', array('escape'=>false)),
				   array(array('row'=>'HtmlTag'),array('tag'=>'p'))
           ));
		// create text input for 	cu_title 
		$cu_title = new Zend_Form_Element_Text('cu_title');
		$cu_title->setLabel(' <span>Title</span>')
		->setOptions(array('class' => 'listform-field'))
		->addFilter('HtmlEntities')
		->addFilter('StringTrim');
		$cu_title->setDecorators(array(
                   'ViewHelper',
				   'Errors',
				   array('Label', array('escape'=>false)),
				   array(array('row'=>'HtmlTag'),array('tag'=>'p'))
           ));
	    //create select input for department
		$cu_department  = new Zend_Form_Element_Select('cu_department ');
		$cu_department ->setLabel(' <span>Department</span>');
		$cu_department ->addMultiOption('', 'Select...');
		foreach ($this->get_populate_fields_records('USER_DEPARTMENT') as $c) {
		$cu_department ->addMultiOption($c['pf_id'],ucfirst($c['pf_name']));
		}
		$cu_department ->setDecorators(array(
                   'ViewHelper',
				   'Errors',
                   array('Label',array('escape'=>false)),
                   array(array('row'=>'HtmlTag'),array('tag'=>'p'))
           ));
		// create text input for 	department additional add
		$cu_department_add_id = new Zend_Form_Element_Text('cu_department_add_id');
		$cu_department_add_id->setLabel('<span>&nbsp;</span>')
		->setOptions(array('class' => 'addfield'))
		->setDescription('<a href="javascript:void();" onClick="add_option(\'cu_department\',\'cu_department_add_id\',\'USER_DEPARTMENT\',document.getElementById(\'cu_department_add_id\').value);"><img src="'.SUB_PATH_URL.'/images/add-more.png"></a>')
		->addFilter('HtmlEntities')
		->addFilter('StringTrim');
		$cu_department_add_id->setDecorators(array(
                   'ViewHelper',
				   'Errors',
				   array('Description',array('tag'=>'span','escape'=>false)),
				   array('Label', array('escape'=>false)),
				   array(array('row'=>'HtmlTag'),array('tag'=>'p', 'id'=>'pcu_department_add_id'))
           ));
		// create text input for 	cu_phone_office 
		$cu_phone_office = new Zend_Form_Element_Text('cu_phone_office');
		$cu_phone_office->setLabel(' <span>Phone (Office)</span>')
		->setOptions(array('class' => 'listform-field'))
		->addFilter('HtmlEntities')
		->addFilter('StringTrim');
		$cu_phone_office->setDecorators(array(
                   'ViewHelper',
				   'Errors',
				   array('Label', array('escape'=>false)),
				   array(array('row'=>'HtmlTag'),array('tag'=>'p'))
           ));

		// create text input for 	cu_phone_mobile 
		$cu_phone_mobile = new Zend_Form_Element_Text('cu_phone_mobile');
		$cu_phone_mobile->setLabel(' <span>Phone (Mobile)</span>')
		->setOptions(array('class' => 'listform-field'))
		->addFilter('HtmlEntities')
		->addFilter('StringTrim');
		$cu_phone_mobile->setDecorators(array(
                   'ViewHelper',
				   'Errors',
				   array('Label', array('escape'=>false)),
				   array(array('row'=>'HtmlTag'),array('tag'=>'p'))
           ));
        $heading_location_tags = new heading_location_tags('heading_location_tags');
        // create select input for cu_country_id
		$cu_country_id = new Zend_Form_Element_Select('cu_country_id');
		$cu_country_id->setLabel(' <span>Country</span>');
		$cu_country_id->addMultiOption('', 'Select');
		$cu_country_id->setAttrib('onchange','AutoFillStates(this.value)');
		foreach ($this->get_countries() as $c) {
		$cu_country_id->addMultiOption($c['id'],ucfirst($c['country_name']));
		}
		$cu_country_id->setDecorators(array(
                   'ViewHelper',
				   'Errors',
                   array('Label',array('escape'=>false)),
                   array(array('row'=>'HtmlTag'),array('tag'=>'p'))
           ));
		// create select input for cu_state_id
		$cu_state_id = new Zend_Form_Element_Select('cu_state_id');
		$cu_state_id->setLabel(' <span>State</span>');
		$cu_state_id->addMultiOption('', 'Select');
		$cu_state_id->setRegisterInArrayValidator(false);
		$cu_state_id->setDecorators(array(
                   'ViewHelper',
				   'Errors',
                   array('Label',array('escape'=>false)),
                   array(array('row'=>'HtmlTag'),array('tag'=>'p','id'=>'pcu_state_id'))
           ));

		// create text input for 	cu_city 
		$cu_city = new Zend_Form_Element_Text('cu_city');
		$cu_city->setLabel(' <span>City</span>')
		->setOptions(array('class' => 'listform-field'))
		->addFilter('HtmlEntities')
		->addFilter('StringTrim');
		$cu_city->setDecorators(array(
                   'ViewHelper',
				   'Errors',
				   array('Label', array('escape'=>false)),
				   array(array('row'=>'HtmlTag'),array('tag'=>'p'))
           ));
	    $arr_timezone = array(
		
		'GMT'=>'Greenwich Mean Time',
		'UTC'=>'Universal Coordinated Time',
		'ECT'=>'European Central Time',
		'EET'=>'Eastern European Time'
		);
		//create select input for cu_timezone
		$cu_timezone  = new Zend_Form_Element_Select('cu_timezone ');
		$cu_timezone ->setLabel(' <span>Time Zone</span>');
		$cu_timezone ->addMultiOption('', 'Select...');
		foreach ($arr_timezone as $key=>$val) {
		$cu_timezone ->addMultiOption($key,$val);
		}
		$cu_timezone->setDecorators(array(
                   'ViewHelper',
				   'Errors',
                   array('Label',array('escape'=>false)),
                   array(array('row'=>'HtmlTag'),array('tag'=>'p'))
           ));

		$end_location_info_block = new end_block('end_location_info_block');

		$submit_save = new Zend_Form_Element_Submit('submit_save');
		$submit_save->setLabel('Save')
		->setOptions(array('class' => 'optional-button'));
		$submit_save->setDecorators(array(
        'ViewHelper',
        'Description',
        'Errors',
	     array(array('row'=>'HtmlTag'),array('tag'=>'div','openOnly'=>true,'align'=>'center'))
        ));
	    $end_contact_info_block = new end_block('end_contact_info_block');
		
		$submit_save_addnew = new Zend_Form_Element_Submit('submit_save_addnew');
		$submit_save_addnew->setLabel('Save & Add New')
		->setOptions(array('class' => 'optional-button'));
		$submit_save_addnew->setDecorators(array(
        'ViewHelper',
        'Description',
        'Errors'
      ));
	   $submit_cancel = new Zend_Form_Element_Button('submit_cancel');
	   $submit_cancel->setLabel('Cancel')
		->setOptions(array('class' => 'optional-button','onclick'=>'javascript:history.go(-1);'));
		$submit_cancel->setDecorators(array(
        'ViewHelper',
        'Description',
        'Errors',
        array(array('row'=>'HtmlTag'),array('tag'=>'div','closeOnly'=>true))
      ));

		
		$this->addElement($heading_starts)
		 ->addElement($cu_email)
		 ->addElement($cu_pwd)
         ->addElement($cu_cnpwd)
		 ->addElement($end_login_info_block)
		 ->addElement($heading_contact_tags)
		 ->addElement($cu_fname)
		 ->addElement($cu_lname)
		 ->addElement($cu_title)
		 ->addElement($cu_department)
		 ->addElement($cu_department_add_id)
		 ->addElement($cu_phone_office)
		 ->addElement($cu_phone_mobile)
		 ->addElement($end_contact_info_block)
		 ->addElement($heading_location_tags)
		 ->addElement($cu_country_id)
		 ->addElement($cu_state_id)
		 ->addElement($cu_city)
		 ->addElement($cu_timezone)
		 ->addElement($end_location_info_block)
		 ->addElement($submit_save)
		 ->addElement($submit_save_addnew)
		 ->addElement($submit_cancel)
		 
		 ;
		$this->setDecorators(array(
               'FormElements',
               'Form'
       ));

	}
	public function get_populate_fields_records($ftype) {
		$q = Doctrine_Query::create()
		->from('Med_Model_PopulateFields p')
		->where('p.pf_type= ?',$ftype);
		if($this->company_specific >0 ){
		    $q->andWhere('(p.pf_cmp_id= ?', '0')
			  ->orWhere('p.pf_cmp_id= ?)',$this->company_specific);
			
		}else{
		   $q->andWhere('p.pf_cmp_id= ?', '0');
		}
		
		$q->orderBy('p.pf_order ASC');
		return $q->fetchArray();
	}
    public function get_countries() {
		$q = Doctrine_Query::create()
		->from('Med_Model_Countries c');
		$q->orderBy('c.country_name ASC');
		return $q->fetchArray();
	}
}
class heading_starts_tags extends Zend_Form_Element
{   
	public function render(Zend_View_Interface $view = null)
    {
    return '<h2><img src="'.SUB_PATH_URL.'/images/down-arrow.gif">Login</h2><div id="login_info"><table  border="0" cellpadding="0" cellspacing="0" width="100%"><tr><td valign="top" width="140px">&nbsp;</td><td width="497px">';        
	}
}
class end_block extends Zend_Form_Element
{
	public function render(Zend_View_Interface $view = null)
    {
    return '</td><td width="497px" valign="top"> </td><td width="50px" valign="top">&nbsp;</td></tr></table></div>';        
	}
}
class heading_contact_tags extends Zend_Form_Element
{   
	public function render(Zend_View_Interface $view = null)
    {
    return '<h2><img src="'.SUB_PATH_URL.'/images/down-arrow.gif">Contact</h2><div id="contact_info"><table  border="0" cellpadding="0" cellspacing="0" width="100%"><tr><td valign="top" width="140px">&nbsp;</td><td width="497px">';        
	}
}
class heading_location_tags extends Zend_Form_Element
{   
	public function render(Zend_View_Interface $view = null)
    {
    return '<h2><img src="'.SUB_PATH_URL.'/images/down-arrow.gif">Location</h2><div id="location_info"><table  border="0" cellpadding="0" cellspacing="0" width="100%"><tr><td valign="top" width="140px">&nbsp;</td><td width="497px">';        
	}
}

?>