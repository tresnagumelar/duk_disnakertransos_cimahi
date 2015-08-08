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

		$sql = "select * from TAgen";
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
		
		$id_agen = clean($id_agen);
		if($id_agen!="") {
			$sql = "update tagen set 
				nama_agen='$nama_agen', 
				no_telepon='$no_telepon',
				alamat='$alamat'
				where id_agen = '$id_agen'
			";
		}else {
			$sql = "insert into tagen values (null,'$nama_agen','$no_telepon','$alamat')";
		}
		$response->success = $db->query($sql);
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
		$id_agen = clean($id_agen);
		$sql = "delete from tagen where id_agen='$id_agen'";
		$response->success = $db->query($sql);
		header("Content-type : application/json");
		echo json_encode($response);
	}
}
?>