<?php

class Kategori extends CI_Controller{
    public function health_and_beauty()
    {
        $data['health_and_beauty'] = $this->model_kategori->data_health_and_beauty()->result();
        $this->load->view('templates/header'); 
        $this->load->view('templates/sidebar'); 
        $this->load->view('health_and_beauty',$data);
        $this->load->view('templates/footer');   
    }

    public function babies_and_moms()
    {
        $data['babies_and_moms'] = $this->model_kategori->data_babies_and_moms()->result();
        $this->load->view('templates/header'); 
        $this->load->view('templates/sidebar'); 
        $this->load->view('babies_and_moms',$data);
        $this->load->view('templates/footer');   
    }

    public function clothing_and_apparel()
    {
        $data['clothing_and_apparel'] = $this->model_kategori->data_clothing_and_apparel()->result();
        $this->load->view('templates/header'); 
        $this->load->view('templates/sidebar'); 
        $this->load->view('clothing_and_apparel',$data);
        $this->load->view('templates/footer');   
    }

    public function computer_and_technology()
    {
        $data['computer_and_technology'] = $this->model_kategori->data_computer_and_technology()->result();
        $this->load->view('templates/header'); 
        $this->load->view('templates/sidebar'); 
        $this->load->view('computer_and_technology',$data);
        $this->load->view('templates/footer');   
    }
    
    public function home_garden_and_kitchen()
    {
        $data['home_garden_and_kitchen'] = $this->model_kategori->data_home_garden_and_kitchen()->result();
        $this->load->view('templates/header'); 
        $this->load->view('templates/sidebar'); 
        $this->load->view('home_garden_and_kitchen',$data);
        $this->load->view('templates/footer');   
    }

} 