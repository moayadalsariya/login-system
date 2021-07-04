<?php
class landing extends Controller{
    public function index($name = ''){
        $user = $this->model('User');
        $this->view("landing");

    }
}