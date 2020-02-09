<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Pegawai extends CI_Controller {
 
    public function __construct()
    {
        parent::__construct();
        $this->load->model('m_pegawai','pegawai');
    }
 
    public function index()
    {
        $this->load->helper('url');
        $this->load->view('v_pegawai');
    }
 
    public function ajax_list()
    {
        $list = $this->pegawai->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $pegawai) {
            $no++;
            $row = array();
            $row[] = $pegawai->id_pegawai;
            $row[] = $pegawai->nama_pegawai;
            $row[] = $pegawai->nip;
            $row[] = $pegawai->alamat;
 
            //add html for action
            $row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit" onclick="edit_pegawai('."'".$pegawai->id_pegawai."'".')"><i class="glyphicon glyphicon-pencil"></i> Edit</a>
                  <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Hapus" onclick="delete_pegawai('."'".$pegawai->id_pegawai."'".')"><i class="glyphicon glyphicon-trash"></i> Delete</a>';
         
            $data[] = $row;
        }
 
        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->pegawai->count_all(),
                        "recordsFiltered" => $this->pegawai->count_filtered(),
                        "data" => $data,
                );
        //output to json format
        echo json_encode($output);
    }
 
    public function ajax_edit($id_pegawai)
    {
        $data = $this->pegawai->get_by_id($id_pegawai);
         
        echo json_encode($data);
    }
 
    public function ajax_add()
    {
        $this->_validate();
        $data = array(
                'id_pegawai' => $this->input->post('id_pegawai'),
                'nama_pegawai' => $this->input->post('nama_pegawai'),
                'nip' => $this->input->post('nip'),
                'alamat' => $this->input->post('alamat'),
            );
        $insert = $this->pegawai->save($data);
        echo json_encode(array("status" => TRUE));
    }
 
    public function ajax_update()
    {
        $this->_validate();
        $data = array(
                'id_pegawai' => $this->input->post('id_pegawai'),
                'nama_pegawai' => $this->input->post('nama_pegawai'),
                'nip' => $this->input->post('nip'),
                'alamat' => $this->input->post('alamat'),
            );
        $this->pegawai->update(array('id_pegawai' => $this->input->post('id_pegawai')), $data);
        echo json_encode(array("status" => TRUE));
    }
 
    public function ajax_delete($id_pegawai)
    {
        $this->pegawai->delete_by_id($id_pegawai);
        echo json_encode(array("status" => TRUE));
    }
 
 
    private function _validate()
    {
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;
 
        if($this->input->post('id_pegawai') == '')
        {
            $data['inputerror'][] = 'id_pegawai';
            $data['error_string'][] = 'No pegawai tidak boleh kosong';
            $data['status'] = FALSE;
        }
 
        if($this->input->post('nama_pegawai') == '')
        {
            $data['inputerror'][] = 'nama_pegawai';
            $data['error_string'][] = 'Nama pegawai tidak boleh kosong';
            $data['status'] = FALSE;
        }
 
        if($this->input->post('nip') == '')
        {
            $data['inputerror'][] = 'nip';
            $data['error_string'][] = 'Kode pegawai tidak boleh kosong';
            $data['status'] = FALSE;
        }
 
        if($this->input->post('alamat') == '')
        {
            $data['inputerror'][] = 'alamat';
            $data['error_string'][] = 'Alamat tidak boleh kosong';
            $data['status'] = FALSE;
        }
 
       
        if($data['status'] === FALSE)
        {
            echo json_encode($data);
            exit();
        }
    }
 
}
