<?php

class Data_barang extends CI_Controller{
    
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
        $data['barang'] = $this->model_barang->tampil_data('tb_barang')->result();
        $this->load->view('templates_admin/header');
        $this->load->view('templates_admin/sidebar');
        $this->load->view('admin/data_barang', $data);
        $this->load->view('templates_admin/footer');
    }

    public function detail($id_brg)
    {
        $data['detail'] = $this->model_barang->ambil_id_brg($id_brg);
        $this->load->view('templates_admin/header');
        $this->load->view('templates_admin/sidebar');
        $this->load->view('admin/detail_barang', $data);
        $this->load->view('templates_admin/footer');
    }
    
    public function detail_barang($id_brg)
    {
        $data['data_barang'] = $this->model_barang->ambil_id_barang($id_brg);
        $this->load->view('templates_admin/header');
        $this->load->view('templates_admin/sidebar');
        $this->load->view('admin/detail_barang', $data);
        $this->load->view('templates_admin/footer');
    }

    public function tambah_barang()
    {
        $data['barang'] = $this->model_barang->tampil_data('tb_barang')->result();
        $this->load->view('templates_admin/header');
        $this->load->view('templates_admin/sidebar');
        $this->load->view('admin/form_barang', $data);
        $this->load->view('templates_admin/footer');
    }

    public function tambah_barang_aksi()
    {
        $this->_rules();

        if($this->form_validation->run() == FALSE){
            $this->tambah_barang();
        } else{
            $id_toko        = $this->input->post('id_toko');
            $nama_brg       = $this->input->post('nama_brg');
            $keterangan     = $this->input->post('keterangan');
            $nama_toko      = $this->input->post('nama_toko');
            $kategori       = $this->input->post('kategori');
            $harga          = $this->input->post('harga');
            $stok           = $this->input->post('stok');
            $gambar         = $_FILES['gambar'];
            if($gambar=''){} else{
                $config['upload_path'] = './uploads/';
                $config['allowed_types'] = 'jpg|jpeg|png|gif';

                $this->load->library('upload', $config);
                if(!$this->upload->do_upload('gambar')){
                    echo "Gambar Gagal Diupload!"; die();
                } else{
                    $gambar = $this->upload->data('file_name');
                }
            }

            $data = array(
                'id_toko'       => $id_toko,
                'nama_brg'      => $nama_brg,
                'keterangan'    => $keterangan,
                'nama_toko'     => $nama_toko,
                'kategori'      => $kategori,
                'harga'         => $harga,
                'stok'          => $stok,
                'gambar'        => $gambar
            );

            $this->model_barang->input_data($data, 'tb_barang');
            $this->session->set_flashdata('pesan', '<div 
                    class="alert alert-danger alert-dismissible fade show" role="alert">
              Data barang berhasil ditambahkan!
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
              </button>
            </div>');
            redirect('admin/data_barang');
        }
    }

    public function _rules()
    {
        $this->form_validation->set_rules('id_toko','nama barang','required', ['required' => 'This field is required!']);
        $this->form_validation->set_rules('nama_brg','nama barang','required', ['required' => 'This field is required!']);
        $this->form_validation->set_rules('keterangan','keterangan','required', ['required' => 'This field is required!']);
        $this->form_validation->set_rules('nama_toko','nama toko','required', ['required' => 'This field is required!']);
        $this->form_validation->set_rules('kategori','kategori','required', ['required' => 'This field is required!']);
        $this->form_validation->set_rules('harga','harga','required', ['required' => 'This field is required!']);
        $this->form_validation->set_rules('stok','stok','required', ['required' => 'This field is required!']);
    }
    
    public function edit($id)
    {
        $where = array('id_brg' => $id);
        $data['barang'] = $this->model_barang->edit_barang($where, 'tb_barang')->result();
        $this->load->view('templates_admin/header');
        $this->load->view('templates_admin/sidebar');
        $this->load->view('admin/edit_barang', $data);
        $this->load->view('templates_admin/footer');
    }

    public function update(){
        $id             = $this->input->post('id_brg');
        $id_toko        = $this->input->post('id_toko');
        $nama_brg       = $this->input->post('nama_brg');
        $keterangan     = $this->input->post('keterangan');
        $nama_toko      = $this->input->post('nama_toko');
        $kategori       = $this->input->post('kategori');
        $harga          = $this->input->post('harga');
        $stok           = $this->input->post('stok');

        $data = array(
            'id_toko'       => $id_toko,
            'nama_brg'      => $nama_brg,
            'keterangan'    => $keterangan,
            'nama_toko'     => $nama_toko,
            'kategori'      => $kategori,
            'harga'         => $harga,
            'stok'          => $stok
        );

        $where = array(
            'id_brg' => $id
        );

        $this->model_barang->update_data($where,$data,'tb_barang');
        redirect('admin/data_barang/index');
    }

    public function hapus($id)
    {
        $where = array('id_brg' => $id);
        $this->model_barang->hapus_data($where, 'tb_barang');
        redirect('admin/data_barang/index');
    }

}