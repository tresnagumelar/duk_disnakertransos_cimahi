<?php


class Controller {
	public function getall(){
		if (isset($_REQUEST)) foreach($_REQUEST as $k=>$v) $$k = clean($v);
		if (isset($_SESSION)) foreach($_SESSION as $k=>$v) $$k = clean($v);
		$db = new DB(); 
		$response = new stdClass();
		$response->success = true;
		$response->rows = array();
		$start = isset($start) ? $start : 0;
		$limit = isset($limit) ? $limit : 100;

		$sql = "select * from r_pangkat";
		//ambil row
		$sql = $sql . " limit $start, $limit";
		if ($result = $db->con->query($sql)) {
	 		while($row = $result->fetch_object()){
	 			unset($row->password);
				$response->rows[] = $row;
	 		}
		}
		//ambil total rows
		$response->total_rows = $db->con->query($sql)->num_rows;
		header("Content-type : application/json");
		echo json_encode($response);
	}
	public function save(){
		if (isset($_REQUEST)) foreach($_REQUEST as $k=>$v) $$k = clean($v);
		if (isset($_SESSION)) foreach($_SESSION as $k=>$v) $$k = clean($v);
		$db = new DB();
		$response = new stdClass();
		$response->success = false;
		$response->msg = "";
		
		$kd_pangkat = clean($kd_pangkat);
		$sql = "replace into r_pangkat values ('$kd_pangkat','$nama_pangkat')";
		$response->success = $db->query($sql);
		$response->test = $sql;
		$response->test2 = $kd_pangkat;
		header("Content-type : application/json");
		echo json_encode($response);
	}
	public function delete(){
		if (isset($_REQUEST)) foreach($_REQUEST as $k=>$v) $$k = clean($v);
		if (isset($_SESSION)) foreach($_SESSION as $k=>$v) $$k = clean($v);
		$db = new DB();
		$response = new stdClass();
		$response->success = false;
		$response->msg = "";
		$kd_pangkat = clean($kd_pangkat);
		$sql = "delete from r_pangkat where kd_pangkat='$kd_pangkat'";
		$response->success = $db->query($sql);
		header("Content-type : application/json");
		echo json_encode($response);
	}
}
?>