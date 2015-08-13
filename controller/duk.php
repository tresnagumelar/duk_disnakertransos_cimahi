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

		$sql = "select * from t_identitas";
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
		
		$nip = clean($nip);
		if($nip!="") {
			$sql = "update t_identitas set 
				nip='$nip',
				nama='$nama', 
				tempat_lahir='$tempat_lahir',
				tanggal_lahir='$tanggal_lahir',
				jenis_kelamin='$jenis_kelamin' 
				where nip = '$nip'
			";
		}else {
			$sql = "insert into t_identitas values (null, '$nip','$nama', '$jenis_kelamin','$tempat_lahir',
				'$tanggal_lahir', null, null, null, null, null, null, null)";
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
		$nip = clean($nip);
		$sql = "delete from t_identitas where nip='$nip'";
		$response->success = $db->query($sql);
		header("Content-type : application/json");
		echo json_encode($response);
	}
}
?>