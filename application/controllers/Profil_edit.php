<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Profil_edit extends CI_Controller
{
    public function index()
    {
        $this->load->model('User_model');
        $dataProfile = $this->session->userdata('user');
        $id = $dataProfile['id'];
        $data['user'] = $this->User_model->getAdminById($id);
        $this->load->view('templates/navbar');
        $this->load->view('templates/footer');

        $current_password = $this->input->post('current_password');
        $new_password = $this->input->post('new_password');
        $repeat_password = $this->input->post('repeat_password');
        $correct_password = $this->session->userdata('password');

        if ($current_password == null) {
            // $this->session->set_flashdata('pesan', 'Password Lama Kosong!');
            $this->load->view('profil-edit', $data);
        } else if ($current_password != $correct_password) {
            $this->session->set_flashdata('pesan', 'Password Lama Salah!');
            $this->load->view('profil-edit', $data);
        } else if ($new_password == null) {
            $this->session->set_flashdata('pesan', 'Password Baru Kosong!');
            $this->load->view('profil-edit', $data);
        } else if ($repeat_password == null) {
            $this->session->set_flashdata('pesan', 'Konfirmasi Password Kosong!');
            $this->load->view('profil-edit', $data);
        } else if ($new_password != $repeat_password) {
            $this->session->set_flashdata('pesan', 'Konfirmasi Password Salah!');
            $this->load->view('profil-edit', $data);
        } else {
            $this->changepassword();
        }
    }

    private function changepassword()
    {
        $current_password = $this->input->post('current_password');
        $new_password = $this->input->post('new_password');
        $repeat_password = $this->input->post('repeat_password');
        $correct_password = $this->session->userdata('password');
        $idUser = $this->session->userdata('id');

        $this->db->set('password', $new_password);
        $this->db->where('id_admin', $idUser);
        $this->db->update('admin');

        $this->session->set_userdata('password', $new_password);

        redirect('Profil');
    }
}
