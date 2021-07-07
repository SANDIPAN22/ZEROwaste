<?php 
 echo "<div id='vehicle_details'></div>";
class GenerateRoute 
{
    
public function maximaizedGarbageCollectionBinList($W, &$wt, $n)
{
	$K = array_fill(0, $n + 1,
		array_fill(0, $W + 1, NULL));

	// Build table K[][] in bottom up manner
	for ($i = 0; $i <= $n; $i++)
	{
		for ($w = 0; $w <= $W; $w++)
		{
			if ($i == 0 || $w == 0)
				$K[$i][$w] = 0;
			else if ($wt[$i - 1] <= $w)
				$K[$i][$w] = max($wt[$i - 1] +
					$K[$i - 1][$w - $wt[$i - 1]],
								$K[$i - 1][$w]);
			else
				$K[$i][$w] = $K[$i - 1][$w];
		}
	}

	// stores the result of Knapsack
	$res = $K[$n][$W];
	$result = array();
	//echo $res;
	$w = $W;
	
	for ($i = $n; $i > 0 && $res > 0; $i--)
	{
		
	
		if ($res == $K[$i - 1][$w])
			continue;	
		else
		{

		
			// echo ' '.($i-1);
			array_push($result,($i-1));
	
			$res = $res - $wt[$i - 1];
			$w = $w - $wt[$i - 1];
		}
	}
	return $result;
}

}

$getRoute = new GenerateRoute;
	
		$wt=array(10,10,25);
        $truck_vol=20; 
        $W = $truck_vol;
        $n = sizeof($wt);
        $result = $getRoute->maximaizedGarbageCollectionBinList($W, $wt, $n);
        $arrlength = count($result);
        print_r ($result);
      

?>
<script type="text/JavaScript">


const xhttp=new XMLHttpRequest()
xhttp.open("GET","http://localhost/designLab/entity/vehicle.php")
xhttp.send()
xhttp.onload= async function(){
    const data= await JSON.parse(this.responseText)
   
    console.log(data)
    data.forEach((elem,index)=>{
     
       
        const htmlBody=`
        <table style="width:100%">
  <tr>
    <th style="color:blue">municipality_id</th>
    <th style="color:blue">vehicle_type</th>
    <th style="color:blue">capacity</th>
    <th style="color:blue">driver_name</th>
    <th style="color:blue">driver_email</th>
    
   
    
  
  </tr>
  <tr>
    <td style="text-align:center">${elem['municipality_id']}</td>
    <td style="text-align:center">${elem['vehicle_type']}</td>
    <td style="text-align:center">${elem['capacity']}</td>
    <td style="text-align:center">${elem['driver_name']}</td>
    <td style="text-align:center">${elem['driver_email']}</td>
   
   
  </tr>
  </table>
        `
        document.querySelector('#vehicle_details').insertAdjacentHTML('beforeend',htmlBody)
    })
  
}

</script>
