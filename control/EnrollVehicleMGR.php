<?php
class EnrollVehicleMGR
{
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
public function checksVehicleInfo($drid,$drm,$drph,$vt,$cap,$mid ){

    $sql = "INSERT INTO  `vehicle` (municipality_id,driver_name,driver_email,driver_ph_no,vehicle_type,capacity)values ('$mid','$drid','$drm','$drph','$vt','$cap');";
    mysqli_multi_query($this->con, $sql);

    $ar = array("SujitMUNICIPALITY2021","SujitDas","Sujit@mail.com","1234578963","Truck-Yo","100");
    return $ar;
  }
}
          $enroll = new EnrollVehicleMGR;
          $drid="SujitDas";
          $drm="Sujit@mail.com";
          $drph=1234578963;
          $vt="Truck-Yo"; 
          $cap=100;
          $mid ="SujitMUNICIPALITY2021";

          $result = $enroll->checksVehicleInfo($drid,$drm,$drph,$vt,$cap,$mid);
          var_dump($result);
