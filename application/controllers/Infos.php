<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Infos extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model(array(
			'user_model' => 'Users'
			,'categorie_model' => 'Categories'
			,'global_model' => 'Global'
		)) ;
		
		if (!$this->Users->getData()) {
			redirect(BASE_URL."/login");
		}
		else{
			$role = $this->Users->getData()['role'] ;

			if($role != 'admin'){
				redirect(BASE_URL."/caisse");
			}
		}
	}

	public function index()
	{	
		$this->layout->set('title', 'Informations de connexion');
		$this->layout->set('headLink', '');
		$this->layout->set('headScript', array(THEMES_URL."js/scripts/infos/index.js"));
		$this->layout->load('default', 'contents' , 'infos/index');
	}

	public function update()
	{
		$res = array() ;

		$pseudo = $this->input->post('pseudo') ;
		$password = $this->input->post('password') ;


		echo "<pre>";
		print_r($pseudo);
		echo "</pre>";
		die() ;

	}

}
