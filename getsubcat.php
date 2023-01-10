            
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
               
            ?>

            <label><b>sub-category Name</b></label>
                <?php
                $cat = $_GET['id'];
                $sql = "SELECT * FROM sub_categories WHERE cat = '$cat'";
                $query = $con->prepare($sql);
                if (!$query) {
                    echo "\nPDO::errorInfo():\n";
                    print_r($con->errorInfo());
                }
                $query->execute();
                $data = $query->fetchAll();
                ?>
                <select class="form-select form-select-lg mb-3" name="subcat_id" class="form-control" 
                           
                        <?php
                                if(isset($subcat_id)){
                                    ?>
                                    value="<?= $subcat_id ?>";
                                    <?php
                                }
                            ?>  
                aria-label=".form-select-lg example">
             <option selected>--select Sub_Category--</option>
            <?php
                 if($query->rowCount() > 0){
                        foreach($data as $row){
                            extract($row);
             ?>
             <option value="<?= $id ?>"><?= $name ?></option>
             <?php
                   }
               }
             ?>
           </select>