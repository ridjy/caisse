<?php
if ( ! defined('BASEPATH')) exit('No direct script access
allowed');

class Medias_model extends CI_Model{
    public function __construct()
    {
        parent::__construct();
        $this->load->model(array(
            'global_model' => 'Global'
        )) ;
    }

    public function addMedia($data)
    {
        if(!is_array($data)){
            return;
        }
        
        $data_medias = array(
            'id_user'       => $data['id_user']
            ,'filename'     => $data['filename']
            ,'title'        => (!empty($data['title'])) ? $data['title'] : null
            ,'caption'      => $data['caption']
            ,'alt'          => $data['alt']
            ,'description'  => $data['description']
        );

        $this->Global->insert("medias", $data_medias);
        $lastId = $this->Global->lastId();

        return $lastId;
    }

}
?>