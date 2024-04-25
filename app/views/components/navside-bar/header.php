<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" type="text/css" href="<?= ROOT ?>css/sidebar-component.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <title>Navsidebar</title>
    <style>
        .notification-badge {
            position: absolute;
            top: 0;
            right: 0;
            background-color: red;
            color: white;
            border-radius: 50%;
            padding: 3px 6px;
            font-size: 12px;
            font-weight: bold;
        }

        .user-pic {
            width: 27px;
            height: 27px;
            border-radius: 50%;
            cursor: pointer;
            margin: 8px 10px -0.5px 10px;
        }

        .hero-ul {
            width: 100%;
            text-align: right;
        }

        .hero-ul-li {
            position: relative;
            display: inline-block;
            list-style: none;
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