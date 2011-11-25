<?php 
class Med_Form_event extends Zend_Form
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
		'id' => 'Event'
		))
		->setMethod('post');
        $heading_starts = new heading_starts_tags('Heading_starts');
		// create text input for Event Name
		$event_name = new Zend_Form_Element_Text('event_name');
		$event_name->setLabel(' <span>Event Name<b class="mandatory">*</b></span>')
		->setRequired(true)
		->addValidator('NotEmpty', true,array(
		'messages' => array(
		Zend_Validate_NotEmpty::IS_EMPTY
		=> "Please enter event name"
		)
		))
		->setOptions(array('class' => 'listform-field'))
		
		->addFilter('StringTrim');
		$event_name->setDecorators(array(
                   'ViewHelper',
				   array('Errors',array('tag'=>'p')),
				   array('Label', array('escape' => false)),
				   array(array('row'=>'HtmlTag'),array('tag'=>'p'))
        ));
		// create text input for event producer
		$event_producer = new Zend_Form_Element_Text('event_producer');
		$event_producer->setLabel(' <span>Event Producer</span>')
		->setOptions(array('class' => 'listform-field'))
		
		->addFilter('StringTrim');
		$event_producer->setDecorators(array(
                   'ViewHelper',
				   'Errors',
				   array('Label', array('escape'=>false)),
				   array(array('row'=>'HtmlTag'),array('tag'=>'p'))
           ));
		// create checkbox for In person / Virtual
         $event_person_virtual = new Zend_Form_Element_MultiCheckbox('event_person_virtual');
         $event_person_virtual->setSeparator('')
                 ->setMultiOptions(array(
                       'Person' => 'Person',
                       'Virtual' => 'Virtual'
					   ));
		$decorator_checks = new person_virtual_checkboxes();
        $event_person_virtual->setDecorators(array($decorator_checks));		

		//create text input for event_start_date
		$event_start_date = new Zend_Dojo_Form_Element_DateTextBox('event_start_date');
		$event_start_date->setLabel(' <span>Start Date<b class="mandatory">*</b></span>')
		->addValidator('NotEmpty', true,array(
		'messages' => array(
		Zend_Validate_NotEmpty::IS_EMPTY
		=> "Please enter start date"
		)
		))
		
		->addFilter('StringTrim');
		$event_start_date->setDecorators(array(
            'DijitElement',
			'Errors',
            array('Label',array('escape'=>false)),
            array(array('row'=>'HtmlTag'),array('tag'=>'p'))
         )); 
		   
		// create text input for 	event_end_date
		$event_end_date = new Zend_Dojo_Form_Element_DateTextBox('event_end_date');
		$event_end_date->setLabel(' <span>End Date<b class="mandatory">*</b></span>')
		->addValidator('NotEmpty', true,array(
		'messages' => array(
		Zend_Validate_NotEmpty::IS_EMPTY
		=> "Please enter end date"
		)
		))
		
		->addFilter('StringTrim');
		$event_end_date->setDecorators(array(
                   'DijitElement',
				   'Errors',
				   array('Label', array('escape'=>false)),
				   array(array('row'=>'HtmlTag'),array('tag'=>'p'))
           ));
				// create text input for 	event_exh_start_date
		$event_exh_start_date = new Zend_Dojo_Form_Element_DateTextBox('event_exh_start_date');
		$event_exh_start_date->setLabel(' <span>Exhibit Start Date</span>')
		
		->addFilter('StringTrim');
		$event_exh_start_date->setDecorators(array(
                   'DijitElement',
				   'Errors',
				   array('Label', array('escape'=>false)),
				   array(array('row'=>'HtmlTag'),array('tag'=>'p'))
           ));
		// create text input for 	event_exh_end_date
		$event_exh_end_date = new Zend_Dojo_Form_Element_DateTextBox('event_exh_end_date');
		$event_exh_end_date->setLabel(' <span>Exhibit End Date</span>')
		
		->addFilter('StringTrim');
		$event_exh_end_date->setDecorators(array(
                   'DijitElement',
				   'Errors',
				   array('Label', array('escape'=>false)),
				   array(array('row'=>'HtmlTag'),array('tag'=>'p'))
           ));
		// create text input for 	event_url
		$event_url = new Zend_Form_Element_Text('event_url');
		$event_url->setLabel(' <span>Event URL</span>')
		->setOptions(array('class' => 'listform-field'))
		->addValidator(new Url_Validator)
		
		->addFilter('StringTrim');
		$event_url->setDecorators(array(
                   'ViewHelper',
				   'Errors',
				   array('Label', array('escape'=>false)),
				   array(array('row'=>'HtmlTag'),array('tag'=>'p'))
           ));

		 // create text area for Event Focus
         $event_focus = new Zend_Form_Element_Textarea('event_focus');
         $event_focus->setLabel(' <span>Event Focus</span>')
                 ->setOptions(array(
                              'id' => 'event_focus',
                              'rows' => '5',
                              'cols' => '22',
                   ))
		
		->addFilter('StringTrim');
		
		$event_focus->setDecorators(array(
                   'ViewHelper',
				   'Errors',
				   array('Label', array('escape'=>false)),
				   array(array('row'=>'HtmlTag'),array('tag'=>'p'))
           ));
        $basic_info_td_starts = new new_td_start('basic_info_td_starts');
	    
		 // create text area for Co-located Event 
         $event_co_located_event = new Zend_Form_Element_Textarea('event_co_located_event');
         $event_co_located_event->setLabel(' <span>Co-located Event</span>')
                 ->setOptions(array(
                              'id' => 'event_co_located_event',
                              'rows' => '5',
                              'cols' => '22',
                   ))
		
		->addFilter('StringTrim');
		
		$event_co_located_event->setDecorators(array(
                   'ViewHelper',
				   'Errors',
				   array('Label', array('escape'=>false)),
				   array(array('row'=>'HtmlTag'),array('tag'=>'p'))
           ));
		// create text input for 	event_venue
		$event_venue = new Zend_Form_Element_Text('event_venue');
		$event_venue->setLabel(' <span>Event Venue</span>')
		->setOptions(array('class' => 'listform-field'))
		
		->addFilter('StringTrim');
		$event_venue->setDecorators(array(
                   'ViewHelper',
				   'Errors',
				   array('Label', array('escape'=>false)),
				   array(array('row'=>'HtmlTag'),array('tag'=>'p'))
           ));

        // create select input for event_region
		$event_region = new Zend_Form_Element_Select('event_region');
		$event_region->setLabel(' <span>Region<b class="mandatory">*</b></span>');
		$event_region->addMultiOption('', 'Select...');
		foreach ($this->get_populate_fields_records('EVENT_REGION') as $c) {
		$event_region->addMultiOption($c['pf_id'],ucfirst($c['pf_name']));
		}
     	$event_region->setRequired(true)
		->addValidator('NotEmpty', true,array(
		'messages' => array(
		Zend_Validate_NotEmpty::IS_EMPTY
		=> "Please select event region"
		)
		)); 
		$event_region->setDecorators(array(
                   'ViewHelper',
				   'Errors',
                   array('Label',array('escape'=>false)),
                   array(array('row'=>'HtmlTag'),array('tag'=>'p'))
           ));
		
		// create text input for 	event_region additional add
		$event_region_add_id = new Zend_Form_Element_Text('event_region_add_id');
		$event_region_add_id->setLabel('<span>&nbsp;</span>')
		->setOptions(array('class' => 'addfield'))
		->setDescription('<a href="javascript:void();" onClick="add_option(\'event_region\',\'event_region_add_id\',\'EVENT_REGION\',document.getElementById(\'event_region_add_id\').value);"><img src="'.SUB_PATH_URL.'/images/add-more.png"></a>')
		
		->addFilter('StringTrim');
		$event_region_add_id->setDecorators(array(
                   'ViewHelper',
				   'Errors',
				   array('Description',array('tag'=>'span','escape'=>false)),
				   array('Label', array('escape'=>false)),
				   array(array('row'=>'HtmlTag'),array('tag'=>'p', 'id'=>'pevent_region_add_id'))
           ));
		
        // create select input for event_country_id
		$event_country_id = new Zend_Form_Element_Select('event_country_id');
		$event_country_id->setLabel(' <span>Country<b class="mandatory">*</b></span>');
		$event_country_id->addMultiOption('', 'Select');
		$event_country_id->setAttrib('onchange','AutoFillStates(this.value)');
		foreach ($this->get_countries() as $c) {
		$event_country_id->addMultiOption($c['id'],ucfirst($c['country_name']));
		}
 		$event_country_id->setRequired(true)
		->addValidator('NotEmpty', true,array(
		'messages' => array(
		Zend_Validate_NotEmpty::IS_EMPTY
		=> "Please select country"
		)
		)); 
		$event_country_id->setDecorators(array(
                   'ViewHelper',
				   'Errors',
                   array('Label',array('escape'=>false)),
                   array(array('row'=>'HtmlTag'),array('tag'=>'p'))
           ));
		// create select input for event_state_id
		$event_state_id = new Zend_Form_Element_Select('event_state_id');
		$event_state_id->setLabel(' <span>State</span>');
		$event_state_id->addMultiOption('', 'Select');
		$event_state_id->setRegisterInArrayValidator(false);
		$event_state_id->setDecorators(array(
                   'ViewHelper',
				   'Errors',
                   array('Label',array('escape'=>false)),
                   array(array('row'=>'HtmlTag'),array('tag'=>'p','id'=>'pevent_state_id'))
           ));

        // create  input for event_city
		$event_city = new Zend_Form_Element_Text('event_city');
		$event_city->setLabel(' <span>City</span>')
		->setOptions(array('class' => 'listform-field'))
		
		->addFilter('StringTrim');
		$event_city->setDecorators(array(
                   'ViewHelper',
				   'Errors',
                   array('Label',array('escape'=>false)),
                   array(array('row'=>'HtmlTag'),array('tag'=>'p'))
           ));
        // create select input for event_frequency
		$event_frequency = new Zend_Form_Element_Select('event_frequency');
		$event_frequency->setLabel(' <span>Frequency</span>');
		$event_frequency->addMultiOption('', 'Select');
		foreach ($this->get_populate_fields_records('EVENT_FREQUENCY') as $c) {
		$event_frequency->addMultiOption($c['pf_id'],ucfirst($c['pf_name']));
		}

		$event_frequency->setDecorators(array(
                   'ViewHelper',
				   'Errors',
                   array('Label',array('escape'=>false)),
                   array(array('row'=>'HtmlTag'),array('tag'=>'p'))
           ));
		// create text input for 	event_frequency additional add
		$event_frequency_add_id = new Zend_Form_Element_Text('event_frequency_add_id');
		$event_frequency_add_id->setLabel('<span>&nbsp;</span>')
		->setOptions(array('class' => 'addfield'))
		->setDescription('<a href="javascript:void();" onClick="add_option(\'event_frequency\',\'event_frequency_add_id\',\'EVENT_FREQUENCY\',document.getElementById(\'event_frequency_add_id\').value);"><img src="'.SUB_PATH_URL.'/images/add-more.png"></a>')
		
		->addFilter('StringTrim');
		$event_frequency_add_id->setDecorators(array(
                   'ViewHelper',
				   'Errors',
				   array('Description',array('tag'=>'span','escape'=>false)),
				   array('Label', array('escape'=>false)),
				   array(array('row'=>'HtmlTag'),array('tag'=>'p','id' => 'pevent_frequency_add_id'))
           ));

		$end_basic_info_block = new end_block('end_basic_info_block');
        $heading_event_details_starts_tags= new heading_event_details_starts_tags('heading_event_details_starts_tags');
		// create select input for event_format
		$event_format = new Zend_Form_Element_Multiselect('ef_format_id');
		$event_format->setLabel(' <span>Event Format</span>');
		$event_format->addMultiOption('', 'Select');
		foreach ($this->get_populate_fields_records('EVENT_FORMAT') as $c) {
		$event_format->addMultiOption($c['pf_id'],ucfirst($c['pf_name']));
		}

		$event_format->setDecorators(array(
                   'ViewHelper',
				   'Errors',
                   array('Label',array('escape'=>false)),
                   array(array('row'=>'HtmlTag'),array('tag'=>'p'))
           ));
		// create text input for 	event_format additional add
		$event_format_add_id = new Zend_Form_Element_Text('event_format_add_id');
		$event_format_add_id->setLabel('<span>&nbsp;</span>')
		->setOptions(array('class' => 'addfield'))
		->setDescription('<a href="javascript:void();" onClick="add_option(\'ef_format_id\',\'event_format_add_id\',\'EVENT_FORMAT\',document.getElementById(\'event_format_add_id\').value);"><img src="'.SUB_PATH_URL.'/images/add-more.png"></a>')
		
		->addFilter('StringTrim');
		$event_format_add_id->setDecorators(array(
                   'ViewHelper',
				   'Errors',
				   array('Description',array('tag'=>'span','escape'=>false)),
				   array('Label', array('escape'=>false)),
				   array(array('row'=>'HtmlTag'),array('tag'=>'p', 'id'=>'pevent_format_add_id'))
           ));
		
		// create text input for 	event_number_attendees
		$event_number_attendees = new Zend_Form_Element_Text('event_number_attendees');
		$event_number_attendees->setLabel(' <span>Number of attendees</span>')
		->setOptions(array('class' => 'listform-field'))
		->addValidator('Int', true,array(
		'messages' => array(
		Zend_Validate_Int::NOT_INT
		=> "Number of attendees can be numeric only"
		)
		))
		
		->addFilter('StringTrim');
		$event_number_attendees->setDecorators(array(
                   'ViewHelper',
				   'Errors',
				   array('Label', array('escape'=>false)),
				   array(array('row'=>'HtmlTag'),array('tag'=>'p'))
           ));
		// create select input for Industries
		$ei_industry = new Zend_Form_Element_Multiselect('ei_industry');
		$ei_industry->setLabel(' <span>Industries</span>');
		$ei_industry->addMultiOption('', 'Select');
		foreach ($this->get_industries() as $c) {
		$ei_industry->addMultiOption($c['ind_id'],$c['ind_name']);
		}

		$ei_industry->setDecorators(array(
                   'ViewHelper',
				   'Errors',
                   array('Label',array('escape'=>false)),
                   array(array('row'=>'HtmlTag'),array('tag'=>'p'))
           ));

		// create text input for 	Industries additional add
		$ei_industry_add_id = new Zend_Form_Element_Text('eei_industry_add_id');
		$ei_industry_add_id->setLabel('<span>&nbsp;</span>')
		->setOptions(array('class' => 'addfield'))
		->setDescription('<a href="javascript:void();" onClick="add_industry(\'ei_industry\',\'eei_industry_add_id\',document.getElementById(\'eei_industry_add_id\').value);"><img src="'.SUB_PATH_URL.'/images/add-more.png"></a>')

		
		->addFilter('StringTrim');
		$ei_industry_add_id->setDecorators(array(
                   'ViewHelper',
				   'Errors',
				   array('Description',array('tag'=>'span','escape'=>false)),
				   array('Label', array('escape'=>false)),
				   array(array('row'=>'HtmlTag'),array('tag'=>'p', 'id'=>'peei_industry_add_id'))
           ));

        $heading_Audience_Profile = new heading_Audience_Profile('heading_Audience_Profile');
		
		// create text area for event_audience_profile
         $event_audience_profile = new Zend_Form_Element_Textarea('event_audience_profile');
         $event_audience_profile->setLabel(' <span><cite>Audience Profile</cite></span>')
                 ->setOptions(array(
                              'id' => 'event_audience_profile',
                              'rows' => '3',
                              'cols' => '22',
                   ))
		
		->addFilter('StringTrim');
		$event_audience_profile->setDecorators(array(
                   'ViewHelper',
				   'Errors',
				   array('Label', array('escape'=>false)),
				   array(array('row'=>'HtmlTag'),array('tag'=>'p'))
           ));
		// create select input for Audience Type
		$event_audience_type = new Zend_Form_Element_Select('event_audience_type');
		$event_audience_type->setLabel(' <span><cite>Audience Type</cite></span>');
		$event_audience_type->addMultiOption('', 'Select');
		foreach ($this->get_populate_fields_records('AUDIENCE_TYPE') as $c) {
		$event_audience_type->addMultiOption($c['pf_id'],ucfirst($c['pf_name']));
		}

		$event_audience_type->setDecorators(array(
                   'ViewHelper',
				   'Errors',
                   array('Label',array('escape'=>false)),
                   array(array('row'=>'HtmlTag'),array('tag'=>'p'))
           ));
		// create text input for 	 Audience Type additional add
		$event_audience_type_add_id = new Zend_Form_Element_Text('event_audience_type_add_id');
		$event_audience_type_add_id->setLabel('<span>&nbsp;</span>')
		->setOptions(array('class' => 'addfield'))
		->setDescription('<a href="javascript:void();" onClick="add_option(\'event_audience_type\',\'event_audience_type_add_id\',\'AUDIENCE_TYPE\',document.getElementById(\'event_audience_type_add_id\').value);"><img src="'.SUB_PATH_URL.'/images/add-more.png"></a>')
		
		->addFilter('StringTrim');
		$event_audience_type_add_id->setDecorators(array(
                   'ViewHelper',
				   'Errors',
				   array('Description',array('tag'=>'span','escape'=>false)),
				   array('Label', array('escape'=>false)),
				   array(array('row'=>'HtmlTag'),array('tag'=>'p', 'id'=>'pevent_audience_type_add_id'))
           ));
		// create text input for event_audience_title
		$event_audience_title = new Zend_Form_Element_Select('event_audience_title');
		$event_audience_title->setLabel(' <span><cite>Title</cite></span>');
		$event_audience_title->addMultiOption('', 'Select');
		foreach ($this->get_populate_fields_records('AUDIENCE_TITLE') as $c) {
		$event_audience_title->addMultiOption($c['pf_id'],ucfirst($c['pf_name']));
		}
		$event_audience_title
		->addFilter('StringTrim');
		$event_audience_title->setDecorators(array(
                   'ViewHelper',
				   'Errors',
				   array('Label', array('escape'=>false)),
				   array(array('row'=>'HtmlTag'),array('tag'=>'p'))
           ));

		// create text input for event_audience_title additional add
		$event_audience_title_add_id = new Zend_Form_Element_Text('event_audience_title_add_id');
		$event_audience_title_add_id->setLabel('<span>&nbsp;</span>')
		->setOptions(array('class' => 'addfield'))
		->setDescription('<a href="javascript:void();" onClick="add_option(\'event_audience_title\',\'event_audience_title_add_id\',\'AUDIENCE_TITLE\',document.getElementById(\'event_audience_title_add_id\').value);"><img src="'.SUB_PATH_URL.'/images/add-more.png"></a>')
		
		->addFilter('StringTrim');
		$event_audience_title_add_id->setDecorators(array(
                   'ViewHelper',
				   'Errors',
				   array('Description',array('tag'=>'span','escape'=>false)),
				   array('Label', array('escape'=>false)),
				   array(array('row'=>'HtmlTag'),array('tag'=>'p', 'id'=>'pevent_audience_title_add_id'))
           ));
		
        $event_new_td_starts = new new_td_start('event_new_td_starts');
		
		// create select input for Company size 
		$ecs_company_sizes = new Zend_Form_Element_Multiselect('ecs_company_sizes');
		$ecs_company_sizes->setLabel(' <span>Company size</span>');
		$ecs_company_sizes->addMultiOption('', 'Select');
		foreach ($this->get_populate_fields_records('COMPANY_SIZE') as $c) {
		$ecs_company_sizes->addMultiOption($c['pf_id'],ucfirst($c['pf_name']));
		}

		$ecs_company_sizes->setDecorators(array(
                   'ViewHelper',
				   'Errors',
                   array('Label',array('escape'=>false)),
                   array(array('row'=>'HtmlTag'),array('tag'=>'p'))
           ));
		// create text input for Company size additional add
		$ecs_company_sizes_add_id = new Zend_Form_Element_Text('ecs_company_sizes_add_id');
		$ecs_company_sizes_add_id->setLabel('<span>&nbsp;</span>')
	    ->setOptions(array('class' => 'addfield'))
		->setDescription('<a href="javascript:void();" onClick="add_option(\'ecs_company_sizes\',\'ecs_company_sizes_add_id\',\'COMPANY_SIZE\',document.getElementById(\'ecs_company_sizes_add_id\').value);"><img src="'.SUB_PATH_URL.'/images/add-more.png"></a>')
		
		->addFilter('StringTrim');
		$ecs_company_sizes_add_id->setDecorators(array(
                   'ViewHelper',
				   'Errors',
				   array('Description',array('tag'=>'span','escape'=>false)),
				   array('Label', array('escape'=>false)),
				   array(array('row'=>'HtmlTag'),array('tag'=>'p','id'=>'pecs_company_sizes_add_id'))
           ));
		// create text input for 	event_analyst_attendees_number
		$event_analyst_attendees_number = new Zend_Form_Element_Text('event_analyst_attendees_number');
		$event_analyst_attendees_number->setLabel(' <span>Journalist / Analyst Attendees</span>')
		->setOptions(array('class' => 'listform-field'))
		->addValidator('Int', true,array(
		'messages' => array(
		Zend_Validate_Int::NOT_INT
		=> "Journalist / Analyst Attendees can be numeric only"
		)
		))
		
		->addFilter('StringTrim');
		$event_analyst_attendees_number->setDecorators(array(
                   'ViewHelper',
				   'Errors',
				   array('Label', array('escape'=>false)),
				   array(array('row'=>'HtmlTag'),array('tag'=>'p'))
           ));

		 // create text area for Journalist / Analyst Profile
         $event_analyst_profile = new Zend_Form_Element_Textarea('event_analyst_profile');
         $event_analyst_profile->setLabel(' <span>Journalist / Analyst Profile</span>')
                 ->setOptions(array(
                              'id' => 'event_analyst_profile',
                              'rows' => '3',
                              'cols' => '22',
                   ))
		
		->addFilter('StringTrim');
		
		$event_analyst_profile->setDecorators(array(
                   'ViewHelper',
				   'Errors',
				   array('Label', array('escape'=>false)),
				   array(array('row'=>'HtmlTag'),array('tag'=>'p'))
           ));
		// create radio buttons for event_sponsor_to_speak
        $event_sponsor_to_speak = new Zend_Form_Element_Radio('event_sponsor_to_speak');
		   $event_sponsor_to_speak   ->setSeparator('')
              ->setValue('Maybe')
			  ->setMultiOptions(array(
                    'Yes' => 'Yes',
                    'No' => 'No',
					'Maybe' => 'Maybe'
                ));
        $decorator_radios = new SponsorToSpeakRadios();
        $event_sponsor_to_speak->setDecorators(array($decorator_radios));
		// create select input for event_paper_open_date
		$event_paper_open_date = new Zend_Dojo_Form_Element_DateTextBox('event_paper_open_date');
		$event_paper_open_date->setLabel(' <span>Call For Paper Open</span>');
		$event_paper_open_date->setDecorators(array(
                  'DijitElement',
				  'Errors',
                   array('Label',array('escape'=>false)),
                   array(array('row'=>'HtmlTag'),array('tag'=>'p'))
           ));
		// create select input for event_paper_deadline_date
		$event_paper_deadline_date = new Zend_Dojo_Form_Element_DateTextBox('event_paper_deadline_date');
		$event_paper_deadline_date->setLabel(' <span>Call For Papers Deadline</span>');
		$event_paper_deadline_date->setDecorators(array(
                   'DijitElement',
                   array('Label',array('escape'=>false)),
                   array(array('row'=>'HtmlTag'),array('tag'=>'p'))
           ));
		$end_event_details_block = new end_block('end_event_details_block');
		$heading_Event_Sponsorship_starts_tags = new heading_Event_Sponsorship_starts_tags('heading_Event_Sponsorship_starts_tags');
		// create text input for 	event_prj_total_sponsors
		$event_prj_total_sponsors = new Zend_Form_Element_Text('event_prj_total_sponsors');
		$event_prj_total_sponsors->setLabel(' <span>Projected Total Sponsors</span>')
		->setOptions(array('class' => 'listform-field'))
		->addValidator('Int', true,array(
		'messages' => array(
		Zend_Validate_Int::NOT_INT
		=> "Total Sponsors can be numeric only"
		)
		));
		$event_prj_total_sponsors->setDecorators(array(
                   'ViewHelper',
				   'Errors',
				   array('Label', array('escape' => false)),
				   array(array('row'=>'HtmlTag'),array('tag'=>'p'))
        ));
		

		// create text input for 	event_sponsorship_cost
		$event_sponsorship_cost = new Zend_Form_Element_Textarea('event_sponsorship_cost');
		$event_sponsorship_cost->setLabel(' <span>Sponsorship Levels & Costs</span>')
		 ->setOptions(array(
                              'id' => 'event_sponsorship_cost',
                              'rows' => '5',
                              'cols' => '22',
                   ))
		
		->addFilter('StringTrim');
		$event_sponsorship_cost->setDecorators(array(
                   'ViewHelper',
				   'Errors',
				   array('Label', array('escape' => false)),
				   array(array('row'=>'HtmlTag'),array('tag'=>'p'))
        ));

        $sponsorship_td_starts = new new_td_start('sponsorship_td_starts');
		
		// create select input for Top Sponsors
		$sc_company = new Zend_Form_Element_Multiselect('sc_company');
		$sc_company->setLabel(' <span>Top Sponsors</span>');
		$sc_company->addMultiOption(0, 'Select');
		foreach ($this->get_sponsors() as $c) {
		$sc_company->addMultiOption($c['spn_id'],$c['spn_name']);
		}
		$sc_company->setDecorators(array(
                   'ViewHelper',
				   'Errors',
                   array('Label',array('escape'=>false)),
                   array(array('row'=>'HtmlTag'),array('tag'=>'p'))
           ));
		
		// create text input for sc_company add
		$sc_company_add_id = new Zend_Form_Element_Text('sc_company_add_id');
		$sc_company_add_id->setLabel('<span>&nbsp;</span>')
		->setOptions(array('class' => 'addfield'))
		->setDescription('<a href="javascript:void();" onClick="add_sponsor(\'sc_company\',\'sc_company_add_id\',document.getElementById(\'sc_company_add_id\').value);"><img src="'.SUB_PATH_URL.'/images/add-more.png"></a>')

		
		->addFilter('StringTrim');
		$sc_company_add_id->setDecorators(array(
                   'ViewHelper',
				   'Errors',
				   array('Description',array('tag'=>'span','escape'=>false)),
				   array('Label', array('escape'=>false)),
				   array(array('row'=>'HtmlTag'),array('tag'=>'p','id'=>'psc_company_add_id'))
           ));

		$end_event_sponsorship_block = new end_block('end_event_sponsorship_block');
		$heading_Event_Content_starts_tags = new heading_Event_Content_starts_tags('heading_Event_Content_starts_tags');
		// create text area for event_tracks_sessions
         $event_tracks_sessions = new Zend_Form_Element_Textarea('event_tracks_sessions');
         $event_tracks_sessions->setLabel(' <span>Tracks and Sessions</span>')
                 ->setOptions(array(
                              'id' => 'event_tracks_sessions',
                              'rows' => '5',
                              'cols' => '22',
                   ))
		
		->addFilter('StringTrim');
		
		$event_tracks_sessions->setDecorators(array(
                   'ViewHelper',
				   'Errors',
				   array('Label', array('escape'=>false)),
				   array(array('row'=>'HtmlTag'),array('tag'=>'p'))
           ));
		   
		 // create text area for event_keynote_speakers
         $event_keynote_speakers = new Zend_Form_Element_Textarea('event_keynote_speakers');
         $event_keynote_speakers->setLabel(' <span>Keynote speakers</span>')
                 ->setOptions(array(
                              'id' => 'event_keynote_speakers',
                              'rows' => '5',
                              'cols' => '22',
                   ))
		
		->addFilter('StringTrim');
		$event_keynote_speakers->setDecorators(array(
                   'ViewHelper',
				   'Errors',
				   array('Label', array('escape'=>false)),
				   array(array('row'=>'HtmlTag'),array('tag'=>'p'))
           ));
		   
        $event_content_td_starts = new new_td_start('event_content_td_starts');
		 // create text area for event_other_speakers
         $event_other_speakers = new Zend_Form_Element_Textarea('event_other_speakers');
         $event_other_speakers->setLabel(' <span>Other speakers</span>')
                 ->setOptions(array(
                              'id' => 'event_other_speakers',
                              'rows' => '5',
                              'cols' => '22',
                   ))
		
		->addFilter('StringTrim');
		$event_other_speakers->setDecorators(array(
                   'ViewHelper',
				   'Errors',
				   array('Label', array('escape'=>false)),
				   array(array('row'=>'HtmlTag'),array('tag'=>'p'))
           ));
		$end_event_content_block = new end_block('end_event_content_block');
		$heading_Client_Participation_starts_tags = new heading_Client_Participation_starts_tags('heading_Client_Participation_starts_tags');
		
		// create text input for contact name
		$emip_emp_contact_name = new Zend_Form_Element_Text('emip_emp_contact_name');
		$emip_emp_contact_name->setLabel(' <span><cite>Contact Name</cite></span>')
		->setOptions(array('class' => 'listform-field'))
		
		->addFilter('StringTrim');
		$emip_emp_contact_name->setDecorators(array(
                   'ViewHelper',
				   'Errors',
				   array('Label', array('escape' => false)),
				   array(array('row'=>'HtmlTag'),array('tag'=>'p'))
        ));
		// create text input for title
		$emip_emp_title = new Zend_Form_Element_Text('emip_emp_title');
		$emip_emp_title->setLabel(' <span><cite>Title</cite></span>')
		->setOptions(array('class' => 'listform-field'))
		
		->addFilter('StringTrim');
		$emip_emp_title->setDecorators(array(
                   'ViewHelper',
				   'Errors',
				   array('Label', array('escape' => false)),
				   array(array('row'=>'HtmlTag'),array('tag'=>'p'))
        ));
		// create select input for emip_emp_buss_unit
		$emip_emp_buss_unit = new Zend_Form_Element_Select('emip_emp_buss_unit');
		$emip_emp_buss_unit->setLabel(' <span><cite>Business Unit or Department</cite></span>');
		$emip_emp_buss_unit->addMultiOption('', 'Select');
		foreach ($this->get_populate_fields_records('BUSINESS_UNIT') as $c) {
		$emip_emp_buss_unit->addMultiOption($c['pf_id'],ucfirst($c['pf_name']));
		}
       $emip_emp_buss_unit->setRegisterInArrayValidator(false);
		$emip_emp_buss_unit->setDecorators(array(
                   'ViewHelper',
				   'Errors',
                   array('Label',array('escape'=>false)),
                   array(array('row'=>'HtmlTag'),array('tag'=>'p'))
           ));
		// create text input for $emip_emp_buss_unit additional add
		$emip_emp_buss_unit_add_id = new Zend_Form_Element_Text('emip_emp_buss_unit_add_id');
		$emip_emp_buss_unit_add_id->setLabel('<span>&nbsp;</span>')
		->setOptions(array('class' => 'addfield'))
		->setDescription('<a href="javascript:void();" onClick="add_option(\'emip_emp_buss_unit\',\'emip_emp_buss_unit_add_id\',\'BUSINESS_UNIT\',document.getElementById(\'emip_emp_buss_unit_add_id\').value);"><img src="'.SUB_PATH_URL.'/images/add-more.png"></a>')
		
		->addFilter('StringTrim');
		$emip_emp_buss_unit_add_id->setDecorators(array(
                   'ViewHelper',
				   'Errors',
				   array('Description',array('tag'=>'span','escape'=>false)),
				   array('Label', array('escape'=>false)),
				   array(array('row'=>'HtmlTag'),array('tag'=>'p', 'id'=>'pemip_emp_buss_unit_add_id'))
           ));

		// create text input for emip_emp_email
		$emip_emp_email = new Zend_Form_Element_Text('emip_emp_email');
		$emip_emp_email->setLabel(' <span><cite>Email address</cite></span>')
		->setOptions(array('class' => 'listform-field'))
		->addValidator('EmailAddress', true)
		
		->addFilter('StringTrim');
		$emip_emp_email->setDecorators(array(
                   'ViewHelper',
				   'Errors',
				   array('Label', array('escape' => false)),
				   array(array('row'=>'HtmlTag'),array('tag'=>'p'))
        ));
		// create text input for emip_emp_phone
		$emip_emp_phone = new Zend_Form_Element_Text('emip_emp_phone');
		$emip_emp_phone->setLabel(' <span><cite>Phone number</cite></span>')
		->setOptions(array('class' => 'listform-field'))
		
		->addFilter('StringTrim');
		$emip_emp_phone->setDecorators(array(
                   'ViewHelper',
				   'Errors',
				   array('Label', array('escape' => false)),
				   array(array('row'=>'HtmlTag'),array('tag'=>'p'))
        ));
		// create select input for emip_event_type
		$emip_event_type = new Zend_Form_Element_Select('emip_event_type');
		$emip_event_type->setLabel(' <span>Event Type</span>');
		$emip_event_type->addMultiOption('', 'Select');
		foreach ($this->get_populate_fields_records('EVENT_TYPE') as $c) {
		$emip_event_type->addMultiOption($c['pf_id'],ucfirst($c['pf_name']));
		}

		$emip_event_type->setDecorators(array(
                   'ViewHelper',
				   'Errors',
                   array('Label',array('escape'=>false)),
                   array(array('row'=>'HtmlTag'),array('tag'=>'p'))
           ));
		// create text input for $emip_event_type additional add
		$emip_event_type_add_id = new Zend_Form_Element_Text('emip_event_type_add_id');
		$emip_event_type_add_id->setLabel('<span>&nbsp;</span>')
		->setOptions(array('class' => 'addfield'))
		->setDescription('<a href="javascript:void();" onClick="add_option(\'emip_event_type\',\'emip_event_type_add_id\',\'EVENT_TYPE\',document.getElementById(\'emip_event_type_add_id\').value);"><img src="'.SUB_PATH_URL.'/images/add-more.png"></a>')
		
		->addFilter('StringTrim');
		$emip_event_type_add_id->setDecorators(array(
                   'ViewHelper',
				   'Errors',
				   array('Description',array('tag'=>'span','escape'=>false)),
				   array('Label', array('escape'=>false)),
				   array(array('row'=>'HtmlTag'),array('tag'=>'p', 'id'=>'pemip_event_type_add_id'))
           ));
		//create select input for emip_event_tier
		$emip_event_tier = new Zend_Form_Element_Select('emip_event_tier');
		$emip_event_tier->setLabel(' <span>Event Tier</span>');
		$emip_event_tier->addMultiOption('', 'Select');
		foreach ($this->get_populate_fields_records('EVENT_TIER') as $c) {
		$emip_event_tier->addMultiOption($c['pf_id'],ucfirst($c['pf_name']));
		}

		$emip_event_tier->setDecorators(array(
                   'ViewHelper',
				   'Errors',
                   array('Label',array('escape'=>false)),
                   array(array('row'=>'HtmlTag'),array('tag'=>'p'))
           ));
		//create text input for $emip_event_tier additional add
		$emip_event_tier_add_id = new Zend_Form_Element_Text('emip_event_tier_add_id');
		$emip_event_tier_add_id->setLabel('<span>&nbsp;</span>')
		->setOptions(array('class' => 'addfield'))
		->setDescription('<a href="javascript:void();" onClick="add_option(\'emip_event_tier\',\'emip_event_tier_add_id\',\'EVENT_TIER\',document.getElementById(\'emip_event_tier_add_id\').value);"><img src="'.SUB_PATH_URL.'/images/add-more.png"></a>')
		
		->addFilter('StringTrim');
		$emip_event_tier_add_id->setDecorators(array(
                   'ViewHelper',
				   'Errors',
				   array('Description',array('tag'=>'span','escape'=>false)),
				   array('Label', array('escape'=>false)),
				   array(array('row'=>'HtmlTag'),array('tag'=>'p', 'id'=>'pemip_event_tier_add_id'))
           ));
		// create select input for emip_primary_event_objective
		$emip_primary_event_objective = new Zend_Form_Element_Select('emip_primary_event_objective');
		$emip_primary_event_objective->setLabel(' <span>Primary Event Objective</span>');
		$emip_primary_event_objective->addMultiOption('', 'Select');
		foreach ($this->get_populate_fields_records('PRIMARY_EVENT_OBJECTIVE') as $c) {
		$emip_primary_event_objective->addMultiOption($c['pf_id'],ucfirst($c['pf_name']));
		}

		$emip_primary_event_objective->setDecorators(array(
                   'ViewHelper',
				   'Errors',
                   array('Label',array('escape'=>false)),
                   array(array('row'=>'HtmlTag'),array('tag'=>'p'))
           ));
		// create text input for $emip_primary_event_objective additional add
		$emip_primary_event_objective_add_id = new Zend_Form_Element_Text('emip_primary_event_objective_add_id');
		$emip_primary_event_objective_add_id->setLabel('<span>&nbsp;</span>')
		->setOptions(array('class' => 'addfield'))
		->setDescription('<a href="javascript:void();" onClick="add_option(\'emip_primary_event_objective\',\'emip_primary_event_objective_add_id\',\'PRIMARY_EVENT_OBJECTIVE\',document.getElementById(\'emip_primary_event_objective_add_id\').value);"><img src="'.SUB_PATH_URL.'/images/add-more.png"></a>')
		
		->addFilter('StringTrim');
		$emip_primary_event_objective_add_id->setDecorators(array(
                   'ViewHelper',
				   'Errors',
				   array('Description',array('tag'=>'span','escape'=>false)),
				   array('Label', array('escape'=>false)),
				   array(array('row'=>'HtmlTag'),array('tag'=>'p', 'id'=>'pemip_primary_event_objective_add_id'))
           ));
		// create select input for emip_campaign_alignment
		$emip_campaign_alignment = new Zend_Form_Element_Select('emip_campaign_alignment');
		$emip_campaign_alignment->setLabel(' <span>Campaign alignment</span>');
		$emip_campaign_alignment->addMultiOption('', 'Select');
		foreach ($this->get_populate_fields_records('CAMPAIGN_ALIGNMENT') as $c) {
		$emip_campaign_alignment->addMultiOption($c['pf_id'],ucfirst($c['pf_name']));
		}

		$emip_campaign_alignment->setDecorators(array(
                   'ViewHelper',
				   'Errors',
                   array('Label',array('escape'=>false)),
                   array(array('row'=>'HtmlTag'),array('tag'=>'p'))
           ));
		// create text input for $emip_campaign_alignment additional add
		$emip_campaign_alignment_add_id = new Zend_Form_Element_Text('emip_campaign_alignment_add_id');
		$emip_campaign_alignment_add_id->setLabel('<span>&nbsp;</span>')
		->setOptions(array('class' => 'addfield'))
		->setDescription('<a href="javascript:void();" onClick="add_option(\'emip_campaign_alignment\',\'emip_campaign_alignment_add_id\',\'CAMPAIGN_ALIGNMENT\',document.getElementById(\'emip_campaign_alignment_add_id\').value);"><img src="'.SUB_PATH_URL.'/images/add-more.png"></a>')
		
		->addFilter('StringTrim');
		$emip_campaign_alignment_add_id->setDecorators(array(
                   'ViewHelper',
				   'Errors',
				   array('Description',array('tag'=>'span','escape'=>false)),
				   array('Label', array('escape'=>false)),
				   array(array('row'=>'HtmlTag'),array('tag'=>'p', 'id'=>'pemip_campaign_alignment_add_id'))
           ));
		// create select input for emip_customer_target
		$emip_customer_target = new Zend_Form_Element_Select('emip_customer_target');
		$emip_customer_target->setLabel(' <span>Customer Target</span>');
		$emip_customer_target->addMultiOption('', 'Select');
		foreach ($this->get_populate_fields_records('CUSTOMER_TARGET') as $c) {
		$emip_customer_target->addMultiOption($c['pf_id'],ucfirst($c['pf_name']));
		}

		$emip_customer_target->setDecorators(array(
                   'ViewHelper',
				   'Errors',
                   array('Label',array('escape'=>false)),
                   array(array('row'=>'HtmlTag'),array('tag'=>'p'))
           ));
		// create text input for $emip_customer_target additional add
		$emip_customer_target_add_id = new Zend_Form_Element_Text('emip_customer_target_add_id');
		$emip_customer_target_add_id->setLabel('<span>&nbsp;</span>')
		->setOptions(array('class' => 'addfield'))
		->setDescription('<a href="javascript:void();" onClick="add_option(\'emip_customer_target\',\'emip_customer_target_add_id\',\'CUSTOMER_TARGET\',document.getElementById(\'emip_customer_target_add_id\').value);"><img src="'.SUB_PATH_URL.'/images/add-more.png"></a>')
		
		->addFilter('StringTrim');
		$emip_customer_target_add_id->setDecorators(array(
                   'ViewHelper',
				   'Errors',
				   array('Description',array('tag'=>'span','escape'=>false)),
				   array('Label', array('escape'=>false)),
				   array(array('row'=>'HtmlTag'),array('tag'=>'p', 'id'=>'pemip_customer_target_add_id'))
           ));
		// create select input for Geographies 
		$eg_geo_id = new Zend_Form_Element_Multiselect('eg_geo_id');
		$eg_geo_id->setLabel(' <span>Geographies</span>');
		$eg_geo_id->addMultiOption('', 'Select');
		foreach ($this->get_populate_fields_records('GEOGRAPHIES') as $c) {
		$eg_geo_id->addMultiOption($c['pf_id'],ucfirst($c['pf_name']));
		}

		$eg_geo_id->setDecorators(array(
                   'ViewHelper',
				   'Errors',
                   array('Label',array('escape'=>false)),
                   array(array('row'=>'HtmlTag'),array('tag'=>'p'))
           ));
		// create text input for eg_geo_idadditional add
		$eg_geo_id_add_id = new Zend_Form_Element_Text('eg_geo_id_add_id');
		$eg_geo_id_add_id->setLabel('<span>&nbsp;</span>')
	    ->setOptions(array('class' => 'addfield'))
		->setDescription('<a href="javascript:void();" onClick="add_option(\'eg_geo_id\',\'eg_geo_id_add_id\',\'GEOGRAPHIES\',document.getElementById(\'eg_geo_id_add_id\').value);"><img src="'.SUB_PATH_URL.'/images/add-more.png"></a>')
		
		->addFilter('StringTrim');
		$eg_geo_id_add_id->setDecorators(array(
                   'ViewHelper',
				   'Errors',
				   array('Description',array('tag'=>'span','escape'=>false)),
				   array('Label', array('escape'=>false)),
				   array(array('row'=>'HtmlTag'),array('tag'=>'p','id'=>'peg_geo_id_add_id'))
           ));
		// create select input for emip_business_unit
		$emip_business_unit = new Zend_Form_Element_Select('emip_business_unit');
		$emip_business_unit->setLabel(' <span>Business Unit</span>');
		$emip_business_unit->addMultiOption('', 'Select');
		foreach ($this->get_populate_fields_records('BUSINESS_UNIT') as $c) {
		$emip_business_unit->addMultiOption($c['pf_id'],ucfirst($c['pf_name']));
		}

		$emip_business_unit->setDecorators(array(
                   'ViewHelper',
				   'Errors',
                   array('Label',array('escape'=>false)),
                   array(array('row'=>'HtmlTag'),array('tag'=>'p'))
           ));
		// create text input for $emip_business_unit additional add
		$emip_business_unit_add_id = new Zend_Form_Element_Text('emip_business_unit_add_id');
		$emip_business_unit_add_id->setLabel('<span>&nbsp;</span>')
		->setOptions(array('class' => 'addfield'))
		->setDescription('<a href="javascript:void();" onClick="add_option(\'emip_business_unit\',\'emip_business_unit_add_id\',\'BUSINESS_UNIT\',document.getElementById(\'emip_business_unit_add_id\').value);"><img src="'.SUB_PATH_URL.'/images/add-more.png"></a>')
		
		->addFilter('StringTrim');
		$emip_business_unit_add_id->setDecorators(array(
                   'ViewHelper',
				   'Errors',
				   array('Description',array('tag'=>'span','escape'=>false)),
				   array('Label', array('escape'=>false)),
				   array(array('row'=>'HtmlTag'),array('tag'=>'p', 'id'=>'pemip_business_unit_add_id'))
           ));
		// create select input for emip_sector_industries
		$emip_sector_industries = new Zend_Form_Element_Select('emip_sector_industries');
		$emip_sector_industries->setLabel(' <span>Sector/Industries</span>');
		$emip_sector_industries->addMultiOption('', 'Select');
		foreach ($this->get_populate_fields_records('SECTOR_INDUSTRY') as $c) {
		$emip_sector_industries->addMultiOption($c['pf_id'],ucfirst($c['pf_name']));
		}

		$emip_sector_industries->setDecorators(array(
                   'ViewHelper',
				   'Errors',
                   array('Label',array('escape'=>false)),
                   array(array('row'=>'HtmlTag'),array('tag'=>'p'))
           ));
		// create text input for $emip_sector_industries additional add
		$emip_sector_industries_add_id = new Zend_Form_Element_Text('emip_sector_industries_add_id');
		$emip_sector_industries_add_id->setLabel('<span>&nbsp;</span>')
		->setOptions(array('class' => 'addfield'))
		->setDescription('<a href="javascript:void();" onClick="add_option(\'emip_sector_industries\',\'emip_sector_industries_add_id\',\'SECTOR_INDUSTRY\',document.getElementById(\'emip_sector_industries_add_id\').value);"><img src="'.SUB_PATH_URL.'/images/add-more.png"></a>')
		
		->addFilter('StringTrim');
		$emip_sector_industries_add_id->setDecorators(array(
                   'ViewHelper',
				   'Errors',
				   array('Description',array('tag'=>'span','escape'=>false)),
				   array('Label', array('escape'=>false)),
				   array(array('row'=>'HtmlTag'),array('tag'=>'p', 'id'=>'pemip_sector_industries_add_id'))
           ));
        $client_participation_td_starts = new new_td_start('client_participation_td_starts');
		$heading_Proposed_section  = new heading_Proposed_section('heading_Proposed_section');
		//Create select buttons for Contracted
		$emp_status = new Zend_Form_Element_Select('emp_status');
		$emp_status->setLabel(' <span><cite>Status</cite></span>');
		$emp_status->addMultiOption(NULL, 'Select');
		$emp_status->addMultiOption('Considering','Considering');
		$emp_status->addMultiOption('Contracted','Contracted');
		$emp_status->setDecorators(array(
                   'ViewHelper',
				   'Errors',
                   array('Label',array('escape'=>false)),
                   array(array('row'=>'HtmlTag'),array('tag'=>'p'))
           ));
        // create text input for Sponsorship Level Cost
		$emip_sponsorship_level_cost = new Zend_Form_Element_Text('emip_sponsorship_level_cost');
		$emip_sponsorship_level_cost->setLabel(' <span><cite>Sponsorship Level Cost</cite></span>')
		->setOptions(array('class' => 'listform-field'))
		->addValidator('regex', false, array( 'pattern'=>'/^([0-9]*|\d*\.\d{1}?\d*)$/',
		'messages'=>array('regexNotMatch'=>'can be in decimal format only')
		));
		$emip_sponsorship_level_cost->setDecorators(array(
                   'ViewHelper',
				   'Errors',
				   array('Label', array('escape' => false)),
				   array(array('row'=>'HtmlTag'),array('tag'=>'p'))
        ));
		// create text input for emip_proposed_booth_space
		$emip_proposed_booth_space = new Zend_Form_Element_Text('emip_proposed_booth_space');
		$emip_proposed_booth_space->setLabel(' <span><cite>Booth Space</cite></span>')
		->setOptions(array('class' => 'listform-field'))
		->addValidator('regex', false, array( 'pattern'=>'/^([0-9]*|\d*\.\d{1}?\d*)$/',
		'messages'=>array('regexNotMatch'=>'can be in decimal format only')
		));
		$emip_proposed_booth_space->setDecorators(array(
                   'ViewHelper',
				   'Errors',
				   array('Label', array('escape' => false)),
				   array(array('row'=>'HtmlTag'),array('tag'=>'p'))
        ));
		 // create text area for emip_branding_opportunities
         $emip_branding_opportunities = new Zend_Form_Element_Textarea('emip_branding_opportunities');
         $emip_branding_opportunities->setLabel(' <span><cite>Branding Opportunities</cite></span>')
                 ->setOptions(array(
                              'id' => 'emip_branding_opportunities',
                              'rows' => '3',
                              'cols' => '22',
                   ))
		
		->addFilter('StringTrim');
		$emip_branding_opportunities->setDecorators(array(
                   'ViewHelper',
				   'Errors',
				   array('Label', array('escape'=>false)),
				   array(array('row'=>'HtmlTag'),array('tag'=>'p'))
           ));
		 // create text area for emip_speaking_opportunities
         $emip_speaking_opportunities = new Zend_Form_Element_Textarea('emip_speaking_opportunities');
         $emip_speaking_opportunities->setLabel(' <span><cite>Speaking Opportunities</cite></span>')
                 ->setOptions(array(
                              'id' => 'emip_speaking_opportunities',
                              'rows' => '3',
                              'cols' => '22',
                   ))
		
		->addFilter('StringTrim');
		$emip_speaking_opportunities->setDecorators(array(
                   'ViewHelper',
				   'Errors',
				   array('Label', array('escape'=>false)),
				   array(array('row'=>'HtmlTag'),array('tag'=>'p'))
           ));
		 // create text input for emip_client_speaker
		$emip_client_speaker = new Zend_Form_Element_Text('emip_client_speaker');
		$emip_client_speaker->setLabel(' <span><cite>Client Speaker</cite></span>')
		->setOptions(array('class' => 'listform-field'))
		
		->addFilter('StringTrim');
		$emip_client_speaker->setDecorators(array(
                   'ViewHelper',
				   'Errors',
				   array('Label', array('escape' => false)),
				   array(array('row'=>'HtmlTag'),array('tag'=>'p'))
        ));
		 // create text area for emip_key_message
         $emip_key_message = new Zend_Form_Element_Textarea('emip_key_message');
         $emip_key_message->setLabel(' <span><cite>Key Message / theme for overall event</cite></span>')
                 ->setOptions(array(
                              'id' => 'emip_key_message',
                              'rows' => '3',
                              'cols' => '22',
                   ))
		
		->addFilter('StringTrim');
		$emip_key_message->setDecorators(array(
                   'ViewHelper',
				   'Errors',
				   array('Label', array('escape'=>false)),
				   array(array('row'=>'HtmlTag'),array('tag'=>'p'))
           ));
		 // create text area for emip_demo_plan
         $emip_demo_plan = new Zend_Form_Element_Textarea('emip_demo_plan');
         $emip_demo_plan->setLabel(' <span><cite>Demo plan</cite></span>')
                 ->setOptions(array(
                              'id' => 'emip_demo_plan',
                              'rows' => '3',
                              'cols' => '22',
                   ))
		
		->addFilter('StringTrim');
		$emip_demo_plan->setDecorators(array(
                   'ViewHelper',
				   'Errors',
				   array('Label', array('escape'=>false)),
				   array(array('row'=>'HtmlTag'),array('tag'=>'p'))
           ));
		 // create text area for emip_partner_participation
         $emip_partner_participation = new Zend_Form_Element_Textarea('emip_partner_participation');
         $emip_partner_participation->setLabel(' <span><cite>Partner participation</cite></span>')
                 ->setOptions(array(
                              'id' => 'emip_partner_participation',
                              'rows' => '3',
                              'cols' => '22',
                   ))
		
		->addFilter('StringTrim');
		$emip_partner_participation->setDecorators(array(
                   'ViewHelper',
				   'Errors',
				   array('Label', array('escape'=>false)),
				   array(array('row'=>'HtmlTag'),array('tag'=>'p'))
           ));
		$end_client_participation_block = new end_block('end_client_participation_block');
		$heading_cost_starts_tags =  new heading_cost_starts_tags('heading_cost_starts_tags');
		// create text input for emi_booth_space
		$emip_booth_space = new Zend_Form_Element_Text('emip_booth_space');
		$emip_booth_space->setLabel(' <span>Booth Space</span>')
		->setOptions(array('class' => 'listform-field'))
		->addValidator('regex', false, array( 'pattern'=>'/^([0-9]*|\d*\.\d{1}?\d*)$/',
		'messages'=>array('regexNotMatch'=>'can be in decimal format only')
		));
		$emip_booth_space->setDecorators(array(
                   'ViewHelper',
				   'Errors',
				   array('Label', array('escape' => false)),
				   array(array('row'=>'HtmlTag'),array('tag'=>'p'))
        ));
		// create text input for emip_sponsorships
		$emip_sponsorships = new Zend_Form_Element_Text('emip_sponsorships');
		$emip_sponsorships->setLabel(' <span>Sponsorships</span>')
		->setOptions(array('class' => 'listform-field'))
		->addValidator('regex', false, array( 'pattern'=>'/^([0-9]*|\d*\.\d{1}?\d*)$/',
		'messages'=>array('regexNotMatch'=>'can be in decimal format only')
		));
		$emip_sponsorships->setDecorators(array(
                   'ViewHelper',
				   'Errors',
				   array('Label', array('escape' => false)),
				   array(array('row'=>'HtmlTag'),array('tag'=>'p'))
        )); 
		// create text input for emip_marketing_opportunities
		$emip_marketing_opportunities = new Zend_Form_Element_Text('emip_marketing_opportunities');
		$emip_marketing_opportunities->setLabel(' <span>Marketing Opportunities</span>')
		->setOptions(array('class' => 'listform-field'))
		->addValidator('regex', false, array( 'pattern'=>'/^([0-9]*|\d*\.\d{1}?\d*)$/',
		'messages'=>array('regexNotMatch'=>'can be in decimal format only')
		));
		$emip_marketing_opportunities->setDecorators(array(
                   'ViewHelper',
				   'Errors',
				   array('Label', array('escape' => false)),
				   array(array('row'=>'HtmlTag'),array('tag'=>'p'))
        ));
		// create text input for emip_venue_costs
		$emip_venue_costs = new Zend_Form_Element_Text('emip_venue_costs');
		$emip_venue_costs->setLabel(' <span>Venue Costs</span>')
		->setOptions(array('class' => 'listform-field'))
		->addValidator('regex', false, array( 'pattern'=>'/^([0-9]*|\d*\.\d{1}?\d*)$/',
		'messages'=>array('regexNotMatch'=>'can be in decimal format only')
		));
		$emip_venue_costs->setDecorators(array(
                   'ViewHelper',
				   'Errors',
				   array('Label', array('escape' => false)),
				   array(array('row'=>'HtmlTag'),array('tag'=>'p'))
        ));
		// create text input for emip_production
		$emip_production = new Zend_Form_Element_Text('emip_production');
		$emip_production->setLabel(' <span>Production</span>')
		->setOptions(array('class' => 'listform-field'))
		->addValidator('regex', false, array( 'pattern'=>'/^([0-9]*|\d*\.\d{1}?\d*)$/',
		'messages'=>array('regexNotMatch'=>'can be in decimal format only')
		));
		$emip_production->setDecorators(array(
                   'ViewHelper',
				   'Errors',
				   array('Label', array('escape' => false)),
				   array(array('row'=>'HtmlTag'),array('tag'=>'p'))
        ));
		// create text input for emip_housing_transportation_air
		$emip_housing_transportation_air = new Zend_Form_Element_Text('emip_housing_transportation_air');
		$emip_housing_transportation_air->setLabel(' <span>Housing / Transportation / Air</span>')
		->setOptions(array('class' => 'listform-field'))
		->addValidator('regex', false, array( 'pattern'=>'/^([0-9]*|\d*\.\d{1}?\d*)$/',
		'messages'=>array('regexNotMatch'=>'can be in decimal format only')
		));
		$emip_housing_transportation_air->setDecorators(array(
                   'ViewHelper',
				   'Errors',
				   array('Label', array('escape' => false)),
				   array(array('row'=>'HtmlTag'),array('tag'=>'p'))
        ));
		// create text input for emip_food_beverage
		$emip_food_beverage = new Zend_Form_Element_Text('emip_food_beverage');
		$emip_food_beverage->setLabel(' <span>Food and Beverage</span>')
		->setOptions(array('class' => 'listform-field'))
		->addValidator('regex', false, array( 'pattern'=>'/^([0-9]*|\d*\.\d{1}?\d*)$/',
		'messages'=>array('regexNotMatch'=>'can be in decimal format only')
		));

		$emip_food_beverage->setDecorators(array(
                   'ViewHelper',
				   'Errors',
				   array('Label', array('escape' => false)),
				   array(array('row'=>'HtmlTag'),array('tag'=>'p'))
        ));
		// create text input for emip_external_speakers
		$emip_external_speakers = new Zend_Form_Element_Text('emip_external_speakers');
		$emip_external_speakers->setLabel(' <span>External Speakers</span>')
		->setOptions(array('class' => 'listform-field'))
		->addValidator('regex', false, array( 'pattern'=>'/^([0-9]*|\d*\.\d{1}?\d*)$/',
		'messages'=>array('regexNotMatch'=>'can be in decimal format only')
		));
		$emip_external_speakers->setDecorators(array(
                   'ViewHelper',
				   'Errors',
				   array('Label', array('escape' => false)),
				   array(array('row'=>'HtmlTag'),array('tag'=>'p'))
        ));
		// create text input for emip_experience_design_costs
		$emip_experience_design_costs = new Zend_Form_Element_Text('emip_experience_design_costs');
		$emip_experience_design_costs->setLabel(' <span>Experience Design costs</span>')
		->setOptions(array('class' => 'listform-field'))
		->addValidator('regex', false, array( 'pattern'=>'/^([0-9]*|\d*\.\d{1}?\d*)$/',
		'messages'=>array('regexNotMatch'=>'can be in decimal format only')
		));

		$emip_experience_design_costs->setDecorators(array(
                   'ViewHelper',
				   'Errors',
				   array('Label', array('escape' => false)),
				   array(array('row'=>'HtmlTag'),array('tag'=>'p'))
        ));
		// create text input for emip_audience_generation_costs
		$emip_audience_generation_costs = new Zend_Form_Element_Text('emip_audience_generation_costs');
		$emip_audience_generation_costs->setLabel(' <span>Audience Generation costs</span>')
		->setOptions(array('class' => 'listform-field'))
		->addValidator('regex', false, array( 'pattern'=>'/^([0-9]*|\d*\.\d{1}?\d*)$/',
		'messages'=>array('regexNotMatch'=>'can be in decimal format only')
		));
		$emip_audience_generation_costs->setDecorators(array(
                   'ViewHelper',
				   'Errors',
				   array('Label', array('escape' => false)),
				   array(array('row'=>'HtmlTag'),array('tag'=>'p'))
        ));
		// create text input for emip_collateral_costs
		$emip_collateral_costs = new Zend_Form_Element_Text('emip_collateral_costs');
		$emip_collateral_costs->setLabel(' <span>Collateral costs</span>')
		->setOptions(array('class' => 'listform-field'))
		->addValidator('regex', false, array( 'pattern'=>'/^([0-9]*|\d*\.\d{1}?\d*)$/',
		'messages'=>array('regexNotMatch'=>'can be in decimal format only')
		));
		$emip_collateral_costs->setDecorators(array(
                   'ViewHelper',
				   'Errors',
				   array('Label', array('escape' => false)),
				   array(array('row'=>'HtmlTag'),array('tag'=>'p'))
        ));
		$cost_info_td_starts = new new_td_start('cost_info_td_starts');
		$heading_KPI_section = new heading_KPI_section('heading_KPI_section');
		// create text input for emf_number_of_leads
		$emf_number_of_leads = new Zend_Form_Element_Text('emf_number_of_leads');
		$emf_number_of_leads->setLabel(' <span><cite>Number of leads</cite></span>')
		->setOptions(array('class' => 'listform-field'))
	    ->addValidator('Int', true,array(
		'messages' => array(
		Zend_Validate_Int::NOT_INT
		=> "Number of leads can be numeric only"
		)
		));
		$emf_number_of_leads->setDecorators(array(
                   'ViewHelper',
				   'Errors',
				   array('Label', array('escape' => false)),
				   array(array('row'=>'HtmlTag'),array('tag'=>'p'))
        ));
		// create text input for emf_number_of_staff
		$emf_number_of_staff = new Zend_Form_Element_Text('emf_number_of_staff');
		$emf_number_of_staff->setLabel(' <span><cite>Number of staff needed for the event</cite></span>')
		->setOptions(array('class' => 'listform-field'))
		->addValidator('Int', true,array(
		'messages' => array(
		Zend_Validate_Int::NOT_INT
		=> "Number of staff can be numeric only"
		)
		));
		$emf_number_of_staff->setDecorators(array(
                   'ViewHelper',
				   'Errors',
				   array('Label', array('escape' => false)),
				   array(array('row'=>'HtmlTag'),array('tag'=>'p'))
        ));

		$end_cost_block = new end_block('end_cost_block');
		
		$submit_save = new Zend_Form_Element_Submit('submit_save');
		$submit_save->setLabel('Save')
		->setOptions(array('class' => 'optional-button'));
		$submit_save->setDecorators(array(
        'ViewHelper',
        'Description',
        'Errors'
      ));
	  	
		// create checkbox for status_checkbox
         $event_status = new Zend_Form_Element_MultiCheckbox('event_status');
         $event_status->setSeparator('')
                 ->setMultiOptions(array(
                       'Publish' => 'Publish'
					   ));
		$decorator_checks_st = new status_checkbox();
        $event_status->setDecorators(array($decorator_checks_st));	
			
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
		 ->addElement($event_name)
		 ->addElement($event_producer)
		 ->addElement($event_person_virtual)
		 ->addElement($event_start_date)
		 ->addElement($event_end_date)
		 ->addElement($event_exh_start_date)
		 ->addElement($event_exh_end_date)
		 ->addElement($event_url)
		 ->addElement($event_focus)
		 ->addElement($basic_info_td_starts)
		 ->addElement($event_co_located_event)
		 ->addElement($event_venue)
		 ->addElement($event_region)
		 ->addElement($event_region_add_id)
		 ->addElement($event_country_id)
		 ->addElement($event_state_id)
		 ->addElement($event_city)
		 ->addElement($event_frequency)
		 ->addElement($event_frequency_add_id)
		 ->addElement($end_basic_info_block)
		 ->addElement($heading_event_details_starts_tags)
		 ->addElement($event_format)
		 ->addElement($event_format_add_id)
		 ->addElement($event_number_attendees)
		 ->addElement($ei_industry)
		 ->addElement($ei_industry_add_id)
		 ->addElement($heading_Audience_Profile)
		 ->addElement($event_audience_profile)
		 ->addElement($event_audience_type)
		 ->addElement($event_audience_type_add_id)
		 ->addElement($event_audience_title)
		 ->addElement($event_audience_title_add_id)
		 ->addElement($event_new_td_starts)
		 ->addElement($ecs_company_sizes)
		 ->addElement($ecs_company_sizes_add_id)
		 ->addElement($event_analyst_attendees_number)
		 ->addElement($event_analyst_profile)
		 ->addElement($event_sponsor_to_speak)
		 ->addElement($event_paper_open_date)
		 ->addElement($event_paper_deadline_date)
		 ->addElement($end_event_details_block)
		 ->addElement($heading_Event_Sponsorship_starts_tags)
		 ->addElement($event_prj_total_sponsors)
		 ->addElement($event_sponsorship_cost)
		 ->addElement($sponsorship_td_starts)
		 ->addElement($sc_company)
		 ->addElement($sc_company_add_id)
		 ->addElement($end_event_sponsorship_block)
		 ->addElement($heading_Event_Content_starts_tags)
		 ->addElement($event_tracks_sessions)
		 ->addElement($event_keynote_speakers)
		 ->addElement($event_content_td_starts)
		 ->addElement($event_other_speakers)
		 ->addElement($end_event_content_block)
		 ->addElement($heading_Client_Participation_starts_tags)
		 ->addElement($emip_emp_contact_name)
		 ->addElement($emip_emp_title)
		 ->addElement($emip_emp_buss_unit)
		 ->addElement($emip_emp_buss_unit_add_id)
		 ->addElement($emip_emp_email)
		 ->addElement($emip_emp_phone)
		 ->addElement($emip_event_type)
		 ->addElement($emip_event_type_add_id)
		 ->addElement($emip_event_tier)
		 ->addElement($emip_event_tier_add_id)
		 ->addElement($emip_primary_event_objective)
		 ->addElement($emip_primary_event_objective_add_id)
		 ->addElement($emip_campaign_alignment)
		 ->addElement($emip_campaign_alignment_add_id)
		 ->addElement($emip_customer_target)
		 ->addElement($emip_customer_target_add_id)
		 ->addElement($eg_geo_id)
		 ->addElement($eg_geo_id_add_id)
		 ->addElement($emip_business_unit)
		 ->addElement($emip_business_unit_add_id)
		 ->addElement($emip_sector_industries)
		 ->addElement($emip_sector_industries_add_id)
		 ->addElement($client_participation_td_starts)
		 ->addElement($heading_Proposed_section)
		 ->addElement($emp_status)
		 ->addElement($emip_sponsorship_level_cost)
		 ->addElement($emip_proposed_booth_space)
		 ->addElement($emip_branding_opportunities)
		 ->addElement($emip_speaking_opportunities)
		 ->addElement($emip_client_speaker)
		 ->addElement($emip_key_message)
		 ->addElement($emip_demo_plan)
		 ->addElement($emip_partner_participation)
		 ->addElement($end_client_participation_block)
		 ->addElement($heading_cost_starts_tags)
		 ->addElement($emip_booth_space)
		 ->addElement($emip_sponsorships)
		 ->addElement($emip_marketing_opportunities)
		 ->addElement($emip_venue_costs)
		 ->addElement($emip_production)
		 ->addElement($emip_housing_transportation_air)
		 ->addElement($emip_food_beverage)
		 ->addElement($emip_external_speakers)
		 ->addElement($emip_experience_design_costs)
		 ->addElement($emip_audience_generation_costs)
		 ->addElement($emip_collateral_costs)
		 ->addElement($cost_info_td_starts)
		 ->addElement($heading_KPI_section)
		 ->addElement($emf_number_of_leads)
		 ->addElement($emf_number_of_staff)
		 ->addElement($end_cost_block)
		 ->addElement($event_status)
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
	public function get_industries() {
		$q = Doctrine_Query::create()
		->from('Med_Model_Industries p')
		->where('p.ind_cmp_id= ?','0');
		if($this->company_specific >0 ){
		    $q->orWhere('p.ind_cmp_id= ?',$this->company_specific);
			
		}
		$q->orderBy('p.ind_name ASC');
		return $q->fetchArray();
	}
    public function get_sponsors() {
		$q = Doctrine_Query::create()
		->from('Med_Model_Sponsors s')
		->where('s.spn_cmp_id= ?','0');
		if($this->company_specific >0 ){
		    $q->orWhere('s.spn_cmp_id = ?',$this->company_specific);
			
		}
		$q->orderBy('s.spn_name ASC');
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
    return '<h2><img src="'.SUB_PATH_URL.'/images/down-arrow.gif">Basic Information</h2><div id="basic_info"><table  border="0" cellpadding="0" cellspacing="0" width="100%"><tr><td valign="top" width="140px">&nbsp;</td><td width="497px">';        
	}
}
class new_td_start extends Zend_Form_Element
{
	public function render(Zend_View_Interface $view = null)
    {
    return '</td><td valign="top" width="497px" >';        
	}
}
class end_block extends Zend_Form_Element
{
	public function render(Zend_View_Interface $view = null)
    {
    return '</td><td valign="top" width="50px">&nbsp;</td></tr></table></div>';        
	}
}

class heading_event_details_starts_tags extends Zend_Form_Element
{
	public function render(Zend_View_Interface $view = null)
    {
    return '<h2><img src="'.SUB_PATH_URL.'/images/down-arrow.gif">Event Details</h2><div id="event_details_info"><table  border="0" cellpadding="0" cellspacing="0" width="100%"><tr><td valign="top" width="140px">&nbsp;</td><td valign="top" width="497px">';        
	}
}
class heading_Event_Sponsorship_starts_tags extends Zend_Form_Element
{
	public function render(Zend_View_Interface $view = null)
    {
    return '<h2><img src="'.SUB_PATH_URL.'/images/down-arrow.gif">Event Sponsorship</h2><div id="event_sponsorship_info"><table  border="0" cellpadding="0" cellspacing="0" width="100%"><tr><td valign="top" width="140px">&nbsp;</td><td valign="top" width="497px">';        
	}
}
class heading_Event_Content_starts_tags extends Zend_Form_Element
{
	public function render(Zend_View_Interface $view = null)
    {
    return '<h2><img src="'.SUB_PATH_URL.'/images/down-arrow.gif">Event Content</h2><div id="event_content_info"><table  border="0" cellpadding="0" cellspacing="0" width="100%"><tr><td valign="top" width="140px">&nbsp;</td><td valign="top" width="497px">';        
	}
}
class heading_Client_Participation_starts_tags extends Zend_Form_Element
{
	public function render(Zend_View_Interface $view = null)
    {
    return '<h2><img src="'.SUB_PATH_URL.'/images/down-arrow.gif">Client Participation</h2><div id="client_participation_info"><table  border="0" cellpadding="0" cellspacing="0" width="100%"><tr><td valign="top" width="140px">&nbsp;</td><td valign="top" width="497px"><p><label><span>Employee Event Contact For Each Event</span></label></p>';        
	}
}
class heading_cost_starts_tags extends Zend_Form_Element
{
	public function render(Zend_View_Interface $view = null)
    {
    return '<h2><img src="'.SUB_PATH_URL.'/images/down-arrow.gif">Cost</h2><div id="event_cost_info"><table  border="0" cellpadding="0" cellspacing="0" width="100%"><tr><td valign="top" width="140px">&nbsp;</td><td valign="top" width="497px">';        
	}
}
class heading_Audience_Profile extends Zend_Form_Element
{
	public function render(Zend_View_Interface $view = null)
    {
    return '<p><span><strong>Audience Profile</strong></span></p>';        
	}
}
class heading_KPI_section extends Zend_Form_Element
{
	public function render(Zend_View_Interface $view = null)
    {
    return '<p><span><strong>KPI Section</strong></span></p>';        
	}
}
class heading_Proposed_section extends Zend_Form_Element
{
	public function render(Zend_View_Interface $view = null)
    {
    return '<p><span><strong>Proposed Participation Plan (costs)</strong></span></p>';        
	}
}

class SponsorToSpeakRadios extends Zend_Form_Decorator_Abstract
{	
    public function render($content)
    {
		 $element   = $this->getElement();
		 $sel_value = $element->getValue();
	     if (null === ($view = $element->getView())) {
            return $content;
         }
		 $baseName = $element->getName();
         $html ="<p><label><span>Must client sponsor to speak</span></label>";
		 foreach ($element->getMultiOptions() as $key => $key) {
		     if($sel_value == $key ){
			   $checked= "checked";
			 }else{
			   $checked = '';
			 }
			 $html.='<input type="radio" name="'.$baseName.'" value="'.$key.'"  '.$checked.' >'.$key;
         }
		 $html.="</p>";
		 return $html;
    }

}

class person_virtual_checkboxes extends Zend_Form_Decorator_Abstract
{	
    public function render($content)
    {
		 $element = $this->getElement();
		 $values   = (array) $element->getValue();
	      if (null === ($view = $element->getView())) {
            return $content;
          }
		$html ="<label><span>In person / Virtual</span></label>";
        foreach ($element->getMultiOptions() as $key => $value) {
		  if(in_array($key,$values)){
		     $checked = "checked";
		  }else{
		     $checked = "";
		  }
		  $html.='<input type="checkbox" name="event_person_virtual[]" value="'.$key.'"  '.$checked.'>'.$value;
        }
		return $html;
    }

}

class status_checkbox extends Zend_Form_Decorator_Abstract
{	
    public function render($content)
    {
		 $element = $this->getElement();
		 $values   = (array) $element->getValue();
	      if (null === ($view = $element->getView())) {
            return $content;
          }
        foreach ($element->getMultiOptions() as $key => $value) {
		  if(in_array($key,$values)){
		     $checked = "checked";
		  }else{
		     $checked = "";
		  }
		  $html.='<div class="green-line"><br><input type="checkbox" name="event_status" value="'.$key.'"  '.$checked.'>Publish<br/><br/>';
        }
		return $html;
    }

}

class Url_Validator extends Zend_Validate_Abstract
{
    const INVALID_URL = 'invalidUrl';
 
    protected $_messageTemplates = array(
        self::INVALID_URL   => "Please enter valid URL",
    );
 
    public function isValid($value)
    {
        $valueString = (string) $value;
        $this->_setValue($valueString);
 
        if (!Zend_Uri::check($value)) {
            $this->_error(self::INVALID_URL);
            return false;
        }
        return true;
    }
}
?>