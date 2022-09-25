<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CodeBarre_Model extends CI_Model {
	public function __construct()
	{
		parent::__construct();
		date_default_timezone_set('Africa/Nairobi');
	}

	public function GetAllProduct()
	{
		return $this->db->select('*')
						->from('articles')
						->get()
						->result();
	}	
}
