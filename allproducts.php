<?php
  include ('inc/conn.php');
  $query = mysqli_query($conn , "SELECT P.id as pid, C.id as cid , S.id as scid , B.id as bid, P.title as title , P.des as des , P.image as img , P.price as price , P.discount as dis , B.name as bname , C.name as cname , S.name as scname FROM (((product P INNER JOIN brand B ON B.id = P.brand_id) INNER JOIN categories C ON C.id = P.cat_id) LEFT JOIN sub_categories S ON S.id = P.subcat_id)");
  if(!$query ){
      echo mysqli_error($conn);   
  }else{
      echo "<pre/>";
   while($row = mysqli_fetch_assoc($query)){
       print_r($row);
   }   
  }
?>