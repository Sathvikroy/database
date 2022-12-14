<?php

$servername = "localhost";
$username = "root";
$password = "password";
$db = "Airlines";


// connection
$conn = new mysqli($servername, $username, $password, $db);

// Check connection
if ($conn -> connect_error) {
  die("Connection failed: " . $conn -> connect_error);
}

$sql1 = "SELECT COUNT(*) as total FROM `Airport` WHERE visibility <> ''";
$res1 = $conn -> query($sql1);
$q1 = $res1 -> fetch_array()['total'];

$sql2 = "SELECT COUNT(*) as total FROM `Aircraft` WHERE engines >= 2";
$res2 = $conn -> query($sql2);
$q2 = $res2 -> fetch_array()['total'];

$sql3 = "SELECT operator, COUNT(*) as total FROM `Operator` GROUP BY operator ORDER BY total DESC LIMIT 1";
$res3 = $conn -> query($sql3);
$q3 = $res3 -> fetch_array()['operator'];

$sql4 = "SELECT COUNT(*) as total FROM `Airport` WHERE Warning_issue <> ''";
$res4 = $conn -> query($sql4);
$q4 = $res4 -> fetch_array()['total'];

$sql5 = "SELECT COUNT(*) as total FROM `Operator` WHERE operator = 'MIL'";
$res5 = $conn -> query($sql5);
$q5 = $res5 -> fetch_array()['total'];

// user defined quiries
if (isset($_POST['SubmitButton'])) {
    $input1 = isset($_POST['inp1']) ? $_POST['inp1'] : '';
    $input2 = isset($_POST['inp2']) ? $_POST['inp2'] : '';

    if (!empty($input1)) {
        $sql = "SELECT COUNT(*) as total FROM `Airport` WHERE `name` = '{$input1}'";
        $res = $conn -> query($sql);
        $ans1 = $res -> fetch_array()['total'];
    }

    if (!empty($input2)) {
        $sql = "SELECT COUNT(*) as total FROM `Airport` WHERE `speed` > '{$input2}'";
        $res = $conn -> query($sql);
        $ans2 = $res -> fetch_array()['total'];
    }
}  

// handle insert requests here
if (isset($_POST['InsSubmitButton1'])) {
    $oid = isset($_POST['inp1_1']) ? $_POST['inp1_1'] : '';
    $oname = isset($_POST['inp1_2']) ? $_POST['inp1_2'] : '';

    if (!empty($oid) && !empty($oname)) {
        $sql = "INSERT INTO Operator (oid, operator) VALUES ('{$oid}', '{$oname}')";
        if ($conn -> query($sql) === TRUE) {
            header('Location: '.$_SERVER['REQUEST_URI']);
        } else {
            echo "Error: " . $sql . "<br>" . $conn -> error;
        }
    }
}

if (isset($_POST['InsSubmitButton2'])) {
    $sid = isset($_POST['inp2_1']) ? $_POST['inp2_1'] : '';
    $sname = isset($_POST['inp2_2']) ? $_POST['inp2_2'] : '';
    $squant = isset($_POST['inp2_3']) ? $_POST['inp2_3'] : '';

    if (!empty($sid) && !empty($sname) && !empty($squant)) {
        $sql = "INSERT INTO Species (sid, name, quantity) VALUES ('{$sid}', '{$sname}', '{$squant}')";
        if ($conn -> query($sql) === TRUE) {
            header('Location: '.$_SERVER['REQUEST_URI']);
        } else {
            echo "Error: " . $sql . "<br>" . $conn -> error;
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Phase 2</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <style>
        body {
            margin: 1rem;
        }
    </style>
</head>
<body>






    <h2>Queries</h2>

    <div class="accordion" id="accordionExample">
        <div class="accordion-item">
            <h2 class="accordion-header" id="headingOne">
            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
               1. Determine the number of accidents that occurred by the visibility ?
            </button>
            </h2>
            <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
            <div class="accordion-body">
                <strong><?= $q1; ?></strong>
            </div>
            </div>
        </div>





	<div class="accordion-item">
            <h2 class="accordion-header" id="headingTwo">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                2.Determine the aircrafts that had accidents with 2 or 3 engines ?
            </button>
            </h2>
            <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
            <div class="accordion-body">
                <strong><?= $q2; ?></strong>
            </div>
            </div>
        </div>

	<div class="accordion-item">
            <h2 class="accordion-header" id="headingThree">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
               3.Determine which airlines had the most number of accidents ?
            </button>
            </h2>
            <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
            <div class="accordion-body">
                <strong><?= $q3; ?></strong>
            </div>
            </div>
        </div>



	<div class="accordion-item">
            <h2 class="accordion-header" id="headingFour">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                4.Determine how many aircrafts were given warning before the incident ?
            </button>
            </h2>
            <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour" data-bs-parent="#accordionExample">
            <div class="accordion-body">
                <strong><?= $q4; ?></strong>
            </div>
            </div>
        </div>
        <div class="accordion-item">
            <h2 class="accordion-header" id="headingFive">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                5.Determine the number of accidents faced by specific airlines ? (MIL)
            </button>
            </h2>
            <div id="collapseFive" class="accordion-collapse collapse" aria-labelledby="headingFive" data-bs-parent="#accordionExample">
            <div class="accordion-body">
                <strong><?= $q5; ?></strong>
            </div>
            </div>
        </div>
    </div>


<br></br>







<h2>User Defined Queries</h2>

    <div class="card">
        <div class="card-body">
            <div class="mb-3 row">
                <label for="staticEmail" class="col-sm-2 col-form-label">Question</label>
                <div class="col-sm-10">
                    <input type="text" readonly class="form-control-plaintext" id="staticEmail" value="Compute the number of accidents occurred in a specific airport defined by the user.(KCVG,PHLI,KJAX,KMCO,PHNL,KSBD,KIAG) ">
                </div>
            </div>
            <form action="" method="POST">
                <div class="mb-3 row">
                    <label for="inputPassword" class="col-sm-2 col-form-label">Input</label>
                    <div class="col-sm-3">
                        <input type="text" class="form-control" id="inp1" name="inp1">
                    </div>
                    <div class="col-sm-2">
                        <button type="submit" name="SubmitButton" class="btn btn-success mb-3">Answer</button>
                    </div>
                    <div class="col-sm-3">
                        <b><?= isset($ans1) ? $ans1 : '' ?></b>
                    </div>
                </div>
            </form>
        </div>
    </div>







    <div class="card mt-2">
        <div class="card-body">
            <div class="mb-3 row">
                <label for="staticEmail" class="col-sm-2 col-form-label">Question</label>
                <div class="col-sm-10">
                    <input type="text" readonly class="form-control-plaintext" id="staticEmail" value="Compute the number of accidents that took place above a certain speed defined by the user.(50,100,150,300,1000,15000)">
                </div>
            </div>
            <form action="" method="POST">
                <div class="mb-3 row">
                    <label for="inputPassword" class="col-sm-2 col-form-label">Input</label>
                    <div class="col-sm-3">
<h2>User Defined Queries</h2>

    <div class="card">
        <div class="card-body">
            <div class="mb-3 row">
                <label for="staticEmail" class="col-sm-2 col-form-label">Question</label>
                <div class="col-sm-10">
                    <input type="text" readonly class="form-control-plaintext" id="staticEmail" value="Compute the number of accidents occurred in a specific airport defined by the user.(KCVG,PHLI,KJAX,KMCO,PHNL,KSBD,KIAG) ">
                </div>
            </div>
            <form action="" method="POST">
                <div class="mb-3 row">
                    <label for="inputPassword" class="col-sm-2 col-form-label">Input</label>
                    <div class="col-sm-3">
                        <input type="text" class="form-control" id="inp1" name="inp1">
                    </div>
                    <div class="col-sm-2">
                        <button type="submit" name="SubmitButton" class="btn btn-success mb-3">Answer</button>
                    </div>
                    <div class="col-sm-3">
                        <b><?= isset($ans1) ? $ans1 : '' ?></b>
                    </div>
                </div>
            </form>
        </div>
    </div>







    <div class="card mt-2">
        <div class="card-body">
            <div class="mb-3 row">
                <label for="staticEmail" class="col-sm-2 col-form-label">Question</label>
                <div class="col-sm-10">
                    <input type="text" readonly class="form-control-plaintext" id="staticEmail" value="Compute the number of accidents that took place above a certain speed defined by the user.(50,100,150,300,1000,15000)">
                </div>
            </div>
            <form action="" method="POST">
                <div class="mb-3 row">
                    <label for="inputPassword" class="col-sm-2 col-form-label">Input</label>
                    <div class="col-sm-3">
                        <input type="text" class="form-control" id="inp2" name="inp2">
                    </div>
                    <div class="col-sm-2">
                        <button type="submit" name="SubmitButton" class="btn btn-success mb-3">Answer</button>
                    </div>
                    <div class="col-sm-3">
                        <b><?= isset($ans2) ? $ans2 : '' ?></b>
                    </div>
                </div>
            </form>
        </div>
    </div>
<br><br>
       <h2>Insert Queries</h2>

    <div class="card">
        <div class="card-body">
            <div class="mb-3 row">
                <label for="staticEmail" class="col-sm-2 col-form-label">Insert Query 1</label>
                <div class="col-sm-10">
                    <input type="text" readonly class="form-control-plaintext" id="staticEmail" value="Accident of a aircraft from airline MIL.">
                </div>
            </div>
            <form action="" method="POST">
                <div class="mb-3 row">
                    <label for="inputPassword" class="col-sm-2 col-form-label">Input</label>
                    <div class="col-sm-3">
                        <input type="text" class="form-control" id="ins1_1" name="inp1_1" placeholder="Operator ID">
                        <br>
                        <input type="text" value="MIL" class="form-control" id="ins1_2" name="inp1_2" placeholder="Operator Name" readonly>
                        <br>
                        <button type="submit" name="InsSubmitButton1" class="btn btn-success mb-3">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="card mt-2">
        <div class="card-body">
            <div class="mb-3 row">
                <label for="staticEmail" class="col-sm-2 col-form-label">Insert Query 2</label>
                <div class="col-sm-10">
                    <input type="text" readonly class="form-control-plaintext" id="staticEmail" value="Insert into species table.">
                </div>
            </div>
            <form action="" method="POST">
                <div class="mb-3 row">
                    <label for="inputPassword" class="col-sm-2 col-form-label">Input</label>
                    <div class="col-sm-3">
                        <input type="text" class="form-control" id="ins2_1" name="inp2_1" placeholder="Specie ID">
                        <br>
                        <input type="text" class="form-control" id="ins2_2" name="inp2_2" placeholder="Specie Name">
                                                                                                    <input type="text" class="form-control" id="inp2" name="inp2">
                    </div>
                    <div class="col-sm-2">
                        <button type="submit" name="SubmitButton" class="btn btn-success mb-3">Answer</button>
                    </div>
                    <div class="col-sm-3">
                        <b><?= isset($ans2) ? $ans2 : '' ?></b>
                    </div>
                </div>
            </form>
        </div>
    </div>
<br><br>
       <h2>Insert Queries</h2>

    <div class="card">
        <div class="card-body">
            <div class="mb-3 row">
                <label for="staticEmail" class="col-sm-2 col-form-label">Insert Query 1</label>
                <div class="col-sm-10">
                    <input type="text" readonly class="form-control-plaintext" id="staticEmail" value="Accident of a aircraft from airline MIL.">
                </div>
            </div>
            <form action="" method="POST">
                <div class="mb-3 row">
                    <label for="inputPassword" class="col-sm-2 col-form-label">Input</label>
                    <div class="col-sm-3">
                        <input type="text" class="form-control" id="ins1_1" name="inp1_1" placeholder="Operator ID">
                        <br>
                        <input type="text" value="MIL" class="form-control" id="ins1_2" name="inp1_2" placeholder="Operator Name" readonly>
                        <br>
                        <button type="submit" name="InsSubmitButton1" class="btn btn-success mb-3">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="card mt-2">
        <div class="card-body">
            <div class="mb-3 row">
                <label for="staticEmail" class="col-sm-2 col-form-label">Insert Query 2</label>
                <div class="col-sm-10">
                    <input type="text" readonly class="form-control-plaintext" id="staticEmail" value="Insert into species table.">
                </div>
            </div>
            <form action="" method="POST">
                <div class="mb-3 row">
                    <label for="inputPassword" class="col-sm-2 col-form-label">Input</label>
                    <div class="col-sm-3">
                        <input type="text" class="form-control" id="ins2_1" name="inp2_1" placeholder="Specie ID">
                        <br>
                        <input type="text" class="form-control" id="ins2_2" name="inp2_2" placeholder="Specie Name">
                        <br>
                        <input type="number" class="form-control" id="ins2_3" name="inp2_3" placeholder="Specie quantity">
                        <br>
                        <button type="submit" name="InsSubmitButton2" class="btn btn-success mb-3">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>
</html>
