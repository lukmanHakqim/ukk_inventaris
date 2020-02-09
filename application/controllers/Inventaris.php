<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Inventaris extends CI_Controller {
 
    public function __construct()
    {
        parent::__construct();
        $this->load->model('m_inventaris','inventaris');
    }
 
    public function index()
    {
        $data['title'] = 'Inventaris';
        $this->load->helper('url');
        $this->load->helper('form');
        
        // $this->load->view('templates/header', $data);
        $this->load->view('v_inventaris', $data);
    }
 
    public function ajax_list()
    {
        $list = $this->inventaris->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $inventaris) {
            $no++;
            $row = array();
            $row[] = $inventaris->id_inventaris;
            $row[] = $inventaris->nama_inventaris;
            $row[] = $inventaris->kondisi;
            $row[] = $inventaris->keterangan;
            $row[] = $inventaris->jumlah;
            $row[] = $inventaris->nama_jenis;
            $row[] = $inventaris->tanggal_register;
            $row[] = $inventaris->nama_ruang;
            $row[] = $inventaris->kode_inventaris;
            $row[] = $inventaris->nama_petugas;
            
            // if($inventaris->jumlah)
            // $row[] = $this->db->query("SELECT nama_level FROM level, inventaris WHERE level.jumlah=jumlah.inventaris");

 
            //add html for action
            $row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit" onclick="edit_inventaris('."'".$inventaris->id_inventaris."'".')"><i class="glyphicon glyphicon-pencil"></i> Edit</a>
                  <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Hapus" onclick="delete_inventaris('."'".$inventaris->id_inventaris."'".')"><i class="glyphicon glyphicon-trash"></i> Delete</a>';
         
            $data[] = $row;
        }
 
        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->inventaris->count_all(),
                        "recordsFiltered" => $this->inventaris->count_filtered(),
                        "data" => $data,
                );
        //output to json format
        echo json_encode($output);
    }   
 
    public function ajax_edit($id_inventaris)
    {
        $data = $this->inventaris->get_by_id($id_inventaris);
         
        echo json_encode($data);
    }
 
    public function ajax_add()
    {
        $this->_validate();
        $data = array(
                'id_inventaris' => $this->input->post('id_inventaris'),
                'nama_inventaris' => $this->input->post('nama_inventaris'),
                'kondisi' => $this->input->post('kondisi'),
                'keterangan' => $this->input->post('keterangan'),
                'jumlah' => $this->input->post('jumlah'),
                'id_jenis' => $this->input->post('id_jenis'),
                'tanggal_register' => $this->input->post('tanggal_register'),
                'id_ruang' => $this->input->post('id_ruang'),
                'kode_inventaris' => $this->input->post('kode_inventaris'),
                'id_petugas' => $this->input->post('id_petugas'),
            );
        $insert = $this->inventaris->save($data);
        echo json_encode(array("status" => TRUE));
    }
 
    public function ajax_update()
    {
        $this->_validate();
        $data = array(
                'id_inventaris' => $this->input->post('id_inventaris'),
                'nama_inventaris' => $this->input->post('nama_inventaris'),
                'kondisi' => $this->input->post('kondisi'),
                'keterangan' => $this->input->post('keterangan'),
                'jumlah' => $this->input->post('jumlah'),
                'id_jenis' => $this->input->post('id_jenis'),
                'tanggal_register' => $this->input->post('tanggal_register'),
                'id_ruang' => $this->input->post('id_ruang'),
                'kode_inventaris' => $this->input->post('kode_inventaris'),
                'id_petugas' => $this->input->post('id_petugas'),
            );
        $this->inventaris->update(array('id_inventaris' => $this->input->post('id_inventaris')), $data);
        echo json_encode(array("status" => TRUE));
    }
 
    public function ajax_delete($id_inventaris)
    {
        $this->inventaris->delete_by_id($id_inventaris);
        echo json_encode(array("status" => TRUE));
    }
 
 
    private function _validate()
    {
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;
 
        if($this->input->post('id_inventaris') == '')
        {
            $data['inputerror'][] = 'id_inventaris';
            $data['error_string'][] = 'id inventaris';
            $data['status'] = FALSE;
        }
 
        if($this->input->post('nama_inventaris') == '')
        {
            $data['inputerror'][] = 'nama_inventaris';
            $data['error_string'][] = 'nama_inventaris';
            $data['status'] = FALSE;
        }

        if($this->input->post('kondisi') == '')
        {
            $data['inputerror'][] = 'kondisi';
            $data['error_string'][] = 'kondisi';
            $data['status'] = FALSE;
        }
 
        if($this->input->post('keterangan') == '')
        {
            $data['inputerror'][] = 'keterangan';
            $data['error_string'][] = 'keterangan';
            $data['status'] = FALSE;
        }
 
        if($this->input->post('jumlah') == '')
        {
            $data['inputerror'][] = 'jumlah';
            $data['error_string'][] = 'jumlah';
            $data['status'] = FALSE;
        }

        if($this->input->post('id_jenis') == '')
        {
            $data['inputerror'][] = 'id_jenis';
            $data['error_string'][] = 'id_jenis';
            $data['status'] = FALSE;
        }
        if($this->input->post('tanggal_register') == '')
        {
            $data['inputerror'][] = 'tanggal_register';
            $data['error_string'][] = 'tanggal_register';
            $data['status'] = FALSE;
        }
        if($this->input->post('id_ruang') == '')
        {
            $data['inputerror'][] = 'id_ruang';
            $data['error_string'][] = 'id_ruang';
            $data['status'] = FALSE;
        }
        if($this->input->post('kode_inventaris') == '')
        {
            $data['inputerror'][] = 'kode_inventaris';
            $data['error_string'][] = 'kode_inventaris';
            $data['status'] = FALSE;
        }
        if($this->input->post('id_petugas') == '')
        {
            $data['inputerror'][] = 'id_petugas';
            $data['error_string'][] = 'id_petugas';
            $data['status'] = FALSE;
        }
        if($data['status'] === FALSE)
        {
            echo json_encode($data);
            exit();
        }
    }

    public function ajax_id_inventaris(){
        $data = $this->inventaris->get_by_id_inventaris($id_inventaris);
         
        echo json_encode($data);
    }
 
}
