<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Detail_pinjam extends CI_Controller {
 
    public function __construct()
    {
        parent::__construct();
        $this->load->model('m_detail_pinjam','detail_pinjam');
    }
 
    public function index()
    {
        $this->load->helper('url');
        $this->load->helper('form');
        
        $this->load->view('v_detail_pinjam');
    }
 
    public function ajax_list()
    {
        $list = $this->detail_pinjam->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $detail_pinjam) {
            $no++;
            $row = array();
            $row[] = $detail_pinjam->id_detail_pinjam;
            $row[] = $detail_pinjam->nama_inventaris;
            $row[] = $detail_pinjam->jumlah;
            // $row[] = $detail_pinjam->status_peminjaman;
           
            // if($detail_pinjam->id_inventaris)
            // $row[] = $this->db->query("SELECT nama_inventaris FROM inventaris, detail_pinjam WHERE inventaris.id_inventaris=id_inventaris.detail_pinjam");

 
            //add html for action
            $row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit" onclick="edit_detail_pinjam('."'".$detail_pinjam->id_detail_pinjam."'".')"><i class="glyphicon glyphicon-pencil"></i> Edit</a>
                  <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Hapus" onclick="delete_detail_pinjam('."'".$detail_pinjam->id_detail_pinjam."'".')"><i class="glyphicon glyphicon-trash"></i> Delete</a>';
         
            $data[] = $row;
        }
 
        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->detail_pinjam->count_all(),
                        "recordsFiltered" => $this->detail_pinjam->count_filtered(),
                        "data" => $data,
                );
        //output to json format
        echo json_encode($output);
    }
 
    public function ajax_edit($id_detail_pinjam)
    {
        $data = $this->detail_pinjam->get_by_id($id_detail_pinjam);
         
        echo json_encode($data);
    }
 
    public function ajax_add()
    {
        $this->_validate();
        $data = array(
                'id_detail_pinjam' => $this->input->post('id_detail_pinjam'),
                'id_inventaris' => $this->input->post('id_inventaris'),
                'jumlah' => $this->input->post('jumlah'),
                // 'id_peminjaman' => $this->input->post('id_peminjaman')
            );
        $insert = $this->detail_pinjam->save($data);
        echo json_encode(array("status" => TRUE));
    }
 
    public function ajax_update()
    {
        $this->_validate();
        $data = array(
                'id_inventaris' => $this->input->post('id_inventaris'),
                'jumlah' => $this->input->post('jumlah'),
                // 'id_peminjaman' => $this->input->post('id_peminjaman')
            );
        $this->detail_pinjam->update(array('id_detail_pinjam' => $this->input->post('id_detail_pinjam')), $data);
        echo json_encode(array("status" => TRUE));
    }
 
    public function ajax_delete($id_detail_pinjam)
    {
        $this->detail_pinjam->delete_by_id($id_detail_pinjam);
        echo json_encode(array("status" => TRUE));
    }
 
 
    private function _validate()
    {
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;
 
        if($this->input->post('id_detail_pinjam') == '')
        {
            $data['inputerror'][] = 'id_detail_pinjam';
            $data['error_string'][] = 'No detail pinjam tidak boleh kosong';
            $data['status'] = FALSE;
        }
 
        if($this->input->post('id_inventaris') == '')
        {
            $data['inputerror'][] = 'id_inventaris';
            $data['error_string'][] = 'No inventaris tidak boleh kosong';
            $data['status'] = FALSE;
        }

        if($this->input->post('jumlah') == '')
        {
            $data['inputerror'][] = 'jumlah';
            $data['error_string'][] = 'Jumlah tidak boleh kosong';
            $data['status'] = FALSE;
        }
 
        // if($this->input->post('id_peminjaman') == '')
        // {
        //     $data['inputerror'][] = 'id_peminjaman';
        //     $data['error_string'][] = 'No peminjaman tidak boleh kosong';
        //     $data['status'] = FALSE;
        // }

        if($data['status'] === FALSE)
        {
            echo json_encode($data);
            exit();
        }
    }

    public function ajax_inventaris(){
        $data = $this->detail_pinjam->get_by_id_inventaris($id_inventaris);
         
        echo json_encode($data);
    }
 
}
