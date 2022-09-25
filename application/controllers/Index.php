<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Index extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model(array(
			'user_model' => 'Users'
			,'global_model' => 'Global'
			,'utils_model' => 'Utils'
			,'dashboard_model' => 'Dashboard'
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

		$this->layout->set('title', 'Bienvenue dans votre Dashboard');
		$this->layout->set('headLink', '');
		$this->layout->set('headScript', array(THEMES_URL."js/scripts/index/index.js"));
		$data=array();
		//nbre des articles
		$data['nbreuser']=$this->Dashboard->count('users');$data['nbrevente']=$this->Dashboard->count('ventes');
		$data['nbrearticle']=$this->Dashboard->count('articles');$data['nbrecategorie']=$this->Dashboard->count('categories');

		$data['dernierarticle']=$this->Dashboard->getlastarticle(); //dernier article enregistré  
		$data['ventemois']=$this->Dashboard->getventedumois();//vente du mois
		//article le plus vendu
		$data['plusvendu']=$this->Dashboard->getarticleplusvendu();
		$data['articleplusvendu']=$this->Dashboard->selectarticle($data['plusvendu']['article_id']);
		//getrupturearticle et articlemoinsvenu
		$data['rowrupture']=$this->Dashboard->getrupturearticle('asc');
		$data['rowmoinvendu']=$this->Dashboard->getrupturearticle('desc');
		//getarticleplusvendu et articlemoinsvendu
		$data['plusvendu1']=$this->Dashboard->getplusvendus('desc');
		$data['articlemoinsvendu']=$this->Dashboard->getplusvendus('asc');
		//montant du mois
		$data['montantmois']=$this->Dashboard->getmontantdumois(date('n'));
		//facture de ces 2 derniers mois
		$data['moisprec']=$this->getmoisprec(date('n'));
		$data['montantmoisprec']=$this->Dashboard->getmontantdumois($data['moisprec']);
		$data['moisprec2']=$this->getmoisprec($data['moisprec']);
		$data['montantmoisprec2']=$this->Dashboard->getmontantdumois($data['moisprec2']);
		$this->layout->load('default', 'contents' , 'index/index', $data);
	}

	private function getmoisprec($m)//prende les deux mois prec
	{
		if ($m=='1')
		{
			return 12; 
		}else{
			return $m-1;
		}
	} 

}
