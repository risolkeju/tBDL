<?php

class Dashboard_seller extends CI_Controller{
   
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

    // public function index()
    // {
    //     $this->load->view('templates_seller/header');
    //     $this->load->view('templates_seller/sidebar');
    //     $this->load->view('seller/dashboard');
    //     $this->load->view('templates_seller/footer');
    // }

    public function index()
	{
        $data['hasil']=$this->model_laporan->jum_laporan_toko();
        $this->load->view('templates_seller/header');
        $this->load->view('templates_seller/sidebar');
        $this->load->view('seller/dashboard', $data);
        $this->load->view('templates_seller/footer');
	}
}