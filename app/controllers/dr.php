<?php

class DR extends Controller
{
    // function __construct()
    // {
    //     if (!Auth::is_dr()) {
    //         message('You are not authorized to view this page');
    //         redirect('login');
    //     }
    // }

    public function index()
    {
        $degree = new Degree();
        // show( $_POST );
        $_SESSION['DegreeID'] = null;
        unset($_SESSION['DegreeID']);

        $data['degrees'] = $degree->findAll();
        $this->view('dr-interfaces/dr-dashboard', $data);
    }

    public function notification()
    {
        $this->view('dr-interfaces/dr-notification');
    }

    public function degreeprograms($action = null, $id = null)
    {
        // show($_POST);
        $degree_name = "";
        $duration = 0;
        $degree = new Degree();
        $subject = new Subjects();
        $grade = new Grades();
        unset($_SESSION['DegreeID']);
        $data = [];
        $data['action'] = $action;
        $data['id'] = $id;

        if ($action == 'add') {
            if ($_SERVER['REQUEST_METHOD'] == "POST") {
                $currentYear = date('Y');
                if ($_POST['degree_type'] === "1 Year") {
                    $duration = 1;
                } else if ($_POST['degree_type'] === "2 Year") {
                    $duration = 2;
                }
                if (($_POST['select_degree_type']) === 'DLIM') {
                    $degree_name = "Diploma in Library Information Management";
                } else if (($_POST['select_degree_type']) === 'DPL') {
                    $degree_name = "Diploma in Public Librarianship";
                } else if (($_POST['select_degree_type']) === 'DSL') {
                    $degree_name = "Diploma in School Librarianship";
                }
                $data = [
                    'DegreeType' => $_POST['degree_type'],
                    'DegreeShortName' => $_POST['select_degree_type'],
                    'DegreeName' => $degree_name,
                    'Duration' => $duration,
                    'AcademicYear' => $currentYear,
                ];
                $degree->insert($data);
                $degree_id = $degree->lastID('DegreeID');
                if (isset($_POST['subjectsData'])) {
                    // Decode the JSON string sent with key 'subjectsData'
                    $subjectsData = json_decode($_POST['subjectsData'], true);
                    // Iterate over each subject's data and insert it into the database
                    foreach ($subjectsData as $subjectData) {
                        // Construct the data array for insertion
                        $data1 = [
                            'SubjectCode' => $subjectData['subjectCode'],
                            'SubjectName' => $subjectData['subjectName'],
                            'NoCredits' => $subjectData['credits'],
                            'DegreeID' => $degree_id,
                            'semester' => $subjectData['semester'],
                        ];
                        // Insert the subject's data into the database
                        $subject->insert($data1);
                    }
                }
                if (isset($_POST['gradesData'])) {
                    // Decode the JSON string sent with key 'gradesData'
                    $gradesData = json_decode($_POST['gradesData'], true);
                    // Iterate over each grade's data and insert it into the database
                    foreach ($gradesData as $gradeData) {
                        // Construct the data array for insertion
                        $data2 = [
                            'Grade' => $gradeData['grade'],
                            'MaxMarks' => $gradeData['maxMarks'],
                            'MinMarks' => $gradeData['minMarks'],
                            'GPV' => $gradeData['gpv'],
                            'DegreeID' => $degree_id,
                        ];
                        // Insert the grade's data into the database
                        $grade->insert($data2);
                    }
                }
                redirect("dr/newdegree");
            }
        }
        $data['degrees'] = $degree->findAll();
        $data['subjects'] = $subject->findAll();
        $data['grades'] = $grade->findAll();

        $this->view('dr-interfaces/dr-degreeprograms', $data);
    }

    public function degreeprofile($action = null, $id = null)
    {
        $data = [];
        $data['action'] = $action;
        $data['id'] = $id;
        if (isset($_GET['id'])) {
            $degreeID = isset($_GET['id']) ? $_GET['id'] : null;
            $_SESSION['DegreeID'] = $degreeID;
            redirect("dr/degreeprofile");
        }
        // $url = $_SERVER['REQUEST_URI'];
        // $parts = parse_url($url);
        // $path_parts = explode('/', $parts['path']);
        // $degreeID = end($path_parts);
        $degreeID = $_SESSION['DegreeID'];
        $_SESSION['DegreeID'] = $degreeID; 
        // echo $degreeID;
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
            if($subjectsData) {
                foreach ($subjectsData as $subject) {
                    $semesterNumber = $subject->semester;
                    // Create semester array if not already exists
                    if (!isset($subjects[$semesterNumber])) {
                        $subjects[$semesterNumber] = [];
                    }
                    // Add subject to semester array
                    $subjects[$semesterNumber][] = $subject;
                }
            }
            $data['subjects'] = $subjects;
            $data['degreeTimeTable'] = $degreeTimeTableData;
            if ($action == "update") {
                echo "update ";
                if ($_SERVER['REQUEST_METHOD'] == "POST") {
                    show($_POST);
                    echo "POST request received ";
                    if (isset($_POST['timetableData'])) {
                        $timetableData = json_decode($_POST['timetableData'], true);
                        // Iterate over each subject's data and insert it into the database
                        foreach ($timetableData as $timetableDataItem) {
                            echo "a";
                            // Construct the data array for insertion
                            $data1 = [
                                'EventID' => $timetableDataItem['eventID'],
                                'DegreeID' => $degreeID,
                                'EventName' => $timetableDataItem['eventName'],
                                'EventType' => $timetableDataItem['eventType'],
                                'StartingDate' => $timetableDataItem['eventStart'],
                                'EndingDate' => $timetableDataItem['eventEnd'],
                            ];
                            echo json_encode($data1);
                            $degreeTimeTable->update($degreeID, $data1);
                            redirect("dr/degreeprofile");
                        }
                    }
                }
            } else if ($action == 'delete') {
                echo "delete";
                $degree->delete($degreeID);
                redirect("dr/degreeprograms");
            }
            // Load the view with the data
            $this->view('dr-interfaces/dr-degreeprofile', $data);
        } else {
            echo "Error: Degree ID not provided in the URL.";
        }
    }



    public function newDegree($action = null, $id = null)
    {
        $degree = new Degree();
        $student = new StudentModel();
        $timeTable = new DegreeTimeTable();
        $data = [];
        $data['action'] = $action;
        $data['id'] = $id;
        if ($_SESSION['DegreeID'] == null) {
            $degree_id = $degree->lastID('DegreeID');
            $_SESSION['DegreeID'] = $degree_id;
        } else {
            $degree_id = $_SESSION['DegreeID'];
        }
        // echo $degree_id;
        $degree_info = (object)$degree->findByID($degree_id);
        $degreeShortName =  $degree_info->DegreeShortName;
        $currentYear = $degree_info->AcademicYear;
        $currentYear = $currentYear % 100;
        if ($action == 'add') {
            if ($_SERVER['REQUEST_METHOD'] == "POST") {
                if (isset($_POST['timetableData'])) {
                    $timetableData = json_decode($_POST['timetableData'], true);
                    // Iterate over each subject's data and insert it into the database
                    foreach ($timetableData as $timetablesData) {
                        // Construct the data array for insertion
                        $data1 = [
                            'EventID' => $timetablesData['eventID'],
                            'DegreeID' => $degree_id,
                            'EventName' => $timetablesData['eventName'],
                            'EventType' => $timetablesData['eventType'],
                            'StartingDate' => $timetablesData['eventStart'],
                            'EndingDate' => $timetablesData['eventEnd'],
                        ];
                        $timeTable->insert($data1);
                    }
                }
                redirect("dr/degreeprofile");
            }
        } else {
            // Write the header row to the CSV file
            $rowData = ['Full-Name', 'Email', 'Country', 'NIC-No', 'Date-Of-Birth', 'whatsappNo', 'Address', 'Phone-No'];
            // get uploaded csv fill
            $studentCSV = 'assets/csv/output/student-data-input.csv';
            // Create CSV file to getstudent data
            $f = fopen($studentCSV, 'w');
            fputcsv($f, $rowData);
            if ($f == false) {
                echo "<script>console.log('file is not open successfully');</script>";
            }
            fclose($f);
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['student-data']) && $_POST['student-data'] == 'upload-csv') {
                echo "pakaya";
                if (isset($_FILES['student-data']) && $_FILES['student-data']['error'] === UPLOAD_ERR_OK) {
                    $uploadDirectory = 'assets/csv/input/';
                    // Ensure the directory exists and set proper permissions
                    if (!is_dir($uploadDirectory)) {
                        mkdir($uploadDirectory, 0777, true);
                        chmod($uploadDirectory, 0777);
                    }
                    $fileName = $_FILES['student-data']['name'];
                    $fileTmpName = $_FILES['student-data']['tmp_name'];
                    $targetPath = $uploadDirectory . basename($fileName);
                    if (move_uploaded_file($fileTmpName, $targetPath)) {
                        echo "<script>console.log('File uploaded successfully.');</script>";
                        // Inside your newDegree function after successful file upload
                        $csvFile = fopen($targetPath, 'r');
                        // Skip the header row
                        fgetcsv($csvFile);
                        while (($rowData = fgetcsv($csvFile)) !== false) {
                            // Assuming the order of columns in the CSV matches the order in the $rowData array
                            $IndexNo = $student->generateIndexRegNumber($degree_id, $degreeShortName, $currentYear);
                            if ($IndexNo !== false && $IndexNo['IndexNo'] != null && $IndexNo['RegistationNo'] != null) {
                                $data = [
                                    'Email' => $rowData[1],
                                    'country' => $rowData[2],
                                    'name' => $rowData[0],
                                    'nicNo' => $rowData[3],
                                    'birthdate' => $rowData[4],
                                    'whatsappNo' => $rowData[5],
                                    'address' => $rowData[6],
                                    'phoneNo' => $rowData[7],
                                    'degreeID' => $degree_id,
                                    'indexNo' => $IndexNo['IndexNo'],
                                    'regNo' => $IndexNo['RegistationNo'],
                                ];
                                $student->insert($data);
                            } else {
                                echo "Error: Failed to generate index and registration numbers.";
                            }
                        }
                        fclose($csvFile);
                    } else {
                        echo "<script>console.log('Failed to upload file.');</script>";
                    }
                } else {
                    echo "<script>console.log('Error uploading file.');</script>";
                }
            }
        }
        $this->view('dr-interfaces/dr-newdegree');
    }
    public function userprofile($action = null, $id = null)
    {
        $data = [];
        $data['action'] = $action;
        $data['id'] = $id;
        if (isset($_GET['id'])) {
            $studentId = isset($_GET['id']) ? $_GET['id'] : null;
            $_SESSION['studentId'] = $studentId;
            redirect("dr/userprofile");
        } else {
            $studentId = null;
        }
        $studentId = $_SESSION['studentId'];
        $_SESSION['studentId'] = $studentId;
        // Check if the student ID is provided in the URL
        if ($studentId) {
            echo "student";
            $degree = new Degree();
            $studentModel = new StudentModel();
            $data['student'] = $studentModel->findstudentid($studentId);
            $degree_id = $data['student'][0]->degreeID;
            $data['degree'] = $degree->find($degree_id);
            if ($data['student']) {
                $this->view('dr-interfaces/dr-userprofile', $data);
            } else {
                echo "Error: Student not found.";
            }
            if ($action == "update") {
                $studentModel->update($studentId, $data['student']);
                redirect("dr/userprofile");
            } else if ($action == 'delete') {
                echo "delete";
                $studentModel->delete(['id' => $studentId]);
                redirect("dr/participants");
            }
        } else {
            echo "Error: Student ID not provided in the URL.";
        }
    }



    public function participants($id = null, $action = null)
    {
        $st = new StudentModel();
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
        } else {
            echo "Error: DegreeID not provided in the session."; // If DegreeID is not set in the session
        }
        $this->view('dr-interfaces/dr-participants', $data);
    }

    public function settings()
    {
        $this->view('dr-interfaces/dr-settings');
    }
    public function reports()
    {
        $this->view('dr-interfaces/dr-reports');
    }
    public function attendance()
    {
        $this->view('dr-interfaces/dr-attendance');
    }
    public function examination()
    {
        $this->view('dr-interfaces/dr-examination');
    }
    public function login()
    {
        $this->view('login/login.view');
    }
}   
