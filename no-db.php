<?php 
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

    $domain = trim("1password.com"); //Change this to the URL column to look up
    $dot = strpos($domain, '.');
    $sld = substr($domain, 0, $dot);
    $tld = substr($domain, $dot+1);

    $whois = getwhois($sld, $tld);
    echo "<pre>"; 
    echo $whois;
    echo "</pre>";

?>