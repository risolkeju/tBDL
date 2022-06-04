<?php

class Toko extends CI_Controller{

    public function __construct(){ 
        parent::__construct(); 

        if($this->session->userdata('role_id') != '1'){
            $this->session->set_flashdata('pesan', '<div 
            class="alert alert-danger alert-dismissible fade show" role="alert">
      You are not logged in!
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
      </button>
    </div>'); 
    redirect('auth/login');
        }
    }

    public function index()
    {
        $data['toko'] = $this->model_toko->tampil_data('tb_toko')->result();
        $this->load->view('templates_admin/header');
        $this->load->view('templates_admin/sidebar');
        $this->load->view('admin/toko', $data);
        $this->load->view('templates_admin/footer');
    }

    public function detail($id_toko)
    {
        $data['toko'] = $this->model_toko->ambil_id_toko($id_toko);
        $data['data_barang'] = $this->model_toko->ambil_id_barang_toko($id_toko);
        $this->load->view('templates_admin/header');
        $this->load->view('templates_admin/sidebar');
        $this->load->view('admin/detail_toko', $data);
        $this->load->view('templates_admin/footer');
    }

    public function tambah_toko()
    {
        $data['toko'] = $this->model_toko->tampil_data('tb_toko')->result();
        $this->load->view('templates_admin/header');
        $this->load->view('templates_admin/sidebar');
        $this->load->view('admin/form_toko', $data);
        $this->load->view('templates_admin/footer');
    }

    public function tambah_toko_aksi()
    {
        $config['upload_path']       = './img/gambar_toko/';
        $config['allowed_types']     = 'jpg|jpeg|png|gif|ico|jfif';
        // $config['max_size']         = '2000';
        $this->load->library('upload');
        $this->upload->initialize($config);
        // $field_name = 'gambar';

        $upload_data                = array('uploads' => $this->upload->data());
        $config['image_library']    = 'gd2';
        $config['source_image']     = './img/gambar_toko/' . $upload_data['uploads']['file_name'];
        $this->load->library('image_lib', $config);
        
        $nama_toko      = $this->input->post('nama_toko');
        $keterangan     = $this->input->post('keterangan');
        $tgl_bergabung  = $this->input->post('tgl_bergabung');
        $alamat_toko    = $this->input->post('alamat_toko');

        $data = array(
            'id_user' => $this->session->userdata('id'),
            'nama_toko'         => $nama_toko,
            'keterangan'        => $keterangan,
            'tgl_bergabung'     => $tgl_bergabung,
            'alamat_toko'       => $alamat_toko,
            'gambar'            => $upload_data['uploads']['file_name']
        );
        $this->model_toko->input_data($data);
        $this->session->set_flashdata('pesan', '<div 
                    class="alert alert-danger alert-dismissible fade show" role="alert">
              Data toko berhasil ditambahkan!
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
              </button>
            </div>');
        redirect('admin/toko');
    
    }

    public function _rules()
    {
        $this->form_validation->set_rules('id_user','id user','required', ['required' => 'This field is required!']);
        $this->form_validation->set_rules('nama_toko','nama toko','required', ['required' => 'This field is required!']);
        $this->form_validation->set_rules('keterangan','keterangan','required', ['required' => 'This field is required!']);
        $this->form_validation->set_rules('tgl_bergabung','tanggal bergabung','required', ['required' => 'This field is required!']);
        $this->form_validation->set_rules('alamat_toko','alamat toko','required', ['required' => 'This field is required!']);
    }

    public function edit($id)
    {
        $where = array('id_toko' => $id);
        $data['toko'] = $this->model_toko->edit_toko($where, 'tb_toko')->result();
        $this->load->view('templates_admin/header');
        $this->load->view('templates_admin/sidebar');
        $this->load->view('admin/edit_toko', $data);
        $this->load->view('templates_admin/footer');
    }

    public function update()
    {
        $id                 = $this->input->post('id_toko');
        $id_user            = $this->input->post('id_user');
        $nama_toko          = $this->input->post('nama_toko');
        $keterangan         = $this->input->post('keterangan');
        $tgl_bergabung      = $this->input->post('tgl_bergabung');
        $alamat_toko        = $this->input->post('alamat_toko');

        $data = array(
            'id_user'        => $id_user,
            'nama_toko'      => $nama_toko,
            'keterangan'     => $keterangan,
            'tgl_bergabung'  => $tgl_bergabung,
            'alamat_toko'    => $alamat_toko,
        );

        $where = array(
            'id_toko' => $id
        );

        $this->model_toko->update_data($where,$data,'tb_toko');
        redirect('admin/toko/index');
    }

    public function hapus($id)
    {
        $where = array('id_toko' => $id);
        $this->model_toko->hapus_data($where, 'tb_toko');
        redirect('admin/toko/index');
    }

}  
