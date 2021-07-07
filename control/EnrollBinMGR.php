<?php
Class EnrollBinMGR{
      public $con;  
      public function __construct()  
      {  
           $this->con = mysqli_connect("166.62.27.181", "nestio_admin","nestio_admin@22","ZEROwaste");  
           
           if(!$this->con)  
           {  
                echo 'Database Connection Error ' . mysqli_connect_error($this->con);  
           }  
           else{
                //echo "Successfully Connected!";
           }
      } 



public function checkBinInfo($bid,$wid,$wm,$lat,$lon,$gv,$gg,$cap,$mid){
   $sql = "INSERT INTO  `garbage_bin` (bin_id,ward_id,ward_email,municipality_id,lat,lon,graph_vol,graph_gas,capacity)values ('$bid','$wid','$wm','$mid','$lat','$lon','$gv','$gg','$cap');";
    
   $sql .= "UPDATE municipality SET used_graph_no=used_graph_no + 2 WHERE municipality_id='$mid'";
   mysqli_multi_query($this->con, $sql);
$ar = array("SujitBINTEST2021","202128","SujitWARDMAIL@MAIL.COM","20.21","20.21","60","40","100","SujitMUNICIPALITY2021");
return $ar;
}

}
     $enroll = new EnrollBinMGR;
     $bid="SujitBINTEST2021";
     $wid=202128;
     $wm="SujitWARDMAIL@MAIL.COM";
     $lat=20.21;
     $lon=20.21;
     $gv=60;
     $gg=40; 
     $cap=100;
     $mid = "SujitMUNICIPALITY2021";
     $result=$enroll->checkBinInfo($bid,$wid,$wm,$lat,$lon,$gv,$gg,$cap,$mid);
     var_dump($result);
