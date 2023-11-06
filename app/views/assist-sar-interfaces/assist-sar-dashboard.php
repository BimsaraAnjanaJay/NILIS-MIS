<?php
    $role = "Assistant-SAR";

    include_once '../../components/navside-bar/header.php';
    include_once '../../components/navside-bar/sidebar.php';
    include_once '../../components/navside-bar/footer.php';
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="./assist-sar-dashboard.css">
        <title>Assistant-SAR Dashboard</title>
    </head>
    <body>
    <div class="assist-sar-home">
            <div class="assist-sar-title">Assistant SAR Dashboard</div>
            <div class="assist-sar-subsection-1">
                <p>Online Degree Programs</p>
                <?php
                    include "../../components/degree-card/degree-card.php";
                    include "../../components/degree-card/degree-card.php";
                ?>
            </div>
            <div class="assist-sar-subsection-2">
                <p>Recently Publish Examination Results</p>
                <?php
                    include "../../components/exam-card/exam-card.php";
                    include "../../components/exam-card/exam-card.php";
                ?>
            </div> 
            <div class="assist-sar-subsection-3">
                <?php
                    // include "../../components/calender/calender.php";
                ?>
            </div>  
        </div>
    </body>
</html>