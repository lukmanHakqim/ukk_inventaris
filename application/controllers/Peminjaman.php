<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Peminjaman extends CI_Controller {
 
    public function __construct()
    {
        parent::__construct();
        $this->load->model('m_peminjaman','peminjaman');
    }
 
    public function index()
    {
        $this->load->helper('url');
        $this->load->helper('form');
        
        $this->load->view('v_peminjaman');
    }
 
    public function ajax_list()
    {
        $list = $this->peminjaman->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $peminjaman) {
            $no++;
            $row = array();
            $row[] = $peminjaman->id_peminjaman;
            $row[] = $peminjaman->tanggal_peminjaman;
            $row[] = $peminjaman->tanggal_kembali;
            $row[] = $peminjaman->status_peminjaman;
            $row[] = $peminjaman->nama_pegawai;
           
            // if($peminjaman->id_pegawai)
            // $row[] = $this->db->query("SELECT nama_pegawai FROM pegawai, peminjaman WHERE pegawai.id_pegawai=id_pegawai.peminjaman");

 
            //add html for action
            $row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit" onclick="edit_peminjaman('."'".$peminjaman->id_peminjaman."'".')"><i class="glyphicon glyphicon-pencil"></i> Edit</a>
                  <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Hapus" onclick="delete_peminjaman('."'".$peminjaman->id_peminjaman."'".')"><i class="glyphicon glyphicon-trash"></i> Delete</a>';
         
            $data[] = $row;
        }
 
        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->peminjaman->count_all(),
                        "recordsFiltered" => $this->peminjaman->count_filtered(),
                        "data" => $data,
                );
        //output to json format
        echo json_encode($output);
    }
 
    public function ajax_edit($id_peminjaman)
    {
        $data = $this->peminjaman->get_by_id($id_peminjaman);
         
        echo json_encode($data);
    }
 
    public function ajax_add()
    {
        $this->_validate();
        $data = array(
                'id_peminjaman' => $this->input->post('id_peminjaman'),
                'tanggal_peminjaman' => $this->input->post('tanggal_peminjaman'),
                'tanggal_kembali' => $this->input->post('tanggal_kembali'),
                'status_peminjaman' => $this->input->post('status_peminjaman'),
                'id_pegawai' => $this->input->post('id_pegawai'),
            );
        $insert = $this->peminjaman->save($data);
        echo json_encode(array("status" => TRUE));
    }
 
    public function ajax_update()
    {
        $this->_validate();
        $data = array(
                'id_peminjaman' => $this->input->post('id_peminjaman'),
                'tanggal_peminjaman' => $this->input->post('tanggal_peminjaman'),
                'tanggal_kembali' => $this->input->post('tanggal_kembali'),
                'status_peminjaman' => $this->input->post('status_peminjaman'),
                'id_pegawai' => $this->input->post('id_pegawai'),
            );
        $this->peminjaman->update(array('id_peminjaman' => $this->input->post('id_peminjaman')), $data);
        echo json_encode(array("status" => TRUE));
    }
 
    public function ajax_delete($id_peminjaman)
    {
        $this->peminjaman->delete_by_id($id_peminjaman);
        echo json_encode(array("status" => TRUE));
    }
 
 
    private function _validate()
    {
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;
 
        if($this->input->post('id_peminjaman') == '')
        {
            $data['inputerror'][] = 'id_peminjaman';
            $data['error_string'][] = 'id peminjaman';
            $data['status'] = FALSE;
        }
 
        if($this->input->post('tanggal_peminjaman') == '')
        {
            $data['inputerror'][] = 'tanggal_peminjaman';
            $data['error_string'][] = 'tanggal_peminjaman';
            $data['status'] = FALSE;
        }

        if($this->input->post('tanggal_kembali') == '')
        {
            $data['inputerror'][] = 'tanggal_kembali';
            $data['error_string'][] = 'tanggal_kembali';
            $data['status'] = FALSE;
        }
 
        if($this->input->post('status_peminjaman') == '')
        {
            $data['inputerror'][] = 'status_peminjaman';
            $data['error_string'][] = 'status_peminjaman';
            $data['status'] = FALSE;
        }
 
        if($this->input->post('id_pegawai') == '')
        {
            $data['inputerror'][] = 'id_pegawai';
            $data['error_string'][] = 'id pegawai';
            $data['status'] = FALSE;
        }

        if($data['status'] === FALSE)
        {
            echo json_encode($data);
            exit();
        }
    }

    public function ajax_pegawai(){
        $data = $this->peminjaman->get_by_id_pegawai($id_pegawai);
         
        echo json_encode($data);
    }
 
}
