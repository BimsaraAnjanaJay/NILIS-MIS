<!DOCTYPE html>
<html>
<title>Login</title>

<head>
    <link href="https://fonts.googleapis.com/css?family=Montserrat&display=swap" rel="stylesheet" />
    <style>
        /* Apply styles to the body and HTML to ensure full height */
        /* <meta name="viewport" content="width=device-width, initial-scale=1.0"> */
        @import url("https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,200;0,300;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,700;1,800;1,900&display=swap");
        @import url("https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Poppins:ital,wght@0,200;0,300;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,700;1,800;1,900&display=swap");

        body {
            width: 100%;
            background-color: #17376e;
            overflow: hidden;
            display: flex;
            flex-direction: row;
            /* align-items: center; */
            /* margin: 0px; */
            align-content: space-between;
            justify-content: center;
        }


        .flex-container {
            display: flex;
            flex-direction: row;
            width: 100%;
            align-items: center;
            background-color: #17376e;
        }

        .body_02 {
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: white;
            font-style: normal;
            border-radius: 50px 0 0 50px;
            width: 45%;
            max-width: 698px;
            text-align: center;
            height: 98%;
            /* line-height: 100%; */
            font-size: 28px;
            margin-left: auto;
            padding: 20px;
            background-color: white;
        }

        .body_02_1 {
            display: flex;
            justify-content: center;
            flex-direction: column;
            align-items: center;
            gap: 35px;
            width: 80%;
        }

        .body_01 {
            display: flex;
            flex-direction: column;
            gap: 30px;
            color: white;
            justify-content: center;
            width: 50%;
            align-items: center;
            margin: 20px;
        }

        .title {
            width: auto;
            font-family: "Montserrat", sans-serif;
            font-weight: 700;
            line-height: 1.2;
            font-size: 3.7vw;
        }

        .img1 {
            width: 28vw;
            max-width: 350px;
            height: auto;
        }

        .img2 {
            width: 30vw;
            max-width: 360px;
            height: auto;
        }

        .login {
            font-family: "Poppins", sans-serif;
            font-size: 30px;
            font-size: larger;
            font-weight: 600;
            color: #17376e;
        }

        .input {
            width: 35vw;
            height: 50px;
            margin-top: 20px;
            font-family: "Poppins";
            font-size: 16px;
            font-weight: 350;
            padding-left: 20px;
            border-radius: 13px;
            border: 1px;
            border-color: rgba(255, 255, 255, 0.2);
            background-color: #f5f5f5;
        }

        a {
            text-decoration: none;
        }

        .forgot-pwd-text {
            font-family: "Poppins";
            font-size: 12px;
            color: #6193b5;
            font-weight: 400;
            cursor: pointer;
        }

        .examination {
            color: #9ad6ff;
        }

        .error_block {
            /* margin: 10px; */
            margin: 10px 0px 30px 10px;
        }

        .error {
            font-family: "Poppins";
            font-size: 12px;
            color: #FF0000;
            font-weight: 300;
            text-align: left;

            /* margin-top: 20px; */
            /* margin-bottom: 20px; */
        }

        root {
            ----colour-secondar-1: #17376e;
        }

        button {
            color: #fff;

            width: 35vw;
            height: 3.2vw;
            padding: 8px 22px;
            border-radius: 10px;
            /* height: 6vh; */

            background: #17376e;
            box-shadow: 0px 3px 6px 0px rgba(0, 0, 0, 0.2);
            border: 0px;
        }

        .bt-name {
            font-size: 1.2vw;
            font-weight: 500;
        }

        button:hover {
            color: #17376e;
            background-color: white;
            border: 1px solid var(--colour-secondary-1, #17376e);
        }

        @media (max-width: 768px) {
            .body_01 {
                font-size: 20px;
            }

            .img1 {
                max-width: 250px;
            }

            .img2 {
                max-width: 260px;
            }
        }

        .show-pass {
            display: flex;
            font-family: "Poppins";
            font-size: 12px;
            color: #6193b5;
            font-weight: 400;
            text-align: left;
            margin-left: 10px;
            align-items: center;
            margin-top: 10px;
            gap: 5px;
        }

        .pass-text {
            margin-left: 5px;
        }

        .forgot-pwd.active {

            top: 50%;
            opacity: 1;
            transform: translate(-50%, -50%) scale(1);
            transition: top 0ms ease-in-out 200ms, opacity 200ms ease-in-out 0ms, transform 200ms ease-in-out 0ms;
        }

        .forgot-pwd {
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

        .login-body.active {
            filter: blur(5px);
            pointer-events: none;
            user-select: none;
            overflow: hidden;

        }

        .login-body {
            display: flex;
            flex-direction: row;
            width: 100%;
        }
    </style>
</head>

<body>
    <div class="login-body" id='body'>
        <div class="flex-container">
            <div class="body_01">
                <img class="img1" src="<?= ROOT ?>/assets/login/NILISLogo.png" alt="Logo" />
                <h1 class="title">
                    <div class="examination">Examination</div>
                    Management<br />Information<br />System
                </h1>
                <img class="img2" src="<?= ROOT ?>/assets/login/Loginpng.png" alt="Logo" />
            </div>
            <div class="body_02">
                <div class="body_02_1">
                    <div class="login">
                        Sign in to <br />
                        your account
                    </div>
                    <form method="post">
                        <input value="<?= set_value('username') ?>" class="input" type="text" placeholder="Username"
                            name="username" required />

                        <input value="<?= set_value('password') ?>" class="input" type="password" placeholder="Password"
                            name="password" id="password" required />
                        <div class="show-pass">
                            <input type="checkbox" onclick="showPassword()">
                            <div classs='pass-text'>Show Password</div>
                        </div>
                        <div class="error_block">
                            <?php if (!empty($errors['username'])): ?>
                                <div class="error">
                                    <?= $errors['username'] ?>
                                </div>
                            <?php endif; ?>
                        </div>
                        <button type="submit">
                            <div class="bt-name">Login</div>
                        </button>
                    </form>
                    <label class="forgot-pwd-text" onclick='showMailPopup()'>Forgot Password</label>
                </div>
            </div>
        </div>
    </div>
    <div class="forgot-pwd" id="forgot-pwd">
        <?php $this->view('components/popup/forgot-pwd', $data) ?>
    </div>
</body>

<script>
    function showPassword() {
        console.log('show password');
        var x = document.getElementById("password");
        if (x.type === "password") {
            x.type = "text";
        } else {
            x.type = "password";
        }
    }

    function showMailPopup() {
        console.log('run');
        document.querySelector("#forgot-pwd").classList.add("active");
        document.querySelector("#body").classList.add("active");
        console.log('run again');
    }
</script>

</html>