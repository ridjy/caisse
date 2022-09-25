<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CodeBarre extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model(array(
			'user_model' => 'Users'
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
		$tabHeadScript[] = THEMES_URL."js/jspdf.debug.js" ;
		$tabHeadScript[] = THEMES_URL."js/html2canvas.js" ;
		$tabHeadScript[] = THEMES_URL."js/jquery.scannerdetection.compatibility.js" ;
		$tabHeadScript[] = THEMES_URL."js//jquery.scannerdetection.js" ;
		$tabHeadScript[] = THEMES_URL."js/scripts/codebarre/index.js" ;

		$this->layout->set('title', 'Code Barre');
		$this->layout->set('headLink', '');
		$this->layout->set('headScript', $tabHeadScript);
		$this->layout->load('default', 'contents' , 'codebarre/index');
	}
}
