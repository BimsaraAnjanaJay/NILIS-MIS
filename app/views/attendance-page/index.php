<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="style.css">
    </head>

<body>
<?php
    $role = "Clerk";

    include_once '../../components/navside-bar/header.php';
    include_once '../../components/navside-bar/sidebar.php';
    // include_once '../../components/navside-bar/footer.php';
?>
    <header>
    </header>
    
    <div class="white-container1">
        Attendance
    </div>

    <div class="white-container2">
        <p class="left-top-text">Add Attendance Record File</p>
        <div class="dashed-container">
            <label for="fileInput" class="file-input-icon"></label>
            <input type="file" id="fileInput" name="fileInput">
            <p class="text1">Drag and drop or <label for="fileInput" class="browse-label">browse</label>
                <input type="file" id="fileInput" name="fileInput">your files.</p>
        </div>
    </div>

    <button type="button">Record Attendance</button>
    
    <?php
    
    ?>
    
    <script>
        
    </script>
</body>
</html>
