<?php if ( ! defined('BASEPATH')) exit('No direct script access
allowed');
 
class User_model extends CI_Model
{
	protected $table = 'users';
	public function __construct()
	{
		// Obligatoire
		parent::__construct();
		$this->load->database('default',TRUE);	
		$this->load->library(array('session'));
	}
	
	public function check_user($email,$password)
	{
		//$query = $this->db->query("SELECT * FROM at_user WHERE user_login='".$login."' AND user_mdp='".$mdp."' LIMIT 0,1");
		$array = array('email' => $email, 'password' => $password);
		$this->db->select('id');
		$this->db->from('users');
		$this->db->where($array);
		$this->db->limit(1);

		$query = $this->db->get();
		$row=$query->result();
		return $row;
	}

	public function delai_activite($id)
	{
		//le delai d'activite est dépassé
		$this->db->set('user_niveau','inactif');	
		$this->db->where('user_id',$id);
		$this->db->limit(1);
		return $this->db->update($this->table);
	}
	
	public function last_activite($id)
	{
		//le delai d'activite new
		$this->db->set('user_lastActivity',time());	
		$this->db->where('user_id',$id);
		$this->db->limit(1);
		return $this->db->update($this->table);
	}

	public function liste_user()
	{
		$this->db->select('*');
		$this->db->from('at_user');
		$query = $this->db->get();
		$row=$query->result();
		return $row;
	}

	public function liste_user_simple()
	{
		$array = array('user_niveau' => 'Simple');
		$this->db->select('*');
		$this->db->from('at_user');
		$this->db->where($array);
		$query = $this->db->get();
		$row=$query->result();
		return $row;
	}

	public function get_user($id)
	{
		$array = array('user_id' => $id);
		$this->db->select('*');
		$this->db->from('at_user');
		$this->db->where($array);
		$query = $this->db->get();
		$row=$query->result();
		return $row;
	}

	public function activiter_compte($id)
	{
		//le delai d'activite new
		$this->db->set('user_niveau','Simple');	
		$this->db->where('user_id',$id);
		$this->db->limit(1);
		return $this->db->update($this->table);
	}

	public function desactiviter_compte($id)
	{
		//le delai d'activite new
		$this->db->set('user_niveau','inactif');	
		$this->db->where('user_id',$id);
		$this->db->limit(1);
		return $this->db->update($this->table);
	}

	public function modifier_compte($id,$niveau,$enr,$stat,$stat_exp,$enr_lect,$enr_tel,$delai,$chartres,$troyes,$chateauroux)
	{
		$array = array(
			    'user_niveau' => $niveau,    
			    'ud_enr' => $enr,
			    'ud_stat' => $stat,
			    'ud_stat_exp' => $stat_exp,
			    'ud_enr_lecture' => $enr_lect,
			    'ud_enr_tel' => $enr_tel,
			    'user_delai' => $delai,
			    'camp_chartres' => $chartres,
			    'camp_troyes' => $troyes,
			    'camp_chateauroux' => $chateauroux
			    );
		$this->db->set($array);	
		$this->db->where('user_id',$id);
		$this->db->limit(1);
		return $this->db->update($this->table);
	}

	public function modifier_mdp($id,$mdp)
	{
		//le delai d'activite new
		$this->db->set('user_mdp',$mdp);	
		$this->db->where('user_id',$id);
		$this->db->limit(1);
		return $this->db->update($this->table);
	}

	public function test_user()
	{
		$this->db->select('*');
		$this->db->from('at_user');
		$query = $this->db->get();
		$row=$query->result();
		return $row;
	}

	public function add_user($id,$login,$mdp,$niveau,$enr,$stat,$stat_exp,$enr_lect,$enr_tel,$delai,$chartres,$troyes,$chateauroux)
	{
		$array = array(
				'user_id' => $id,    
			    'user_login' => $login,
			    'user_mdp' => $mdp,
			    'user_niveau' => $niveau, 
			    'user_lastActivity' => time(),   
			    'ud_enr' => $enr,
			    'ud_stat' => $stat,
			    'ud_stat_exp' => $stat_exp,
			    'ud_enr_lecture' => $enr_lect,
			    'ud_enr_tel' => $enr_tel,
			    'user_delai' => $delai,
			    'camp_chartres' => $chartres,
			    'camp_troyes' => $troyes,
			    'camp_chateauroux' => $chateauroux
			    );
		$this->db->set($array);	
		//$this->db->set('ref_iris',$ref);
		return $this->db->insert($this->table);
	}

	public function getData(){
		if (!empty($this->session->userdata['logged_in'])) {
			return $this->session->userdata['logged_in'] ;
		}
 	}

 	public function getId(){
 		if (!empty($this->session->userdata['logged_in'])) {
			return (int)$data['id'] ;
		}
 	}

 	public function logOut(){
 		$this->session->unset_userdata('logged_in');
		session_destroy();
		redirect(BASE_URL."/login");
 	}

}