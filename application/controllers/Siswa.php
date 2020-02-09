<?php defined('BASEPATH') OR exit('No direct script access allowed'); 
class Siswa extends CI_Controller {     public function __construct()     {         
    parent::__construct();         
    $this->load->model('siswa_model','siswa');
    }
 
    public function index()
    {
        $this->load->helper('url');
        $this->load->view('siswa_view');
    }
 
    public function ajax_list()
    {
        $this->load->helper('url');
 
        $list = $this->siswa->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $siswa) {
            $no++;
            $row = array();
            $row[] = $siswa->id_siswa;
            $row[] = $siswa->nisn;
            $row[] = $siswa->nis;
            $row[] = $siswa->nama;
            $row[] = $siswa->jenis_kelamin;
            $row[] = $siswa->tempat_lahir;
            $row[] = $siswa->tanggal_lahir;
            $row[] = $siswa->pendidikan;
            $row[] = $siswa->alamat;
            $row[] = $siswa->no_telp;
            $row[] = $siswa->email;
            $row[] = $siswa->id_jurusan;
            if($siswa->photo)
                $row[] = '<a href="'.base_url('upload/'.$siswa->photo).'" target="_blank"><img src="'.base_url('upload/'.$siswa->photo).'" class="img-responsive" /></a>';
            else
                $row[] = '(No photo)';
 
            //add html for action
            $row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit" onclick="edit_siswa('."'".$siswa->id_siswa."'".')"><i class="glyphicon glyphicon-pencil"></i> Edit</a>
                  <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Hapus" onclick="delete_siswa('."'".$siswa->id_siswa."'".')"><i class="glyphicon glyphicon-trash"></i> Delete</a>';
         
            $data[] = $row;
        }
 
        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->siswa->count_all(),
                        "recordsFiltered" => $this->siswa->count_filtered(),
                        "data" => $data,
                );
        //output to json format
        echo json_encode($output);
    }
 
    public function ajax_edit($id_siswa)
    {
        $data = $this->siswa->get_by_id($id_siswa);
        $data->tanggal_lahir = ($data->tanggal_lahir == '0000-00-00') ? '' : $data->tanggal_lahir; // if 0000-00-00 set tu empty for datepicker compatibility
        echo json_encode($data);
    }
 
    public function ajax_add()
    {
        $this->_validate();
         
        $data = array(
                'id_siswa' => $this->input->post('id_siswa'),
                'nisn' => $this->input->post('nisn'),
                'nis' => $this->input->post('nis'),
                'nama' => $this->input->post('nama'),
                'jenis_kelamin' => $this->input->post('jenis_kelamin'),
                'tempat_lahir' => $this->input->post('tempat_lahir'),
                'tanggal_lahir' => $this->input->post('tanggal_lahir'),
                'pendidikan' => $this->input->post('pendidikan'),
                'alamat' => $this->input->post('alamat'),
                'no_telp' => $this->input->post('no_telp'),
                'email' => $this->input->post('email'),
                'id_jurusan' => $this->input->post('id_jurusan'),
            );
 
        if(!empty($_FILES['photo']['name']))
        {
            $upload = $this->_do_upload();
            $data['photo'] = $upload;
        }
 
        $insert = $this->siswa->save($data);
 
        echo json_encode(array("status" => TRUE));
    }
 
    public function ajax_update()
    {
        $this->_validate();
        $data = array(
                 'id_siswa' => $this->input->post('id_siswa'),
                'nisn' => $this->input->post('nisn'),
                'nis' => $this->input->post('nis'),
                'nama' => $this->input->post('nama'),
                'jenis_kelamin' => $this->input->post('jenis_kelamin'),
                'tempat_lahir' => $this->input->post('tempat_lahir'),
                'tanggal_lahir' => $this->input->post('tanggal_lahir'),
                'pendidikan' => $this->input->post('pendidikan'),
                'alamat' => $this->input->post('alamat'),
                'no_telp' => $this->input->post('no_telp'),
                'email' => $this->input->post('email'),
                'id_jurusan' => $this->input->post('id_jurusan'),
            );
 
        if($this->input->post('remove_photo')) // if remove photo checked
        {
            if(file_exists('upload/'.$this->input->post('remove_photo')) && $this->input->post('remove_photo'))
                unlink('upload/'.$this->input->post('remove_photo'));
            $data['photo'] = '';
        }
 
        if(!empty($_FILES['photo']['name']))
        {
            $upload = $this->_do_upload();
             
            //delete file
            $siswa = $this->siswa->get_by_id($this->input->post('id_siswa'));
            if(file_exists('upload/'.$siswa->photo) && $siswa->photo)
                unlink('upload/'.$siswa->photo);
 
            $data['photo'] = $upload;
        }
 
        $this->siswa->update(array('id_siswa' => $this->input->post('id_siswa')), $data);
        echo json_encode(array("status" => TRUE));
    }
 
    public function ajax_delete($id_siswa)
    {
        //delete file
        $siswa = $this->siswa->get_by_id($id_siswa);
        if(file_exists('upload/'.$siswa->photo) && $siswa->photo)
            unlink('upload/'.$siswa->photo);
         
        $this->siswa->delete_by_id($id_siswa);
        echo json_encode(array("status" => TRUE));
    }
 
    private function _do_upload()
    {
        $config['upload_path']          = 'upload/';
        $config['allowed_types']        = 'gif|jpg|png';
        $config['max_size']             = 100; //set max size allowed in Kilobyte
        $config['max_width']            = 1000; // set max width image allowed
        $config['max_height']           = 1000; // set max height allowed
        $config['file_name']            = round(microtime(true) * 1000); //just milisecond timestamp fot unique name
 
        $this->load->library('upload', $config);
 
        if(!$this->upload->do_upload('photo')) //upload and validate
        {
            $data['inputerror'][] = 'photo';
            $data['error_string'][] = 'Upload error: '.$this->upload->display_errors('',''); //show ajax error
            $data['status'] = FALSE;
            echo json_encode($data);
            exit();
        }
        return $this->upload->data('file_name');
    }
 
    private function _validate()
    {
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;
 
        if($this->input->post('id_siswa') == '')
        {
            $data['inputerror'][] = 'id_siswa';
            $data['error_string'][] = 'No Urut Siswa';
            $data['status'] = FALSE;
        }
 
        if($this->input->post('nisn') == '')
        {
            $data['inputerror'][] = 'nisn';
            $data['error_string'][] = 'No Induk Siswa Sekolah Nasional';
            $data['status'] = FALSE;
        }
 
        if($this->input->post('nis') == '')
        {
            $data['inputerror'][] = 'nis';
            $data['error_string'][] = 'No Induk Siswa';
            $data['status'] = FALSE;
        }
 
        if($this->input->post('jenis_kelamin') == '')
        {
            $data['inputerror'][] = 'jenis_kelamin';
            $data['error_string'][] = 'Jenis Kelamin';
            $data['status'] = FALSE;
        }
 
        if($this->input->post('tempat_lahir') == '')
        {
            $data['inputerror'][] = 'tempat_lahir';
            $data['error_string'][] = 'Kota Tempat Lahir';
            $data['status'] = FALSE;
        }
 
        if($this->input->post('tanggal_lahir') == '')
        {
            $data['inputerror'][] = 'tanggal_lahir';
            $data['error_string'][] = 'Tanggal Lahir';
            $data['status'] = FALSE;
        }

        if($this->input->post('pendidikan') == '')
        {
            $data['inputerror'][] = 'pendidikan';
            $data['error_string'][] = 'pendidikan';
            $data['status'] = FALSE;
        }

        if($this->input->post('alamat') == '')
        {
            $data['inputerror'][] = 'alamat';
            $data['error_string'][] = 'Alamat Rumah';
            $data['status'] = FALSE;
        }

        if($this->input->post('no_telp') == '')
        {
            $data['inputerror'][] = 'no_telp';
            $data['error_string'][] = 'No Hp';
            $data['status'] = FALSE;
        }
         if($this->input->post('email') == '')
        {
            $data['inputerror'][] = 'email';
            $data['error_string'][] = 'Email';
            $data['status'] = FALSE;
        }
         if($this->input->post('id_jurusan') == '')
        {
            $data['inputerror'][] = 'id_jurusan';
            $data['error_string'][] = 'Jurusan';
            $data['status'] = FALSE;
        }
        if($data['status'] === FALSE)
        {
            echo json_encode($data);
            exit();
        }
    }
 
}
