<?php

$BV = array();
function fgl_nlc()
{
    global $S;
    $S[] = "\n";
}
function fgl_commanl()
{
    global $S;
    $S[] = preg_replace('/,/', ",\n", array_pop($S));
}
function fgl_bv()
{
    global $BV, $S;
    $a = array_pop($S);
    $b = array_pop($S);
    $BV[$a] = $b;
}
function fgl_fgh()
{
    global $S;
    $S[] = file_get_html(array_pop($S));
}

function fgl_ot()
{
    global $S; 
    $b = array_pop($S);  
    $S[] = $b->outertext;
}

function fgl_geid() // get element by id
{
    global $S; 
    $a = array_pop($S);  
    $b = array_pop($S);  
    // $F = $html->find('#'.$argv[2]);
    $S[] = $b->find('#'.$a);
}


function fgl_src()
{
    global $S;
    $b = array_pop($S);
    $S[] = $b->src;
}

function fgl_0str() // 0 length string
{
    global $S;
    $S[] = "";
}


function fgl_it()
{
    global $S;
    $b = array_pop($S);
    $S[] = $b->innertext;
}

function fgl_id()
{
    global $S;
    $b = array_pop($S);
    $S[] = $b->id;
}


function fgl_sid()
{
    global $S;
    $a = array_pop($S);
    $b = array_pop($S);
    $b->id = $a;
}

function fgl_sit()
{
    global $S;
    $a = array_pop($S);
    $b = array_pop($S);
    $b->innertext = $a;
}
function fgl_find()
{
    global $S;
    $a = array_pop($S);
    $b = array_pop($S);
    $S[] = $b->find($a);
}
function F()
{
    global $S;
    $count = 0;
    if (func_num_args() == 0) {
        return false;
    } else {
        for ($i = 0; $i < func_num_args() - 1; $i++) {
            $S[] = func_get_arg($i);
        }
        FGL(func_get_arg($i));
    }
}
function FGLV()
{
    global $S;
    $count = 0;
    if (func_num_args() == 0) {
        return false;
    } else {
        for ($i = 0; $i < func_num_args() - 1; $i++) {
            $S[] = func_get_arg($i);
        }
        FGL(func_get_arg($i));
    }
}
function fgl_nn1()
{
    global $S;
    $N = array_pop($S);
    $l = count($S);
    echo __LINE__ . ">> " . $l . " " . $N . " " . gettype($S[$l - $N]);
    fgl_st();
    $n = array_pop($S);
    $O = array_pop($S);
    $A = $O->childNodes();
    echo " " . $O->tag . " " . gettype($A[$n]) . " " . $A[$n]->tag . " ";
}
function fgl_nn2()
{
    global $S;
    $N = array_pop($S);
    $l = count($S);
    echo __LINE__ . ">> " . $l . " " . $N . " " . gettype($S[$l - $N]);
    fgl_st();
    $n = array_pop($S);
    $O = array_pop($S);
    $A = $O->childNodes();
    echo " " . $O->tag . " " . gettype($A[$n]) . " " . $A[$n]->tag . " ";
    $C = $A[$n];
    $A = $C->childNodes();
    echo count($A);
    echo " " . gettype($A[$n]) . " " . $A[$n]->tag . " ";
    $C = $A[$n];
    $A = $C->childNodes();
    echo count($A) . " ";
}
function fgl_nn()
{
    global $S;
    $N = array_pop($S);
    $l = count($S);
    $O = $S[$l - $N - 1];
    $A = $O->childNodes();
    $noc = count($A);
    $N--;
    $n = array_pop($S);
    while ($noc > 0 && $N > 0) {
        $C = $A[$n];
        $A = $C->childNodes();
        $noc = count($A);
        $N--;
        if ($N == 0) {
            break;
        }
        $n = array_pop($S);
    }
    if ($N > 1) {
        $n = array_pop($S);
    }
    $C = $A[$n];
    $A = $C->childNodes();
    $S[] = $C;
    $S[] = count($A);
}
function fgl_nl()
{
    global $BV;
    if (isset($BV['ECHO'])) {
        if ($BV['ECHO'] == "ON") {
            echo "\n";
        }
    }
}
function fgl_st()
{
    global $S;
    echo "< " . count($S) . " > ";
    foreach ($S as $e) {
        echo gettype($e) . " ";
    }
}
function fgl_stv()
{
    global $S;
    echo "< " . count($S) . " > ";
    foreach ($S as $e) {
        if (gettype($e) == "object" || gettype($e) == "array") {
            echo " " . gettype($e) . " ";
        } else {
            echo " " . gettype($e) . " " . json_encode($e) . ", ";
        }
    }
}
function my_var_export($var, $is_str = false)
{
    $rtn = preg_replace(array('/Array\\s+\\(/', '/\\[(\\d+)\\] => (.*)\\n/', '/\\[([^\\d].*)\\] => (.*)\\n/'), array('array (', '\\1 => \'\\2\'' . "\n", '\'\\1\' => \'\\2\'' . "\n"), substr(print_r($var, true), 0, -1));
    $rtn = strtr($rtn, array("=> 'array ('" => '=> array ('));
    $rtn = strtr($rtn, array(")\n\n" => ")\n"));
    $rtn = strtr($rtn, array("'\n" => "',\n", ")\n" => "),\n"));
    $rtn = preg_replace(array('/\\n +/e'), array('strtr(\'\\0\', array(\'    \'=>\'  \'))'), $rtn);
    $rtn = strtr($rtn, array(" Object'," => " Object'<-"));
    if ($is_str) {
        return $rtn;
    } else {
        echo $rtn;
    }
}
function fgl_gtp()
{
    global $S;
    $a = array_pop($S);
    $S[] = gettype($a);
}
function fgl_gtpx()
{
    global $S;
    $a = end($S);
    $S[] = gettype($a);
}
function fgl_esp()
{
    global $S, $BV;
    $a = array_pop($S);
    if (isset($BV['ECHO'])) {
        if ($BV['ECHO'] == "ON") {
            echo $a . " ";
        }
    }
}
function fgl_ses()
{
    global $S;
    $a = array_pop($S);
    echo " " . $a . " ";
}
function fgl_gc()
{
    global $S;
    $a = array_pop($S);
    $S[] = get_class($a);
}
function fgl_mthd()
{
    global $S;
    $b = array_pop($S);
    $a = array_pop($S);
    $S[] = eval('return $a->' . $b . '();');
}
function fgl_mbr()
{
    global $S;
    $b = array_pop($S);
    $a = array_pop($S);
    $S[] = eval('return $a->' . $b . ';');
}
function fgl_mbrx()
{
    global $S;
    $b = array_pop($S);
    $a = end($S);
    echo " " . __LINE__ . " " . $b . " ";
    echo $a->tag . " ";
    $S[] = eval('return $a->' . 'tag' . ';');
}
function file_get_html_node($url, $use_include_path = false, $context = null, $offset = -1, $maxLen = -1, $lowercase = true, $forceTagsClosed = true, $target_charset = DEFAULT_TARGET_CHARSET, $stripRN = true, $defaultBRText = DEFAULT_BR_TEXT, $defaultSpanText = DEFAULT_SPAN_TEXT)
{
    $dom = new simple_html_dom_node(null, $lowercase, $forceTagsClosed, $target_charset, $stripRN, $defaultBRText, $defaultSpanText);
    $contents = file_get_contents($url, $use_include_path, $context, $offset);
    if (empty($contents) || strlen($contents) > MAX_FILE_SIZE) {
        return false;
    }
    $dom->load($contents, $lowercase, $stripRN);
    return $dom;
}
