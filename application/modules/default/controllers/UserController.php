    <?php	
	
	class UserController extends Zend_Controller_Action {
   	public function init() {
     
  	}
	public function preDispatch()
    {
  	 
	 
	} 
	
    public function logoutAction()
    {
     Zend_Auth::getInstance()->clearIdentity();
     Zend_Session::destroy();
     $this->_redirect('/default/index/index');
	 exit;
    } 
	
   }