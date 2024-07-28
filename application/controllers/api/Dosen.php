<?php

use Restserver\Libraries\REST_Controller;

defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';
class Dosen extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Dosen_model', 'dosen');

        $this->methods['index_get']['limit'] = 10;
    }
    public function index_get()
    {
        $id = $this->get('id');
        if ($id === null) {
            $dosen = $this->dosen->getDosen();
        } else {
            $dosen = $this->dosen->getDosen($id);
        }
        if ($dosen) {
            $this->response([
                'status' => true,
                'data' => $dosen
            ], REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'status' => false,
                'data' => 'id not found'
            ], REST_Controller::HTTP_NOT_FOUND);
        }
    }
    public function index_delete()
    {
        $id = $this->delete('id');
        if ($id === null) {
            $this->response([
                'status' => false,
                'message' => 'provide an id!'
            ], REST_Controller::HTTP_BAD_REQUEST);
        } else {
            if ($this->dosen->deleteDosen($id) > 0) {
                //ok
                $this->response([
                    'status' => true,
                    'id' => $id,
                    'message' => 'data dosen has been deleted!'
                ], REST_Controller::HTTP_NO_CONTENT);
            } else {
                //id not found
                $this->response([
                    'status' => false,
                    'message' => 'id not found!'
                ], REST_Controller::HTTP_BAD_REQUEST);
            }
        }
    }
    public function index_post()
    {
        $data = [
            'id' => $this->post('id'),
            'no_dosen' => $this->post('no_dosen'),
            'nama' => $this->post('nama'),
            'email' => $this->post('email')
        ];
        if ($this->dosen->createDosen($data) > 0) {
            $this->response([
                'status' => true,
                'message' => 'new dosen has been created.'
            ], REST_Controller::HTTP_CREATED);
        } else {
            //id not found
            $this->response([
                'status' => false,
                'message' => 'failed to create new data!'
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }
    public function index_put()
    {
        // kenapa dibedakan agar id masuk ke where
        $id = $this->put('id');
        $data = [
            'id' => $this->put('id'),
            'no_dosen' => $this->put('no_dosen'),
            'nama' => $this->put('nama'),
            'email' => $this->put('email')
        ];
        if ($this->dosen->updateDosen($data, $id) > 0) {
            $this->response([
                'status' => true,
                'message' => 'data dosen has been updated.'
            ], REST_Controller::HTTP_NO_CONTENT);
        } else {
            //id not found
            $this->response([
                'status' => false,
                'message' => 'failed to update data!'
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }
}
