<?php
//$test = 'C:\mibatsiasyscan.bat'; 
//$test = shell_exec('C:\mibat.bat'); 
//$test = system('C:\mibat.bat'); 
//$test = exec('C:\mibat.bat',$output,$return); 
////funciono bien
$test = popen('C:\mibatsiasyscan.bat','r');  
////funciono bien
//$test = popen('//192.168.0.107/siasys_popen/mibatsiasyscan.bat','r'); 

echo "<script>document.location.href='obtencionscan.php';</script>";
?>