<?php
class Med_Auth_Doctrine implements Zend_Auth_Adapter_Interface
{
// array containing authenticated user record
protected  $_result;
// constructor
// accepts username and password
public function __construct($username, $password)
{
$this->username = $username;
$this->password = md5($password);
$this->passworduser = $password;

}
// main authentication method
// queries database for match to authentication credentials
// returns Zend_Auth_Result with success/failure code
public function authenticate()
{
$q = Doctrine_Query::create()
->from('Med_Model_AdminUsers u')
->where('u.au_email = ? AND u.au_pwd = ? ',
array($this->username, $this->password)
);
$this->_result = $q->fetchArray();
if(count($this->_result)<1)
{
// Check Inactive user
$q1 = Doctrine_Query::create()
->from('Med_Model_ClientUsers u')
->where('u.cu_email = ? AND u.cu_pwd = ? ',
array($this->username, $this->passworduser)
);
// Execute Inactive user
$this->_result = $q1->fetchArray();
if (count($this->_result) == 1) {
return new Zend_Auth_Result(
Zend_Auth_Result::SUCCESS, $this->_result['0']['cu_id'], array());
} else {

return new Zend_Auth_Result(
Zend_Auth_Result::FAILURE, null,
array('Your user name (email) or password is wrong')
);
}
}
else {
return new Zend_Auth_Result(
Zend_Auth_Result::SUCCESS, $this->_result['0']['au_id'], array());
} 


}



// returns result array representing authenticated user record
// excludes specified user record fields as needed
public function getResultArray($excludeFields = null)
{

if (!$this->_result) {
return false;
}
if ($excludeFields != null) {
$excludeFields = (array)$excludeFields;

foreach ($this->_result as $key => $value) {
	
if (!in_array($key, $excludeFields)) {
 $returnArray[$key] = $value;
}

}

return $returnArray;
} else {

return $this->_result;
}
}
}