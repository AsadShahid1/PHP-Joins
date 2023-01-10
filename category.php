<?php
  error_reporting(E_ALL);
  ini_set('display_errors', '1');

$servername = "localhost";
$username = "root";
$password = "";

try {
  $con = new PDO("mysql:host=$servername;dbname=batch", $username, $password);
  // set the PDO error mode to exception
} catch(PDOException $e) {
  echo "Connection failed: " . $e->getMessage();
}


if(isset($_POST['submit'])){
        extract($_POST);
        if(isset($name) && !empty(trim($name))){
          $sql = "INSERT INTO categories ( name ) VALUES ('$name')";
          $con->exec($sql);
          echo "<div class='alert alert-success'>new record insert successfully</div>";
        }
        else{
            $name_error = "Name is required";
        }
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>CATEGORY FORM</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/css/bootstrap.min.css" integrity="sha384-r4NyP46KrjDleawBgD5tp8Y7UzmLA05oM1iAEQ17CSuDqnUK2+k9luXQOfXJCJ4I" crossorigin="anonymous">
 <style>
      body{
  background-image: url(../img/animated_back.gif);
  background-position: center;
    background-size: cover;
    background-repeat: no-repeat;
    min-height: 100vh;
}
.opacity{
    background-color: rgba(220, 227, 222, 0.521);
    /* min-height: 100vh; */
    width: 100%;
    padding: 20px;
    border-radius: 20px;
}
     .error{
         border:1px solid red;
     }
 </style>
</head>
<body>
    <div class="container mt-5 opacity">
        <h1 class="text-center text-dark">Category FORM</h1>
        <form action="" method="POST">
            <div class="row">
                <div class="col-12 my-2">
                    <div class="form-group">
                        <label for="exampleFormControlInput1"><b>Category Name</b></label>
                        <input name="name" type="text" 
                            <?php
                            if(isset($name_error)){
                            ?>
                            class="form-control error"
                            <?php
                                }else{
                            ?>
                            class="form-control" 
                            <?php
                                }
                            ?>
                        <?php
                                if(isset($name)){
                                    ?>
                                    value="<?= $name ?>";
                                    <?php
                                }
                            ?>  
                        id="exampleFormControlInput1" placeholder="category.....">
                        <span class="text-danger">
                            <?php
                                if(isset($name_error)){
                                    echo $name_error;
                                }
                            ?>
                        </span>
                    </div>
                </div>
              
                </div>
                <button class="btn btn-primary mt-5" name="submit">Submit</button>
            </div>
        </form>
    </div>

<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/js/bootstrap.min.js" integrity="sha384-oesi62hOLfzrys4LxRF63OJCXdXDipiYWBnvTl9Y9/TRlw5xlKIEHpNyvvDShgf/" crossorigin="anonymous"></script>
</body>
</html>