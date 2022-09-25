<?php
if ( ! defined('BASEPATH')) exit('No direct script access
allowed');

class Dashboard_model extends CI_Model{
    public function __construct()
    {
        parent::__construct();
        $this->load->model(array(
            'global_model' => 'Global'
        )) ;
    }

    public function count($table)
    {
        $this->db->select('COUNT(*) as total');
        $this->db->from($table);
        $query = $this->db->get();
        $row = $query->row_array();
        return $row['total'];    
    }

    public function getlastarticle()
    {
        $this->db->select('MAX(id_article) as max');
        $this->db->from('articles'); 
        $query = $this->db->get();
        $row1 = $query->row_array();
        $this->db->select('*');
        $this->db->from('articles');
        $this->db->where('id_article',$row1['max']);  
        $query = $this->db->get();
        $row = $query->row_array();
        return $row; 

    }

    public function getarticleplusvendu()
    {
        $sql='SELECT MAX(sum) as total,article_id FROM
                (
                SELECT
                SUM(vente_quantite) as sum, article_id FROM ventes v GROUP BY article_id 
                ) as a';
        $query = $this->db->query($sql) ;
        $row = $query->row_array(); 
        return $row;
    }

    public function getplusvendus($ordre)
    {
        $sql='SELECT
            SUM(vente_quantite) as sum, article_id ,a.*
            FROM ventes v
            INNER JOIN articles a
            ON a.id_article = v.article_id GROUP BY article_id 
                ORDER BY sum '.$ordre.' LIMIT 0,5';
        $query = $this->db->query($sql) ;
        $row = $query->result(); 
        return $row;
    }    

    public function selectarticle($id)
    {
        $this->db->where('id_article',$id);
        $query = $this->db->get("articles");
        $row = $query->row_array();
        return $row;
    }

    public function getventedumois()
    {
        $this->db->select('COUNT(*) as total');
        $this->db->from('ventes');
        $this->db->where("MONTH(vente_date)",date('n'));
        $query = $this->db->get();
        $row = $query->row_array();
        return $row['total'];  

    }

    public function getmontantdumois($n)
    {
        $this->db->select('SUM(facture_montant) as total');
        $this->db->from('factures f');
        $this->db->where("MONTH(f.facture_date)",$n);//date('m') est $m avec  initiaux
        $query = $this->db->get();
        $row = $query->row_array();
        return $row['total'];  

    }    

    public function getrupturearticle($ordre)
    {
        $this->db->select('*')
                ->from('articles')
                ->order_by('nbre_stock_article',$ordre)
                ->limit(5);
        $query = $this->db->get();
        $row = $query->result();
        return $row ;        
    }
        
    public function getnbrarticlevendu($id)
    {
        $this->db->select('COUNT(*) as total');
        $this->db->from('articles');
        $this->db->where('id_article',$id);
        $query = $this->db->get();
        $row = $query->row_array();
        return $row['total'];       
    }    

    private function getpourcentage($total,$pce)
    {
        $res=($pce*100)/$total;  
        return $res; 
    }
    

}
?>