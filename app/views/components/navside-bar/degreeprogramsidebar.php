<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" type="text/css" href="<?= ROOT ?>css/degreeprogramsidebar-component.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <title>Navsidebar</title>
    <style>
        .notification-badge {
            position: absolute;
            background-color: red;
            color: white;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 12px;
        }
        </style>
</head>

<body>
    <nav class="sidebar close">
        <header>
            <div class="image-text">
                <span class="image">
                    <img src="<?= ROOT ?>assets/NILIS-logo.png" alt="logo">
                </span>
                <div class="text header-text">
                    <h4 class="name1">National Institute of</h4>
                    <h5 class="name2">Library and Information Sciences</h5>
                    <span class="profession">University of Colombo</span>
                </div>
            </div>
            <i class='bx bx-chevron-right toggle'></i>
        </header>

        <?php if ($role == "DR") : ?>

            <div class="menu-bar">
                <hr>
                <div class="menu">
                    <ul class="menu-links">
                        <h6 class="topic3">PROGRAMS</h6>
                        <li class="nav-link">
                            <a href="<?= ROOT ?>dr/newdegree">
                                <i class="bx bx-layer-plus icon"></i>
                                <span class="text nav-text">Degree Name</span></a>
                        </li>
                        <li class="nav-link">
                            <a href="<?= ROOT ?>dr/participants">
                                <i class="bx bx-group icon"></i>
                                <span class="text nav-text">Participants</span>
                            </a>
                        </li>
                        <li class="nav-link">
                            <a href="<?= ROOT ?>dr/examination">
                                <i class="bx bx-book icon"></i>
                                <span class="text nav-text">Examination</span>
                            </a>
                        </li>
                        <li class="nav-link">
                            <a href="<?= ROOT ?>dr/attendance">
                                <i class="bx bx-check-square icon"></i>
                                <span class="text nav-text">Attendance</span>
                            </a>
                        </li>
                        <li class="nav-link">
                            <a href="<?= ROOT ?>dr/reports">
                                <i class="bx bx-file icon"></i>
                                <span class="text nav-text">Reports</span>
                            </a>
                        </li>


                        <hr class="horizontal-line"><br>
                        <h6 class="topic1">MAIN</h6>
                        <li class="nav-link">
                            <a href="<?= ROOT ?>dr">
                                <i class="bx bx-home icon"></i>
                                <span class="text nav-text">Dashboard</span>
                            </a>
                        </li>
                        <li class="nav-link">
                            <a href="<?= ROOT ?>dr/notification">
                                <i class="bx bx-bell icon"></i>
                                <span class="text nav-text">Notification</span>
                            </a>
                        </li>
                        <li class="nav-link">
                            <a href="<?= ROOT ?>dr/degreeprograms">
                                <i class="bx bx-layer-plus icon"></i>
                                <span class="text nav-text">Degree Programs</span>
                            </a>
                        </li>
                        <hr class="horizontal-line">
                        <h6 class="topic2">SETTINGS</h6>
                        <li class="nav-link">
                            <a href="<?= ROOT ?>dr/settings">
                                <i class="bx bx-cog icon"></i>
                                <span class="text nav-text">Settings</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
    </nav>

    <div class="hero">
        <nav>
            <ul class="hero-ul">
                <li class="hero-ul-li"><a href="<?= ROOT ?>dr/notification"><i class="bx bxs-bell icon"></i></a></li>
                <li class="hero-ul-li"><img src="http://localhost/NILIS-MIS/public/assets/user_img.jpg" class="user-pic" onclick="toggleMenu()"></li>
            </ul>

            <div class="sub-menu-wrap" id="subMenu">
                <div class="sub-menu">
                    <div class="user-info">
                        <img src="http://localhost/NILIS-MIS/public/assets/user_img.jpg">
                        <h3><?=$_SESSION['USER_DATA']->fname . " " . $_SESSION['USER_DATA']->lname?></h3>
                    </div>
                    <hr>
                    <a href="<?= ROOT ?>logout" class="sub-menu-link">
                        <i class="bx bx-log-out icon"></i>
                        <p>Logout</p>
                        <span>></span>
                    </a>
                </div>
            </div>
        </nav>
    </div>

<?php endif ?>
<?php if ($role == "SAR") : ?>

    <div class="menu-bar">
        <hr>
        <div class="menu">
            <ul class="menu-links">
                <h6 class="topic3">PROGRAMS</h6>
                <li class="nav-link">
                    <a href="<?= ROOT ?>sar/newdegree">
                        <i class="bx bx-layer-plus icon"></i>
                        <span class="text nav-text">Degree Name</span></a>
                </li>
                <li class="nav-link">
                    <a href="<?= ROOT ?>sar/participants">
                        <i class="bx bx-group icon"></i>
                        <span class="text nav-text">Participants</span>
                    </a>
                </li>
                <li class="nav-link" id="myButton">
                    <a href="<?= ROOT ?>sar/examination">
                        <i class="bx bx-book icon"></i>
                        <span class="text nav-text">Examination</span>
                    </a>
                    <?php
                    // Check if the URL contains any of the specified patterns
                    $url = $_SERVER['REQUEST_URI'];
                    if (
                        strpos($url, "examination/participants") !== false ||
                        strpos($url, "examination/resultsupload") !== false ||
                        strpos($url, "examination/results") !== false
                    ) {
                        echo '<div class="dropdown">' .
                            '<a href="' . ROOT . 'sar/participants"><center>Examination Results</center></a>' .
                            '<a href="' . ROOT . 'sar/resultsupload"><center>Examination Submission</center></a>' .
                            '<a href="' . ROOT . 'sar/results"><center>Examination Participants</center></a>' .
                            '</div>';
                    }
                    ?>
                </li>
                <li class="nav-link">
                    <a href="<?= ROOT ?>sar/attendance">
                        <i class="bx bx-check-square icon"></i>
                        <span class="text nav-text">Attendance</span>
                    </a>
                </li>
                <li class="nav-link">
                    <a href="<?= ROOT ?>sar/reports">
                        <i class="bx bx-file icon"></i>
                        <span class="text nav-text">Reports</span>
                    </a>
                </li>


                <hr class="horizontal-line"><br>
                <h6 class="topic1">MAIN</h6>
                <li class="nav-link">
                    <a href="<?= ROOT ?>sar">
                        <i class="bx bx-home icon"></i>
                        <span class="text nav-text">Dashboard</span>
                    </a>
                </li>
                <li class="nav-link">
                    <a href="<?= ROOT ?>sar/notification">
                        <i class="bx bx-bell icon"></i>
                        <span class="text nav-text">Notification</span>
                    </a>
                </li>
                <li class="nav-link">
                    <a href="<?= ROOT ?>sar/degreeprograms">
                        <i class="bx bx-layer-plus icon"></i>
                        <span class="text nav-text">Degree Programs</span>
                    </a>
                </li>
                <hr class="horizontal-line">
                <h6 class="topic2">SETTINGS</h6>
                <li class="nav-link">
                    <a href="<?= ROOT ?>sar/settings">
                        <i class="bx bx-cog icon"></i>
                        <span class="text nav-text">Settings</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
    </nav>

    <div class="hero">
        <nav>
            <ul class="hero-ul">
                <li class="hero-ul-li"><a href="<?= ROOT ?>sar/notification"><i class="bx bxs-bell icon"></i></a></li>
                <li class="hero-ul-li"><img src="http://localhost/NILIS-MIS/public/assets/user_img.jpg" class="user-pic" onclick="toggleMenu()"></li>
            </ul>

            <div class="sub-menu-wrap" id="subMenu">
                <div class="sub-menu">
                    <div class="user-info">
                        <img src="http://localhost/NILIS-MIS/public/assets/user_img.jpg">
                        <h3><?=$_SESSION['USER_DATA']->fname . " " . $_SESSION['USER_DATA']->lname?></h3>
                    </div>
                    <hr>
                    <a href="<?= ROOT ?>logout" class="sub-menu-link">
                        <i class="bx bx-log-out icon"></i>
                        <p>Logout</p>
                        <span>></span>
                    </a>
                </div>
            </div>
        </nav>
    </div>

<?php endif ?>
<?php if ($role == "Assistant-SAR") : ?>

    <div class="menu-bar">
        <hr>
        <div class="menu">
            <ul class="menu-links">
                <h6 class="topic3">PROGRAMS</h6>
                <li class="nav-link">
                    <a href="<?= ROOT ?>dr/newdegree">
                        <i class="bx bx-layer-plus icon"></i>
                        <span class="text nav-text">Degree Name</span></a>
                </li>
                <li class="nav-link">
                    <a href="<?= ROOT ?>dr/participants">
                        <i class="bx bx-group icon"></i>
                        <span class="text nav-text">Participants</span>
                    </a>
                </li>
                <li class="nav-link">
                    <a href="<?= ROOT ?>dr/examination">
                        <i class="bx bx-book icon"></i>
                        <span class="text nav-text">Examination</span>
                    </a>
                </li>
                <li class="nav-link">
                    <a href="<?= ROOT ?>dr/attendance">
                        <i class="bx bx-check-square icon"></i>
                        <span class="text nav-text">Attendance</span>
                    </a>
                </li>
                <li class="nav-link">
                    <a href="<?= ROOT ?>dr/reports">
                        <i class="bx bx-file icon"></i>
                        <span class="text nav-text">Reports</span>
                    </a>
                </li>


                <hr class="horizontal-line"><br>
                <h6 class="topic1">MAIN</h6>
                <li class="nav-link">
                    <a href="<?= ROOT ?>dr">
                        <i class="bx bx-home icon"></i>
                        <span class="text nav-text">Dashboard</span>
                    </a>
                </li>
                <li class="nav-link">
                    <a href="<?= ROOT ?>dr/notification">
                        <i class="bx bx-bell icon"></i>
                        <span class="text nav-text">Notification</span>
                    </a>
                </li>
                <li class="nav-link">
                    <a href="<?= ROOT ?>dr/degreeprograms">
                        <i class="bx bx-layer-plus icon"></i>
                        <span class="text nav-text">Degree Programs</span>
                    </a>
                </li>
                <hr class="horizontal-line">
                <h6 class="topic2">SETTINGS</h6>
                <li class="nav-link">
                    <a href="<?= ROOT ?>dr/settings">
                        <i class="bx bx-cog icon"></i>
                        <span class="text nav-text">Settings</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
    </nav>

    <div class="hero">
        <nav>
            <ul class="hero-ul">
                <li class="hero-ul-li"><a href="<?= ROOT ?>dr/notification"><i class="bx bxs-bell icon"></i></a></li>
                <li class="hero-ul-li"><img src="http://localhost/NILIS-MIS/public/assets/user_img.jpg" class="user-pic" onclick="toggleMenu()"></li>
            </ul>

            <div class="sub-menu-wrap" id="subMenu">
                <div class="sub-menu">
                    <div class="user-info">
                        <img src="http://localhost/NILIS-MIS/public/assets/user_img.jpg">
                        <h3><?=$_SESSION['USER_DATA']->fname . " " . $_SESSION['USER_DATA']->lname?></h3>
                    </div>
                    <hr>
                    <a href="<?= ROOT ?>logout" class="sub-menu-link">
                        <i class="bx bx-log-out icon"></i>
                        <p>Logout</p>
                        <span>></span>
                    </a>
                </div>
            </div>
        </nav>
    </div>

<?php endif ?>
<?php if ($role == "Admin") : ?>

    <div class="menu-bar">
        <hr>
        <div class="menu">
            <ul class="menu-links">
                <h6 class="topic3">PROGRAMS</h6>
                <li class="nav-link">
                    <a href="<?= ROOT ?>dr/newdegree">
                        <i class="bx bx-layer-plus icon"></i>
                        <span class="text nav-text">Degree Name</span></a>
                </li>
                <li class="nav-link">
                    <a href="<?= ROOT ?>dr/participants">
                        <i class="bx bx-group icon"></i>
                        <span class="text nav-text">Participants</span>
                    </a>
                </li>
                <li class="nav-link">
                    <a href="<?= ROOT ?>dr/examination">
                        <i class="bx bx-book icon"></i>
                        <span class="text nav-text">Examination</span>
                    </a>
                </li>
                <li class="nav-link">
                    <a href="<?= ROOT ?>dr/attendance">
                        <i class="bx bx-check-square icon"></i>
                        <span class="text nav-text">Attendance</span>
                    </a>
                </li>
                <li class="nav-link">
                    <a href="<?= ROOT ?>dr/reports">
                        <i class="bx bx-file icon"></i>
                        <span class="text nav-text">Reports</span>
                    </a>
                </li>


                <hr class="horizontal-line"><br>
                <h6 class="topic1">MAIN</h6>
                <li class="nav-link">
                    <a href="<?= ROOT ?>dr">
                        <i class="bx bx-home icon"></i>
                        <span class="text nav-text">Dashboard</span>
                    </a>
                </li>
                <li class="nav-link">
                    <a href="<?= ROOT ?>dr/notification">
                        <i class="bx bx-bell icon"></i>
                        <span class="text nav-text">Notification</span>
                    </a>
                </li>
                <li class="nav-link">
                    <a href="<?= ROOT ?>dr/degreeprograms">
                        <i class="bx bx-layer-plus icon"></i>
                        <span class="text nav-text">Degree Programs</span>
                    </a>
                </li>
                <hr class="horizontal-line">
                <h6 class="topic2">SETTINGS</h6>
                <li class="nav-link">
                    <a href="<?= ROOT ?>dr/settings">
                        <i class="bx bx-cog icon"></i>
                        <span class="text nav-text">Settings</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
    </nav>

    <div class="hero">
        <nav>
            <ul class="hero-ul">
                <li class="hero-ul-li"><a href="<?= ROOT ?>dr/notification"><i class="bx bxs-bell icon"></i></a></li>
                <li class="hero-ul-li"><img src="http://localhost/NILIS-MIS/public/assets/user_img.jpg" class="user-pic" onclick="toggleMenu()"></li>
            </ul>

            <div class="sub-menu-wrap" id="subMenu">
                <div class="sub-menu">
                    <div class="user-info">
                        <img src="http://localhost/NILIS-MIS/public/assets/user_img.jpg">
                        <h3><?=$_SESSION['USER_DATA']->fname . " " . $_SESSION['USER_DATA']->lname?></h3>
                    </div>
                    <hr>
                    <a href="<?= ROOT ?>logout" class="sub-menu-link">
                        <i class="bx bx-log-out icon"></i>
                        <p>Logout</p>
                        <span>></span>
                    </a>
                </div>
            </div>
        </nav>
    </div>

<?php endif ?>
<?php if ($role == "director") : ?>

    <div class="menu-bar">
        <hr>
        <div class="menu">
            <ul class="menu-links">
                <h6 class="topic3">PROGRAMS</h6>
                <li class="nav-link">
                    <a href="<?= ROOT ?>dr/newdegree">
                        <i class="bx bx-layer-plus icon"></i>
                        <span class="text nav-text">Degree Name</span></a>
                </li>
                <li class="nav-link">
                    <a href="<?= ROOT ?>dr/participants">
                        <i class="bx bx-group icon"></i>
                        <span class="text nav-text">Participants</span>
                    </a>
                </li>
                <li class="nav-link">
                    <a href="<?= ROOT ?>dr/examination">
                        <i class="bx bx-book icon"></i>
                        <span class="text nav-text">Examination</span>
                    </a>
                </li>
                <li class="nav-link">
                    <a href="<?= ROOT ?>dr/attendance">
                        <i class="bx bx-check-square icon"></i>
                        <span class="text nav-text">Attendance</span>
                    </a>
                </li>
                <li class="nav-link">
                    <a href="<?= ROOT ?>dr/reports">
                        <i class="bx bx-file icon"></i>
                        <span class="text nav-text">Reports</span>
                    </a>
                </li>


                <hr class="horizontal-line"><br>
                <h6 class="topic1">MAIN</h6>
                <li class="nav-link">
                    <a href="<?= ROOT ?>dr">
                        <i class="bx bx-home icon"></i>
                        <span class="text nav-text">Dashboard</span>
                    </a>
                </li>
                <li class="nav-link">
                    <a href="<?= ROOT ?>dr/notification">
                        <i class="bx bx-bell icon"></i>
                        <span class="text nav-text">Notification</span>
                    </a>
                </li>
                <li class="nav-link">
                    <a href="<?= ROOT ?>dr/degreeprograms">
                        <i class="bx bx-layer-plus icon"></i>
                        <span class="text nav-text">Degree Programs</span>
                    </a>
                </li>
                <hr class="horizontal-line">
                <h6 class="topic2">SETTINGS</h6>
                <li class="nav-link">
                    <a href="<?= ROOT ?>director/settings">
                        <i class="bx bx-cog icon"></i>
                        <span class="text nav-text">Settings</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
    </nav>

    <div class="hero">
        <nav>
        <ul class="hero-ul">
    <li class="hero-ul-li"><a href="<?= ROOT ?>director/notifications">
            <?php
            // Retrieve notification count from session variable
            $notificationCount = isset($_SESSION['notificationCount']) ? $_SESSION['notificationCount'] : 0;
            ?>
            <?php if ($notificationCount > 0) : ?>
                <span class="notification-badge"><?= $notificationCount ?></span>
            <?php endif; ?><i class="bx bxs-bell icon">
            </i>
        </a></li>
    <li class="hero-ul-li"><img src="http://localhost/NILIS-MIS/public/assets/user_img.jpg" class="user-pic" onclick="toggleMenu()"></li>
</ul>

            <div class="sub-menu-wrap" id="subMenu">
                <div class="sub-menu">
                    <div class="user-info">
                        <img src="http://localhost/NILIS-MIS/public/assets/user_img.jpg">
                        <h3><?=$_SESSION['USER_DATA']->fname . " " . $_SESSION['USER_DATA']->lname?></h3>
                    </div>
                    <hr>
                    <a href="<?= ROOT ?>logout" class="sub-menu-link">
                        <i class="bx bx-log-out icon"></i>
                        <p>Logout</p>
                        <span>></span>
                    </a>
                </div>
            </div>
        </nav>
    </div>

<?php endif ?>

<?php if ($role == "Clerk") : ?>

<div class="menu-bar">
    <hr>
    <div class="menu">
        <ul class="menu-links">
            <h6 class="topic3">PROGRAMS</h6>
            <li class="nav-link">
                <a href="<?= ROOT ?>dr/newdegree">
                    <i class="bx bx-layer-plus icon"></i>
                    <span class="text nav-text">Degree Name</span></a>
            </li>
            <li class="nav-link">
                <a href="<?= ROOT ?>clerk/participants">
                    <i class="bx bx-group icon"></i>
                    <span class="text nav-text">Participants</span>
                </a>
            </li>
            <li class="nav-link">
                <a href="<?= ROOT ?>clerk/examination">
                    <i class="bx bx-book icon"></i>
                    <span class="text nav-text">Examination</span>
                </a>
            </li>
            <li class="nav-link">
                <a href="<?= ROOT ?>clerk/attendance">
                    <i class="bx bx-check-square icon"></i>
                    <span class="text nav-text">Attendance</span>
                </a>
            </li>
            <li class="nav-link">
                <a href="<?= ROOT ?>clerk/updatedattendance">
                    <i class="bx bx-file icon"></i>
                    <span class="text nav-text">Reports</span>
                </a>
            </li>


            <hr class="horizontal-line"><br>
            <h6 class="topic1">MAIN</h6>
            <li class="nav-link">
                <a href="<?= ROOT ?>dr">
                    <i class="bx bx-home icon"></i>
                    <span class="text nav-text">Dashboard</span>
                </a>
            </li>
            <li class="nav-link">
                <a href="<?= ROOT ?>clerk/notifications">
                    <i class="bx bx-bell icon"></i>
                    <span class="text nav-text">Notification</span>
                </a>
            </li>
            <li class="nav-link">
                <a href="<?= ROOT ?>clerk/degreeprograms">
                    <i class="bx bx-layer-plus icon"></i>
                    <span class="text nav-text">Degree Programs</span>
                </a>
            </li>
            <hr class="horizontal-line">
            <h6 class="topic2">SETTINGS</h6>
            <li class="nav-link">
                <a href="<?= ROOT ?>clerk/settings">
                    <i class="bx bx-cog icon"></i>
                    <span class="text nav-text">Settings</span>
                </a>
            </li>
        </ul>
    </div>
</div>
</nav>

<div class="hero">
<nav>
<ul class="hero-ul">
    <li class="hero-ul-li"><a href="<?= ROOT ?>clerk/notifications">
            <?php
            // Retrieve notification count from session variable
            $notificationCount = isset($_SESSION['notificationCount']) ? $_SESSION['notificationCount'] : 0;
            ?>
            <?php if ($notificationCount > 0) : ?>
                <span class="notification-badge"><?= $notificationCount ?></span>
            <?php endif; ?><i class="bx bxs-bell icon">
            </i>
        </a></li>
    <li class="hero-ul-li"><img src="http://localhost/NILIS-MIS/public/assets/user_img.jpg" class="user-pic" onclick="toggleMenu()"></li>
</ul>

<div class="sub-menu-wrap" id="subMenu">
    <div class="sub-menu">
        <div class="user-info">
            <img src="http://localhost/NILIS-MIS/public/assets/user_img.jpg">
            <h3><?= $_SESSION['USER_DATA']->fname . " " . $_SESSION['USER_DATA']->lname ?></h3>
        </div>
        <hr>
        <a href="<?= ROOT ?>logout" class="sub-menu-link">
            <i class="bx bx-log-out icon"></i>
            <p>Logout</p>
            <span>></span>
        </a>
    </div>
</div>
</nav>
</div>

<?php endif ?>