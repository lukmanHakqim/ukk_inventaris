<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Jenis extends CI_Controller {
 
    public function __construct()
    {
        parent::__construct();
        $this->load->model('m_jenis','jenis');
    }
 
    public function index()
    {
        $this->load->helper('url');
        $this->load->view('v_jenis');
    }
 
    public function ajax_list()
    {
        $list = $this->jenis->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $jenis) {
            $no++;
            $row = array();
            $row[] = $jenis->id_jenis;
            $row[] = $jenis->nama_jenis;
            $row[] = $jenis->kode_jenis;
            $row[] = $jenis->keterangan;
 
            //add html for action
            $row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit" onclick="edit_jenis('."'".$jenis->id_jenis."'".')"><i class="glyphicon glyphicon-pencil"></i> Edit</a>
                  <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Hapus" onclick="delete_jenis('."'".$jenis->id_jenis."'".')"><i class="glyphicon glyphicon-trash"></i> Delete</a>';
         
            $data[] = $row;
        }
 
        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->jenis->count_all(),
                        "recordsFiltered" => $this->jenis->count_filtered(),
                        "data" => $data,
                );
        //output to json format
        echo json_encode($output);
    }
 
    public function ajax_edit($id_jenis)
    {
        $data = $this->jenis->get_by_id($id_jenis);
         
        echo json_encode($data);
    }
 
    public function ajax_add()
    {
        $this->_validate();
        $data = array(
                'id_jenis' => $this->input->post('id_jenis'),
                'nama_jenis' => $this->input->post('nama_jenis'),
                'kode_jenis' => $this->input->post('kode_jenis'),
                'keterangan' => $this->input->post('keterangan'),
            );
        $insert = $this->jenis->save($data);
        echo json_encode(array("status" => TRUE));
    }
 
    public function ajax_update()
    {
        $this->_validate();
        $data = array(
                'id_jenis' => $this->input->post('id_jenis'),
                'nama_jenis' => $this->input->post('nama_jenis'),
                'kode_jenis' => $this->input->post('kode_jenis'),
                'keterangan' => $this->input->post('keterangan'),
            );
        $this->jenis->update(array('id_jenis' => $this->input->post('id_jenis')), $data);
        echo json_encode(array("status" => TRUE));
    }
 
    public function ajax_delete($id_jenis)
    {
        $this->jenis->delete_by_id($id_jenis);
        echo json_encode(array("status" => TRUE));
    }
 
 
    private function _validate()
    {
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;
 
        if($this->input->post('id_jenis') == '')
        {
            $data['inputerror'][] = 'id_jenis';
            $data['error_string'][] = 'No jenis tidak boleh kosong';
            $data['status'] = FALSE;
        }
 
        if($this->input->post('nama_jenis') == '')
        {
            $data['inputerror'][] = 'nama_jenis';
            $data['error_string'][] = 'Nama jenis tidak boleh kosong';
            $data['status'] = FALSE;
        }
 
        if($this->input->post('kode_jenis') == '')
        {
            $data['inputerror'][] = 'kode_jenis';
            $data['error_string'][] = 'Kode jenis tidak boleh kosong';
            $data['status'] = FALSE;
        }
 
        if($this->input->post('keterangan') == '')
        {
            $data['inputerror'][] = 'keterangan';
            $data['error_string'][] = 'Keterangan tidak boleh kosong';
            $data['status'] = FALSE;
        }
 
       
        if($data['status'] === FALSE)
        {
            echo json_encode($data);
            exit();
        }
    }
 
}
