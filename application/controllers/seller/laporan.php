<?php

class Laporan extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();

        if ($this->session->userdata('role_id') != '3') {
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
        $data['tahun'] = $this->model_laporan->getTahun();
        $this->load->view('templates_seller/header');
        $this->load->view('templates_seller/sidebar');
        $this->load->view('seller/laporan', $data);
        $this->load->view('templates_seller/footer');
    }

    function filter()
    {
        $awal = $this->input->post('awal');
        $akhir = $this->input->post('akhir');
        $tahun1 = $this->input->post('tahun1');
        $bulanawal = $this->input->post('bulanawal');
        $bulanakhir = $this->input->post('bulanakhir');
        $tahun2 = $this->input->post('tahun2');
        $nilai = $_POST['nilai'];
        /*$this->input->post('nilai')*/
        if ($nilai == 1) {
            $data['title'] = "Laporan Penjualan per Tanggal";
            $data['subtitle'] = "Dari Tanggal: " . $awal . 'sampai' . $akhir;
            $data['datafilter'] = $this->model_laporan->filterTanggal_toko($awal, $akhir);
            $this->load->view('templates_seller/header');
            // $this->load->view('templates_seller/sidebar');
            $this->load->view('seller/print_laporan_tgl', $data);
            $this->load->view('templates_seller/footer');
        } elseif ($nilai == 2) {
            $data['title'] = "Laporan Penjualan Bulanan";
            $data['subtitle'] = "Dari Bulan: " . $bulanawal . 'sampai' . $bulanakhir . "Tahun " . $tahun1;
            $data['datafilter'] = $this->model_laporan->filterBulan_toko($tahun1, $bulanawal, $bulanakhir);
            $this->load->view('templates_seller/header');
            // $this->load->view('templates_seller/sidebar');
            $this->load->view('seller/print_laporan', $data);
            $this->load->view('templates_seller/footer');
        } elseif ($nilai == 3) {
            $data['title'] = "Laporan Penjualan Tahunan";
            $data['subtitle'] = 'Tahun: ' . $tahun2;
            $data['datafilter'] = $this->model_laporan->filterTahun($tahun2);
            $this->load->view('templates_seller/header');
            // $this->load->view('templates_seller/sidebar');
            $this->load->view('seller/print_laporan', $data);
            $this->load->view('templates_seller/footer');
        }
    }
}