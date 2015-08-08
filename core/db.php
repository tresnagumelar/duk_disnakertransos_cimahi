<?php

class DB {
	public $con = null;
	public $host = MSQL_HOST;
	public $user = MSQL_USER;
	public $pass = MSQL_PASSWORD;
	public $port = MSQL_PORT;
	public $dtbs = MSQL_DATABASE;

	public function __construct(){
		$this->con = mysqli_connect($this->host,$this->user,$this->pass,$this->dtbs,$this->port)or die (mysqli_error());
	}

	public function __destruct(){
		mysqli_close($this->con);
	}

	public function query($sql){
		return $this->con->query($sql);
	}
}

?>