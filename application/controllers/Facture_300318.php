<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Facture extends CI_Controller {
	public function __construct()
	{		
		parent::__construct();

		$this->load->model(array(
			'caisse_model' => 'Caisse'
			,'global_model' => 'Global'
			,'options_model' => 'Options'
			,'historique_model' => 'Histo'
			,'user_model' => 'Users'
		)) ;
		define('FPDF_FONTPATH','system/fonts');
		//define('FPDF_FONTPATH',$this->config->item('fonts_path'));
		//define('FPDF_FONTPATH','/var/www/commande/system/fonts');
		$this->load->library('fpdf');

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

	function Footer()
	{
	    // Positionnement à 1,5 cm du bas
	    $this->fpdf->SetY(-15);
	    // Police Arial italique 8
	    $this->fpdf->SetFont('Arial','I',8);
	    // Numéro de page
	    $this->fpdf->Cell(0,10,'Page ',0,0,'C');
	}

	public function index()
	{
		echo 'fact A4';
	}

	public function factureA4()
	{
		$date=getdate();
		$id_facture=$this->input->get('id');
		$row_article=$this->Histo->getArticleByFactureId($id_facture);
		$row_facture=$this->Histo->Get_facture($id_facture);
		$this->fpdf->Open();
		$this->fpdf->AddPage();
		
		//$this->fpdf->Image(img_url('code_barre.gif'),140,7,55);
		//$this->fpdf->Image(img_url('logo.PNG'),11,5,-100);

		/*a propos de la societe*/
		$this->fpdf->SetXY(15,7);
		$this->fpdf->SetFont('helvetica','B',15);
		$this->fpdf->Cell(40,20,'BAZAR KIDS');
		$this->fpdf->SetXY(15,20);
	 	$this->fpdf->SetFont('Times','',11);
	 	$this->fpdf->MultiCell(0,5,utf8_decode('Rond point boulevard de l\'Europe Ankazomanga'),'');
	 	$this->fpdf->SetXY(15,24);
	 	$this->fpdf->MultiCell(0,5,utf8_decode('Antananarivo 101, Madagascar'),'');
	 	$this->fpdf->SetXY(15,28);
	 	$this->fpdf->MultiCell(0,5,utf8_decode('Tél : 034 43 883 76 / 034 64 874 35'),'');

	 	//a propos de la facture
		$this->fpdf->SetXY(130,30);
		$this->fpdf->SetFont('Times','',11);
		$this->fpdf->Cell(27,5,utf8_decode('FACTURE N°'),'');
		$this->fpdf->SetFont('Times','B',11);
		$this->fpdf->Cell(25,5,$id_facture,'B',0,'C');
		$this->fpdf->SetXY(130,35);
		$this->fpdf->SetFont('Times','',11);
		$this->fpdf->Cell(27,5,'Date','');
		$this->fpdf->SetFont('Times','B',11);
		$this->fpdf->cell(25,5,date('d-m-Y',strtotime($row_facture->facture_date)),'B',0,'C');
	 	

	 	//client
	 	$this->fpdf->SetXY(130,43);
	 	$this->fpdf->SetFont('Times','',11);
	 	$this->fpdf->Cell(25,5,'DOIT : ','');
	 	$this->fpdf->Cell(40,5,'','B',0,'C');
	 	/*
	 	$this->fpdf->SetXY(130,49);
	 	$this->fpdf->SetFont('Times','',11);
	 	$this->fpdf->Cell(25,5,'Adresse : ','');
	 	$this->fpdf->Cell(40,5,'','B',0,'C');
	 	*/
	 	
	 	//mode de reglement
	 	$this->fpdf->SetXY(15,58);
	 	$this->fpdf->SetFont('Times','B',11);
	 	$this->fpdf->Cell(40,5,'Mode de reglement :','');
	 	$this->fpdf->Cell(40,5,'','B',0,'C');

	 	//tableau
	 	$this->fpdf->SetXY(15,68);
	 	$this->fpdf->SetFont('Times','B',10);
		$this->fpdf->Cell(25,6,'QUANTITE',1,0,'C');
		$this->fpdf->Cell(85,6,'DESIGNATION',1,0,'C'); 	
		$this->fpdf->Cell(35,6,'PU',1,0,'C');
		$this->fpdf->Cell(40,6,'TOTAL',1,0,'C');
		$this->fpdf->SetFont('Times','',11);

		//for
		$coords=74;
		foreach ($row_article as $item) {
			# code...
		
		$this->fpdf->SetXY(15,$coords);	
		$this->fpdf->Cell(25,6,utf8_decode($item->vente_quantite),1,0,'C');
		$this->fpdf->Cell(85,6,utf8_decode($item->nom_article),1,0,'L');
		$this->fpdf->Cell(35,6,utf8_decode($item->prix_article),1,0,'C');
		$this->fpdf->Cell(40,6,utf8_decode($item->vente_quantite*$item->prix_article),1,0,'C');
		$coords=$coords+6;
		//endfor
		}

		for ($i=$coords;$i<=200;$i=$i+6) {
			$this->fpdf->SetXY(15,$i);	
			$this->fpdf->Cell(25,6,'',1,0,'C');
			$this->fpdf->Cell(85,6,'',1,0,'L');
			$this->fpdf->Cell(35,6,'',1,0,'C');
			$this->fpdf->Cell(40,6,'',1,0,'C');
		}

		$this->fpdf->SetXY(15,206);	
		$this->fpdf->Cell(25,6,'',1,0,'C');
		$this->fpdf->Cell(45,6,'','LTB',0,'L');
		$this->fpdf->Cell(40,6,utf8_decode('TOTAL (ou à reporter)'),'TRB',0,'R');
		$this->fpdf->Cell(35,6,'',1,0,'C');
		$this->fpdf->Cell(40,6,number_format($row_facture->facture_montant, 2, ',', ' ').' Ariary TTC',1,0,'R');


		$this->fpdf->SetAutoPageBreak(0,1);

		$this->fpdf->SetXY(45,280);
		$this->fpdf->SetFont('Times','',10);
		$this->fpdf->Cell(120,4,'Bazar kids / Rond point boulevard de l\'Europe Ankazomanga / Merci pour votre collaboration ');
		
		$this->fpdf->Output();
	}
	
}
