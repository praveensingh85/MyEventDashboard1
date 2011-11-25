<?php 
class Med_Form_login extends Zend_Form
{
	public function init()
	{		
		
		// initialize form
		$this->setAttribs(array(
		'class' => 'login-form-element',
		'id' => 'Login'
		))
		->setMethod('post');
		// create text input for first name
		$company = new Zend_Form_Element_Text('company');
		$company->setLabel('Company')
		
		->setOptions(array('class' => 'field-input-long'))
		->setRequired(true)
		->addValidator('NotEmpty', true,array(
		'messages' => array(
		Zend_Validate_NotEmpty::IS_EMPTY
		=> "Please enter company"
		)
		))
		->addFilter('HtmlEntities')
		->addFilter('StringTrim');
		
		$company->setDecorators(array(
                   'ViewHelper',
                   'Description',
                   array('Errors'),

                   array(array('data'=>'HtmlTag'), array('tag' => 'td')),
				    array(array('row'=>'HtmlTag'),array('tag'=>'tr')),
                   array('Label', array('tag' => 'td')),
                   array(array('row'=>'HtmlTag'),array('tag'=>'tr'))
           ));
		    
		// create text input for email address
		$email = new Zend_Form_Element_Text('email');
		$email->setLabel('User Name (Email)');
		$email->setOptions(array('class' => 'field-input'))
		->setRequired(true)
		->addValidator('NotEmpty', true,array(
		'messages' => array(
		Zend_Validate_NotEmpty::IS_EMPTY
		=> "Please enter user name (email)"
		)
		))
		->addValidator('EmailAddress', true)
		->addFilter('HtmlEntities')
		->addFilter('StringToLower')
		->addFilter('StringTrim');
		$email->setDecorators(array(
                   'ViewHelper',
                   'Description',
                   'Errors',
                   array(array('data'=>'HtmlTag'), array('tag' => 'td')),
				   array(array('row'=>'HtmlTag'),array('tag'=>'tr')),
                   array('Label', array('tag' => 'td','class'=>'lefttdlabel')),
                   array(array('row'=>'HtmlTag'),array('tag'=>'tr'))
           ));

		// create text input for password
		$password = new Zend_Form_Element_Password('password');
		$password->setLabel('Password')
		->setOptions(array('class' => 'field-input'))
		->setRequired(true)
		->addValidator('NotEmpty', true,array(
		'messages' => array(
		Zend_Validate_NotEmpty::IS_EMPTY
		=> "Please enter password"
		)
		))

		->addFilter('HtmlEntities')
		->addFilter('StringTrim');
		$password->setDecorators(array(
                   'ViewHelper',
                   'Description',
                   'Errors',
                   array(array('data'=>'HtmlTag'), array('tag' => 'td')),
				   array(array('row'=>'HtmlTag'),array('tag'=>'tr')),
                   array('Label', array('tag' => 'td')),
				  
                   array(array('row'=>'HtmlTag'),array('tag'=>'tr'))
           ));
		
		
		// create image submit button
		$submit = new Zend_Form_Element_Submit('submit');
		$submit->setLabel('Submit')
		->setDescription('<a href="#" title="Forget Password">Forget Password?</a>')
		->setOptions(array('class' => 'login-button'));
		$submit->setDecorators(array(
        'ViewHelper',
        array('Description',array('tag'=>'span','escape'=>false)),
        'Errors',
        array(array('data'=>'HtmlTag'), array('tag' => 'td','class'=>'submit')),
		array(array('row'=>'HtmlTag'),array('tag'=>'tr')),
        array(array('emptyrow'=>'HtmlTag'), array('placement' => 'prepend', 'tag'=>'td')),
        array(array('row'=>'HtmlTag'),array('tag'=>'tr'))
      ));

		// attach elements to form
		$this->addElement($company)
		->addElement($email)
		->addElement($password)
		->addElement($submit);
		$this->setDecorators(array(
               'FormElements',
               array(array('data'=>'HtmlTag'),array('tag'=>'table')),
               'Form'
       ));

	}
}
?>