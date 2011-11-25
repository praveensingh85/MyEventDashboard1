    <?php
    class Med_My_Controller_Helper_Acl
    {
    public $acl;
    public function __construct()
    {
    $this->acl = new Zend_Acl();
	
    }
    public function setRoles()
    {
    $this->acl->addRole(new Zend_Acl_Role('user'));
    $this->acl->addRole(new Zend_Acl_Role('super_user'));
    $this->acl->addRole(new Zend_Acl_Role('super_admin'));
    $this->acl->addRole(new Zend_Acl_Role('client_admin'));
    }

    public function setResources()
    {

    $this->acl->add(new Zend_Acl_Resource('default'));
	$this->acl->add(new Zend_Acl_Resource('admin'));
    

    }

    public function setPrivilages()
    {
    $this->acl->allow('user','default');
    $this->acl->allow('super_admin','admin');
	$this->acl->allow('super_admin','default');
    $this->acl->deny('user','admin');
    }
    public function setAcl()
    {
    Zend_Registry::set('acl',$this->acl);
    }
    }
    ?>