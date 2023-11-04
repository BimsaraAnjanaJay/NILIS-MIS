<?php

class DR extends Controller{

    public function index(){

        $degree = new Degree();

        // $degree->insert($_POST);
        // show($_POST);

        $data['degrees'] = $degree->findAll();
        //show($data['degrees']);

        $this->view('dr-interfaces/dr-dashboard',$data);
    }

    public function notification(){
        $this->view('dr-interfaces/dr-notification');
    }
    public function degreeprograms(){
        $degree = new Degree();

        // $degree->insert($_POST);
        // show($_POST);

        $data['degrees'] = $degree->findAll();
        //show($data['degrees']);

        $this->view('dr-interfaces/dr-degreeprograms',$data);
    }
    public function degreeprofile(){
        $degree = new Degree();

        // $degree->insert($_POST);
        // show($_POST);

        $data['degrees'] = $degree->findAll();
        // show($data['degrees']);

        $this->view('dr-interfaces/dr-degreeprofile',$data);
    }
    public function newDegree(){
        $degree = new Degree();

        // $degree->insert($_POST);
        // show($_POST);

        $data['degrees'] = $degree->findAll();
        //show($data['degrees']);

        $this->view('dr-interfaces/dr-newdegree',$data);
    }
    public function userprofile(){
        $degree = new Degree();

        // $degree->insert($_POST);
        // show($_POST);

        $data['degrees'] = $degree->findAll();
        //show($data['degrees']);

        $this->view('dr-interfaces/dr-userprofile',$data);
    }
    public function participants($id = null, $action = null, $id2 = null){
       
        $st = new StudentModel();
        if (!empty($id)) {
            if (!empty($action)) {
                if ($action === 'delete' && !empty($id2)) {
                    $st->delete(["id" => $id2]);
                }
            } else if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                // print_r($_POST);
                // die;
                $st->update($_POST['id'], $_POST);
                //    redirect('student/'.$id);
                $data['student'] = $st->where(['indexNo' => $id])[0];

                $this->view('common/student/student.view', $data);
                return;
            } else {
                $data['student'] = $st->where(['indexNo' => $id])[0];
               
                $this->view('common/student/student.view', $data);
                return;
            }
        }
        $data['students'] = $st->findAll();
        //print_r($data);
        // die;
        $this->view('dr-interfaces/dr-participants.view', $data);
    }
    public function settings(){
        $this->view('dr-interfaces/dr-settings');
    }
    public function login(){
        $this->view('login/login.view');
    }

}

?>