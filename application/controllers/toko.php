<?php

class Toko extends CI_Controller{

    public function index()
    {
        $data['toko'] = $this->model_toko->tampil_data('tb_toko')->result();
        $this->load->view('templates/header');
        $this->load->view('templates/sidebar');
        $this->load->view('toko', $data);
        $this->load->view('templates/footer');
    }

    public function detail($id_toko)
    {
        $data['toko'] = $this->model_toko->detail_toko($id_toko);
        $data['barang'] = $this->model_toko->detail_brg_toko($id_toko);
        $this->load->view('templates/header');
        $this->load->view('templates/sidebar');
        $this->load->view('detail_toko', $data);
        $this->load->view('templates/footer');
    }

}