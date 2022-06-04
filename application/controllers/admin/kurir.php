<?php

class Kurir extends CI_Controller{ 
    
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
        $data['kurir'] = $this->model_kurir->tampil_data()->result();
        $this->load->view('templates_admin/header');
        $this->load->view('templates_admin/sidebar');
        $this->load->view('admin/kurir', $data);
        $this->load->view('templates_admin/footer');
    }

    public function input()
    {
        $data = array(
            'id_kurir'       => set_value('id_kurir'),
            'nama_kurir'     => set_value('nama_kurir'),
            'jenis_kurir'    => set_value('jenis_kurir'),
            'layanan'        => set_value('layanan'),
            'harga'          => set_value('harga'),
        );
        $this->load->view('templates_admin/header');
        $this->load->view('templates_admin/sidebar');
        $this->load->view('admin/form_kurir', $data);
        $this->load->view('templates_admin/footer');
    }

    public function input_aksi()
    {
        $this->_rules();

        if($this->form_validation->run() == FALSE) {
            $this->input();
        } else{
            $data = array(
                'nama_kurir'     => $this->input->post('nama_kurir', TRUE),
                'jenis_kurir'    => $this->input->post('jenis_kurir', TRUE),
                'layanan'        => $this->input->post('layanan', TRUE),
                'harga'          => $this->input->post('harga', TRUE),
            );

            $this->model_kurir->input_data($data);
            $this->session->set_flashdata('pesan', '<div 
                    class="alert alert-danger alert-dismissible fade show" role="alert">
              Data kurir berhasil ditambahkan!
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
              </button>
            </div>');
            redirect('admin/kurir');
        }
    }

    public function _rules()
    {
        $this->form_validation->set_rules('nama_kurir','nama kurir','required', ['required' => 'This field is required!']);
        $this->form_validation->set_rules('jenis_kurir','jenis kurir','required', ['required' => 'This field is required!']);
        $this->form_validation->set_rules('layanan','layanan','required', ['required' => 'This field is required!']);
        $this->form_validation->set_rules('harga','harga','required', ['required' => 'This field is required!']);
    }

    public function edit($id)
    {
        $where = array('id_kurir' =>$id); 
        $data['kurir'] = $this->model_kurir->edit_kurir($where, 'tb_kurir')->result();
        $this->load->view('templates_admin/header');
        $this->load->view('templates_admin/sidebar');
        $this->load->view('admin/edit_kurir', $data);
        $this->load->view('templates_admin/footer');
    }

    public function update()
    {
        $id                     = $this->input->post('id_kurir');
        $nama_kurir             = $this->input->post('nama_kurir');
        $jenis_kurir            = $this->input->post('jenis_kurir');
        $layanan                = $this->input->post('layanan'); 
        $harga                  = $this->input->post('harga'); 
    
        $data = array(
            'nama_kurir'            => $nama_kurir,
            'jenis_kurir'           => $jenis_kurir,
            'layanan'               => $layanan,
            'harga'                 => $harga
        );

        $where = array(
            'id_kurir'              => $id
        ); 

        $this->model_kurir->update_data($where,$data,'tb_kurir');
        redirect('admin/kurir/index'); 
    }

    public function hapus ($id){
        $where = array('id_kurir' => $id); 
        $this->model_kurir->hapus_data($where, 'tb_kurir');
        redirect('admin/kurir/index'); 
    } 
    
}