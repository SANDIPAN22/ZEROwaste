

<?php 


echo "<div id='bin_details'></div>";

?>

<script type="text/JavaScript">
var arr=[]

const xhttp=new XMLHttpRequest()
xhttp.open("GET","http://localhost/designLab/entity/bin.php")
xhttp.send()
xhttp.onload= async function(){
    const data= await JSON.parse(this.responseText)
   
    console.log(data)
    data.forEach((elem,index)=>{
        pnpREADapi(elem['graph_vol']);
        pnpREADapi(elem['graph_gas']);
       
        const htmlBody=`
        <table style="width:100%">
  <tr>
    <th style="color:blue">alarm_status</th>
    <th style="color:blue">bin_id</th>
    <th style="color:blue">capacity</th>
    <th style="color:blue">municipality_id</th>
    <th style="color:blue">ward_email</th>
    <th style="color:blue">ward_id</th>
    <th style="color:blue">lat</th>
    <th style="color:blue">lon</th>
    <th style="color:green">Garbage Level</th>
    <th style="color:green">Gas Level</th>
    <th style="color:red">MAIL</th>
    
  
  </tr>
  <tr>
    <td style="text-align:center">${elem['alarm_status']}</td>
    <td style="text-align:center">${elem['bin_id']}</td>
    <td style="text-align:center">${elem['capacity']}</td>
    <td style="text-align:center">${elem['municipality_id']}</td>
    <td style="text-align:center">${elem['ward_email']}</td>
    <td style="text-align:center">${elem['ward_id']}</td>
    <td style="text-align:center">${elem['lat']}</td>
    <td style="text-align:center">${elem['lon']}</td>
    <td style="text-align:center">${arr[elem['graph_vol']-1]}</td>
    <td style="text-align:center">${arr[elem['graph_gas']-1]}</td>
    <td style="text-align:center">${ mailHit(elem['alarm_status'],arr[elem['graph_vol']-1],arr[elem['graph_gas']-1],index+1)}</td>
  </tr>
  </table>
        `
        document.querySelector('#bin_details').insertAdjacentHTML('beforeend',htmlBody)
    })
  
}

function mailHit(a,v,g,i)
{
    if (a==1){
        const xhttp=new XMLHttpRequest()
        xhttp.open("GET","http://publicapi.iotics.net/SMSofficialget.php?q=cypher1059@gmail.com&mb=%3Ch1%3EThe%20alert%20SOS%20button%20of%20GARBAGE%20BIN%20"+i+"%20has%20been%20pressed%20%3C/h1%3E&sb=SOS_BUTTON PRESSED !")
        xhttp.send()
        return true
    }
    else{
        if (v>60 || g>60)
        {
            const xhttp=new XMLHttpRequest()
            xhttp.open("GET","https://publicapi.iotics.net/SMSofficialget.php?q=cypher1059@gmail.com&mb=%3Ch1%3EThe%20Garbage%20bin%20of%20seq%20no.%20"+i+"%20is%20overflowing.%20The%20current%20Garbage%20level%20= "+v+".%20The%20current%20Gas%20level%20is%20"+g+".%3C/h1%3E&sb=SENSOR_OUTBOUND")
            xhttp.send()
            return true
        }
    }
    return false
}

function pnpREADapi(f) {
                            console.log("PNP read!!")
                            var xmlhttp = new XMLHttpRequest();
                            xmlhttp.onreadystatechange = function() {
                                if (this.readyState == 4 && this.status == 200) {

                                   
                                       console.log(this.responseText);
                                       arr.splice(f-1, 0, this.responseText)
                                    }

                                }
                            
                            xmlhttp.open("GET", "http://plugnplot.iotics.net/pnpout.php?topicid=608d472fe0626&rkey=608d472fe0638&f="+f, false);
                            xmlhttp.send();
                        }


</script>







