<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exam Attendacne</title>
</head>
<style>
    @import url("https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600;700&display=swap");
    @import url('https://fonts.googleapis.com/css2?family=Noto+Sans:ital,wght@0,400;0,700;1,400;1,700&display=swap');

    /* * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: "Poppins", sans-serif;
}

.container {
    height: 100vh;
    width: 100%;
    align-items: center;
    display: flex;
    justify-content: center;
    background-color: #fcfcfc;
} */
    /* 
.card {
    border-radius: 10px;
    box-shadow: 0 5px 10px 0 rgba(0, 0, 0, 0.3);
    width: 600px;
    height: 260px;
    background-color: #ffffff;
    padding: 10px 30px 40px;
} */

    .card h3 {
        font-size: 22px;
        font-weight: 600;

    }

    .drop_box {
        margin: 10px 0;
        padding: 30px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        border: 2px dotted #a3a3a3;
        border-radius: 5px;
    }

    .drop_box h4 {
        font-size: 16px;
        font-weight: 400;
        color: #2e2e2e;
    }

    .drop_box p {
        margin-top: 10px;
        margin-bottom: 20px;
        font-size: 12px;
        color: #a3a3a3;
    }

    .btn {
        width: 30%;
        color: #fff;
        height: 4vh;
        padding: 5px 5px 5px 5px;
        border-radius: 12px;
        background: #17376e;
        box-shadow: 0px 3px 6px 0px rgba(0, 0, 0, 0.2);
        border: 0px;
        margin-bottom: 10px;
    }

    .btn:hover {
        color: #17376e;
        background-color: white;
        border: 1px solid
    }

    .form input {
        margin: 10px 0;
        width: 100%;
        background-color: #e2e2e2;
        border: none;
        outline: none;
        padding: 12px 20px;
        border-radius: 4px;
    }
</style>

<body>
    <div class="container">
        <div class="card">
            <h3>Upload Files</h3>
            <div class="drop_box">
                <header>
                    <h4>Select File here</h4>
                </header>
                <p>Files Supported: .CSV </p>
                <input type="file" hidden accept=".doc,.docx,.pdf,.csv" id="fileID" style="display:none;">
                <button class="btn">Choose File</button>
            </div>

        </div>
    </div>
</body>
<script>
    const dropArea = document.querySelector(".drop_box"),
        button = dropArea.querySelector("button"),
        dragText = dropArea.querySelector("header"),
        input = dropArea.querySelector("input");
    let file;
    var filename;

    button.onclick = () => {
        input.click();
    };

    input.addEventListener("change", function (e) {
        var fileName = e.target.files[0].name;
        let filedata = `
    <form action="" method="post">
    <div class="form">
    <h4>${fileName}</h4>
    <button class="btn">Upload</button>
    </div>
    </form>`;
        dropArea.innerHTML = filedata;
    });
</script>

</html>