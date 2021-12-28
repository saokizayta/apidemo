<?php
private function login()
{
// Cross validation if the request method is POST else it will return "Not Acceptable" status
if($this->get_request_method() != "POST")
{
$this->response('',406);
}

$email = $this->_request['email'];
$password = $this->_request['pwd'];

// Input validations
if(!empty($email) and !empty($password))
{
if(filter_var($email, FILTER_VALIDATE_EMAIL)){
$sql = MySQL_query("SELECT user_id, user_fullname, user_email FROM users WHERE user_email = '$email' AND user_password = '".md5($password)."' LIMIT 1", $this->db);
if(MySQL_num_rows($sql) > 0){
$result = MySQL_fetch_array($sql,MySQL_ASSOC);

// If success everythig is good send header as "OK" and user details
$this->response($this->json($result), 200);
}
$this->response('', 204); // If no records "No Content" status
}
}

// If invalid inputs "Bad Request" status message and reason
$error = array('status' => "Failed", "msg" => "Invalid Email address or Password");
$this->response($this->json($error), 400);
}
?>                                                                 