<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Report_model extends CI_Model {


	public function get_companies()
	{

		$query= $this->db->query("call sp_get_companies()");
        mysqli_next_result($this->db->conn_id);
        $data = $query->result();

        $query->free_result();

        return $data;

	}

	public function get_poll($params)
	{
		$procedure = "call sp_get_poll(?,?)";
        $parameters = array($params['company'], $params['polltype']);
        $query = $this->db->query($procedure, $parameters);
        mysqli_next_result($this->db->conn_id);
        $data = $query->result();
        $query->free_result();
		
		return $data;


	}

	public function get_report($params)
	{
		$procedure = "call sp_get_report(?,?)";
        $parameters = array($params['pollIdInt'], $params['pollIdTemp']);
        $query = $this->db->query($procedure, $parameters);
        mysqli_next_result($this->db->conn_id);
        $data = $query->result();
        $query->free_result();
		
		return $data;


	}

	public function get_linksConsolidado($PollId)
	{
		$procedure = "call sp_get_consolidate_links(?)";
        $query = $this->db->query($procedure, $PollId);
        //mysqli_next_result($this->db->conn_id);
        $data = $query->result();
        $query->free_result();
		
		return $data;


	}

	public function get_Intereses($id_interes)
	{
		$procedure = "call sp_get_status_interes(?)";
		$query = $this->db->query($procedure, $id_interes);
		mysqli_next_result($this->db->conn_id);
		$data = $query->result();
		$query->free_result();
		return $data;
	}

	public function get_Temperamentos($id_interes)
	{
		$procedure = "call sp_get_status_temperamentos(?)";
		$query = $this->db->query($procedure, $id_interes);
		mysqli_next_result($this->db->conn_id);
		$data = $query->result();
		$query->free_result();
		return $data;
	}
  }


?>