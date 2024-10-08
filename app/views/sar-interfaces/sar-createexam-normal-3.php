<?php



$role = "SAR";
$degreeID = '1';
$data['role'] = $role;

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <title>Exam Creation</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>exam-create Dashboard</title>
</head>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap');

    * {
        font-family: 'Poppins', sans-serif;
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    :root {
        --body-color: #E2E2E2;
        --sidebar-color: #17376E;
        --primary-color: #9AD6FF;
        --text-color: #ffffff;
        --tran-02: all 0.2s ease;
        --tran-03: all 0.3s ease;
        --tran-04: all 0.4s ease;
        --tran-05: all 0.5s ease;
    }

    .exam-create-home {
        height: 100vh;
        left: 250px;
        position: relative;
        width: calc(100% - 250px);
        transition: var(--tran-05);
        background: var(--body-color);
    }

    .exam-create-title {
        font-size: 30px;
        font-weight: 600;
        color: black;
        padding: 10px 0px 10px 32px;
        background-color: var(--text-color);
        border-radius: 6px;
        margin: 7px 4px 7px 4px;
    }

    .sidebar.close~.exam-create-home {
        left: 88px;
        width: calc(100% - 88px);
    }

    .exam-create-subsection-0 {
        display: flex;
        flex-direction: row;
        justify-content: space-around;
        align-items: center;
        /* background-color: var(--text-color); */
        padding: 15px 10px 15px 35px;
        border-radius: 6px;
        margin: 7px 4px 7px 4px;
        flex-wrap: wrap;

    }

    .exam-create-subsection-01 {
        display: flex;
        padding: 15px 30px 14px 30px;
        justify-content: center;
        align-items: center;
        border-radius: 10px;
        border: 1px solid rgba(0, 0, 0, 0.12);
        background-color: var(--text-color);
        box-shadow: 0px 10px 25px 0px rgba(0, 0, 0, 0.12);
        width: 25%;
        height: 150px;
        flex-direction: row;
        gap: 60px;
    }

    .exam-create-subcard-data {
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
    }

    .exam-create-subcard-data-value {
        font-size: 38px;
        font-weight: 600;
        color: #17376E;
    }

    .exam-create-subcard-data-title {
        font-size: 18px;
        font-weight: 600;
        color: #17376E;
    }

    .exam-create-subsection-1 {
        background-color: var(--text-color);
        padding: 10px 10px 15% 35px;
        border-radius: 6px;
        margin: 7px 4px 7px 4px;
    }

    .exam-create-sub-title {

        color: #17376E;
        font-family: Poppins;
        font-size: 22px;
        font-style: normal;
        font-weight: 600;
        margin: 40px;

    }

    .exam-create-subsection-2 {
        display: flex;
        flex-direction: row;
        justify-content: space-between;

        /* padding: 10px 10px 30px 35px; */
        /* border-radius: 6px; */
        /* margin: 7px 4px 7px 4px; */
    }

    .exam-create-subsection-21 {
        display: flex;
        flex-direction: column;
        background-color: var(--text-color);
        padding: 10px 10px 30px 35px;
        border-radius: 6px;
        margin: 3px 4px 7px 4px;
        width: 100%;
    }

    .exam-create-subsection-22 {
        background-color: var(--text-color);
        padding: 10px 10px 31px 35px;
        border-radius: 6px;
        margin: 3px 4px 7px 4px;
        width: 50%;
    }

    .exam-create-calender {
        display: flex;
        align-items: center;
        justify-content: center;

    }

    .exam-create-degree-bar {
        display: flex;
        flex-direction: row;
        justify-content: space-around;
        flex-wrap: wrap;
        margin-bottom: 20px;
    }

    .exam-create-card1 {
        display: flex;
        flex-direction: column;
    }

    .exam-create-card2 {
        display: flex;
        flex-direction: column;
    }

    .exam-create-exam-bar {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        flex-wrap: nowrap;
        gap: 30px;
    }

    .exam-create-exam-card1 {
        display: flex;
        flex-direction: column;
    }

    .exam-create-exam-card2 {
        display: flex;
        flex-direction: column;
    }

    .form-subname {
        margin: 10px 0px 10px 0px;
        color: var(--black, #000);
        text-align: right;
        font-size: 14px;
        font-style: normal;
        font-weight: 400;
        line-height: normal;
        letter-spacing: 0.14px;
    }

    .progress {
        margin: 30px 0px 10px 0px;
        display: flex;
        flex-direction: row;
        justify-content: space-between;
    }

    .progress-bar {
        width: 100%;
        height: 10px;
        background-color: #CDEBFF;
        border-radius: 10px;
    }

    .progress-bar-active {
        width: 66%;
        height: 10px;
        background-color: #17376E;
        border-radius: 10px;

    }


    .exam-buttons {
        margin-top: 100px;
        display: flex;
        flex-direction: row;
        justify-content: center;
        gap: 20px;
    }

    .btn-primary {
        min-width: 10vh;
        color: #fff;
        height: 5vh;
        padding: 5px 5px 5px 5px;
        border-radius: 12px;
        background: #17376e;
        box-shadow: 0px 3px 6px 0px rgba(0, 0, 0, 0.2);
        border: 0px;
        margin-bottom: 10px;
        /* margin-top: 25px; */
    }

    .bt-name {
        font-size: 16px;
        font-weight: 500px;
    }

    .btn-primary:hover {
        color: #17376e;
        background-color: white;
        border: 1px solid
    }

    .btn-secondary {
        min-width: 10vh;
        color: #17376e;
        background: white;
        height: 5vh;
        padding: 5px 5px 5px 5px;
        border-radius: 12px;
        box-shadow: 0px 3px 6px 0px rgba(0, 0, 0, 0.2);
        border: 1px solid;
        margin-bottom: 10px;
    }

    .btn-secondary:hover {
        color: black;
        background-color: #E0E0E0;
        border: 1px solid #17376e;
    }



    .time-table-data {
        display: flex;
        flex-direction: row;
        justify-content: space-around;
        align-items: center;
        margin-top: 100px;


    }

    .exam-subjects {
        display: flex;
        flex-direction: row;
        justify-content: space-around;
        align-items: center;


    }


    .exam-sub-input {
        width: 100%;
        height: 40px;
        border-radius: 10px;
        border: 1px solid #17376E;
        padding: 10px;
        margin-top: 10px;

    }

    .exam-date-input {
        width: 50%;
        height: 40px;
        border-radius: 10px;
        border: 1px solid #17376E;
        padding: 10px;
        margin-top: 10px;

    }

    .exam-input-time {
        width: 80%;
        height: 40px;
        border-radius: 10px;
        border: 1px solid #17376E;
        padding: 10px;
        margin-top: 10px;

    }

    .title-headers {
        display: flex;
        flex-direction: row;
        justify-content: space-around;
        align-items: center;
        gap: 10em;
        margin-top: 100px;
    }

    .date-time-header {
        display: flex;
        flex-direction: row;
        justify-content: space-around;
        align-items: center;
        gap: 5em;

    }

    .date-time-input {
        display: flex;
        flex-direction: row;
        justify-content: space-around;
        align-items: center;
        gap: 10px;


    }

    .table th {
        color: #17376E;
        font-family: Poppins;
        font-size: 22px;
        font-style: normal;
        font-weight: 600;
        border: none;
        padding: 1em 0.5em 1em 0.5em;
    }

    table {
        border-collapse: collapse;
        border: none;
        margin: 50px 0px 20px 0px;
        width: 100%;
    }

    td {
        border: none;
        text-align: center;

    }

    .error {
        font-family: "Poppins";
        font-size: 14px;
        color: #FF0000;
        font-weight: 300;
        text-align: left;
    }

    .cancel-link {
        display: flex;
        justify-content: center;
        font-family: "Poppins";
        font-size: 12px;
        color: #17376E;
        font-weight: 400;
        margin-top: 40px;
        text-decoration: underline;
        cursor: pointer;
    }

    .cancel-a:hover {
        color: #FF0000;
    }

    .exam-cancel {
        position: fixed;
        top: -150%;
        left: 50%;
        transform: translate(-50%, -50%) scale(1.25);
        border: 1.5px solid rgba(00, 00, 00, 0.30);
        opacity: 0;
        background: #fff;
        width: 40%;
        /* height: 60vh; */
        padding: 40px;
        box-shadow: 9px 11px 60.9px 0px rgba(0, 0, 0, 0.60);
        border-radius: 10px;
        transition: top 0ms ease-in-out 200ms, opacity 200ms ease-in-out 0ms, transform 200ms ease-in-out 0ms;
        z-index: 2000;
    }

    .exam-cancel.active {
        top: 50%;
        opacity: 1;
        transform: translate(-50%, -50%) scale(1);
        transition: top 0ms ease-in-out 200ms, opacity 200ms ease-in-out 0ms, transform 200ms ease-in-out 0ms;
    }

    .create-body {
        width: 100%;
    }

    .create-body.active {
        filter: blur(5px);
        pointer-events: none;
        user-select: none;
        background: rgba(0, 0, 0, 0.30);
        overflow: hidden;
    }
</style>

<body>
    <div class='create-body' id='exam-create-body'>
        <?php $this->view('components/navside-bar/header', $data) ?>
        <?php $this->view('components/navside-bar/sidebar', $data) ?>
        <?php $this->view('components/navside-bar/footer', $data) ?>

        <div class="exam-create-home">
            <div class="exam-create-title">Create Examination</div>
            <div class="exam-create-subsection-1">
                <form method="post" id="exam-timetable" name='exam-timetable' onsubmit="return validateForm();">
                    <div class="exam-create-sub-title">
                        Add Participant

                        <div class="exam-create-steps">
                            <div class="progress">
                                <lable class="form-subname">Define time table for the examination</lable>
                                <lable class="form-subname">Step 3 of 3</lable>

                            </div>
                            <div class="progress-bar">
                                <div class="progress-bar-active"></div>
                            </div>
                            <div class="exam-time-table">
                                <table class="table">
                                    <tr>
                                        <th>
                                            Subject
                                        </th>
                                        <th>
                                            Date
                                        </th>
                                        <th>
                                            Time
                                        </th>
                                    </tr>
                                    <?php foreach ($subjects as $subject): ?>
                                        <?php $json = json_encode($subject); ?>

                                        <tr>
                                            <td>
                                                <input type="text" name="subName[]" value="<?= $subject->SubjectName ?>"
                                                    id="input-subject" class="exam-sub-input">
                                                <input type="text" name="subCode[]" value="<?= $subject->SubjectCode ?>"
                                                    id="input-subject" class="exam-sub-input" hidden>
                                            </td>
                                            <td>
                                                <input type="date" name="examDate[]" id="input-date" class=exam-date-input>
                                            </td>
                                            <td>
                                                <input type="time" name="examTime[]" class="exam-input-time">
                                            </td>
                                        </tr>

                                    <?php endforeach; ?>
                                    <!-- <tr>
                                    <td>
                                        <input type="text" name="subName[]" placeholder="Subject 01" id="input-subject"
                                            class="exam-sub-input">
                                        <input type="text" name="subCode[]" value='Sub1' placeholder="Subject 01"
                                            id="input-subject" class="exam-sub-input" hidden>
                                    </td>
                                    <td>
                                        <input type="date" name="examDate[]" id="input-date" class=exam-date-input>
                                    </td>
                                    <td>
                                        <input type="time" name="examTime[]" class="exam-input-time">
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <input type="text" name="subName[]" placeholder="Subject 01" id="input-subject"
                                            class="exam-sub-input">
                                        <input type="text" name="subCode[]" value='Sub1' placeholder="Subject 01"
                                            id="input-subject" class="exam-sub-input" hidden>
                                    </td>
                                    <td>
                                        <input type="date" name="examDate[]" id="input-date" class=exam-date-input>
                                    </td>
                                    <td>
                                        <input type="time" name="examTime[]" class="exam-input-time">
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <input type="text" name="subName[]" placeholder="Subject 01" id="input-subject"
                                            class="exam-sub-input">
                                        <input type="text" name="subCode[]" value='Sub1' placeholder="Subject 01"
                                            id="input-subject" class="exam-sub-input" hidden>
                                    </td>
                                    <td>
                                        <input type="date" name="examDate[]" id="input-date" class=exam-date-input>
                                    </td>
                                    <td>
                                        <input type="time" name="examTime[]" class="exam-input-time">
                                    </td>
                                </tr> -->
                                </table>
                                <div>
                                    <?php if (!empty($errors['date'])): ?>
                                        <div class="error">
                                            <?= $errors['date'] ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <div>
                                    <?php if (!empty($errors['subjectName'])): ?>
                                        <div class="error">
                                            <?= $errors['subjectName'] ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="exam-buttons">
                        <div class="cancel-button">
                            <button class="btn-secondary" type="button"
                                onclick="window.location.href='<?= ROOT ?>sar/examination/create/2'">Back</button>

                        </div>
                        <div class="next-button">
                            <button class="btn-primary" type="submit" value='timetable' name='submit'>Submit</button>
                        </div>
                    </div>
                    <div class=cancel-link>
                        <a class='cancel-a' onclick='showExamCanclePopup()'>Cancel</a>
                    </div>
                </form>
            </div>
            <div class="exam-create-footer">
                <?php $this->view('components/footer/index', $data) ?>
            </div>
        </div>
    </div>
    <div id="exam-cancel" class="exam-cancel">
        <?php $this->view('components/popup/examination-cancel-popup', $data) ?>
    </div>
</body>
<script>

    function showExamCanclePopup() {

        document.querySelector("#exam-cancel").classList.add("active");
        document.querySelector("#exam-create-body").classList.add("active");


    }

    function validateForm() {
        var subjects = document.getElementsByName("subName[]");
        var dates = document.getElementsByName("examDate[]");
        var times = document.getElementsByName("examTime[]");

        for (var i = 0; i < subjects.length; i++) {
            var subject = subjects[i].value.trim();
            var date = dates[i].value.trim();
            var time = times[i].value.trim();

            //validate all the fields
            if (subject === '' || date === '' || time === '') {
                alert("All fields are required. Please fill in all fields.");
                return false;
            }

            var currentDate = new Date();
            var inputDate = new Date(date + ' ' + time);

            //validate date
            if (inputDate <= currentDate) {
                alert("Please enter a future date and time.");
                return false;
            }
        }

        return true;
    }
</script>


</html>