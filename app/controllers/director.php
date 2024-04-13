<?php

class DIRECTOR extends Controller
{

    // function __construct()
    // {
    //     if (!Auth::is_director()) {
    //         message('You are not authorized to view this page');
    //         redirect('login');
    //     }
    // }

    public function index()
    {
        $degree = new Degree();

        // $degree->insert($_POST);
        // show($_POST);

        $data['degrees'] = $degree->findAll();
        //show($data['degrees']);

        $this->view('director-interfaces/director-dashboard', $data);
    }
    public function notifications()
    {
        $notification = new NotificationModel();
        $data['notifications'] = $notification->findAll();

        $this->view('director-interfaces/director-notification', $data);
    }
    public function degreeprograms()
    {
        $degree = new Degree();

        // $degree->insert($_POST);
        // show($_POST);

        $data['degrees'] = $degree->findAll();
        //show($data['degrees']);

        $this->view('director-interfaces/director-degreeprograms', $data);
    }
    

    public function participants($id = null, $action = null, $id2 = null)
    {

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
        $this->view('director-interfaces/director-participants', $data);
    }
    // public function userprofile()
    // {
    //     $degree = new Degree();

    //     // $degree->insert($_POST);
    //     // show($_POST);
    //     $student = new StudentModel();
    //     $data['student'] = $student->findAll();
    //     $data['degrees'] = $degree->findAll();
    //     //show($data['degrees']);

    //     $this->view('director-interfaces/director-userprofile', $data);
    // }
    public function settings()
    {
        $user = new User();


        if (isset($_POST['update_user_data'])) {
            $id = $_SESSION['USER_DATA']->id;
            $dataToUpdate = [
                'fname' => $_POST['fname'],
                'lname' => $_POST['lname'],
                'email' => $_POST['email'],
                'phoneNo' => $_POST['phoneNo']
            ];

            $user->update($id, $dataToUpdate);

            $updatedUserData = $user->first(['id' => $id]);

            if ($updatedUserData === null) {
                echo 'No user data found after update.';
                exit();
            }

            $data['user'] = $updatedUserData;
        } else {
            $id = $_SESSION['USER_DATA']->id;
            $data['user'] = $user->first(['id' => $id]);

            if ($data['user'] === null) {
                echo 'No user data found.';
                exit();
            }
        }

        $this->view('director-interfaces/director-settings', $data);
    }

    public function userprofile()
    {
        $degree = new Degree();
        $data['degrees'] = $degree->findAll();

        // Fetch the specific student data using the ID from the URL
        $studentId = isset($_GET['studentId']) ? $_GET['studentId'] : null;
        // show($studentId);
        // Check if the student ID is provided in the URL
        if ($studentId) {
            $studentModel = new StudentModel();
            $data['student'] = $studentModel->find($studentId);
            // var_dump($data['student']);
            // Check if the student data is retrieved
            if ($data['student']) {
                $this->view('director-interfaces/director-userprofile', $data);
            } else {
                echo "Error: Student not found.";
            }
        } else {
            echo "Error: Student ID not provided in the URL.";
        }
    }
    public function login()
    {
        $this->view('common/login/login.view');
    }

    public function degreeprofile($action = null, $id = null)
{
    $data = [];
    $data['action'] = $action;
    $data['id'] = $id;
    $degreeID = isset($_GET['id']) ? $_GET['id'] : null;
    // Check if degree ID is provided
    if ($degreeID !== null) {
        $degree = new Degree();
        $subject = new Subjects();
        $degreeTimeTable = new DegreeTimeTable();
        // Fetch the data based on the ID
        $degreeData = $degree->find($degreeID);
        $degreeTimeTableData = $degreeTimeTable->find($degreeID);
        $subjectsData = $subject->find($degreeID);
        $data['degrees'] = $degreeData;
        $subjects = [];
        foreach ($subjectsData as $subject) {
            $semesterNumber = $subject->semester;
            // Create semester array if not already exists
            if (!isset($subjects[$semesterNumber])) {
                $subjects[$semesterNumber] = [];
            }
            // Add subject to semester array
            $subjects[$semesterNumber][] = $subject;
        }
        $data['subjects'] = $subjects;
        $data['degreeTimeTable'] = $degreeTimeTableData;

        // Load the view with the data
        $this->view('director-interfaces/director-degreeprofile', $data);
    } else {
        echo "Error: Degree ID not provided in the URL.";
    }
}
}
