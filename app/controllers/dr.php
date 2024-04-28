<?php

class DR extends Controller
{
    function __construct()
    {
        if (!Auth::is_dr()) {
            // message('You are not authorized to view this page');
            redirect('_403_');
        }
    }

    public function index()
    {
        $degree = new Degree();
        $student = new StudentModel();
        $exam = new Exam();
        $finalMarks = new FinalMarks();
        $degreetimetable = new DegreeTimeTable();
        $recentExamId = $finalMarks->lastID('examID');

        //join exam and degree tables
        if (!empty($recentExamId)) {
            $dataTables = ['degree'];
            $columns = ['*'];
            $examConditions = ['exam.degreeID = degree.DegreeID', 'exam.examID = ' . $recentExamId];
            $data['RecentResultExam'] = $exam->join($dataTables, $columns, $examConditions);
        } else {
            $data['RecentResultExam'] = null;
        }

        // show( $_POST );
        $_SESSION['DegreeID'] = null;
        unset($_SESSION['DegreeID']);

        $data['degrees'] = $degree->findAll();
        $data['students'] = $student->findAll();
        $data['exam'] = $exam->findAll();
        $data['degreetimetables'] = $degreetimetable->findAll();
        $data['notification_count_obj_dr'] = getNotificationCountDR();
        $this->view('dr-interfaces/dr-dashboard', $data);
    }

    public function notifications()
    {
        $notification = new NotificationModel();
        $data['notifications'] = $notification->findAll();
        $data['notification_count_obj_dr'] = getNotificationCountDR();

        $username = $_SESSION['USER_DATA']->username;
        $data['usernames'] = $username;
        $data['notification_count_obj'] = getNotificationCountDR();

        $this->view('dr-interfaces/dr-notification', $data);
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
        $data['notification_count_obj_dr'] = getNotificationCountDR();

        if ($action == 'add') {
            if ($_SERVER['REQUEST_METHOD'] == "POST") {
                $currentYear = date('Y');
                $currentDate = date('Y-m-d');
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
                } else if (($_POST['select_degree_type']) === 'HDLIM') {
                    $degree_name = "Higher Diploma in Library and Information
                    Management";
                }
                $data = [
                    'DegreeType' => $_POST['degree_type'],
                    'DegreeShortName' => $_POST['select_degree_type'],
                    'DegreeName' => $degree_name,
                    'Duration' => $duration,
                    'AcademicYear' => $currentYear,
                    'createdDate' => $currentDate,
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
        $data['notification_count_obj_dr'] = getNotificationCountDR();
        if (isset($_GET['id'])) {
            $degreeID = isset($_GET['id']) ? $_GET['id'] : null;
            $_SESSION['DegreeID'] = $degreeID;
            redirect("dr/degreeprofile");
        }
        $degreeID = $_SESSION['DegreeID'];
        $_SESSION['DegreeID'] = $degreeID;
        // echo $degreeID;
        // Check if degree ID is provided
        if ($degreeID !== null) {
            $degree = new Degree();
            $subject = new Subjects();
            $degreeTimeTable = new DegreeTimeTable();
            $student = new StudentModel();
            // Fetch the data based on the ID
            $data['degrees'] = $degree->find($degreeID);
            $degreeTimeTableData = $degreeTimeTable->find($degreeID);
            $subjectsData = $subject->find($degreeID);
            $subjects = [];
            if ($subjectsData) {
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
            $data['students'] = $student->find($degreeID);
            if ($action == "update") {
                if ($_SERVER['REQUEST_METHOD'] == "POST") {
                    show($_POST);
                    if (isset($_POST['timetableData'])) {
                        $timetableData = json_decode($_POST['timetableData'], true);
                        // Iterate over each subject's data and insert it into the database
                        foreach ($timetableData as $timetableDataItem) {
                            // Construct the data array for insertion
                            show($timetableDataItem);
                            $dataSet1 = [
                                'EventName' => $timetableDataItem['eventName'],
                                'EventType' => $timetableDataItem['eventType'],
                                'StartingDate' => $timetableDataItem['eventStart'],
                                'EndingDate' => $timetableDataItem['eventEnd'],
                                'EventID' => $timetableDataItem['eventID'],
                                'DegreeID' => $degreeID
                            ];
                            $dataGet1 = [
                                'EventID' => $timetableDataItem['eventID'],
                                'DegreeID' => $degreeID
                            ];
                            $degreeTimeTable->delete($dataGet1);
                            $degreeTimeTable->insert($dataSet1);
                        }
                        redirect("dr/degreeprofile");
                    }
                }
            } else if ($action == "delete") {
                echo "delete";
                $data = ['DegreeID' => $degreeID];
                echo json_encode($data);
                $degree->delete($data);
                redirect("dr/degreeprograms");
            } else if ($action == "status") {
                echo "status ";
                if ($_SERVER['REQUEST_METHOD'] == "POST") {
                    echo "eka ";
                    if (isset($_POST['degreeStatus'])) {
                        // Retrieve the value of the "degreeStatus" parameter
                        $Status = $_POST['degreeStatus'];
                        // echo $Status;
                        $dataset = [
                            'Status' => $Status
                        ];
                        $dataget = [
                            'DegreeID' => $degreeID
                        ];
                        $degree->updateRows($dataset, $dataget);
                        redirect("dr/degreeprofile");
                    }
                }
            } else if ($action == 'eventDelete') {
                if ($_SERVER['REQUEST_METHOD'] == "POST") {
                    if (isset($_POST['eventId']) && !empty($_POST['eventId'])) {
                        $eventID = trim($_POST['eventId']);
                        $data = [
                            'EventID' => $eventID,
                            'DegreeID' => $degreeID
                        ];
                        $degreeTimeTable->delete($data);
                        $response = [
                            'status' => 'success',
                            'message' => 'Event deleted successfully.'
                        ];
                        header('Content-Type: application/json');
                        echo json_encode($response);
                        exit();
                        // redirect("dr/degreeprofile");
                    }
                }
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
        $data['notification_count_obj_dr'] = getNotificationCountDR();
        $data['action'] = $action;
        $data['id'] = $id;
        if (!isset($_SESSION['DegreeID']) || $_SESSION['DegreeID'] == null) {
            $degree_id = $degree->lastID('DegreeID');
            $_SESSION['DegreeID'] = $degree_id;
        } else {
            $degree_id = $_SESSION['DegreeID'];
        }
        // echo $degree_id;
        $degree_info = (object)$degree->findByID($degree_id);
        $data['degrees'] = $degree->find($degree_id);
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
                        // echo json_encode($data1);
                    }
                }
                redirect("dr/degreeprofile");
            }
        } else if ($action == 'file') {
            $expectedColumns = ['Name', 'Email', 'Country', 'NIC-No', 'Date-Of-Birth', 'whatsappNo', 'Address', 'Phone-No', 'Gender(M/F)'];
            $uploadDirectory = 'assets/csv/input/';
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                if (isset($_POST['submit']) && $_POST['submit'] == 'upload-csv') {
                    if (isset($_FILES['student-data']) && $_FILES['student-data']['error'] === UPLOAD_ERR_OK) {
                        $fileName = $_FILES['student-data']['name'];
                        $fileTmpName = $_FILES['student-data']['tmp_name'];
                        $targetPath = $uploadDirectory . basename($fileName);
                        $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);
                        if (strtolower($fileExtension) !== 'csv') {
                            message('Invalid file type. Please upload a CSV file.','error');
                            redirect("dr/newdegree");
                        }
                        if (move_uploaded_file($fileTmpName, $targetPath)) {
                            $csvFile = fopen($targetPath, 'r');
                            if ($csvFile !== false) {
                                $headerRow = fgetcsv($csvFile);
                                if ($headerRow !== $expectedColumns) {
                                    message('Invalid CSV file. Header row does not match the expected columns.','error');
                                    redirect("dr/newdegree");
                                    fclose($csvFile);
                                    exit();
                                }
                                $invalidRows = [];
                                $validRows = [];
                                while (($rowData = fgetcsv($csvFile)) !== false) {
                                    // echo $rowData;
                                    if (!validateRowData($rowData)) {
                                        $invalidRows[] = $rowData;
                                        continue;
                                    } 
                                    $validRows[] = $rowData;
                                }
                                if (!empty($invalidRows)) {
                                    // Convert invalid rows array to a human-readable string
                                    $invalidRowsString = '';
                                    foreach ($invalidRows as $invalidRow) {
                                        // Join each row's data with commas or any other delimiter as per your preference
                                        $invalidRowsString .= implode(', ', $invalidRow) . "\n";
                                    }
                                
                                    // Handle invalid rows, e.g., log them or send back to the user
                                    message("Some rows have invalid data:\n" . $invalidRowsString, 'error');
                                    redirect("dr/newdegree");
                                }
                                if (empty($invalidRows)) {
                                    // echo "adoo";
                                    foreach ($validRows as $rowData1) {
                                        // echo "asdsax";
                                        $IndexNo = $student->generateIndexRegNumber($degreeShortName, $currentYear);
                                        if ($IndexNo !== false && $IndexNo['IndexNo'] != null && $IndexNo['RegistationNo'] != null && isset($IndexNo['IndexNo'], $IndexNo['RegistationNo'])) {
                                            $data1 = [
                                                'Email' => $rowData1[1],
                                                'country' => $rowData1[2],
                                                'name' => $rowData1[0],
                                                'nicNo' => $rowData1[3],
                                                'birthdate' => $rowData1[4],
                                                'whatsappNo' => $rowData1[5],
                                                'address' => $rowData1[6],
                                                'phoneNo' => $rowData1[7],
                                                'degreeID' => $degree_id,
                                                'indexNo' => $IndexNo['IndexNo'],
                                                'regNo' => $IndexNo['RegistationNo'],
                                                'gender' => $rowData1[8],
                                            ];
                                            $student->insert($data1);
                                        } else {
                                            message('Error: Failed to generate index and registration numbers for students.','error');
                                            redirect("dr/newdegree");
                                        }
                                    }
                                    message('All rows in CSV file imported successfully.','success');
                                    fclose($csvFile);
                                    redirect("dr/newdegree");
                                }
                            } else {
                                message('Failed to open CSV file.','error');
                                redirect("dr/newdegree");
                            }
                        } else {
                            message('Failed to upload file.','error');
                            redirect("dr/newdegree");
                        }
                    } else {
                        message('No file uploaded.','error');
                        redirect("dr/newdegree");
                    }
                }
            }
        }
        $this->view('dr-interfaces/dr-newdegree', $data);
    }
    public function userprofile($action = null, $id = null)
    {
        $data = [];
        $data['action'] = $action;
        $data['id'] = $id;
        $data['notification_count_obj_dr'] = getNotificationCountDR();
        if (isset($_GET['id'])) {
            $studentId = isset($_GET['id']) ? $_GET['id'] : null;
            $_SESSION['studentId'] = $studentId;
            redirect("dr/userprofile");
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
            $studentEmail = $data['student'][0]->Email;
            // echo $studentIndex;
            $data['finalMarks'] = $finalMarks->findwhere("studentIndexNo", $studentIndex);
            $data['exams'] = $exam->find($degreeId);
            // if ($action == "update") {
            //     if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            //         if (isset($_POST['submit']) && $_POST['submit'] === 'update') {
            //             // echo " update";
            //             $updatedData = [
            //                 'name' => $_POST['name'],
            //                 'Email' => $studentEmail,
            //                 'nicNo' => $_POST['nicNo'],
            //                 'whatsappNo' => $_POST['whatsappNo'],
            //                 'country' => $_POST['country'],
            //                 'phoneNo' => $_POST['phoneNo'],
            //                 'address' => $_POST['address'],
            //                 'birthdate' => $_POST['birthdate'],
            //                 'gender' => $_POST['gender'],
            //             ];
            //             $studentModel->update($studentId, $updatedData);
            //             redirect("dr/userprofile");
            //         }
            //     }
            if ($action == "update") {
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    if (isset($_POST['submit']) && $_POST['submit'] === 'update') {
                        // Create the updated data array
                        $updatedData = [
                            'name' => $_POST['name'],
                            'Email' => $studentEmail,
                            'nicNo' => $_POST['nicNo'],
                            'whatsappNo' => $_POST['whatsappNo'],
                            'country' => $_POST['country'],
                            'phoneNo' => $_POST['phoneNo'],
                            'address' => $_POST['address'],
                            'birthdate' => $_POST['birthdate'],
                            'gender' => $_POST['gender'],
                        ];
                        // Perform backend validation using the studentModel's validate method
                        $studentModel->validate($updatedData);
                        // Check if there were any validation errors
                        if (empty($studentModel->errors)) {
                            // If there are no validation errors, proceed with updating the student information
                            message('Student data updated successfully.', 'success');
                            $studentModel->update($studentId, $updatedData);
                            redirect("dr/userprofile");
                        } else {
                            // If there are validation errors, handle them (e.g., provide feedback to the user)
                            foreach ($studentModel->errors as $error) {
                                message($error, 'error');
                            }
                        }
                    }
                }
            } else if ($action == 'delete') {
                echo "delete";
                $studentModel->delete(['id' => $studentId]);
                redirect("dr/participants");
            } else if ($action == 'add') {
                if ($_SERVER['REQUEST_METHOD'] == "POST") {
                    $newDegreeID = $_POST['select_degree_id'];
                    $oldDegreeDate = $data['degrees'][0]->createdDate;
                    $oldDegreeID = $data['degrees'][0]->DegreeID;
                    $data['newDegree'] = $degree->find($newDegreeID);
                    // echo $newDegreeID;
                    // echo $oldDegreeID;
                    if ((time() - strtotime($oldDegreeDate)) < (3 * 30 * 24 * 60 * 60) && $data['student'][0]->status == "continue" && $data['student'][0]->Status == "ongoing") {
                        if ($data['newDegree'][0]->Status != "completed" && (time() - strtotime($data['newDegree'][0]->createdDate)) < (5 * 30 * 24 * 60 * 60) && $data['newDegree'][0]->DegreeID != $oldDegreeID) {
                            $newDegreeType = $degree->find($newDegreeID)[0]->DegreeShortName;
                            $newDegreeYear = $degree->find($newDegreeID)[0]->AcademicYear;
                            $newDegreeYear = $newDegreeYear % 100;
                            $status = "continue";
                            // echo $newDegreeType;
                            // echo $newDegreeYear;
                            $suspendSTU = [   // Update student to suspend
                                'status' => "suspended",
                            ];
                            $studentModel->update($studentId, $suspendSTU);
                            // Generate new index and registration numbers
                            $IndexNo = $studentModel->generateIndexRegNumber($newDegreeType, $newDegreeYear);
                            if ($IndexNo !== false && $IndexNo['IndexNo'] != null && $IndexNo['RegistationNo'] != null) {
                                $data = [
                                    'Email' => $data['student'][0]->Email,
                                    'regNo' => $IndexNo['RegistationNo'],
                                    'country' => $data['student'][0]->country,
                                    'indexNo' => $IndexNo['IndexNo'],
                                    'name' => $data['student'][0]->name,
                                    'nicNo' => $data['student'][0]->nicNo,
                                    'birthdate' => $data['student'][0]->birthdate,
                                    'whatsappNo' => $data['student'][0]->whatsappNo,
                                    'address' => $data['student'][0]->address,
                                    'phoneNo' => $data['student'][0]->phoneNo,
                                    'degreeID' => $newDegreeID,
                                    'status' => $status,
                                    'gender' => $data['student'][0]->gender,
                                ];
                                $studentModel->insert($data);

                                sleep(4);
                                redirect("dr/participants");
                            } else {
                                echo "Error: Failed to generate index and registration numbers.";
                            }
                        }
                    }
                }
            }
            $this->view('dr-interfaces/dr-userprofile', $data);
        } else {
            echo "Error: Student ID not provided in the URL.";
        }
    }


    public function participants($id = null, $action = null)
    {
        $st = new StudentModel();
        $degree = new Degree();
        $data = [];
        $data['notification_count_obj_dr'] = getNotificationCountDR();
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
        $this->view('dr-interfaces/dr-participants', $data);
    }

    public function settings()
    {
        $user = new User();
        $data = [];
        $data['notification_count_obj'] = getNotificationCount();

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

        $this->view('dr-interfaces/dr-settings', $data);
    }
    public function reports($action = null, $id = null)
    {
        $data = [];
        $data['action'] = $action;
        $data['id'] = $id;
        $degree = new Degree();
        $data['notification_count_obj_dr'] = getNotificationCountDR();
        $degreeID = $_SESSION['DegreeID'];
        $data['degrees'] = $degree->find($degreeID);
        $this->view('dr-interfaces/dr-reports', $data);
    }
    public function attendance()
    {
        $data['notification_count_obj_dr'] = getNotificationCountDR();
        $this->view('dr-interfaces/dr-attendance');
    }
    public function examination($method = null)
    {
        $degree = new Degree();
        $student = new StudentModel();
        $examParticipants = new ExamParticipants();
        $medicalStudents = new MedicalStudents();
        $repeatStudents = new RepeatStudents();
        $examtimetable = new ExamTimeTable();
        $subjects = new Subjects();
        $exam = new Exam();
        $resultSheet = new ResultSheet();
        $examAttendance = new Attendance();
        $examiner3Eligibility = new Examiner3Subject();
        $finalMarks = new FinalMarks();
        $data['notification_count_obj_dr'] = getNotificationCountDR();

        //need to add degree details to session 
        if (!empty($_SESSION['DegreeID'])) {
            $degreeID = $_SESSION['DegreeID']->DegreeID;
        }
        $examID = isset($_GET['examID']) ? $_GET['examID'] : null;

        if (!empty($examID)) {
            $_SESSION['examDetails'] = $exam->where(['examID' => $examID]);
        }
        //unset session message data
        if (!empty($_SESSION['message'])) {
            unset($_SESSION['message']);
        }
        //set examination id
        if (!empty($_SESSION['examDetails'])) {
            $examID = $_SESSION['examDetails'][0]->examID;
            $semester = $_SESSION['examDetails'][0]->semester;
        } else {
            $examID = null;
            $semester = null;
        }
        //give 403 error
        if ($examID == null) {
            redirect('_403_');
        }

        $data['errors'] = [];
        $data['degrees'] = $degree->findAll();
        $data['students'] = $student->where(['degreeID' => $degreeID]);

        //get exam details with degree details
        $dataTables = ['degree'];
        $columns = ['*'];
        $examConditions = ['exam.degreeID = degree.DegreeID', 'exam.degreeID= ' . $degreeID];
        $data['examDetails'] = $exam->join($dataTables, $columns, $examConditions);

        $repeatStudents->setid(1000);
        if ($method == 'results') {

            $examMarks = new Marks();
            $degreeID = isset($_GET['degreeID']) ? $_GET['degreeID'] : null;
            //get examID from session
            if (!empty($_SESSION['examDetails'])) {
                $examID = $_SESSION['examDetails'][0]->examID;
                $semester = $_SESSION['examDetails'][0]->semester;
            }
            //get subjects in the exam
            $examSubjects = $examtimetable->where(['examID' => $examID]);
            //get subject code from post data
            if (isset($_POST['submit'])) {
                $resultSubCode = isset($_POST['subCode']) ? $_POST['subCode'] : '';
                // show($resultSubCode);
            } else {
                $resultSubCode = '';
            }
            // remove any leading or trailing spaces from the string
            $resultSubCode = trim($resultSubCode);

            //get subject details
            $subjectDetails = $subjects->where(['SubjectCode' => $resultSubCode, 'DegreeID' => $degreeID]);
            //get examination results using marks and final marks
            $tables = ['final_marks', 'exam_participants'];
            $columns = ['*'];
            $conditions = ['marks.examID = final_marks.examID', 'marks.studentIndexNo = exam_participants.indexNo', 'marks.studentIndexNo = final_marks.studentIndexNo', 'marks.subjectCode = final_marks.subjectCode'];
            $whereConditions = ['marks.examID = ' . $examID, 'marks.subjectCode =  "' . $resultSubCode . '"', 'exam_participants.examID = ' . $examID];
            $examResults = $examMarks->joinWhere($tables, $columns, $conditions, $whereConditions);
            //generate csv file name
            $fileName = $examID . '_' . $resultSubCode . '.csv';
            $newFileName = $examID . '_' . $resultSubCode . '_new.csv';
            //generate updated marksheet as csv file
            if (!empty($resultSubCode)) {
                updateMarksheet($fileName, $examResults, $newFileName);
            }
            $data['subjectDetails'] = $subjectDetails;
            $data['subNames'] = $examSubjects;
            $data['examResults'] = $examResults;
            $this->view('dr-interfaces/dr-examresults', $data);
        } else if ($method == 'participants') {
            //get the count of exam participants
            $data['examCount'] = $examParticipants->count(['examID' => $examID]);
            $participants[] = $examParticipants->where(['examID' => $examID]);
            $data['examParticipants'] = $participants;
            $this->view('dr-interfaces/dr-examparticipants', $data);
        } else {
            $this->view('dr-interfaces/dr-examination', $data);
        }
    }
    public function login()
    {
        $this->view('login/login.view');
    }
}