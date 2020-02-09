<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Ruang extends CI_Controller {
 
    public function __construct()
    {
        parent::__construct();
        $this->load->model('m_ruang','ruang');
    }
 
    public function index()
    {
        $this->load->helper('url');
        $this->load->view('v_ruang');
    }
 
    public function ajax_list()
    {
        $list = $this->ruang->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $ruang) {
            $no++;
            $row = array();
            $row[] = $ruang->id_ruang;
            $row[] = $ruang->nama_ruang;
            $row[] = $ruang->kode_ruang;
            $row[] = $ruang->keterangan;
 
            //add html for action
            $row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit" onclick="edit_ruang('."'".$ruang->id_ruang."'".')"><i class="glyphicon glyphicon-pencil"></i> Edit</a>
                  <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Hapus" onclick="delete_ruang('."'".$ruang->id_ruang."'".')"><i class="glyphicon glyphicon-trash"></i> Delete</a>';
         
            $data[] = $row;
        }
 
        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->ruang->count_all(),
                        "recordsFiltered" => $this->ruang->count_filtered(),
                        "data" => $data,
                );
        //output to json format
        echo json_encode($output);
    }
 
    public function ajax_edit($id_ruang)
    {
        $data = $this->ruang->get_by_id($id_ruang);
         
        echo json_encode($data);
    }
 
    public function ajax_add()
    {
        $this->_validate();
        $data = array(
                'id_ruang' => $this->input->post('id_ruang'),
                'nama_ruang' => $this->input->post('nama_ruang'),
                'kode_ruang' => $this->input->post('kode_ruang'),
                'keterangan' => $this->input->post('keterangan'),
            );
        $insert = $this->ruang->save($data);
        echo json_encode(array("status" => TRUE));
    }
 
    public function ajax_update()
    {
        $this->_validate();
        $data = array(
                'id_ruang' => $this->input->post('id_ruang'),
                'nama_ruang' => $this->input->post('nama_ruang'),
                'kode_ruang' => $this->input->post('kode_ruang'),
                'keterangan' => $this->input->post('keterangan'),
            );
        $this->ruang->update(array('id_ruang' => $this->input->post('id_ruang')), $data);
        echo json_encode(array("status" => TRUE));
    }
 
    public function ajax_delete($id_ruang)
    {
        $this->ruang->delete_by_id($id_ruang);
        echo json_encode(array("status" => TRUE));
    }
 
 
    private function _validate()
    {
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;
 
        if($this->input->post('id_ruang') == '')
        {
            $data['inputerror'][] = 'id_ruang';
            $data['error_string'][] = 'No Ruang';
            $data['status'] = FALSE;
        }
 
        if($this->input->post('nama_ruang') == '')
        {
            $data['inputerror'][] = 'nama_ruang';
            $data['error_string'][] = 'Nama Ruang';
            $data['status'] = FALSE;
        }
 
        if($this->input->post('kode_ruang') == '')
        {
            $data['inputerror'][] = 'kode_ruang';
            $data['error_string'][] = 'Kode Ruang';
            $data['status'] = FALSE;
        }
 
        if($this->input->post('keterangan') == '')
        {
            $data['inputerror'][] = 'keterangan';
            $data['error_string'][] = 'Keterangan';
            $data['status'] = FALSE;
        }
 
       
        if($data['status'] === FALSE)
        {
            echo json_encode($data);
            exit();
        }
    }
 
}
