<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Petugas extends CI_Controller {
 
    public function __construct()
    {
        parent::__construct();
        $this->load->model('m_petugas','petugas');
    }
 
    public function index()
    {
        $this->load->helper('url');
        $this->load->helper('form');
        
        $this->load->view('v_petugas');
    }
 
    public function ajax_list()
    {
        $list = $this->petugas->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $petugas) {
            $no++;
            $row = array();
            $row[] = $petugas->id_petugas;
            $row[] = $petugas->username;
            $row[] = $petugas->password;
            $row[] = $petugas->nama_petugas;
            $row[] = $petugas->nama_level;
           
            // if($petugas->id_level)
            // $row[] = $this->db->query("SELECT nama_level FROM level, petugas WHERE level.id_level=id_level.petugas");

 
            //add html for action
            $row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit" onclick="edit_petugas('."'".$petugas->id_petugas."'".')"><i class="glyphicon glyphicon-pencil"></i> Edit</a>
                  <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Hapus" onclick="delete_petugas('."'".$petugas->id_petugas."'".')"><i class="glyphicon glyphicon-trash"></i> Delete</a>';
         
            $data[] = $row;
        }
 
        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->petugas->count_all(),
                        "recordsFiltered" => $this->petugas->count_filtered(),
                        "data" => $data,
                );
        //output to json format
        echo json_encode($output);
    }
 
    public function ajax_edit($id_petugas)
    {
        $data = $this->petugas->get_by_id($id_petugas);
         
        echo json_encode($data);
    }
 
    public function ajax_add()
    {
        $this->_validate();
        $data = array(
                'id_petugas' => $this->input->post('id_petugas'),
                'username' => $this->input->post('username'),
                'password' => $this->input->post('password'),
                'nama_petugas' => $this->input->post('nama_petugas'),
                'id_level' => $this->input->post('id_level'),
            );
        $insert = $this->petugas->save($data);
        echo json_encode(array("status" => TRUE));
    }
 
    public function ajax_update()
    {
        $this->_validate();
        $data = array(
                'id_petugas' => $this->input->post('id_petugas'),
                'username' => $this->input->post('username'),
                'password' => $this->input->post('password'),
                'nama_petugas' => $this->input->post('nama_petugas'),
                'id_level' => $this->input->post('id_level'),
            );
        $this->petugas->update(array('id_petugas' => $this->input->post('id_petugas')), $data);
        echo json_encode(array("status" => TRUE));
    }
 
    public function ajax_delete($id_petugas)
    {
        $this->petugas->delete_by_id($id_petugas);
        echo json_encode(array("status" => TRUE));
    }
 
 
    private function _validate()
    {
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;
 
        if($this->input->post('id_petugas') == '')
        {
            $data['inputerror'][] = 'id_petugas';
            $data['error_string'][] = 'id petugas';
            $data['status'] = FALSE;
        }
 
        if($this->input->post('username') == '')
        {
            $data['inputerror'][] = 'username';
            $data['error_string'][] = 'username';
            $data['status'] = FALSE;
        }

        if($this->input->post('password') == '')
        {
            $data['inputerror'][] = 'password';
            $data['error_string'][] = 'password';
            $data['status'] = FALSE;
        }
 
        if($this->input->post('nama_petugas') == '')
        {
            $data['inputerror'][] = 'nama_petugas';
            $data['error_string'][] = 'nama_petugas';
            $data['status'] = FALSE;
        }
 
        if($this->input->post('id_level') == '')
        {
            $data['inputerror'][] = 'id_level';
            $data['error_string'][] = 'id level';
            $data['status'] = FALSE;
        }

        if($data['status'] === FALSE)
        {
            echo json_encode($data);
            exit();
        }
    }

    public function ajax_level(){
        $data = $this->petugas->get_by_id_level($id_level);
         
        echo json_encode($data);
    }
 
}
