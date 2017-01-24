<?php

//print_r($_SERVER);

$data = [
	$_POST['group'],
    //$_SERVER['DB_PASSWORD'],
    'sample3',
    'sample4',
    'sample5',
];

header("Content-Type: application/json; charset=utf-8");
echo json_encode($data);


