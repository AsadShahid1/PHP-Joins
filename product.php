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
    // print_r($_POST);
    if(isset($cat_id) && !empty(trim($cat_id)) && is_numeric($cat_id)){
        if(isset($subcat_id) && !empty(trim($subcat_id)) && is_numeric($subcat_id)){
            if(isset($brand_id) && !empty(trim($brand_id)) && is_numeric($brand_id)){
                if(isset($title) && !empty(trim($title))){
                    if(isset($price) && !empty(trim($price))){
                        if(isset($discount) && !empty(trim($discount))){
                            if(isset($des) && !empty(trim($des))){
                                if(isset($_FILES['photo'])){
                                    $filename = $_FILES['photo']['name'];
                                    $file = $_FILES['photo']['tmp_name'];
                                    $size = filesize($file);
                                    $ext = pathinfo($filename, PATHINFO_EXTENSION);
                                    $pic = pathinfo($filename, PATHINFO_FILENAME) . time() .".". $ext;
                                    $extensions= array("jpeg","jpg","png");
                                    if(in_array($ext,$extensions)){
                                        // echo $size . " bytes";
                                        if($size <= 320000){
                                            if(move_uploaded_file($file,"uploads/".$pic)){
                                                $sql = "INSERT INTO product (cat_id,brand_id,subcat_id,title,des,image,price,discount ) VALUES ('$cat_id','$brand_id','$subcat_id','$title','$des','$pic','$price','$discount')";
                                                $con->exec($sql);
                                                echo "<div class='alert alert-success'>new record insert successfully</div>";
                                            }
                                        }else{
                                            $error = "Your size is larger max size is 32kb";
                                        }
                                    }else{
                                         $error = "Image extension is not valid";
                                     }
                                }else{
                                    $error = "Image is required";
                                }
                            }else{
                                $error = "Description is required";
                            }
                        }else{
                            $error = "Discount is required";
                        }
                    }else{
                        $error = "Price is required";
                    }
                }else{
                    $error = "Title is required";
                }
            }else{
                $error = "Brand is required";
            }
        }else{
            $error = "Subcategory is required";
        }
    }else{
        $error = "Category is required";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>PRODUCT FORM</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/css/bootstrap.min.css" integrity="sha384-r4NyP46KrjDleawBgD5tp8Y7UzmLA05oM1iAEQ17CSuDqnUK2+k9luXQOfXJCJ4I" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css" integrity="sha512-3pIirOrwegjM6erE5gPSwkUzO+3cTjpnV9lexlNZqvupR64iZBnOOTiiLPb9M36zpMScbmUNIcHUqKD47M719g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
 
 <style>
      body{
  /* background-image: url(../img/animated_back.gif); */
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
     .drop { background-color: #fff; }

.drop:after { border: dashed 0.3rem rgba(0, 0, 0, 0.0875); }

.drop .drop-label { color: rgba(0, 0, 0, 0.0875); }

.drop:hover:after { border-color: rgba(0, 0, 0, 0.125); }

.drop:hover .drop-label { color: rgba(0, 0, 0, 0.125); }

#image-preview, .image-preview { background-color: #000; }

.drop {
  min-width: 200px;
  min-height: 20rem;
  position: relative;
  overflow: hidden;
  cursor: pointer;
  margin: 0;
}

.drop:after {
  content: "";
  position: absolute;
  top: 0;
  right: 0;
  left: 0;
  bottom: 0;
}

.drop.file-focus { border: 0; }

.drop:hover { cursor: pointer; }

.drop .drop-label {
  font-size: 2.4rem;
  font-weight: 300;
  line-height: 4rem;
  width: 32rem;
  text-align: center;
  position: absolute;
  top: 50%;
  margin-top: -1.5rem;
  left: 50%;
  margin-left: -16rem;
}

.drop input[type=file] {
  line-height: 50rem;
  position: absolute;
  top: 0;
  right: 0;
  bottom: 0;
  left: 0;
  height: 100%;
  width: 100%;
  opacity: 0;
  z-index: 10;
  cursor: pointer;
}

#image-preview, .image-preview {
  width: 100%;
  display: block;
  position: relative;
  z-index: 1;
}

#image-preview:empty, .image-preview:empty { display: none; }

#image-preview img, .image-preview img {
  display: block;
  margin: 0 auto;
  width: 100%
}

#image-preview:after, .image-preview:after {
  content: "";
  position: absolute;
  top: 0;
  bottom: 0;
  right: 0;
  left: 0;
  border: solid 0.1rem rgba(0, 0, 0, 0.08);
  background: bottom center repeat-x url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAABfCAMAAAAeT108AAABEVBMVEUAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAABoX7lMAAAAW3RSTlMBCHwGAwQFCgIMCw4PERITFBYXGRoNHR4gISIlJicpKiwuLzEzNDY3OTs8G0BBQ0VGSEpLTU9QUVRVVlhZW11eX2FiZGVmaGlrbG1ucHFyc3R1dnd4eXp7Pn1+eLXrxAAAADRJREFUCFtjYAACDmYGJkYmRiDJAMJMbEzMTP+ZeJgZmTChOFZR7FAPYi71IQMT0JXhTIwAN8YCxDyw89IAAAAASUVORK5CYII=);
}
 </style>
</head>
<body>
    <div class="container mt-5 opacity">
        <h1 class="text-center text-dark">PRODUCT FORM</h1>
        <form action="" method="POST" enctype="multipart/form-data">
            <div class="row">
           
                <div class="col-4 my-2">
                    <label><b>Subcategory Name</b></label>
                    <?php
                    $sql = "SELECT * FROM categories";
                    $query = $con->prepare($sql);
                    if (!$query) {
                        echo "\nPDO::errorInfo():\n";
                        print_r($con->errorInfo());
                    }
                    $query->execute();
                    $data = $query->fetchAll();
                    ?>
                    <select class="form-select form-select-lg mb-3 category" name="cat_id" class="form-control"                         
                        <?php
                            if(isset($cat_id)){
                        ?>
                            value="<?= $cat_id ?>";
                                <?php
                            }
                        ?>
                        aria-label=".form-select-lg example">
                            <option selected>--select Category--</option>
                            <?php
                                foreach($data as $row){
                                    extract($row);
                            ?>
                                <option value="<?= $id ?>"><?= $name ?></option>
                            <?php
                                }
                            ?>
                    </select>
                </div>
                <div class="col-4">
                    <div id="sub"></div>
                </div>
                <div class="col-4">
                    <label><b>Brands Name</b></label>
                        <?php
                        $sql = "SELECT * FROM brand";
                        $query = $con->prepare($sql);
                        if (!$query) {
                            echo "\nPDO::errorInfo():\n";
                            print_r($con->errorInfo());
                        }
                        $query->execute();
                        $data = $query->fetchAll();
                        ?>
                    <select class="form-select form-select-lg mb-3" name="brand_id" class="form-control" 
                        <?php
                            if(isset($brand_id)){
                                ?>
                                value="<?= $brand_id ?>";
                                <?php
                            }
                        ?>  
                        aria-label=".form-select-lg example">
                        <option selected>--select brand--</option>
                            <?php
                                    foreach($data as $row){
                                    extract($row);
                            ?>
                            <option value="<?= $id ?>"><?= $name ?></option>
                            <?php
                                }
                            ?>
                    </select>
                </div>
                <div class="col-4">
                    <div class="form-group">
                        <label for="title">Title</label>
                        <input type="text" name="title" class="form-control">
                    </div>
                </div>
                <div class="col-4">
                    <div class="form-group">
                        <label for="price">Price</label>
                        <input type="text" id="price" name="price" class="form-control">
                    </div>
                </div>
                <div class="col-4">
                    <div class="form-group">
                        <label for="discount" >Discount</label>
                        <input type="text" name="discount" id="discount" class="form-control">
                    </div>
                </div>
                <div class="col-6 mt-3">
                    <div class="drop">
                        <div class="uploader">
                            <label class="drop-label">Drag and drop images here</label>
                            <input type="file" class="image-upload" id="photo" name="photo" accept="image/*" multiple>
                        </div>
                        <div id="image-preview"></div>
                    </div>
                </div>
                
                <div class="col-6">
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea  name="des" id="description"></textarea>
                    </div>
                </div>
            </div>
            <button class="btn btn-primary mt-5" name="submit">Submit</button>
        </form>
    </div>

<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/js/bootstrap.min.js" integrity="sha384-oesi62hOLfzrys4LxRF63OJCXdXDipiYWBnvTl9Y9/TRlw5xlKIEHpNyvvDShgf/" crossorigin="anonymous"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="js/jquery.imagereader-1.1.0.js"></script>
<script src="https://cdn.ckeditor.com/4.17.1/standard/ckeditor.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
 
  <script>
      
      CKEDITOR.replace( 'description', {
        } );
    $(document).on('change' , '.category' , function(){
        // console.log($(this).val());
        url = 'getsubcat.php?id='+ $(this).val();
        $('#sub').load(url);
    });
    $('#photo').imageReader({
        renderType: 'canvas',
        onload: function(canvas) {
            var ctx = canvas.getContext('2d');
            ctx.fillStyle = "orange";
            ctx.font = "12px Verdana";
            ctx.fillText("Filename : "+ this.name, 10, 20, canvas.width - 10);
            $(canvas).css({
            width: '100%',
            marginBottom: '-10px'
            });
        }
    });
</script>
<?php
    if(isset($error)){
        ?>
        <script>
            toastr.error('<?= $error ?>' , "Error");
        </script>
        <?php
    }
?>
</body>
</html>