<?php 
class Med_My_Controller_Plugin_Acl extends Zend_Controller_Plugin_Abstract
{
public function preDispatch(Zend_Controller_Request_Abstract $request)
{
$acl = Zend_Registry::get('acl');
$usersNs = new Zend_Session_NameSpace("Med.auth");

If($usersNs->user_type==''){
$roleName='user';
 

} else {
$roleName=$usersNs->user_type;
}
$privilageName=$request->getModuleName().$request->getControllerName().$request->getActionName();

if(!$acl->isAllowed($roleName,$privilageName)){
$request->setControllerName('Error');
$request->setActionName('error');

}
}

}
?>