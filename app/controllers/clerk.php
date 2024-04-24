<?php

class Clerk extends Controller
{

    // function __construct()
    // {
    //     if (!Auth::is_clerk()) {
    //         message('You are not authorized to view this page');
    //         redirect('login');
    //     }
    // }
    public function index()
    {
        $user = new User();
        $degree = new Degree();
        $student = new StudentModel();
        $exam = new Exam();
        // $notification = new NotificationModel();
        // $notification_count_arr = $notification->countNotifications();
        $finalMarks = new FinalMarks();
        $recentExamId = $finalMarks->lastID('examID');

        //join exam and degree tables
        $dataTables = ['degree'];
        $columns = ['*'];
        $examConditions = ['exam.degreeID = degree.DegreeID', 'exam.examID = ' . $recentExamId];
        $data['RecentResultExam'] = $exam->join($dataTables, $columns, $examConditions);

        // show($data['RecentResultExam']);
        $_SESSION['getid'] = null;
        unset($_SESSION['getid']);

        $_SESSION['DegreeID'] = null;
        unset($_SESSION['DegreeID']);

        $data['title'] = 'Dashboard';
        $data['notification_count_obj'] = getNotificationCount();

        // $data['notification_count_obj'] = $notification_count_arr[0];
        $data['user'] = $user->findAll();
        $data['degrees'] = $degree->findAll();
        $data['students'] = $student->findAll();
        $data['exams'] = $exam->findAll();
        $this->view('clerk-interfaces/clerk-dashboard', $data);
    }

    public function notification()
    {
        $notification = new NotificationModel();
        $username = $_SESSION['USER_DATA']->username;
        $data['usernames'] = $username;

        $data['notification_count_obj'] = getNotificationCount();
        $data['notifications'] = $notification->findAll();
        $this->view('clerk-interfaces\clerk-notification', $data);
    }

    public function updatedattendance()
    {
        $attendance = new studentAttendance();
        $data['attendances'] = $attendance->findAll();
        // show($attendance);
        // show($data['attendances']);
      
        $degree = new Degree();

        if (!empty($_SESSION['DegreeID'])) {
            $degreeId = $_SESSION['DegreeID'];
        }
        $data['degreedata'] = $degree->find($degreeId);
        // show($data['degreedata']);
        $this->view('clerk-interfaces\clerk-updatedattendance', $data);
    }

    public function degreeprograms()
    {

        $degree = new Degree();
        unset($_SESSION['DegreeID']);

        $data['degrees'] = $degree->findAll();
        $this->view('clerk-interfaces\clerk-degreeprograms', $data);
    }

    public function settings()
    {
        $user = new User();
        $data = [];

        if (isset($_POST['update_user_data'])) {
            // Validate input fields
            $fname = isset($_POST['fname']) ? trim($_POST['fname']) : '';
            $lname = isset($_POST['lname']) ? trim($_POST['lname']) : '';
            $phoneNo = isset($_POST['phoneNo']) ? trim($_POST['phoneNo']) : '';

            // Update user data
            $id = $_SESSION['USER_DATA']->id;
            $dataToUpdate = [
                'fname' => $fname,
                'lname' => $lname,
                'phoneNo' => $phoneNo
            ];

            $user->update($id, $dataToUpdate);
            header('Location:settings');
            exit;
        }

        // Fetch user data for display
        $id = $_SESSION['USER_DATA']->id;
        $data['user'] = $user->first(['id' => $id]);

        if ($data['user'] === null) {
            $data['error'] = 'No user data found.';
        }

        $this->view('clerk-interfaces/clerk-settings', $data);
    }

    public function attendance()
    {
        $degree = new Degree();

        if (!empty($_SESSION['DegreeID'])) {
            $degreeId = $_SESSION['DegreeID'];
        }
        //get degree details
        $data['degreedata'] = $degree->find($degreeId);
        // show($_SESSION['DegreeID']);
        // show($data['degreedata']);

        $st = new StudentModel();
        foreach ($st->findAll() as $student) {
            if (is_object($student) && $student->degreeID == $degreeId) {
                $students[] = $student;
                // show($student);
                // Add student to data array
            }
        }

        if (!empty($degreeId)) {
            $head = 'Name of  Programme  : ' . $degreeId;
            $rowHeadings = ['Index No', 'Registration No', 'Attendance'];
            $attedancesheet = 'assets/csv/output/Attendance_' . $degreeId . '.csv';
            $f = fopen($attedancesheet, 'w');

            if ($f == false) {
                echo 'file is not open successfully';
            } else {
                fputcsv($f, [$head]);
                fputcsv($f, array());
                fputcsv($f, $rowHeadings);

                $sortedData = sortArray($students, 'indexNo');

                if (!empty($sortedData)) {
                    foreach ($sortedData as $participant) {
                        $rowData = [$participant->indexNo, $participant->regNo];
                        fputcsv($f, $rowData);
                    }
                }
                fclose($f);
            }
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['importSubmit'])) {
            // Check if the uploaded file is present and no errors occurred during upload
            if ($_FILES['csvFile']['error'] == 0 && !empty($_FILES['csvFile']['tmp_name'])) {
                // Load StudentModel
                $studentAttendance = new studentAttendance();
                $degree_name = $_POST['selectDegree'];
                // Process the CSV file
                $csvFile = fopen($_FILES['csvFile']['tmp_name'], 'r');

                // Skip the first four rows
                for ($i = 0; $i < 4; $i++) {
                    fgetcsv($csvFile);
                }

                // Start reading from the 4th row and first column
                // $row = 3; 
                while (($line = fgetcsv($csvFile)) !== FALSE) {
                    // $row++;

                    // // Skip rows until reaching the 4th row
                    // if ($row < 4) {
                    //     continue;
                    // }

                    // Read data from the first column (index 0)
                    $index_no = $line[0];
                    $reg_no = $line[1];
                    $attendance = $line[2];


                    // Check if the record already exists
                    $existingData = $studentAttendance->where(['index_no' => $index_no]);
                    if ($existingData) {
                        // If record exists, update it
                        $updateData = [
                            'attendance' => $attendance,
                            'degree_name' => $degree_name
                        ];
                        $whereConditions = [
                            'index_no' => $index_no
                        ];
                        $studentAttendance->updateRows($updateData, $whereConditions);
                    } else {
                        // show($_POST);
                        // If record doesn't exist, insert it
                        $insertData = [
                            'index_no' => $index_no,
                            'degree_name' => $degree_name,
                            'attendance' => $attendance
                        ];
                        // show($insertData);
                        $studentAttendance->insert($insertData);
                    }
                }

                fclose($csvFile);
                header('Location: ' . $_SERVER['REQUEST_URI']);
                exit();
            } else {
                echo "Error uploading the file.";
            }
        }
        // echo "$_SESSION[getid]";
        // $data['degrees'] = $degree->findAll();

        // Load the view with the data
        $this->view('clerk-interfaces/clerk-attendance', $data);
    }


    public function degreeprofile($action = null, $id = null)
    {
        $data = [];
        $data['action'] = $action;
        $data['id'] = $id;

        if (isset($_GET['id'])) {
            $degreeID = isset($_GET['id']) ? $_GET['id'] : null;
            $_SESSION['DegreeID'] = $degreeID;
            redirect("clerk/degreeprofile");
        }
        $degreeID = $_SESSION['DegreeID'];
        $_SESSION['DegreeID'] = $degreeID;
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
            $this->view('clerk-interfaces/clerk-degreeprofile', $data);
        } else {
            echo "Error: Degree ID not provided in the URL.";
        }
    }

    public function participants($id = null, $action = null)
    {
        $st = new StudentModel();
        $degree = new Degree();
        $data = [];
        $data['action'] = $action;
        $data['id'] = $id;

        unset($_SESSION['studentId']);
        if (isset($_SESSION['DegreeID'])) {
            $degreeID = $_SESSION['DegreeID'];
            // Iterate through students to find those with the given DegreeID
            foreach ($st->findAll() as $student) {
                if (is_object($student) && $student->degreeID == $degreeID) {
                    $data['students'][] = $student; // Add student to data array
                }
            }
            $data['degrees'] = $degree->find($degreeID);
        } else {
            echo "Error: DegreeID not provided in the session."; // If DegreeID is not set in the session
        }
        $this->view('clerk-interfaces/clerk-participants', $data);
    }

    public function userprofile($action = null, $id = null)
    {
        $data = [];
        $data['action'] = $action;
        $data['id'] = $id;
        
        if (isset($_GET['id'])) {
            $studentId = isset($_GET['id']) ? $_GET['id'] : null;
            $_SESSION['studentId'] = $studentId;
            redirect("clerk/userprofile");
        } else {
            $studentId = null;
        }
        $studentId = $_SESSION['studentId'];
        $_SESSION['studentId'] = $studentId;
        if ($studentId) {  // Check if the student ID is provided in the URL
            $degree = new Degree();
            $studentModel = new StudentModel();
            $finalMarks = new FinalMarks();
            $exam = new Exam();
            $studentId = $_SESSION['studentId']; // Get student ID from session
            $degreeId = $_SESSION['DegreeID']; // Get degree ID from session
            $data['student'] = $studentModel->findwhere("id", $studentId);
            $data['degrees'] = $degree->find($degreeId);
            $data['Degree'] = $degree->findAll();
            $studentIndex = $data['student'][0]->indexNo;
            // echo $studentIndex;
            $data['finalMarks'] = $finalMarks->findwhere("studentIndexNo", $studentIndex);
            $data['exams'] = $exam->find($degreeId);
            $this->view('clerk-interfaces/clerk-userprofile', $data);
        } else {
            echo "Error: Student ID not provided in the URL.";
        }
    }

    public function reports()
    {

        $this->view('clerk-interfaces/clerk-reports');
    }

    
}
