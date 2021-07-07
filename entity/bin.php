<?php 
class Bin{


    public $con;  
      public function __construct()  
      {  
           $this->con = mysqli_connect("166.62.27.181", "nestio_admin","nestio_admin@22","ZEROwaste");  
           
           if(!$this->con)  
           {  
                echo 'Database Connection Error ' . mysqli_connect_error($this->con);  
           }  
           else{
            //    echo "Successfully Connected!";
           }
      }  
      public function getBinDetails()
      {
          $arr=array();
          $q="select * from garbage_bin where municipality_id ='MY2021S01'";
          $result = mysqli_query($this->con,$q);
          
          while($row=mysqli_fetch_assoc($result))
          {
            //   var_dump ($row);
            //   echo "<br>";
            //   echo "<br>";
            array_push($arr,$row);
          }
          return $arr;
      }


}

$b=new Bin();
$res=$b->getBinDetails();
// var_dump($res);
echo json_encode($res)





?>