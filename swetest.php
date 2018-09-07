<?php

// Partial web/GETinterface to the Swiss Ephemeris.  Copyright Seth Frey 2018, licensed under GPL3

// allow cross site requests, at least during debugging (for easier local development)
// header('Access-Control-Allow-Origin: *');
// header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept');


$path_to_executable = 'src/swetest';

//./src/swetest -b30.6.2018 -p0 -emos -fPLBRS -house121.74,38.54,p -ut11:30:00
// IS
//http://HOST/swetest.php?b=30%2E6%2E2018&p=0&emos&f=PLBRSjJG&house=121%2E74%2C38%2E54%2Cp&ut=11%3A30%3A00

$command = [];
$command[] = escapeshellarg($path_to_executable);

/*
//data scrubbing as necessary
if (isset($_GET['arg1'])) {
    if ($_GET['arg1'] > 1000) {
        echo "Error: Please don't specify an 'arg1' higher than 1000.";
        exit(1);
    }
}
*/

$supported_args = ['b', 'p', 'emos', 'ejpl', 'eswe', 'f', 'house', 'ut'];
foreach ($supported_args as $arg) {
    if (isset($_GET[$arg])) {
        // scrub inputs
        //   allow not just alphnumerics, but also dot, hyphen, comma, and colon, because of the complexity of the swetest commandline interface
        $arg_in = preg_replace("/[^A-Za-z0-9\.\-,:]/", '', $_GET[$arg]);
        $command[] = "-$arg" . escapeshellarg($arg_in);
    }
}

$command = implode($command, ' ');
//echo $command;
//echo "<br>";
exec($command . " 2>&1", $result, $return_val);
echo implode("\n", $result);
//echo "<br>";
