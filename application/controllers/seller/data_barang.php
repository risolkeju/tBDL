<?php

class Data_barang extends CI_Controller{
    
    public function __construct(){ 
        parent::__construct(); 

        if($this->session->userdata('role_id') != '3'){
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
        $username = $this->session->userdata('username');
        $data['barang'] = $this->model_seller->tampil_data($username)->result();
        $this->load->view('templates_seller/header');
        $this->load->view('templates_seller/sidebar');
        $this->load->view('seller/data_barang', $data);
        $this->load->view('templates_seller/footer');
    }

    public function detail($id_brg)
    {
        $data['detail'] = $this->model_seller->ambil_id_brg($id_brg);
        $this->load->view('templates_seller/header');
        $this->load->view('templates_seller/sidebar');
        $this->load->view('seller/detail_barang', $data);
        $this->load->view('templates_seller/footer');
    }

    public function tambah_barang()
    {
        $data['barang'] = $this->model_seller->tampil_data('tb_barang')->result();
        $this->load->view('templates_seller/header');
        $this->load->view('templates_seller/sidebar');
        $this->load->view('seller/form_barang', $data);
        $this->load->view('templates_seller/footer');
    }

    public function tambah_barang_aksi()
    {       
        $nama_brg       = $this->input->post('nama_brg');
        $keterangan     = $this->input->post('keterangan');
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
            'id_toko'       => $this->session->userdata('id_toko'),
            'nama_brg'      => $nama_brg,
            'keterangan'    => $keterangan,
            'nama_toko'     => $this->session->userdata('nama_toko'),
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
        redirect('seller/data_barang');
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
        $data['barang'] = $this->model_seller->edit_barang($where, 'tb_barang')->result();
        $this->load->view('templates_seller/header');
        $this->load->view('templates_seller/sidebar');
        $this->load->view('seller/edit_barang', $data);
        $this->load->view('templates_seller/footer');
    }

    public function update(){
        $id             = $this->input->post('id_brg');
        $nama_brg       = $this->input->post('nama_brg');
        $keterangan     = $this->input->post('keterangan');
        $kategori       = $this->input->post('kategori');
        $harga          = $this->input->post('harga');
        $stok           = $this->input->post('stok');

        $data = array(
            'id_toko'       => $this->session->userdata('id_toko'),
            'nama_brg'      => $nama_brg,
            'keterangan'    => $keterangan,
            'nama_toko'     => $this->session->userdata('nama_toko'),
            'kategori'      => $kategori,
            'harga'         => $harga,
            'stok'          => $stok
        );

        $where = array(
            'id_brg' => $id
        );

        $this->model_seller->update_data($where,$data,'tb_barang');
        redirect('seller/data_barang/index/');
    }

    public function hapus($id)
    {
        $where = array('id_brg' => $id);
        $this->model_seller->hapus_data($where, 'tb_barang');
        redirect('seller/data_barang/index');
    }

}