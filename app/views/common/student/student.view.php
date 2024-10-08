<?php
    $role = "DR";
    $data['role']=$role;
?>

<?php $this->view('components/navside-bar/header',$data) ?>
<?php $this->view('components/navside-bar/sidebar',$data) ?>
<?php $this->view('components/navside-bar/footer',$data) ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="<?= ROOT ?>/css/student/style.css">
    <!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> -->
    <style>

.sidebar.close~.home {
    left: 88px;
    width: calc(100% - 88px);
}

.home {
    height: 100vh;
    left: 250px;
    position: relative;
    width: calc(100% - 250px);
    transition: var(--tran-05);
    /* background: var(--body-color); */
}

        #overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.7);
            z-index: 1;
            transition: background-color 0.5s;
        }
        .button-container {
            margin-left: 5%;
            margin-top: 150px;
            gap:10%;
            display: flex;
            flex-direction: row;
        }
        .yesorno{
            margin-left: 100px;
            display: flex;
            flex-direction: row;
            column-gap: 20px;
        }

        .pop-up {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: aqua;
            padding: 20px;
            z-index: 2;
        }

        .pop-up1 {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: #fff;
            padding: 20px;
            z-index: 2;
        }

        .pop-up2 {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: #fff;
            padding: 20px;
            z-index: 2;
        }

        .popupForm2{
            background-color: aquamarine;
            height: 40vw;
        }

        #fname,
#lname,
#mail,
#regno,
#country,
#indexno,
#nicno,
#bday,
#fax,
#addr,
#phoneno {
  width: 100%;
  height: 0.1vw;
  /* margin: 8px 0;
  display: inline-block;
  border: 1px solid #ccc;
  border-radius: 4px;
  box-sizing: border-box; */
 
} 
   

    </style>
</head>

<body>

   <div class="home">

    <div class="white-container1-1">
       <h1> Diploma in Library and Information Management</h1>
    </div>

    <div class="white-container2-1">
    <p class="left-top-text1">User Details</p>
        <div class="row">
            <div class="column1">
                <div class=name>
                <img src="<?=ROOT?>assets/dr/imgano.png">
                    <!-- <p><h2><?= $student->name ?></h2></p> -->
                    <p><h2>Senudi Muthugala</h2></p>
                
                </div>
            </div>


            <div class="column2">
                <div class="data1"><b>Email:</b><br>
                    <!-- <div class="email"><?= $student->Email ?></div> -->
                    <div class="email">email1@gmail.com</div>
                </div>
                <br>
                <div class="data2"><b>Registration number:</b><br>
                    <!-- <div class="regNum"> <?= $student->regNo ?></div> -->
                    <div class="regNum">DLIM/01/01</div>
                </div>
            </div>

            <div class="column3">
                <div class="data3"><b>Country:</b><br>
                    <div class="country"> Sri Lanka</div>
                </div>
                <br>
                <div class="data4"><b>Index number:</b><br>
                    <div class="indexNum"> DLIM/005</div>
                </div>
            </div>
        </div>
<div class="button-container">
 <div class="buttony">
            <input type="button" id="changedegreebutton" class="button" value="Change Degree Program" onclick="updateData()">
 </div>
 <div class="buttony">
            <input type="button" id="deletebutton" class="button" value="Delete User Details" onclick="updateData2()">
 </div>
</div>
            <script>
                function updateData() {
                    // Show the overlay and pop-up
                    $('#overlay').css('display', 'block');
                    $('.pop-up1').css('display', 'block');

                    $('.close-button').click(function(e) {
                        // Hide the pop-up and overlay when the close button is clicked
                        $('.pop-up1').css('display', 'none');
                        $('#overlay').css('display', 'none');
                        e.stopPropagation();
                    });
                }
                function updateData2() {
                    // Show the overlay and pop-up
                    $('#overlay').css('display', 'block');
                    $('.pop-up2').css('display', 'block');

                    $('.close-button').click(function(e) {
                        // Hide the pop-up and overlay when the close button is clicked
                        $('.pop-up2').css('display', 'none');
                        $('#overlay').css('display', 'none');
                        e.stopPropagation();
                    });
                }
            </script>
        </div>



    <div class="pop-up1">
        

        <div class="popupForm1">
            <form method="post">
                <p>
                <h1>Change Degree Program</h1>
                </p>
                <br>
                <div class="cur-deg">
                <!-- <input type="hidden" name="id" value="<?=$student->id?>"> -->
                <label for="degree"><h3>Current Degree Program : </h3>
                <!-- <?=$student->Degree?> -->
                DLIM
            </label>
                </div>
            </br>
            <div class="change-deg">
                <label for="Degrees">Change Degree Program</label>
                <select id="Degree" name="Degree">
                    <option value="Degree1">Degree1</option>
                    <option value="Degree2">Degree2</option>
                    <option value="Degree3">Degree3</option>
                </select>
                <br>
            </div>
        <input type="submit" id="update-deg" value="Submit">
        <button class="close-button">Close</button>
            </form>
        </div>

        
    </div>

    <div id="overlay"></div>

    <div class="pop-up2">
        

        <div class="popupForm">
                <p>
                <h2>Do you want to delete this student data?</h2>
                </p>
               <br>
        <div class="yesorno">
        <!-- <a href="<?=ROOT?>/Student/<?=$student->indexNo?>/delete/<?=$student->id?>"> -->
        <button class="close-button">Yes,Sure</button></a>
        <button class="close-button">No,Close</button>
        </div>
    </div>

    <div id="overlay"></div>


            
    </div>

    <div class="flex-container">
        <div class="white-container3-1">
            <p class="left-top-text2">Examination Results</p>
            <p class="left-top-text3">Semester 1</p>
            <table>
                <tr>
                    <th>Subject</th>
                    <th>Result</th>
                </tr>
                <tr>
                    <td>Subject1</td>
                    <td>A</td>
                </tr>
                <tr>
                    <td>Subject2</td>
                    <td>A</td>
                </tr>
                <tr>
                    <td>Subject3</td>
                    <td>A</td>
                </tr>
                <tr>
                    <td>Subject4</td>
                    <td>A</td>
                </tr>
            </table>
            <br>
            <p class="left-top-text3">Semester 2</p>
            <table>
                <tr>
                    <th>Subject</th>
                    <th>Result</th>
                </tr>
                <tr>
                    <td>Subject1</td>
                    <td>A</td>
                </tr>
                <tr>
                    <td>Subject2</td>
                    <td>A</td>
                </tr>
                <tr>
                    <td>Subject3</td>
                    <td>A</td>
                </tr>
                <tr>
                    <td>Subject4</td>
                    <td>A</td>
                </tr>
            </table>
        </div>


        <div class="white-container4-1">
            <p class="left-top-text2">Other Information</p>

            <div class="row2">
                <div class="column2-1">
                    <div class="data1"><b>Date Of Birth:</b><br>
                        <!-- <div class="bday"><?= $student->birthdate ?></div> -->
                        <div class="bday">2001.11.24</div>
                    </div>
                    <br>
                    <div class="data2"><b>N.I.C. No:</b><br>
                        <!-- <div class="nic"> <?= $student->nicNo ?></div> -->
                        <div class="nic">20018223456</div>
                    </div><br>
                    <div class="data2"><b>Phone Number:</b><br>
                        <!-- <div class="phoneNum"> <?= $student->phoneNo ?></div> -->
                        <div class="phoneNum">0702637466</div>
                    </div>
                </div>

                <div class="column2-2">
                    <div class="data1"><b>Fax:</b><br>
                        <!-- <div class="Fax"><?= $student->fax ?></div> -->
                        <div class="Fax">+2134-2345678</div>
                    </div>
                    <br>
                    <div class="data2"><b>Address:</b><br>
                        <!-- <div class="adr"> <?= $student->address ?></div> -->
                        <div class="adr">No 34,Gamunu Mawatha,Panadura</div>
                    </div>
                </div>
            </div>
            <div class="buttonx">
                <input type="button" id="updateButton" class="button" value="Update" onclick="updateData1()">

                <script>
                    function updateData1() {
                        // Show the overlay and pop-up
                        $('#overlay').css('display', 'block');
                        $('.pop-up').css('display', 'block');

                        $('.close-button').click(function(e) {
                            // Hide the pop-up and overlay when the close button is clicked
                            $('.pop-up').css('display', 'none');
                            $('#overlay').css('display', 'none');
                            e.stopPropagation();
                        });
                    }
                </script>
            </div>
        </div>
    </div>

    <div class="pop-up">

        <div class="popupForm2">
            <form method="post">
                <p>
                <h2>Change Student Details</h2>
                </p>
                <!-- <input type="hidden" id="id"  name="id" value="<?=$student->id?>"> -->
                <label for="fname">Name</label>
                <input type="text" id="fname"placeholder="Full Name" name="name">
                <label for="mail">Email</label>
                <input type="text" id="mail" placeholder="Email Address" name="Email">
                <label for="country">Country</label>
                <input type="text" id="country" placeholder="Currently living country" name="country">
                <label for="nicno">N.I.C</label>
                <input type="text" id="nicno" placeholder="N.I.C Number" name="nicNo">
                <label for="bday">Birthdate</label>
                <input type="text" id="bday" placeholder="Birthdate" name="birthdate">
                <label for="fax">Fax</label>
                <input type="text" id="fax" placeholder="Fax" name="fax">
                <label for="addr">Address</label>
                <input type="text" id="addr" placeholder="Adress" name="address">
                <label for="phoneno">Phone Number</label>
                <input type="text" id="phoneno" placeholder="Fax" name="phoneNo">
                <label for="fax">Fax</label>
                <input type="text" id="fax" placeholder="Fax" name="fax">

                <input type="submit" id="submitbutton" value="Submit">
                <button class="close-button">Close</button>
            </form>
        </div>

        
    </div>

    <div id="overlay"></div>
   </div>
</body>

</html>