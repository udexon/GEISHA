<?php

include("simple_html_dom.php");
include("libfgl.php");
include("libuui.php");
include("libphos.php");


$CDW=array();
$S=array();

if (isset($argv[1])) {
    $S[] = $argv;
} else {
    // $S[]="uui.php";
    $S[] = file_get_contents('php://input');

    F("jd: space: explode:");
    F(": r_cdw o_cdw.json fgc: jd: lcdw: ;");

    init_ss_cdw();
    
    F(__FILE__." FILE sv:");
}

FGLA($S[0]);

function init_ss_cdw()
{
  session_start();
  
  global $S, $CDW;
  // $S[]=$CDW;
  
  // $_SESSION[] = array( 'CDW' => $CDW );
  if ( array_key_exists('CDW', $_SESSION) ) {
    // $CDW=$_SESSION['CDW'];
    if (count($_SESSION['CDW'])>0) $CDW=$_SESSION['CDW'];
    else {
    F("r_cdw");
    
    echo "  CDW ".var_src($CDW);
    
    $_SESSION['CDW'] = $CDW;
    
    // if (isset($_SESSION['CDW']) $CDW=$_SESSION['CDW'];
    }
  }
  else {
    F("r_cdw");
    $_SESSION['CDW'] = $CDW;
  }
  
}
