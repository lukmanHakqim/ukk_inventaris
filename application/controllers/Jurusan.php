<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Jurusan extends CI_Controller {
 
    public function __construct()
    {
        parent::__construct();
        $this->load->model('jurusan_model','jurusan');
    }
 
    public function index()
    {
        $this->load->helper('url');
        $this->load->helper('form');
      
        $this->load->view('jurusan_view');
    }
 
    public function ajax_list()
    {
        $list = $this->jurusan->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $jurusan) {
            $no++;
            $row = array();
            $row[] = $jurusan->id_jurusan;
            $row[] = $jurusan->jurusan;
            $row[] = $jurusan->keterangan;
            $row[] = $jurusan->tahun;

            if($jurusan->id_kurikulum)
            $row[] = $this->db->query("SELECT kurikulum FROM kurikulum WHERE id_kurikulum");

            $row[] = $jurusan->id_sekolah;
            $row[] = $jurusan->akreditasi;
 
            //add html for action
            $row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit" onclick="edit_jurusan('."'".$jurusan->id_jurusan."'".')"><i class="glyphicon glyphicon-pencil"></i> Edit</a>
                  <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Hapus" onclick="delete_jurusan('."'".$jurusan->id_jurusan."'".')"><i class="glyphicon glyphicon-trash"></i> Delete</a>';
         
            $data[] = $row;
        }
 
        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->jurusan->count_all(),
                        "recordsFiltered" => $this->jurusan->count_filtered(),
                        "data" => $data,
                );
        //output to json format
        echo json_encode($output);
    }
 
    public function ajax_edit($id_jurusan)
    {
        $data = $this->jurusan->get_by_id($id_jurusan);
         
        echo json_encode($data);
    }
 
    public function ajax_add()
    {
        $this->_validate();
        $data = array(
                'id_jurusan' => $this->input->post('id_jurusan'),
                'jurusan' => $this->input->post('jurusan'),
                'tahun' => $this->input->post('tahun'),
                'id_kurikulum' => $this->input->post('id_kurikulum'),
                'id_sekolah' => $this->input->post('id_sekolah'),
                'akreditasi' => $this->input->post('akreditasi'),
            );
        $insert = $this->jurusan->save($data);
        echo json_encode(array("status" => TRUE));
    }
 
    public function ajax_update()
    {
        $this->_validate();
        $data = array(
                'id_jurusan' => $this->input->post('id_jurusan'),
                'jurusan' => $this->input->post('jurusan'),
                'tahun' => $this->input->post('tahun'),
                'id_kurikulum' => $this->input->post('id_kurikulum'),
                'id_sekolah' => $this->input->post('id_sekolah'),
                'akreditasi' => $this->input->post('akreditasi'),
            );
        $this->jurusan->update(array('id_jurusan' => $this->input->post('id_jurusan')), $data);
        echo json_encode(array("status" => TRUE));
    }
 
    public function ajax_delete($id_jurusan)
    {
        $this->jurusan->delete_by_id($id_jurusan);
        echo json_encode(array("status" => TRUE));
    }
 
 
    private function _validate()
    {
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;
 
        if($this->input->post('id_jurusan') == '')
        {
            $data['inputerror'][] = 'id_jurusan';
            $data['error_string'][] = 'no jurusan';
            $data['status'] = FALSE;
        }
 
        if($this->input->post('jurusan') == '')
        {
            $data['inputerror'][] = 'jurusan';
            $data['error_string'][] = 'nama jurusan';
            $data['status'] = FALSE;
        }

 
        if($this->input->post('tahun') == '')
        {
            $data['inputerror'][] = 'tahun';
            $data['error_string'][] = 'tahun';
            $data['status'] = FALSE;
        }

        if($this->input->post('id_kurikulum') == '')
        {
            $data['inputerror'][] = 'id_kurikulum';
            $data['error_string'][] = 'id kurikulum';
            $data['status'] = FALSE;
        }
 
        if($this->input->post('id_sekolah') == '')
        {
            $data['inputerror'][] = 'id_sekolah';
            $data['error_string'][] = 'id sekolah';
            $data['status'] = FALSE;
        }

        if($this->input->post('akreditasi') == '')
        {
            $data['inputerror'][] = 'akreditasi';
            $data['error_string'][] = 'status akreditasi';
            $data['status'] = FALSE;
        }

        if($data['status'] === FALSE)
        {
            echo json_encode($data);
            exit();
        }
    }

    public function ajax_kurikulum(){
        $data = $this->jurusan->get_by_id_kurikulum($id_kurikulum);
         
        echo json_encode($data);
    }
 
}
