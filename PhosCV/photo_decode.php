<?php

    // $data = $_POST['photo'];
    $data = file_get_contents( $argv[1] );
    list($type, $data) = explode(';', $data);
    list(, $data)      = explode(',', $data);
    $data = base64_decode($data);

    // mkdir($_SERVER['DOCUMENT_ROOT'] . "/photos");

    // file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/photos/".time().'.png', $data);
    file_put_contents( $argv[2], $data);
    die;
?>

