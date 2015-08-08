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

		$sql = "select * from TTravel";
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
		
		$id_travel = clean($id_travel);
		if($id_travel!="") {
			$sql = "update ttravel set 
				nama_travel='$nama_travel', 
				kota_asal='$kota_asal',
				kota_tujuan='$kota_tujuan',
				harga='$harga'
				where id_travel = '$id_travel'
			";
		}else {
			$sql = "insert into ttravel values (null,'$nama_travel','$kota_asal','$kota_tujuan','$harga')";
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
		$id_travel = clean($id_travel);
		$sql = "delete from ttravel where id_travel='$id_travel'";
		$response->success = $db->query($sql);
		header("Content-type : application/json");
		echo json_encode($response);
	}
}
?>