<?php

class Invoice extends CI_Controller{
    
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
        $data['invoice'] = $this->model_invoice->tampil_data_toko();
        $this->load->view('templates_seller/header');
        $this->load->view('templates_seller/sidebar');
        $this->load->view('seller/invoice',$data);
        $this->load->view('templates_seller/footer');
    }

    public function detail($id_invoice)
    {
        $data['detail'] = $this->model_invoice->detail_invoice_toko($id_invoice);
        $data['invoice'] = $this->model_invoice->ambil_id_invoice_toko($id_invoice);
        $this->load->view('templates_seller/header');
        $this->load->view('templates_seller/sidebar');
        $this->load->view('seller/detail_invoice',$data);
        $this->load->view('templates_seller/footer');
    }
}