<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Options extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model(array(
			'user_model' => 'Users'
			,'global_model' => 'Global'
			,'options_model' => 'Options'
			,'utils_model' => 'Utils'
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
		$getAllOptions = $this->Options->getAllOptions() ;

		$this->layout->set('title', 'Configuration du site');
		$this->layout->set('headLink', '');
		$this->layout->set('headScript', array(THEMES_URL."js/scripts/options/index.js"));
		$this->layout->load('default', 'contents' , 'options/index',array("getAllOptions"=>$getAllOptions));
	}

	public function update()
	{
		// update options
		if(!empty($_POST['Options'])){
			foreach ($_POST['Options'] as $meta_key => $meta_value) {
				$this->Options->updateOptions($meta_key,$meta_value) ;
			}
		}

		$res['state'] = 'success' ;
		$res['msg'] = 'Mise à jour effectuée' ;
		
		echo json_encode($res);
	}
}
