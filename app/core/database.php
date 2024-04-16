<?php

/**
 * database calss
 */

class Database
{


    private function connect()
    {
        $str = DBDRIVER . ":host=" . DBHOST . ";dbname=" . DBNAME;
        return new PDO(
            $str,
            DBUSER,
            DBPASS,
            array(
                PDO::ATTR_PERSISTENT => true
            )
        );
    }

    public function query($query, $data = [], $type = 'object')
    {

        $con = $this->connect();
        $stm = $con->prepare($query);

        if ($stm) {
            $check = $stm->execute($data);

            if ($check) {

                if ($type == 'object') {
                    $type = PDO::FETCH_OBJ;
                } else {
                    $type = PDO::FETCH_ASSOC;
                }
                $result = $stm->fetchAll($type);

                if (is_array($result) && count($result) > 0) {
                    return $result;
                }
            }
        }
        return false;
    }

    function create_tables()
    {
        //user table 
        $query = "
        CREATE TABLE IF NOT EXISTS users (
            id int(11) NOT NULL AUTO_INCREMENT,
            fname varchar(50) NOT NULL,
            lname varchar(50) NOT NULL,
            username varchar(20) NOT NULL,
            email varchar(100) NOT NULL,
            phoneNo varchar(12) NOT NULL,
            role varchar(20) NOT NULL,
            password varchar(255) NOT NULL,
            cpassword varchar(255) NOT NULL,
            newpassword varchar(255) NOT NULL,
            status varchar(20) NOT NULL,
            date date DEFAULT NULL,
            PRIMARY KEY (id),
            KEY email (email),
            KEY date (date)
        ) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4
        ";

        $this->query($query);
        //Degree Table
        $query = "
        CREATE TABLE degree (
            DegreeID ⁠ int(11) NOT NULL AUTO_INCREMENT,
            DegreeType ⁠ varchar(50) NOT NULL,
            DegreeShortName ⁠ varchar(50) NOT NULL,
            DegreeName ⁠ text NOT NULL,
            Duration ⁠ int(20) DEFAULT NULL,
            AcademicYear ⁠ int(20) NOT NULL,
            Status ⁠ varchar(50) NOT NULL DEFAULT 'ongoing',
            createdDate ⁠ date NOT NULL,
            PRIMARY KEY (⁠ DegreeID ⁠),
            UNIQUE KEY ⁠ DegreeID ⁠ (⁠ DegreeID ⁠)
          ) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci
        ";

        $this->query($query);
        //Subject Table
        // $query = "
        // CREATE TABLE IF NOT EXISTS `subject` (
        //     `SubjectID` int(11) NOT NULL AUTO_INCREMENT,
        //     `SubjectCode` varchar(50) NOT NULL,
        //     `SubjectName` text NOT NULL,
        //     `NoCredits` int(10) NOT NULL,
        //     `DegreeID` int(11) NOT NULL,
        //     `semester` int(10) NOT NULL,
        //     CONSTRAINT `FK_DegreeID` FOREIGN KEY (`DegreeID`) REFERENCES `degree` (`DegreeID`) ON DELETE CASCADE 
        //     PRIMARY KEY (`SubjectID`),
        //     UNIQUE KEY `SubjectCode` (`SubjectCode`) 
        //    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci
        // ";

        // $this->query($query);

        //Grading Values Table
        $query = "
        CREATE TABLE IF NOT EXISTS `grading_values` (
            `GradeID` int(11) NOT NULL AUTO_INCREMENT,
            `DegreeID` int(11) NOT NULL,
            `Grade` varchar(5) NOT NULL,
            `MaxMarks` int(10) NOT NULL,
            `MinMarks` int(10) NOT NULL,
            `GPV` varchar(20) NOT NULL,
            PRIMARY KEY (`GradeID`),
            FOREIGN KEY (DegreeID) REFERENCES degree(DegreeID)
           ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci
        ";

        $this->query($query);
        //Degree Time table table
        $query = "
        CREATE TABLE IF NOT EXISTS `degree_timetable` (
            `EventID` INT NOT NULL AUTO_INCREMENT,
            `DegreeID` int(11) NOT NULL,
            `EventName` VARCHAR(50) NOT NULL,
            `EventType` VARCHAR(30) NOT NULL,
            `StartingDate` DATE NOT NULL,
            `EndingDate` DATE NOT NULL,
            PRIMARY KEY (`EventID`,`DegreeID`),
            KEY `DegreeID` (`DegreeID`),
            CONSTRAINT `degree_timetable_ibfk_1` FOREIGN KEY (`DegreeID`) REFERENCES `degree` (`DegreeID`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci
        ";
        $this->query($query);
        //student Table
        $query = "
        CREATE TABLE ⁠ student ⁠ (
            ⁠ id ⁠ int(11) NOT NULL AUTO_INCREMENT,
            ⁠ Email ⁠ varchar(40) NOT NULL,
            ⁠ regNo ⁠ varchar(40) NOT NULL,
            ⁠ country ⁠ varchar(40) NOT NULL,
            ⁠ indexNo ⁠ varchar(40) NOT NULL,
            ⁠ name ⁠ text NOT NULL,
            ⁠ nicNo ⁠ varchar(40) NOT NULL,
            ⁠ birthdate ⁠ varchar(40) NOT NULL,
            ⁠ whatsappNo ⁠ int(12) NOT NULL,
            ⁠ address ⁠ varchar(100) NOT NULL,
            ⁠ phoneNo ⁠ int(20) NOT NULL,
            ⁠ degreeID ⁠ int(11) NOT NULL,
            ⁠ status ⁠ varchar(50) NOT NULL DEFAULT 'continue',
            PRIMARY KEY (⁠ id ⁠),
            UNIQUE KEY ⁠ indexNo ⁠ (⁠ indexNo ⁠),
            KEY ⁠ fk_student_degree ⁠ (⁠ degreeID ⁠)
          ) ENGINE=InnoDB AUTO_INCREMENT=77 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci
        ";
        $this->query($query);

        //Exam Tables
        //exam table
        $query = "
        CREATE TABLE IF NOT EXISTS exam(
            examID int(11) AUTO_INCREMENT,
            examType varchar(20) NOT NULL ,
            degreeID  INT(11) NOT NULL,
            semester INT(10) NOT NULL,
            status varchar(30) NOT NULL,
            FOREIGN KEY (degreeID) references degree(DegreeID),
            PRIMARY KEY (examID)
            ) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4
        
        ";

        $this->query($query);
        //exam participation table
        $query = "
        CREATE TABLE IF NOT EXISTS exam_participants (
            id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
            examID INT(11) NOT NULL,
            degreeID INT(11) NOT NULL,
            semester INT(10) NOT NULL,
            indexNo VARCHAR(40) NOT NULL,
            attempt INT(10) NOT NULL,
            studentType VARCHAR(40) NOT NULL,
            FOREIGN KEY (degreeID) REFERENCES degree(DegreeID) ON DELETE CASCADE ON UPDATE CASCADE,
            FOREIGN KEY (examID) REFERENCES exam(examID) ON DELETE CASCADE ON UPDATE CASCADE,
            UNIQUE KEY unique_participant (degreeID, semester, indexNo)
        ) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;
        
        ";

        $this->query($query);

        $query = "
        CREATE TABLE IF NOT EXISTS medical_students (
            id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
            examID int(11) NOT NULL,
            degreeID int(11) NOT NULL,
            degreeShortName varchar(50) NOT NULL,
            semester int(10) NOT NULL,
            indexNo varchar(40) NOT NULL,
            subjectCode varchar(50) NOT NULL,
            attempt int(10) NOT NULL,
            status boolean NOT NULL DEFAULT 0,
            FOREIGN KEY (examID) REFERENCES exam(examID),
            FOREIGN KEY (degreeID) REFERENCES degree(degreeID),
            FOREIGN KEY (indexNo) REFERENCES student(indexNo)
                ON UPDATE CASCADE ON DELETE CASCADE,
            CONSTRAINT fk_indexNo FOREIGN KEY (indexNo) REFERENCES student(indexNo)
                ON UPDATE CASCADE ON DELETE CASCADE
        ) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4
        ";


        $this->query($query);

        $query = "
     CREATE TABLE IF NOT EXISTS repeat_students(
        id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
        degreeID int(11) NOT NULL,
        degreeShortName varchar(50) NOT NULL,
        examID int(11) NOT NULL,
        semester int(10) NOT NULL,
        indexNo varchar(40) NOT NULL,
        subjectCode varchar(50) NOT NULL,
        attempt int(10) NOT NULL,
        paymentStatus boolean NOT NULL DEFAULT 0,
        FOREIGN KEY (degreeID) REFERENCES degree(DegreeID),
        FOREIGN KEY (indexNo) REFERENCES student(indexNo),
        FOREIGN KEY (examID) REFERENCES exam(examID)
     ) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4
     ";
        $this->query($query);


        $query = "
 CREATE TABLE IF NOT EXISTS exam_timetable(
    subjectCode varchar(50) NOT NULL,
    examID int(11) NOT NULL,
    subjectName varchar(50) NOT NULL,
    date date NOT NULL,
    time time NOT NULL,
    degreeID int(11) NOT NULL,
    semester int(10) NOT NULL,
    FOREIGN KEY (degreeID) REFERENCES degree(DegreeID),
    Foreign key (examID) references exam(examID),
    primary key (subjectCode, degreeID, semester)
 ) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4
 ";
        $this->query($query);


        $query = "
        CREATE TABLE IF NOT EXISTS `mark_sheets` (
            `Id` int(11) NOT NULL AUTO_INCREMENT,
            `uploadName` varchar(50) NOT NULL,
            `newName` varchar(50) NOT NULL,
            `formId` varchar(20) NOT NULL,
            `degreeId` int(11) NOT NULL,
            `subjectCode` varchar(50) NOT NULL,
            `type` varchar(30) NOT NULL,
            `examId` int(11) NOT NULL,
            `date` date NOT NULL,
            PRIMARY KEY (`Id`),
            Foreign key (examId) references exam(examID),
            Foreign key (degreeId) references degree(DegreeID)
        ) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4
        ";

        $this->query($query);

        $query = "
        CREATE TABLE IF NOT EXISTS `marks` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `studentIndexNo` varchar(40) NOT NULL,
            `subjectCode` varchar(50) NOT NULL,
            `degreeID` int(11) NOT NULL,
            `examID` int(11) NOT NULL,
            `examiner1Marks` float DEFAULT NULL,
            `examiner2Marks` float DEFAULT NULL,
            `examiner3Marks` float DEFAULT NULL,
            `assessmentMarks` float DEFAULT NULL,
            PRIMARY KEY (`id`),
            FOREIGN KEY (`studentIndexNo`) REFERENCES `student` (`indexNo`),
            FOREIGN KEY (`degreeID`) REFERENCES `degree` (`DegreeID`),
            FOREIGN KEY (`examID`) REFERENCES `exam` (`examID`)
        ) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4
        ";

        $this->query($query);


        $query = "
        CREATE TABLE IF NOT EXISTS `attempts` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `studentIndexNo` varchar(40) NOT NULL,
            `subjectCode` varchar(50) NOT NULL,
            `degreeID` int(11) NOT NULL,
            `examID` int(11) NOT NULL,
            `attempts` int(10) DEFAULT NULL,
            PRIMARY KEY (`id`),
            FOREIGN KEY (`studentIndexNo`) REFERENCES `student` (`indexNo`),
            FOREIGN KEY (`degreeID`) REFERENCES `degree` (`DegreeID`),
            FOREIGN KEY (`examID`) REFERENCES `exam` (`examID`)
        ) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4
        ";

        $this->query($query);


        $query = "
        CREATE TABLE IF NOT EXISTS `final_marks` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `studentIndexNo` varchar(40) NOT NULL,
            `subjectCode` varchar(50) NOT NULL,
            `examID` int(11) NOT NULL,
            `degreeID` int(11) NOT NULL,
            `finalMarks` float  NOT NULL,
            `grade` varchar(10) DEFAULT NULL,
            PRIMARY KEY (`id`),
            FOREIGN KEY (`studentIndexNo`) REFERENCES `student` (`indexNo`),
            FOREIGN KEY (`degreeID`) REFERENCES `degree` (`DegreeID`),
            FOREIGN KEY (`examID`) REFERENCES `exam` (`examID`)
        ) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;
        ";

        $this->query($query);

        $query = "
        CREATE TABLE IF NOT EXISTS `activity` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `user` varchar(40) NOT NULL,
            `discription` varchar(500) NOT NULL,
            `date` date NOT NULL,
            `time` TIME NOT NULL,
            PRIMARY KEY (`id`)
        ) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;
        ";

        $this->query($query);


        $query = "
        CREATE TABLE IF NOT EXISTS `index_token` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `indexNo` varchar(40) NOT NULL,
            `examID` int(11) NOT NULL,
            `token` varchar(255) NOT NULL,
            PRIMARY KEY (`id`),
            FOREIGN KEY (`indexNo`) REFERENCES `student` (`indexNo`)
            ) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;
            ";

        $this->query($query);


        $query = "
        CREATE TABLE IF NOT EXISTS `examiner3_eligibility`(
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `subCode` varchar(50) NOT NULL,
            `examID` int(11) NOT NULL,
            `degreeID` int(11) NOT NULL,
            `semester` int(10) NOT NULL,
            `status` boolean NOT NULL,
            PRIMARY KEY (`id`),
            FOREIGN KEY (`examID`) REFERENCES `exam` (`examID`),
            FOREIGN KEY (`degreeID`) REFERENCES `degree` (`DegreeID`)
        ) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;
        ";

        $this->query($query);

        $query = "
        CREATE TABLE IF NOT EXISTS `exam_attendance`(
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `examID` int(11) NOT NULL,
            `degreeID` int(11) NOT NULL,
            `semester` int(10) NOT NULL,
            `subjectCode` varchar(50) NOT NULL,
            `attempt` int(10) NOT NULL,
            `type` varchar(40) NOT NULL,
            `regNo` varchar(40) NOT NULL,
            `indexNo` varchar(40) NOT NULL,
            `attendance` boolean NOT NULL DEFAULT 0,
            PRIMARY KEY (`id`),
            FOREIGN KEY (`examID`) REFERENCES `exam` (`examID`),
            FOREIGN KEY (`degreeID`) REFERENCES `degree` (`DegreeID`),
            FOREIGN KEY (`indexNo`) REFERENCES `student` (`indexNo`)
        ) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;
        ";
        $this->query($query);

        $query = "
        CREATE TABLE IF NOT EXISTS `notifications`(
            `notify_id` int(11) NOT NULL,
            `description` varchar(255) NOT NULL,
            `type` varchar(50) NOT NULL,
            `msg_type` varchar(100) NOT NULL,
            `issuing_date` datetime NOT NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
        ";
        $this->query($query);
    }

    public function createFinalMarksTrigger()
    {
        // Create the trigger creation query
        $triggerQuery = "
        DELIMITER $$

CREATE TRIGGER calculate_final_marks
AFTER INSERT ON marks FOR EACH ROW
BEGIN
    DECLARE final_marks_value DECIMAL(10, 2);
    DECLARE examiner1_marks_value INT;
    DECLARE examiner2_marks_value INT;
    DECLARE examiner3_marks_value INT;
    DECLARE assessment_marks_value INT;
    DECLARE min_gap_marks INT;
    
    -- Calculate final marks based on the given conditions
    IF NEW.examiner3Marks IS NOT NULL AND NEW.examiner3Marks != -1 THEN
        -- Calculate the gap between each pair of marks
        SET examiner1_marks_value = NEW.examiner1Marks;
        SET examiner2_marks_value = NEW.examiner2Marks;
        SET examiner3_marks_value = NEW.examiner3Marks;
        
        -- Get the minimum gap marks
        SET min_gap_marks = LEAST(ABS(examiner1_marks_value - examiner2_marks_value),
                                  ABS(examiner2_marks_value - examiner3_marks_value),
                                  ABS(examiner1_marks_value - examiner3_marks_value));
        
        -- Determine which pair has the minimum gap marks and adjust accordingly
        IF ABS(examiner1_marks_value - examiner3_marks_value) = min_gap_marks THEN
            SET examiner2_marks_value = examiner3_marks_value;
        ELSEIF ABS(examiner2_marks_value - examiner3_marks_value) = min_gap_marks THEN
            SET examiner1_marks_value = examiner2_marks_value;
        
        END IF;
        
        -- Calculate final marks
        SET final_marks_value = (examiner1_marks_value + examiner2_marks_value) / 2 * 0.5;
    ELSE
        SET final_marks_value = (NEW.examiner1Marks + NEW.examiner2Marks) / 2 * 0.5;
    END IF;
    
    SET final_marks_value = final_marks_value + NEW.assessmentMarks * 0.5;
    
    -- Insert the calculated final marks into the final_marks table if it does not already exist
    IF NOT EXISTS (
        SELECT 1 FROM final_marks 
        WHERE studentIndexNo = NEW.studentIndexNo 
        AND subjectCode = NEW.subjectCode 
        AND examID = NEW.examID
    ) THEN
        INSERT INTO final_marks (studentIndexNo, subjectCode, examID, degreeID, finalMarks)
        VALUES (NEW.studentIndexNo, NEW.subjectCode, NEW.examID, NEW.degreeID, final_marks_value);
    END IF;
END$$

DELIMITER ;

        ";


        // Execute the trigger creation query
        $this->query($triggerQuery);
    }

    public function createFinalMarksUpdateTrigger()
    {
        $query = "
        DELIMITER $$

CREATE TRIGGER update_final_marks
AFTER UPDATE ON marks FOR EACH ROW
BEGIN
    DECLARE final_marks_value DECIMAL(10, 2);
    DECLARE examiner1_marks_value INT;
    DECLARE examiner2_marks_value INT;
    DECLARE examiner3_marks_value INT;
    DECLARE assessment_marks_value INT;
    DECLARE min_gap_marks INT;
    
    -- Calculate final marks based on the given conditions
    IF NEW.examiner3Marks IS NOT NULL AND NEW.examiner3Marks != -1 THEN
        -- Calculate the gap between each pair of marks
        SET examiner1_marks_value = NEW.examiner1Marks;
        SET examiner2_marks_value = NEW.examiner2Marks;
        SET examiner3_marks_value = NEW.examiner3Marks;
        
        -- Get the minimum gap marks
        SET min_gap_marks = LEAST(ABS(examiner1_marks_value - examiner2_marks_value),
                                  ABS(examiner2_marks_value - examiner3_marks_value),
                                  ABS(examiner1_marks_value - examiner3_marks_value));
        
        -- Determine which pair has the minimum gap marks and adjust accordingly
        IF ABS(examiner1_marks_value - examiner3_marks_value) = min_gap_marks THEN
            SET examiner2_marks_value = examiner3_marks_value;
        ELSEIF ABS(examiner2_marks_value - examiner3_marks_value) = min_gap_marks THEN
            SET examiner1_marks_value = examiner2_marks_value;
        END IF;
        
        -- Calculate final marks
        SET final_marks_value = (examiner1_marks_value + examiner2_marks_value) / 2 * 0.5;
    ELSE
        SET final_marks_value = (NEW.examiner1Marks + NEW.examiner2Marks) / 2 * 0.5;
    END IF;
    
    SET final_marks_value = final_marks_value + NEW.assessmentMarks * 0.5;
    
    -- Update the final marks in the final_marks table if it exists
    UPDATE final_marks 
    SET finalMarks = final_marks_value 
    WHERE studentIndexNo = NEW.studentIndexNo 
    AND subjectCode = NEW.subjectCode 
    AND examID = NEW.examID;
    
END$$

DELIMITER ;
";

        $this->query($query);
    }

    public function create_procedure()
    {
        // Procedure creation query
        $query = "
        CREATE PROCEDURE IF NOT EXISTS `InsertNotification`()
        BEGIN
        DECLARE currentDate DATE;
        DECLARE eventStartDate DATE;
        DECLARE userId INT;
        DECLARE daysRemaining INT;
        DECLARE degreeName TEXT; -- Specify the length for VARCHAR

        DECLARE str1 VARCHAR(255); -- Declare variables for string concatenation
        DECLARE str2 VARCHAR(255);

        DECLARE eventCursor CURSOR FOR
            SELECT dt.StartingDate, d.DegreeName
            FROM degree_timetable AS dt
            JOIN degree AS d ON dt.DegreeID = d.DegreeID;

        -- Set the current date
        SET currentDate = CURDATE();

        OPEN eventCursor;

        read_loop: LOOP
            FETCH eventCursor INTO eventStartDate, degreeName;
            IF eventStartDate IS NULL THEN
                LEAVE read_loop;
            END IF;

            -- Calculate the days remaining
            SET daysRemaining = DATEDIFF(eventStartDate, currentDate);

            -- Check if days remaining is less than or equal to 14 and greater than 0
            IF (daysRemaining <= 14 AND daysRemaining > 0) THEN
               -- Construct notification message
                SET str1 = CONCAT('There will be an upcoming examination scheduled on ', eventStartDate);
                SET str2 = CONCAT(' for the diploma ', degreeName, ' examination');

                -- Print concatenated strings to console (optional)
                -- SELECT CONCAT(str1, str2);

                -- Insert record into notifications table
                INSERT INTO notifications (description, type, msg_type,button_text,button_link)
                VALUES (CONCAT(str1, str2), 'Examination', 'msg1', 'create examination','sar/examination');
            END IF;
        END LOOP;

        CLOSE eventCursor;
    END;
        ";

        // Execute the procedure creation query
        $this->query($query);

        $query = "
        CREATE PROCEDURE IF NOT EXISTS `Exam_Begin`()
        BEGIN
        DECLARE currentDate DATE;
        DECLARE eventStartDate DATE;
        DECLARE userId INT;
        DECLARE daysRemaining INT;
        DECLARE degreeName TEXT; -- Specify the length for VARCHAR

        DECLARE str1 VARCHAR(255); -- Declare variables for string concatenation
        DECLARE str2 VARCHAR(255);

        DECLARE eventCursor CURSOR FOR
            SELECT dt.StartingDate, d.DegreeName
            FROM degree_timetable AS dt
            JOIN degree AS d ON dt.DegreeID = d.DegreeID;

        -- Set the current date
        SET currentDate = CURDATE();

        OPEN eventCursor;

        read_loop: LOOP
            FETCH eventCursor INTO eventStartDate, degreeName;
            IF eventStartDate IS NULL THEN
                LEAVE read_loop;
            END IF;

            -- Calculate the days remaining
            SET daysRemaining = DATEDIFF(eventStartDate, currentDate);

            -- Check if days remaining is less than or equal to 14 and greater than 0
            IF (daysRemaining = 14 ) THEN
               -- Construct notification message
                SET str1 = CONCAT('There will be an upcoming examination scheduled on ', eventStartDate);
                SET str2 = CONCAT(' for the diploma ', degreeName, ' examination');

                -- Print concatenated strings to console (optional)
                -- SELECT CONCAT(str1, str2);

                -- Insert record into notifications table
                INSERT INTO notifications (description, type, msg_type)
                VALUES (CONCAT(str1, str2), 'Examination', 'Exam-start-alert');
            END IF;
        END LOOP;

        CLOSE eventCursor;
    END;
        ";

        // Execute the procedure creation query
        $this->query($query);

        $query = "
        CREATE PROCEDURE IF NOT EXISTS `Exam_End`()
        BEGIN
        DECLARE currentDate DATE;
        DECLARE eventEndDate DATE;
        DECLARE userId INT;
        DECLARE daysAfterExam INT;
        DECLARE degreeName TEXT; -- Specify the length for VARCHAR

        DECLARE str1 VARCHAR(255); -- Declare variables for string concatenation
        DECLARE str2 VARCHAR(255);

        DECLARE eventCursor CURSOR FOR
            SELECT dt.EndingDate, d.DegreeName
            FROM degree_timetable AS dt
            JOIN degree AS d ON dt.DegreeID = d.DegreeID;

        -- Set the current date
        SET currentDate = CURDATE();

        OPEN eventCursor;

        read_loop: LOOP
            FETCH eventCursor INTO eventEndDate, degreeName;
            IF eventEndDate IS NULL THEN
                LEAVE read_loop;
            END IF;

            -- Calculate the days remaining
            SET daysAfterExam = DATEDIFF(currentDate,eventEndDate);

            -- Check if days remaining is less than or equal to 14 and greater than 0
            IF (daysAfterExam = 1) THEN
               -- Construct notification message
                SET str1 = CONCAT('The examination for the diploma ', degreeName ,' has ended. If required, please proceed with any necessary actions post-examination.');
                

                -- Print concatenated strings to console (optional)
                -- SELECT CONCAT(str1, str2);

                -- Insert record into notifications table
                INSERT INTO notifications (description, type, msg_type)
                VALUES (CONCAT(str1), 'Examination', 'Exam-end-alert');
            END IF;
        END LOOP;

        CLOSE eventCursor;
    
END;
        ";

        // Execute the procedure creation query
        $this->query($query);

        $query = "
        CREATE PROCEDURE IF NOT EXISTS `Vacation_Begin`()
        BEGIN
        DECLARE currentDate DATE;
        DECLARE eventStartDate DATE;
        DECLARE userId INT;
        DECLARE daysRemaining INT;
        DECLARE degreeName TEXT; -- Specify the length for VARCHAR

        DECLARE str1 VARCHAR(255); -- Declare variables for string concatenation
        DECLARE str2 VARCHAR(255);

        DECLARE eventCursor CURSOR FOR
            SELECT dt.StartingDate, d.DegreeName
            FROM degree_timetable AS dt
             JOIN degree AS d ON dt.DegreeID = d.DegreeID
             WHERE dt.EventType = 'Vacation';

        -- Set the current date
        SET currentDate = CURDATE();

        OPEN eventCursor;

        read_loop: LOOP
            FETCH eventCursor INTO eventStartDate, degreeName;
            IF eventStartDate IS NULL THEN
                LEAVE read_loop;
            END IF;

            -- Calculate the days remaining
            SET daysRemaining = DATEDIFF(eventStartDate, currentDate);

            -- Check if days remaining is less than or equal to 14 and greater than 0
            IF (daysRemaining <= 7 ) THEN
               -- Construct notification message
                SET str1 = CONCAT('There will be an upcoming vacation scheduled on ', eventStartDate,' for the diploma ', degreeName,'Please make sure to complete any pending tasks or submissions before the scheduled vacation date.');
                
                INSERT INTO notifications (description, type, msg_type,issuing_date)
                VALUES (CONCAT(str1), 'Vacation', 'Vacation-start-alert',NOW());
            END IF;
        END LOOP;

        CLOSE eventCursor;
    END;
        ";

        // Execute the procedure creation query
        $this->query($query);

        $query = "
           CREATE PROCEDURE IF NOT EXISTS `Vacation_End`()
           BEGIN
           DECLARE currentDate DATE;
           DECLARE eventEndDate DATE;
           DECLARE userId INT;
           DECLARE daysAfterEvent INT;
           DECLARE degreeName TEXT; -- Specify the length for VARCHAR
   
           DECLARE str1 VARCHAR(255); -- Declare variables for string concatenation
           DECLARE str2 VARCHAR(255);
   
           DECLARE eventCursor CURSOR FOR
               SELECT dt.EndingDate, d.DegreeName
               FROM degree_timetable AS dt
               JOIN degree AS d ON dt.DegreeID = d.DegreeID
               WHERE dt.EventType = 'Vacation';
   
           -- Set the current date
           SET currentDate = CURDATE();
   
           OPEN eventCursor;
   
           read_loop: LOOP
               FETCH eventCursor INTO eventEndDate, degreeName;
               IF eventEndDate IS NULL THEN
                   LEAVE read_loop;
               END IF;
   
               -- Calculate the days remaining
               SET daysAfterEvent = DATEDIFF(currentDate,eventEndDate);
   
               -- Check if days remaining is less than or equal to 14 and greater than 0
               IF (daysAfterEvent = 0) THEN
                  -- Construct notification message
                   SET str1 = CONCAT('The vacation period for the diploma ', degreeName ,' has ended and normal semester activities will resume starting from tomorrow ');
                   
   
                   -- Print concatenated strings to console (optional)
                   -- SELECT CONCAT(str1, str2);
   
                   -- Insert record into notifications table
                   INSERT INTO notifications (description, type, msg_type,issuing_date)
                   VALUES (CONCAT(str1), 'Vacation', 'Vacation-end-alert',NOW());
               END IF;
           END LOOP;
   
           CLOSE eventCursor;
       
   END;
           ";

        // Execute the procedure creation query
        $this->query($query);

        $query = "
           CREATE PROCEDURE IF NOT EXISTS `Studyleave_Begin`()
           BEGIN
           DECLARE currentDate DATE;
           DECLARE eventStartDate DATE;
           DECLARE userId INT;
           DECLARE daysRemaining INT;
           DECLARE degreeName TEXT; -- Specify the length for VARCHAR
   
           DECLARE str1 VARCHAR(255); -- Declare variables for string concatenation
           DECLARE str2 VARCHAR(255);
   
           DECLARE eventCursor CURSOR FOR
               SELECT dt.StartingDate, d.DegreeName
               FROM degree_timetable AS dt
               JOIN degree AS d ON dt.DegreeID = d.DegreeID WHERE dt.EventType = 'Study leave';
   
           -- Set the current date
           SET currentDate = CURDATE();
   
           OPEN eventCursor;
   
           read_loop: LOOP
               FETCH eventCursor INTO eventStartDate, degreeName;
               IF eventStartDate IS NULL THEN
                   LEAVE read_loop;
               END IF;
   
               -- Calculate the days remaining
               SET daysRemaining = DATEDIFF(eventStartDate, currentDate);
   
               -- Check if days remaining is less than or equal to 14 and greater than 0
               IF (daysRemaining <= 7 ) THEN
                  -- Construct notification message
                   SET str1 = CONCAT('Study leave has been scheduled for the ', degreeName ,' diploma program ,starting on ', eventStartDate);
                   SET str2 = CONCAT('.Kindly ensure all relevant pending tasks and submissions are completed before the study leave period begins.');
   
                   -- Print concatenated strings to console (optional)
                   -- SELECT CONCAT(str1, str2);
   
                   -- Insert record into notifications table
                   INSERT INTO notifications (description, type, msg_type,issuing_date)
                   VALUES (CONCAT(str1, str2), 'Study leave', 'Studyleave-start-alert',NOW());
               END IF;
           END LOOP;
   
           CLOSE eventCursor;
       END;
           ";

        // Execute the procedure creation query
        $this->query($query);

        $query = "
           CREATE PROCEDURE IF NOT EXISTS `Studyleave_End`()
           BEGIN
           DECLARE currentDate DATE;
           DECLARE eventEndDate DATE;
           DECLARE userId INT;
           DECLARE daysAfterEvent INT;
           DECLARE degreeName TEXT; -- Specify the length for VARCHAR
   
           DECLARE str1 VARCHAR(255); -- Declare variables for string concatenation
           DECLARE str2 VARCHAR(255);
   
           DECLARE eventCursor CURSOR FOR
               SELECT dt.EndingDate, d.DegreeName
               FROM degree_timetable AS dt
               JOIN degree AS d ON dt.DegreeID = d.DegreeID
               WHERE dt.EventType = 'Study leave';
   
           -- Set the current date
           SET currentDate = CURDATE();
   
           OPEN eventCursor;
   
           read_loop: LOOP
               FETCH eventCursor INTO eventEndDate, degreeName;
               IF eventEndDate IS NULL THEN
                   LEAVE read_loop;
               END IF;
   
               -- Calculate the days remaining
               SET daysAfterEvent = DATEDIFF(currentDate,eventEndDate);
   
               -- Check if days remaining is less than or equal to 14 and greater than 0
               IF (daysAfterEvent = 0) THEN
                  -- Construct notification message
                   SET str1 = CONCAT('The Study leave for the diploma ', degreeName ,' has ended.');
                   
   
                   -- Insert record into notifications table
                   INSERT INTO notifications (description, type, msg_type,issuing_date)
                   VALUES (CONCAT(str1), 'Study leave', 'Studyleave-end-alert',NOW());
               END IF;
           END LOOP;
   
           CLOSE eventCursor;
       
   END;
           ";

        // Execute the procedure creation query
        $this->query($query);

        $query = "
           CREATE PROCEDURE IF NOT EXISTS `Payment_Check`()
           BEGIN
           DECLARE currentDate DATE;
           DECLARE eventStartDate DATE;
           DECLARE userId INT;
           DECLARE daysRemaining INT;
           DECLARE degreeName TEXT; -- Specify the length for VARCHAR
   
           DECLARE str1 VARCHAR(255); -- Declare variables for string concatenation
           DECLARE str2 VARCHAR(255);
   
           DECLARE eventCursor CURSOR FOR
               SELECT dt.StartingDate, d.DegreeName
               FROM degree_timetable AS dt
               JOIN degree AS d ON dt.DegreeID = d.DegreeID WHERE dt.EventType = 'Examination';
   
           -- Set the current date
           SET currentDate = CURDATE();
   
           OPEN eventCursor;
   
           read_loop: LOOP
               FETCH eventCursor INTO eventStartDate, degreeName;
               IF eventStartDate IS NULL THEN
                   LEAVE read_loop;
               END IF;
   
               -- Calculate the days remaining
               SET daysRemaining = DATEDIFF(eventStartDate, currentDate);
   
               -- Check if days remaining is less than or equal to 14 and greater than 0
               IF (daysRemaining = 7 ) THEN
                  -- Construct notification message
                   SET str1 = CONCAT('There will be an upcoming examination scheduled on ', eventStartDate,' for the diploma ', degreeName, ' examination.Please review the payment details of all students before the exams commence.');
                   -- Insert record into notifications table
                   INSERT INTO notifications (description, type, msg_type,issuing_date)
                   VALUES (CONCAT(str1), 'Examination', 'payement_check_alert',NOW());
               END IF;
           END LOOP;
   
           CLOSE eventCursor;
       END;
           ";

        // Execute the procedure creation query
        $this->query($query);

        $query = "
           CREATE PROCEDURE IF NOT EXISTS `Exam-Attendance`()
           BEGIN
           DECLARE currentDate DATE;
           DECLARE eventEndDate DATE;
           DECLARE userId INT;
           DECLARE daysAfterExam INT;
           DECLARE degreeName TEXT; -- Specify the length for VARCHAR
   
           DECLARE str1 VARCHAR(255); -- Declare variables for string concatenation
           DECLARE str2 VARCHAR(255);
   
           DECLARE eventCursor CURSOR FOR
               SELECT dt.EndingDate, d.DegreeName
               FROM degree_timetable AS dt
               JOIN degree AS d ON dt.DegreeID = d.DegreeID
               WHERE dt.EventType = 'Examination';
   
           -- Set the current date
           SET currentDate = CURDATE();
   
           OPEN eventCursor;
   
           read_loop: LOOP
               FETCH eventCursor INTO eventEndDate, degreeName;
               IF eventEndDate IS NULL THEN
                   LEAVE read_loop;
               END IF;
   
               -- Calculate the days remaining
               SET daysAfterExam = DATEDIFF(currentDate,eventEndDate);
   
               -- Check if days remaining is less than or equal to 14 and greater than 0
               IF (daysAfterExam = 1) THEN
                  -- Construct notification message
                   SET str1 = CONCAT('The examination for the diploma ', degreeName ,' has ended. Please upload the  examination attendance of the students.');
                   
   
                   -- Print concatenated strings to console (optional)
                   -- SELECT CONCAT(str1, str2);
   
                   -- Insert record into notifications table
                   INSERT INTO notifications (description, type, msg_type,issuing_date)
                   VALUES (CONCAT(str1), 'Examination', 'Exam-attendance-alert',NOW());
               END IF;
           END LOOP;
   
           CLOSE eventCursor;
       
   END;
           ";

        // Execute the procedure creation query
        $this->query($query);

        $query = "
           CREATE PROCEDURE IF NOT EXISTS `Student-Attendance`()
           BEGIN
        DECLARE currentDate DATE;
        DECLARE eventStartDate DATE;
        DECLARE userId INT;
        DECLARE daysRemaining INT;
        DECLARE degreeName TEXT; -- Specify the length for VARCHAR

        DECLARE str1 VARCHAR(255); -- Declare variables for string concatenation
        DECLARE str2 VARCHAR(255);

        DECLARE eventCursor CURSOR FOR
            SELECT dt.StartingDate, d.DegreeName
            FROM degree_timetable AS dt
            JOIN degree AS d ON dt.DegreeID = d.DegreeID WHERE dt.EventType = 'Examination';

        -- Set the current date
        SET currentDate = CURDATE();

        OPEN eventCursor;

        read_loop: LOOP
            FETCH eventCursor INTO eventStartDate, degreeName;
            IF eventStartDate IS NULL THEN
                LEAVE read_loop;
            END IF;

            -- Calculate the days remaining
            SET daysRemaining = DATEDIFF(eventStartDate, currentDate);

            -- Check if days remaining is less than or equal to 14 and greater than 0
            IF (daysRemaining = 7 ) THEN
               -- Construct notification message
                SET str1 = CONCAT('There will be an upcoming examination scheduled on ', eventStartDate,' for the diploma ', degreeName, ' examination.Please review the payment details of all students before the exams commence.');
                -- Insert record into notifications table
                INSERT INTO notifications (description, type, msg_type,issuing_date)
                VALUES (CONCAT(str1), 'Examination', 'payement_check_alert',NOW());
            END IF;
        END LOOP;

        CLOSE eventCursor;
    END;
           ";

        // Execute the procedure creation query
        $this->query($query);
    }

    public function create_event()
    {
        // Event creation query
        $query = "
        CREATE EVENT IF NOT EXISTS `daily_event` 
        ON SCHEDULE EVERY 30 MINUTE STARTS '2024-02-20 08:34:00' 
        ON COMPLETION NOT PRESERVE ENABLE 
        DO 
            CALL InsertNotification();
        ";

        // Execute the event creation query
        $this->query($query);

        $query = "
        CREATE EVENT IF NOT EXISTS `Exam-Begin` 
        ON SCHEDULE EVERY 1 DAY STARTS '2024-02-21 21:41:00' 
        ON COMPLETION NOT PRESERVE ENABLE 
        DO 
        CALL Exam_Begin();
        ";

        // Execute the event creation query
        $this->query($query);

        $query = "
        CREATE EVENT IF NOT EXISTS `Exam-End` 
        ON SCHEDULE EVERY 1 DAY STARTS '2024-02-21 21:41:00' 
        ON COMPLETION NOT PRESERVE ENABLE 
        DO 
        CALL Exam_End();
        ";

        // Execute the event creation query
        $this->query($query);

        $query = "
        CREATE EVENT IF NOT EXISTS `Vacation-Begin` 
        ON SCHEDULE EVERY 1 DAY STARTS '2024-02-21 21:41:00'
        ON COMPLETION NOT PRESERVE ENABLE 
        DO 
        CALL Vacation_Begin()
        ";

        // Execute the event creation query
        $this->query($query);

        $query = "
        CREATE EVENT IF NOT EXISTS `Vacation-End` 
        ON SCHEDULE EVERY 1 DAY STARTS '2024-02-21 21:41:00'
        ON COMPLETION NOT PRESERVE ENABLE 
        DO 
        CALL Vacation_End()
        ";

        // Execute the event creation query
        $this->query($query);

        $query = "
        CREATE EVENT IF NOT EXISTS `Studyleave-Begin` 
        ON SCHEDULE EVERY 1 DAY STARTS '2024-02-21 21:41:00'
        ON COMPLETION NOT PRESERVE ENABLE 
        DO 
        CALL Studyleave_Begin()
        ";

        // Execute the event creation query
        $this->query($query);

        $query = "
        CREATE EVENT IF NOT EXISTS `Studyleave-End` 
        ON SCHEDULE EVERY 1 DAY STARTS '2024-02-21 21:41:00'
        ON COMPLETION NOT PRESERVE ENABLE 
        DO 
        CALL Studyleave_End()
        ";

        // Execute the event creation query
        $this->query($query);

        $query = "
        CREATE EVENT IF NOT EXISTS `Payment-Check` 
        ON SCHEDULE EVERY 1 DAY STARTS '2024-02-21 21:41:00'
        ON COMPLETION NOT PRESERVE ENABLE 
        DO 
        CALL Payment_Check()
        ";

        // Execute the event creation query
        $this->query($query);

        $query = "
        CREATE EVENT IF NOT EXISTS `Exam-Attendance` 
        ON SCHEDULE EVERY 1 DAY STARTS '2024-02-21 21:41:00'
        ON COMPLETION NOT PRESERVE ENABLE 
        DO 
        CALL Exam_Attendance()
        ";

        // Execute the event creation query
        $this->query($query);

        $query = "
        CREATE EVENT IF NOT EXISTS `Student-Attendance` 
        ON SCHEDULE EVERY 1 DAY STARTS '2024-02-21 21:41:00'
        ON COMPLETION NOT PRESERVE ENABLE 
        DO 
        CALL Exam_Attendance()
        ";

        // Execute the event creation query
        $this->query($query);
    }
}
