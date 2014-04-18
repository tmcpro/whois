<?php 
$DBServer = 'localhost'; // e.g 'localhost' or '192.168.1.100'
$DBUser   = 'root';
$DBPass   = 'root';
$DBName   = 'db';

$conn = mysqli_connect($DBServer, $DBUser, $DBPass, $DBName);
if (mysqli_connect_errno()) {
  trigger_error('Database connection failed: '  . mysqli_connect_error(), E_USER_ERROR);
}

function getwhois($domain, $tld){
    require_once("whois.class.php");
    $whois = new Whois();

    if(!$whois->ValidDomain($domain.'.'.$tld)){
        return 'Sorry, the domain is not valid or not supported.';
    }

    if($whois->Lookup($domain.'.'.$tld)){
        return $whois->GetData(1);
    }else{
        return 'Sorry, an error occurred.';
    }
}



$sql='SELECT * FROM urls';
$rs=$conn->query($sql);

//Check to make sure SQL worked
if($rs === false) {
    echo "err";
    trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $conn->error, E_USER_ERROR);
}

while($row = $rs->fetch_row()){
    // Make sure to parse the URL so only the host is sent without www.
    // parse_url();
    // preg_replace('#^www\.(.+\.)#i', '$1', $row['url']);
    $domain = trim($row['url']); //Change this to the URL column to look up
    $dot = strpos($domain, '.');
    $sld = substr($domain, 0, $dot);
    $tld = substr($domain, $dot+1);

    $whois = getwhois($sld, $tld);
    echo "<pre>"; 
    echo $whois;
    echo "</pre>";
}

?>