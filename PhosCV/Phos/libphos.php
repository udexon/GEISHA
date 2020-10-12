<?php


function fgl_sscdw() // update CDW in SESSION
{
    global $CDW;

    F(": r_cdw o_cdw.json fgc: jd: lcdw: ;");

    F("r_cdw");
    
    echo "  CDW ".var_src($CDW);
    
    $_SESSION['CDW'] = $CDW;
}



function fgl_atab() // array tab: make html table
{
    global $S;
    
    $T = "";
    $A = array_pop($S);
    $CR = count($A);
    $CC = count($A[0]);
    foreach($A as $kr => $R) {
        $TR = "";
        foreach($R as $kc => $C) {
          $CH = '<td id="c_'.chr($kr+65).($kc+1).'">'.$C."</td>";
          $TR = $TR." ".$CH;
        }
        $CR = "<tr>".$TR."</tr>";
        $T = $T." ".$CR;
    }
    $S[] = $T;
    // $S[] = array_map('str_getcsv', file( array_pop($S)) );
}

function fgl_csv() // file csv:
{
    global $S;
    $S[] = array_map('str_getcsv', file( array_pop($S)) );
}

function fgl_sgh() // str_get_html
{
    global $S;
    $S[] = str_get_html(array_pop($S));
}

function fgl_mssx() // merge string on stack no delimiter
{
    global $S;
    $l = array_pop($S);
    $L = count($S);
    $s = $S[$L - $l];
    for ($i = $L - $l + 1; $i < $L; $i++) {
        $s = $s . $S[$i];
    }
    array_splice($S, $L - $l);
    $S[] = $s;
}

function fgl_tn() // TagName <tag> </tag>
{
   global $S;
   $tn  = array_pop($S);
   $S[] = "<".$tn.">".array_pop($S)."</".$tn.">";
}

function fgl_tna() // TagName with attributes <tag attr="val" ....> </tag>
{
   global $S;
   $tn  = array_pop($S);
   $ta  = array_pop($S);
   $S[] = "<".$tn." ".$ta.">".array_pop($S)."</".$tn.">";
}

function fgl_ta() // value attr ta: tag attribute attr="value"
{
   global $S;
   $ta  = array_pop($S);
   $v  = array_pop($S);
   $S[] = $ta.'="'.$v.'"';
}



function fgl_td() // <td>
{
   global $S;
   $S[] = "<td>".array_pop($S)."</td>";
}


function fgl_apop() // pop TOS array
{
   global $S;
   $T = count($S)-1;
   $S[] = array_pop($S[$T]);
}

function fgl_na() // N na: pack N elements to array
{
    global $S;
    $l = array_pop($S);
    $L = count($S);
    /*
    $s = $S[$L - $l];
    for ($i = $L - $l + 1; $i < $L; $i++) {
        $s = $s . " " . $S[$i];
    }
    */
    $s = array_splice($S, $L - $l);
    $S[] = $s;
}

function fgl_gjs() // get js string
{
  global $S;
  $text = array_pop($S);
  // $res = preg_replace('~\{(?:[^{}]|(?R))*\}~', '', $text);
  // $res = preg_match_all('~\{(?:[^{}]|(?R))*\}~', '', $text);
  $pattern = '
/
\{              # { character
    (?:         # non-capturing group
        [^{}]   # anything that is not a { or }
        |       # OR
        (?R)    # recurses the entire pattern
    )*          # previous group zero or more times
\}              # } character
/x
';

preg_match_all($pattern, $text, $matches);
// print_r($matches[0]);
  $S[] = $matches[0];
}

function fgl_sp() // space char
{
  global $S;
  $S[] = ' ';
}

function fgl_wa()
{
    global $S;
    $S[] = file_put_contents(array_pop($S), array_pop($S), FILE_APPEND);
}

function fgl_dc0() // drop char 0: escape aliases reserved words
{
  global $S;
  $S[] = substr(array_pop($S),1);
}

function fgl_jsp() // join string add space
{
  global $S;
  $S[] = array_pop($S)." ".array_pop($S);
}

function fgl_jsd() // join string add delimiter
{
  global $S;
  $d = array_pop($S);
  $S[] = array_pop($S).$d.array_pop($S);
}


function fgl_jnl() // add new line
{
  global $S;
  $S[] = array_pop($S)."\n";
}


function fgl_gss()
{
  global $S, $SS;
  $S[] = $SS; // call stack
}

function var_src($b)
{
//    return preg_replace("/\\s+/", " ", var_export($b, true)) . "\n";
    return preg_replace("/\\s+/", " ", var_export($b, true)) . " ";
}
function fgl_dup2()
{
    fgl_over();
    fgl_over();
}
function fgl_rsa4096()
{
    $config = array("digest_alg" => "sha512", "private_key_bits" => 4096, "private_key_type" => OPENSSL_KEYTYPE_RSA);
    global $S;
    $S[] = $config;
}
function fgl_array()
{
    global $S;
    $S[] = array();
}

function fgl_gvv() // get variable variable
{
    global $S;
    $V = array_pop($S);
    // $S[] = ${$V};
    $S[] = $$V; // scope is limiting, so just use $_SESSION
    // $S[] = $V;
}

function fgl_gbv() // get variable variable
{
    global $S, $BV;
    // $V = array_pop($S);
    // $S[] = ${$V};
    $S[] = $BV;
    // $S[] = $V;
}


function fgl_ka() // array( key => val ) for JSON
{
    global $S;
    $S[] = array( array_pop($S) => array_pop($S) );
}

function fgl_pknew()
{
    global $S;
    $S[] = openssl_pkey_new(array_pop($S));
}
function fgl_pvk()
{
    global $S;
    openssl_pkey_export(array_pop($S), $privKey);
    $S[] = $privKey;
}
function fgl_pbk()
{
    global $S;
    $pubKey = openssl_pkey_get_details(array_pop($S));
    $S[] = $pubKey["key"];
}
function fgl_enc()
{
    global $S;
    openssl_public_encrypt(array_pop($S), $encrypted, array_pop($S));
    $S[] = $encrypted;
}
function fgl_dcr()
{
    global $S;
    openssl_private_decrypt(array_pop($S), $decrypted, array_pop($S));
    $S[] = $decrypted;
}
function fgl_b64e()
{
    global $S;
    $S[] = base64_encode(array_pop($S));
}
function fgl_b64d()
{
    global $S;
    $S[] = base64_decode(array_pop($S));
}
function fgl_orpb()
{
    global $S;
    $S[] = openssl_random_pseudo_bytes(array_pop($S));
}
function fgl_hex()
{
    global $S;
    $S[] = bin2hex(array_pop($S));
}
function fgl_SERVER()
{
    global $S;
    $S[] = $_SERVER;
}

function fgl_COOKIE()
{
    global $S;
    $S[] = $_COOKIE;
}

function fgl_ssrg()
{
    session_regenerate_id();
}

function fgl_SESSION()
{
    global $S;
    $S[] = $_SESSION;
}

function fgl_sv() // set session variable
{
    global $S;
    $_SESSION[ array_pop($S) ] = array_pop($S);
}

function fgl_ufa() // update FA array_replace()
{
    global $S;
    $_SESSION[ 'FA' ] = array_replace( $_SESSION[ 'FA' ], array_pop($S) );
}

function fgl_uss() // update SS array_replace()
{
    global $S;
    $K0 = array_pop($S);
    if (!array_key_exists($K0, $_SESSION)) $_SESSION[ $K0 ] = array();
    $K1 = array_pop($S);
    $_SESSION[ $K0 ] = array_replace( $_SESSION[ $K0 ], $K1 );
}

function fgl_ucdw() // update _SESSION CDW array_replace()
{
    global $S;
    $_SESSION[ 'CDW' ] = array_replace( $_SESSION[ 'CDW' ], array_pop($S) );
}


function fgl_fa() // set front end alias
{
    global $S;
    $_SESSION[ 'FA' ][ array_pop($S) ] = array_pop($S);
}

function fgl_gfa() // get front end alias
{
    global $S;
    $S[] = $_SESSION[ 'FA' ][ array_pop($S) ];
}

function fgl_gsv() // get session variable
{
    global $S;
    $S[] = $_SESSION[ array_pop($S) ];
}

function fgl_cmp() // strcmp
{
    global $S;
    $S[] = strcmp( array_pop($S) , array_pop($S) ) ;
}


function fgl_ssid()
{
    global $S;
    // session_start();
    $S[] = "ssid2:" . session_id() . "_";
}

function fgl_ss_start()
{
    // global $S;
    session_start();
    // $S[] = "ssid2:" . session_id() . "_";
}

function fgl_nts() // null terminated string
{
  global $S;
  
  $s = array_pop($S);
  /*
  $i = 0;
  while ($i<100) {
    if ($s[$i]=='\0') break;
    $sb[$i] = $s[$i];
    $i++;
  }
  
  $S[] = $sb;
  */
  $S[] = str_replace(chr(0), '', $s);
}


function fgl_gshm()
{
  global $S;
  
// Create 100 byte shared memory block with system id of 0xff3
$shm_id = shmop_open(0xff3, "c", 0644, 100);
if (!$shm_id) {
    echo "Couldn't create shared memory segment\n";
}

// Get shared memory block's size
$shm_size = shmop_size($shm_id);
// echo "SHM Block Size: " . $shm_size . " has been created.\n";

// Now lets read the string back
$my_string = shmop_read($shm_id, 0, $shm_size);
if (!$my_string) {
    echo "Couldn't read from shared memory block\n";
}
// echo "The data inside shared memory was: " . $my_string . "\n";
  $S[] = $my_string;
}


function fgl_dshm() // delete shm
{
    global $S;
    // $a = array_pop($S);
    $shm_id = shmop_open(0xff3, "c", 0644, 100);
    if (!$shm_id) {
        echo "Couldn't create shared memory segment\n";
    }
    $shm_size = shmop_size($shm_id);
    // echo "SHM Block Size: " . $shm_size . " has been created.\n";

    shmop_delete($shm_id);
}

function fgl_strval()
{
    global $S;
    $S[] = strval( array_pop( $S ) );
}

function fgl_shm()
{
    global $S;
    $a = array_pop($S);
    $shm_id = shmop_open(0xff3, "c", 0644, 100);
    if (!$shm_id) {
        echo "Couldn't create shared memory segment\n";
    }
    $shm_size = shmop_size($shm_id);
    // echo "SHM Block Size: " . $shm_size . " has been created.\n";
    $shm_bytes_written = shmop_write($shm_id, $a, 0);
    if ($shm_bytes_written != strlen($a)) {
        echo "Couldn't write the entire length of data\n";
    }
    // $S[] = "fgl_shm";
}
function fgl_date()
{
    global $S;
    $S[] = date("Ymd_His", array_pop($S));
}

function fgl_h() // hour
{
    global $S;
    $S[] = substr( array_pop($S), 9,2);
}

function fgl_m() // minute
{
    global $S;
    $S[] = substr( array_pop($S), 11,2);
}


function fgl_fmt()
{
    global $S;
    $S[] = filemtime(array_pop($S));
}
function fgl_dts()
{
    global $S;
    $d = new DateTime();
    $S[] = $d->format("Ymd_His");
}
function fgl_ak()
{
    global $S;
    $S[] = array_keys(array_pop($S));
}
function fgl_evs()
{
    global $S;
    echo var_src(array_pop($S));
}
function fgl_w480()
{
    global $S;
    system('ffmpeg -y -i v_in -vf "[in]scale=iw*min(480/iw\\,320/ih):ih*min(480/iw\\,320/ih)[scaled]; [scaled]pad=480:320:(480-iw*min(480/iw\\,320/ih))/2:(320-ih*min(480/iw\\,320/ih))/2[padded]; [padded]setsar=1:1[out]" -c:v libx264 -c:a copy ' . array_pop($S));
}
function fgl_res()
{
    global $S;
    system("ffprobe -v error -show_entries stream=width,height -of csv=p=0:s=x " . array_pop($S) . " > tmp_res");
}
function fgl_probe()
{
    global $S;
    system("ffprobe -i input.mkv -show_entries format 2>/dev/null | grep nb_streams > tmp_nb");
}
function fgl_mv()
{
    global $S, $SB, $xk, $BV;
    echo "  symlink sl: \n";
    $l = array_pop($S);
    $t = array_pop($S);
    rename($t, $l);
}
function fgl_sl()
{
    global $S, $SB, $xk, $BV;
    echo "  symlink sl: \n";
    $l = array_pop($S);
    $t = array_pop($S);
    echo "  {$t} {$l} ";
    exec("ln -fs '" . $t . "' {$l}");
}
function fgl_lsl()
{
    global $S, $SB, $xk, $BV;
    system("ls -l input.mkv");
}
function fgl_ife()
{
    global $S, $SB, $xk, $BV, $CDW;
    $cda = end($BV['CDW']);
    $tn = $cda[1];
    $cdw = $cda[0];
    echo "\n\n" . __FILE__ . " " . __FUNCTION__ . "  " . $CDW[$cdw][$tn + 1] . " " . $CDW[$cdw][$tn + 2] . "   ";
    echo var_src($BV);
    if (array_pop($S)) {
        F($CDW[$cdw][$tn + 1]);
    } else {
        F($CDW[$cdw][$tn + 2]);
    }
    $BV['skip'] = 2;
}

function fgl_n() // N n: X // repeat X N times
{
    global $S, $SB, $BV, $CDW;
    echo __FUNCTION__." ".__LINE__;
    // echo var_src(array_keys($BV));
    $xk = $BV['xk'];
    echo "  ".count($BV)."  xk ".$xk."  TOK ".$S[0][$xk];
    $cda = end($BV['CDW']);
    $tn = $cda[1];
    $cdw = $cda[0];
    $n = array_pop($S);
    while($n-->0) {
      if (array_key_exists($S[0][$xk+1], $CDW)) F( $S[0][$xk+1] );
      else $S[] = $S[0][$xk+1];
    }
    // $b = array_pop($S);
    // echo "\n\n" . __FILE__ . " " . __FUNCTION__ . "  {$a} {$b}  "; // . $CDW[$cdw][$tn + 1] . " " . $CDW[$cdw][$tn + 2] . "   ";
    // echo var_src($BV);
    /*
    if ((int) $a == (int) $b) {
        if (array_key_exists($S[0][$xk+1], $CDW)) { 
          // echo __LINE__." ".$S[0][$xk+1];
          F( $S[0][$xk+1] );
          // F($CDW[ ($S[0][$xk+1]) ]);
        }
        else $S[] = $S[0][$xk+1];
    } else {
        if (array_key_exists($S[0][$xk+2], $CDW)) F($S[0][$xk+2]); // F($CDW[ ($S[0][$xk+2]) ]);
        else $S[] = $S[0][$xk+2];
    }
    */
    $BV['skip'] = 1;
}


function fgl_ifeq()
{
    global $S, $SB, $BV, $CDW;
    echo __FUNCTION__." ".__LINE__;
    // echo var_src(array_keys($BV));
    $xk = $BV['xk'];
    echo "  ".count($BV)."  xk ".$xk."  TOK ".$S[0][$xk];
    $cda = end($BV['CDW']);
    $tn = $cda[1];
    $cdw = $cda[0];
    $a = array_pop($S);
    $b = array_pop($S);
    echo "\n\n" . __FILE__ . " " . __FUNCTION__ . "  {$a} {$b}  "; // . $CDW[$cdw][$tn + 1] . " " . $CDW[$cdw][$tn + 2] . "   ";
    // echo var_src($BV);
    if ((int) $a == (int) $b) {
        if (array_key_exists($S[0][$xk+1], $CDW)) { 
          // echo __LINE__." ".$S[0][$xk+1];
          F( $S[0][$xk+1] );
          // F($CDW[ ($S[0][$xk+1]) ]);
        }
        else $S[] = $S[0][$xk+1];
    } else {
        if (array_key_exists($S[0][$xk+2], $CDW)) F($S[0][$xk+2]); // F($CDW[ ($S[0][$xk+2]) ]);
        else $S[] = $S[0][$xk+2];
    }
    $BV['skip'] = 2;
}
function fgl_fea()
{
    global $S, $SB, $xk, $BV;
    echo count(end($S));
    $tn = $BV['tn'] + 1;
    foreach (end($S) as $k => $a) {
        echo "\n" . $k . " " . $a . "  ";
        $S[] = $k;
        $S[] = $a;
        F($S[0][$tn]);
    }
    $BV['skip'] = 1;
}
function fgl_mpss()
{
    global $S;
    $f_out = array_pop($S);
    $t_l = array_pop($S);
    $t_s = array_pop($S);
    $f_in = array_pop($S);
    exec("ffmpeg -ss {$t_s} -i {$f_in} -t {$t_l} -vcodec copy -acodec copy {$f_out}");
}
function fgl_splav()
{
    global $S, $SB;
    exec("ffmpeg -y -i input.mkv -map 0:0 -vcodec copy o_video.mp4 -map 0:1 -acodec copy o_audio.webm");
}
function fgl_ffs()
{
    global $S, $SB;
    exec("ffmpeg -i video http://localhost:8090/feed.ffm");
}
function fgl_ffm()
{
    global $S, $SB;
    exec("ffmpeg -i video -i audio -c copy output.mkv");
}
function fgl_psb()
{
    global $S, $SB;
    $S[] = $SB;
}
function fgl_jecdw()
{
    global $CDW, $S;
    $S[] = json_encode($CDW);
}
function fgl_am()
{
    global $S;
    $S[] = array_merge(array_pop($S), array_pop($S));
}
function fgl_cdw()
{
    global $CDW, $S;
    $S[] = $CDW;
}
function fgl_cdwx()
{
    global $CDW, $S;
    $k = substr(array_pop($S), 1);
    $search_array = array('first' => 1, 'second' => 4);
    if (array_key_exists('first', $search_array)) {
        echo "The 'first' element is in the array";
    }
    $ca = $CDW[$k];
    while (1) {
        $cb = $ca;
        foreach ($ca as $ck => $e) {
            echo " " . $e . " ";
            if ($e != $k && array_key_exists($e, $CDW)) {
                $ca = $CDW[$e];
            }
        }
        if ($cb == $ca) {
            break;
        }
    }
    $S[] = $CDW[$k];
}
function fgl_cdwk()
{
    global $CDW, $S;
    fgl_s();
    $k = substr(array_pop($S), 1);
    echo "  cdwk: " . $k . "  ";
    echo json_encode($CDW[$k]);
    $S[] = $CDW[$k];
}

function fgl_cdwka() // used for ucdw:
{
    global $CDW, $S;
    // fgl_s();
    $k = substr(array_pop($S), 1); // prefix with any escape character, so that CDW is not executed, do not use _ as prefix as FGLA has special operations with _
    // echo "  cdwk: " . $k . "  ";
    // echo json_encode($CDW[$k]);
    $S[] = array($k => $CDW[$k]);
}

function fgl_lcdw()
{
    global $CDW, $S;
    $CDW = array_pop($S);
}
function fgl_gdf()
{
    global $CDW, $S;
    $S[] = get_defined_functions();
}
function fgl_aslice()
{
    global $S;
    $st = array_pop($S);
    $S[] = array_slice(array_pop($S), $st);
}
function fgl_a2cd()
{
    global $S, $CDW;
    $CDW[array_pop($S)] = array_pop($S);
}
function fgl_sc()
{
    global $S;
    $S[] = ';';
}
function fgl_apk()
{
    global $S;
    $k = array_pop($S);
    $b = array_pop($S);
    $l = count($S);
    $S[$l - 1][$k] = $b;
}
function fgl_ue()
{
    global $S;
    $S[] = urlencode(array_pop($S));
}
function fgl_fgt()
{
    global $S;
    $S[] = file_get_contents(array_pop($S));
}
function fgl_trim()
{
    global $S;
    $S[] = trim(array_pop($S));
}
function fgl_substr()
{
    global $S;
    $n = array_pop($S);
    $S[] = substr(array_pop($S), $n);
}
function fgl_post()
{
    global $S;
    $url = array_pop($S);
    $data = array_pop($S);
    $dje = json_encode($data);
    $options = array('http' => array('header' => "Content-type: application/x-www-form-urlencoded\r\n", 'method' => 'POST', 'content' => http_build_query($data)));
    $context = stream_context_create($options);
    $result = file_get_contents($url, false, $context);
    if ($result === FALSE) {
    }
    var_dump($result);
    $S[] = $result;
}
