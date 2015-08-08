<?php


class Controller {
	public function dologin(){
		if (isset($_REQUEST)) foreach($_REQUEST as $k=>$v) $$k = clean($v);
		if (isset($_SESSION)) foreach($_SESSION as $k=>$v) $$k = clean($v);
		$db = new DB();
		$response = new stdClass();
		$username = clean($_POST['username']);
		$password = clean($_POST['password']);
		$response->success = true;
		$response->login = true;
		$response->errorMsg= array();

		if ($username==''){
			$response->login = false;
			$error = new stdClass;
			$error->inp = "username";
			$error->reason = "Kolom Username tidak boleh kosong";
			$response->errorMsg[]=$error;
		}
		if ($response->login){		
			if (strtolower($username)!="admin"){
				$response->login = false;
				$error = new stdClass;
				$error->inp = "username";
				$error->reason = "Username tidak ditemukan";
				$response->errorMsg[]=$error;
			}
			if ($password != "12345"){
				$response->login = false;
				$error = new stdClass;
				$error->inp = "password";
				$error->reason = "password salah";
				$response->errorMsg[]=$error;
			}
			
			if($response->login){
				session_regenerate_id();
				$_SESSION['SESS_SECREATKEY'] = session_id();
				$_SESSION['SESS_NAME'] = "Administrator";
				session_write_close();
				$response->login = true;
				unset($response->errorMsg);
			}
		}
		header("Content-type : application/json");
		echo json_encode($response);
	}

	public function dologout(){
		session_unset();
		session_destroy();

		foreach($_COOKIE as $k=>$v){
			 unset($_COOKIE[$k]);
	         setcookie($k, null, -1, '/');
		}

		header("Content-type : application/json");
		$response			= new stdClass();
		$response->success	= true;
		echo json_encode($response);
	}
}
?>