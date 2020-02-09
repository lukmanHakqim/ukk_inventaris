<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Coba extends CI_Controller {
 
    public function __construct()
    {
        parent::__construct();
        $this->load->model('m_coba','coba');
    }
 
    public function index()
    {
        $this->load->helper('url');
        $this->load->view('templates/header');
        $this->load->view('v_coba');
        $this->load->view('templates/footer');
    }
 
    public function ajax_list()
    {
        $list = $this->level->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $level) {
            $no++;
            $row = array();
            $row[] = $level->id_level;
            $row[] = $level->nama_level;
 
            //add html for action
            $row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit" onclick="edit_level('."'".$level->id_level."'".')"><i class="glyphicon glyphicon-pencil"></i> Edit</a>
                  <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Hapus" onclick="delete_level('."'".$level->id_level."'".')"><i class="glyphicon glyphicon-trash"></i> Delete</a>';
         
            $data[] = $row;
        }
 
        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->level->count_all(),
                        "recordsFiltered" => $this->level->count_filtered(),
                        "data" => $data,
                );
        //output to json format
        echo json_encode($output);
    }
 
    public function ajax_edit($id_level)
    {
        $data = $this->level->get_by_id($id_level);
         
        echo json_encode($data);
    }
 
    public function ajax_add()
    {
        $this->_validate();
        $data = array(
                'id_level' => $this->input->post('id_level'),
                'nama_level' => $this->input->post('nama_level')
            );
        $insert = $this->level->save($data);
        echo json_encode(array("status" => TRUE));
    }
 
    public function ajax_update()
    {
        $this->_validate();
        $data = array(
                'id_level' => $this->input->post('id_level'),
                'nama_level' => $this->input->post('nama_level')
            );
        $this->level->update(array('id_level' => $this->input->post('id_level')), $data);
        echo json_encode(array("status" => TRUE));
    }
 
    public function ajax_delete($id_level)
    {
        $this->level->delete_by_id($id_level);
        echo json_encode(array("status" => TRUE));
    }
 
 
    private function _validate()
    {
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;
 
        if($this->input->post('id_level') == '')
        {
            $data['inputerror'][] = 'id_level';
            $data['error_string'][] = 'no level';
            $data['status'] = FALSE;
        }
 
        if($this->input->post('nama_level') == '')
        {
            $data['inputerror'][] = 'nama_level';
            $data['error_string'][] = 'nama level';
            $data['status'] = FALSE;
        }
 
       
        if($data['status'] === FALSE)
        {
            echo json_encode($data);
            exit();
        }
    }
 
}
