<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Test extends CI_Controller {

	public function index()
	{
		error_reporting(E_ALL);
        ini_set("display_error", 1);

		$this->load->model(array(
			'user_model' => 'Users'
			,'global_model' => 'Global'
			,'utils_model' => 'Utils'
			,'categorie_model' => 'Categorie'
			,'caisse_model' => 'Caisse'
			,'options_model' => 'Options'
			,'article_model' => 'Article'
		)) ;


        $t = $this->Caisse->Get_All_Facture(6) ;

		echo "<pre>";
		print_r($t) ;
		echo "</pre>";
		die() ;
	}

}
