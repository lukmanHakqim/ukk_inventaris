<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Provinsi extends CI_Controller {
 
    public function __construct()
    {
        parent::__construct();
        $this->load->model('provinsi_model','provinsi');
    }
 
    public function index()
    {
        $this->load->helper('url');
        $this->load->view('provinsi_view');
    }
 
    public function ajax_list()
    {
        $list = $this->provinsi->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $provinsi) {
            $no++;
            $row = array();
            $row[] = $provinsi->id_prov;
            $row[] = $provinsi->kode_prov;
            $row[] = $provinsi->nama_provinsi;
 
            //add html for action
            $row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit" onclick="edit_provinsi('."'".$provinsi->id_prov."'".')"><i class="glyphicon glyphicon-pencil"></i> Edit</a>
                  <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Hapus" onclick="delete_provinsi('."'".$provinsi->id_prov."'".')"><i class="glyphicon glyphicon-trash"></i> Delete</a>';
         
            $data[] = $row;
        }
 
        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->provinsi->count_all(),
                        "recordsFiltered" => $this->provinsi->count_filtered(),
                        "data" => $data,
                );
        //output to json format
        echo json_encode($output);
    }
 
    public function ajax_edit($id_prov)
    {
        $data = $this->provinsi->get_by_id($id_prov);
         
        echo json_encode($data);
    }
 
    public function ajax_add()
    {
        $this->_validate();
        $data = array(
                'id_prov' => $this->input->post('id_prov'),
                'kode_prov' => $this->input->post('kode_prov'),
                'nama_provinsi' => $this->input->post('nama_provinsi'),
            );
        $insert = $this->provinsi->save($data);
        echo json_encode(array("status" => TRUE));
    }
 
    public function ajax_update()
    {
        $this->_validate();
        $data = array(
                'id_prov' => $this->input->post('id_prov'),
                'kode_prov' => $this->input->post('kode_prov'),
                'nama_provinsi' => $this->input->post('nama_provinsi'),
            );
        $this->provinsi->update(array('id_prov' => $this->input->post('id_prov')), $data);
        echo json_encode(array("status" => TRUE));
    }
 
    public function ajax_delete($id_prov)
    {
        $this->provinsi->delete_by_id($id_prov);
        echo json_encode(array("status" => TRUE));
    }
 
 
    private function _validate()
    {
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;
 
        if($this->input->post('id_prov') == '')
        {
            $data['inputerror'][] = 'id_prov';
            $data['error_string'][] = 'no prov';
            $data['status'] = FALSE;
        }
 
        if($this->input->post('kode_prov') == '')
        {
            $data['inputerror'][] = 'kode_prov';
            $data['error_string'][] = 'kode prov';
            $data['status'] = FALSE;
        }

 
        if($this->input->post('nama_provinsi') == '')
        {
            $data['inputerror'][] = 'nama_provinsi';
            $data['error_string'][] = 'nama prov';
            $data['status'] = FALSE;
        }
 
       
        if($data['status'] === FALSE)
        {
            echo json_encode($data);
            exit();
        }
    }
 
}
