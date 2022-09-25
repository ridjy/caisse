<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Caisse_Model extends CI_Model {
	public function __construct()
	{
		parent::__construct();
		date_default_timezone_set('Africa/Nairobi');
		$this->load->model(array(
            'global_model' => 'Global'
        )) ;
	}

	public function Get_content_product($id){
		return $this->db->select('*')
						->from('articles')
						->where('codebarre_article',$id)
						->get()
						->row();
	}

	public function GetLastFacture()
	{
		return $this->db->select('facture_numero')
						->from('factures')
						->limit(1)
						->order_by('id_facture','desc')
						->get()
						->row();
	}

	public function Get_article($id)
	{
		return $this->db->select('nbre_stock_article')
						->from('articles')
						->where('id_article',$id)
						->get()
						->row();
	}

	public function Get_All_Facture($facture_id)
	{
        $sql  = "
        	SELECT 
        		a.nom_article
        		,a.prix_article
        		,v.vente_quantite
        	FROM ventes v
        	LEFT JOIN articles a ON (v.article_id = a.id_article)
        	WHERE v.facture_id =$facture_id
        ";

     	$query = $this->db->query($sql) ;
		$data = $query->result();

		$fact = $this->Global->selectRow('factures','facture_numero','id_facture='.$facture_id) ;

        if(!empty($data)){
        	$res['facture_numero'] = $fact->facture_numero ;

            foreach ($data as $k => $item) {
            	$res['details'][$k]['nom_article'] = $item->nom_article ;
            	$res['details'][$k]['prix_article'] = $item->prix_article ;
            	$res['details'][$k]['vente_quantite'] = $item->vente_quantite ;
            }   
        }

        return $res ;

		// return $this->db->select('nom_article,prix_article,vente_quantite,facture_numero')
		// 			->from('ventes')
		// 			->where('facture_id',$num)
		// 			->join('factures','ventes.facture_id=factures.facture_numero')
		// 			->join('articles','ventes.article_id=articles.id_article')
		// 			->get()
		// 			->result();
	}
	public function Add_Vente($data)
	{
		$this->db->insert('ventes',$data);
	}

	public function Add_Facture($data)
	{
		$this->db->insert('factures',$data);
	}

	public function Update_article($data,$id)
	{
		$this->db->where('id_article',$id)
				->update('articles',$data);
	}

	public function List_MP()
	{
		return $this->db->select('*')
						->from('mode_paiement')
						->get()
						->result();
	}
}
