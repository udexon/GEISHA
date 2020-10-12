<?php

include "alias.php";
// include "fgl_pdo.php";
function fgl_sort()
{
    global $S;
    $a = array_pop($S);
    sort($a);
    $S[] = $a;
}
function fgl_gor()
{
    global $S;
    $a = array_pop($S);
    echo var_src(preg_grep("/(preview|like)/i", $a));
}
function fgl_gor2()
{
    global $S;
    $b = array_pop($S);
    $a = array_pop($S);
    echo "\n\n    " . __LINE__ . " " . var_src(preg_grep("/(preview|like)/i", $a));
    echo "\n\n    " . __LINE__ . " " . var_src(preg_grep($b, $a));
    echo "    " . __LINE__ . " b " . $b . "    ";
}
function fgl_gx()
{
    global $S;
    $S[] = preg_grep(array_pop($S), end($S));
}
function fgl_grep()
{
    global $S;
    $S[] = preg_grep(array_pop($S), array_pop($S));
}
function fgl_2sort()
{
    global $S, $SHV;
    $b = array_pop($S);
    $a = array_pop($S);
    array_multisort($SHV[$a], SORT_NUMERIC, $SHV[$b]);
}
function fgl_3sort()
{
    global $S, $SHV;
    $c = array_pop($S);
    $b = array_pop($S);
    $a = array_pop($S);
    array_multisort($SHV[$a], SORT_NUMERIC, $SHV[$b], $SHV[$c]);
}
function fgl_sortn()
{
    global $S;
    $a = array_pop($S);
    sort($a, SORT_NUMERIC);
    $S[] = $a;
}
function fgl_colon()
{
    global $S;
    $S[] = ':';
}
function fgl_l()
{
    global $SL;
    global $argv, $S, $SS, $xk, $xs, $SC;
    $xc = count($SS);
    $xk =& $SS[$xc - 1][0];
    $xs =& $SS[$xc - 1][1];
    $xl = count($SS[$xc - 1][1]);
    $vk = $xk;
    $Z = $xl;
    $SL[array_pop($S)] = $xk;
}
function fgl_false()
{
    global $S;
    $S[] = false;
}
function fgl_sq()
{
    global $S;
    $S[] = "'" . array_pop($S) . "'";
}
function fgl_fop()
{
}
function fgl_jd()
{
    global $S;
    $S[] = json_decode(array_pop($S), true);
}
function fgl_fi()
{
    global $S;
    $S[] = file(array_pop($S));
}
function fgl_inline()
{
    $a = file($argv[1]);
    $S = $argv;
    foreach ($a as $k => $b) {
        if (substr($b, 0, 5) == "//5: ") {
            echo $b;
            fgl_p5(substr($b, 5), $a[$k + 1]);
        } else {
            if (substr($b, 0, 5) == "//p: ") {
                echo substr($b, 5);
            } else {
                echo $b;
            }
        }
    }
}
function fgl_dup()
{
    global $S;
    $S[] = end($S);
}
function fgl_2dup()
{
    fgl_over();
    fgl_over();
}
function fgl_over()
{
    global $S;
    $l = count($S);
    $S[] = $S[$l - 2];
}
function fgl_2over()
{
    global $S;
    $l = count($S);
    $S[] = $S[$l - 3];
}
function fgl_swap()
{
    global $S;
    $b = array_pop($S);
    $a = array_pop($S);
    $S[] = $b;
    $S[] = $a;
}
function fgl_rot()
{
    global $S;
    $c = array_pop($S);
    $b = array_pop($S);
    $a = array_pop($S);
    $S[] = $b;
    $S[] = $c;
    $S[] = $a;
}
function fgl_pick()
{
    global $S;
    $l = count($S);
    $S[] = $S[$l - 2 - array_pop($S)];
}
function fgl_ss()
{
    global $S;
    $i = array_pop($S);
    $S[] = substr(array_pop($S), $i);
}
function fgl_av()
{
    global $S;
    $S[] = array_values(array_pop($S));
}
function fgl_intval()
{
    global $S;
    $S[] = intval(array_pop($S));
}
function fgl_ms()
{
    global $S;
    $a = array_pop($S);
    $S[] = array_pop($S) . $a;
}
function fgl_estr()
{
    global $S;
    $S[] = "";
}
function fgl_msv()
{
    global $S, $SHV;
    $v = array_pop($S);
    $SHV[$v] = $SHV[$v] . array_pop($S);
}
function fgl_ssl()
{
    global $S;
    fgl_s();
    $l = array_pop($S);
    $i = array_pop($S);
    $S[] = substr(array_pop($S), $i, $l);
    fgl_s();
}
function fgl_ap()
{
    fgl_array_push();
}
function fgl_vt()
{
    fgl_apush();
}
function fgl_pi()
{
    fgl_apush();
}
function fgl_showtab()
{
    global $S;
    $db = new PDO('mysql:host=localhost;dbname=' . array_pop($S), 'root', '0000');
    $rs = $db->query("SHOW TABLES");
    $all = $rs->fetchAll();
    if (0) {
        foreach ($all as $item) {
            echo $item[0] . "\n";
        }
    }
    $S[] = $all;
}
function fgl_foreach()
{
    global $S, $vk;
    $l = count($S[0]);
    for ($i = $vk; $i < $l; $i++) {
        echo __LINE__ . " if: {$i} ";
        if ($S[0][$i] == "end:") {
            break;
        }
    }
    echo __LINE__ . ": {$i} {$vk} ";
    $sl = count($S);
    foreach ($S[$sl - 1] as $k => $e) {
        echo "\n\n" . __LINE__ . " foreach: " . $k . " ";
        $S[] = $e;
        $S[] = $vk;
        $S[] = $i;
        fgl_esx();
        fgl_s();
        break;
    }
    $vk = $i + 1;
}
function fgl_ec()
{
    global $S, $BV;
    if (isset($BV['ECHO'])) {
        if ($BV['ECHO'] == "ON") {
            echo array_pop($S);
        } else {
            array_pop($S);
        }
    } else {
        array_pop($S);
    }
}
function fgl_ecx()
{
    global $S;
    echo end($S);
}
function fgl_i()
{
    global $S;
    $a = array_pop($S);
    $b = array_pop($S);
    $S[] = $b[$a];
}
function fgl_ix()
{
    global $S;
    $l = count($S);
    $a = end($S);
    $b = $S[$l - 2];
    $S[] = $b[$a];
}
function fgl_ixn()
{
    global $S;
    $l = count($S);
    $n = array_pop($S);
    $a = array_pop($S);
    $b = $S[$l - $n - 1];
    $S[] = $b[$a];
}
function fgl_akx()
{
    global $S;
    $S[] = array_keys(end($S));
}
function fgl_s()
{
    global $S, $a;
    echo "\n" . __FUNCTION__ . " " . __LINE__ . " < " . count($S) . " > " . preg_replace("/\\s+/", " ", var_export($S, true)) . "\n";
}
function fgl_sa()
{
    global $SA, $a;
    echo "< " . count($SA) . " > " . preg_replace("/\\s+/", " ", var_export($SA, true)) . "\n";
}
function fgl_sa2s()
{
    global $SA, $a, $S;
    $S[] = $SA;
}
function fgl_s2sa()
{
    global $SA, $a, $S;
    $SA[] = array_pop($S);
}
function fgl_trims()
{
    global $S, $a;
    $S[] = trim(preg_replace("/\\s+/", " ", array_pop($S)));
}
function fgl_pss()
{
    global $SS;
    echo "< " . count($SS) . " > " . preg_replace("/\\s+/", " ", var_export($SS, true)) . "\n";
}
function fgl_c()
{
    global $S, $a;
    $S[] = count(array_pop($S));
}
function fgl_cx()
{
    global $S, $a;
    $S[] = count(end($S));
}
function fgl_inc()
{
    global $S;
    $S[] = 1 + array_pop($S);
}
function fgl_apush()
{
    global $S, $a;
    $l = count($S);
    $S[] = $S[$l - 2][end($S)];
    array_splice($S, -3, 2);
}
function fgl_p5($p, $q)
{
    global $S;
    echo __FUNCTION__ . " " . $p . " " . $q . " " . end($S) . "\n";
    $r = explode(" ", $p);
    $s = preg_replace("/" . $r[0] . "/", eval('return ' . $r[1] . ';'), $q);
    echo $s;
}
function fgl_explode()
{
    global $S;
    $S[] = explode(array_pop($S), array_pop($S));
}
function fgl_x_sp()
{
    global $S;
    $S[] = explode(" ", array_pop($S));
}
function fgl_tostr()
{
    global $S;
    $a = array_pop($S);
    $S[] = $a[0];
}
$ss = "SELECT \ntable_schema,\nMAX(create_time) create_time,\nMAX(update_time) update_time\nFROM information_schema.tables\nGroup by TABLE_SCHEMA\nOrder by create_time desc";
function fgl_showdbt()
{
    global $S;
    $ss = "SELECT \ntable_schema,\nMAX(create_time) create_time,\nMAX(update_time) update_time\nFROM information_schema.tables\nGroup by TABLE_SCHEMA\nOrder by create_time desc";
    $user = 'root';
    $pass = '0000';
    $server = 'localhost';
    $dbh = new PDO("mysql:host={$server}", $user, $pass);
    $dbs = $dbh->query($ss);
    if (0) {
        while (($db = $dbs->fetchColumn(0)) !== false) {
            echo $db . '<br>';
            file_put_contents("o_showdb", "\n\n" . date("Y-m-d H:i:s") . "> " . json_encode(array($db)) . "\n", FILE_APPEND);
        }
    }
    $S[] = $dbs->fetchAll();
}
function fgl_je()
{
    global $S;
    $S[] = json_encode(array_pop($S));
}
function fgl_w()
{
    global $S;
    $S[] = file_put_contents(array_pop($S), array_pop($S));
}
function fgl_showdb()
{
    global $S;
    $user = 'root';
    $pass = '0000';
    $server = 'localhost';
    $dbh = new PDO("mysql:host={$server}", $user, $pass);
    $dbs = $dbh->query('SHOW DATABASES');
    if (0) {
        while (($db = $dbs->fetchColumn(0)) !== false) {
            echo $db . '<br>';
            file_put_contents("o_showdb", "\n\n" . date("Y-m-d H:i:s") . "> " . json_encode(array($db)) . "\n", FILE_APPEND);
            $S[] = $db;
        }
    }
    $S[] = $dbs->fetchAll();
}
function fgl_var()
{
    global $S;
    $a = array_pop($S);
    $S[] = eval("global \$" . $a . "; return \$" . $a . ";");
}
function fgl_va()
{
    global $S, $V;
    $a = array_pop($S);
    echo "\n\n" . __FUNCTION__ . " " . __LINE__ . " a " . $a . " ; ";
    $b = array_pop($S);
    echo __LINE__ . " V " . var_src($V) . " ; ";
    echo __LINE__ . " b " . $b . " ; ";
    $V[$a] = $b;
    echo __LINE__ . " a " . $a . " ; ";
    echo __LINE__ . " V " . var_src($V) . " ; ";
}
function fgl_argv()
{
    global $argv, $S, $vk, $v;
    $S[] = $argv;
    $L = count($argv);
    $vk = 0;
    while ($vk < $L) {
        $v = $argv[$vk];
        echo "\n\nline " . __LINE__ . " ";
        echo $vk . " " . $v . " " . $L . " ";
        if (strpos($v, ":")) {
            $l = strlen($v);
            echo $v . " " . $l . " ; ";
            $fn = substr($v, 0, $l - 1);
            if (function_exists("fgl_" . $fn)) {
                echo "line " . __LINE__ . " fgl_" . $fn . " ";
                call_user_func("fgl_" . $fn);
                echo "line " . __LINE__ . " fgl_" . $fn . " end; {$vk} {$l} ";
            } else {
                echo __LINE__ . " fgl_" . $fn . " error.\n";
            }
        } else {
            if ($v[0] == '_') {
                echo "line " . __LINE__ . " ";
                echo "_x";
            } else {
                if ($v == '.s') {
                    echo "\nline " . __LINE__ . " {$v} ";
                    fgl_s();
                } else {
                    if ($v == '-') {
                        $Sc = count($S);
                        $ve = array_pop($S);
                        $S[] = array_pop($S) - $ve;
                    } else {
                        $S[] = $v;
                    }
                }
            }
        }
        $vk++;
    }
}
function fgl_search()
{
    global $S;
    $a = array_pop($S);
    $S[] = array_search($a, end($S));
}
function fgl_slice()
{
    global $S;
    $a = array_pop($S);
    $S[] = array_slice(array_pop($S), $a);
}
function fgl_es()
{
    global $argv, $S;
    $a = array_pop($S);
    foreach ($a as $vk => $v) {
        if (strpos($v, ":")) {
            $l = strlen($v);
            $fn = substr($v, 0, $l - 1);
            if (function_exists("fgl_" . $fn)) {
                call_user_func("fgl_" . $fn);
            } else {
                echo __LINE__ . " fgl_" . $fn . " error.\n";
            }
        } else {
            if ($v[0] == '_') {
                echo "line " . __LINE__ . " ";
                echo "_x";
            } else {
                if ($v == '.s') {
                    echo "\nline " . __LINE__ . " {$v} ";
                    fgl_s();
                } else {
                    if ($v == '-') {
                        $Sc = count($S);
                        $S[] = $S[$Sc - 2] - end($S);
                    } else {
                        $S[] = $v;
                    }
                }
            }
        }
    }
}
function fgl_esx()
{
    global $argv, $S;
    echo __LINE__ . " " . var_src($S);
    $Z = array_pop($S);
    $vk = array_pop($S) + 1;
    echo "\n" . __LINE__ . " " . var_src($S);
    while ($vk < $Z) {
        $v = $S[0][$vk];
        echo "\nline " . __LINE__ . " ";
        echo $v . " " . $vk . " " . $Z . " ";
        fgl_s();
        if (strpos($v, ":")) {
            $l = strlen($v);
            echo $v . " " . $l . " ; ";
            $fn = substr($v, 0, $l - 1);
            if (function_exists("fgl_" . $fn)) {
                echo "line " . __LINE__ . " fgl_" . $fn . " ";
                call_user_func("fgl_" . $fn);
            } else {
                echo __LINE__ . " fgl_" . $fn . " error.\n";
            }
        } else {
            if ($v[0] == '_') {
                echo "line " . __LINE__ . " ";
                echo "_x";
            } else {
                if ($v == '.s') {
                    echo "\nline " . __LINE__ . " {$v} ";
                    fgl_s();
                } else {
                    if ($v == '-') {
                        $Sc = count($S);
                        $ve = array_pop($S);
                        $S[] = array_pop($S) - $ve;
                    } else {
                        $S[] = $v;
                    }
                }
            }
        }
        $vk++;
    }
}
function fgl_pwd()
{
    global $S;
    $S[] = getcwd();
}
function fgl_CC()
{
    global $S, $SS, $SC;
    $k = array_pop($S);
    $i = 0;
    while ($k > $SC[$i][2]) {
        $i++;
    }
    $S[] = array($i, $SC);
}
function fgl_x()
{
    global $argv, $S, $SS, $SC;
    $xc = count($SS);
    $xk =& $SS[$xc - 1][0];
    $xs =& $SS[$xc - 1][1];
    $xl = count($SS[$xc - 1][1]);
    $A = array_pop($S);
    $Z = $A[1];
    $vk = $A[0];
    $xk = $vk;
    if (isset($D)) {
        echo "\n" . __FUNCTION__ . " start " . __LINE__ . " vk " . $vk . " Z " . $Z . " SS " . var_src($SS) . "\n";
    }
    $S[] = $vk;
    fgl_CC();
    $t = array_pop($S);
    $CC = $t[0];
    do {
        $vk++;
        $xk = $vk;
        if ($vk == $Z) {
            break;
        }
        $v = $xs[$vk];
        if (isset($D)) {
            echo "line x: " . __LINE__ . " A " . var_src($A) . " ";
            echo " CC " . $CC . " v " . $v . " vk " . $vk . " Z " . $Z . " xk " . $xk . " ";
        }
        if (strpos($v, ":")) {
            $l = strlen($v);
            $fn = substr($v, 0, $l - 1);
            if (function_exists("fgl_" . $fn)) {
                call_user_func("fgl_" . $fn);
                if (is_array(end($S))) {
                    if (in_array("prg_ctr", end($S))) {
                        if (isset($D)) {
                            echo "\n\n x: " . __LINE__ . " CC " . $CC . " v " . $v . " xk " . $xk . " vk " . $vk . "\n";
                            fgl_s();
                        }
                        $va = array_pop($S);
                        $vk = $va[1];
                        if (isset($D)) {
                            echo "\n x: " . __LINE__ . " v " . $v . " xk " . $xk . " vk " . $vk . " Z " . $Z . " SC[CC][3] " . $SC[$CC][3] . "\n";
                        }
                        $Z = $SC[$CC][3];
                    }
                }
            } else {
                echo __LINE__ . " fgl_" . $fn . " error.\n";
            }
        } else {
            if ($v[0] == '_') {
                echo "line " . __LINE__ . " ";
                echo "_x";
            } else {
                if ($v == '.s') {
                    echo "\nline " . __LINE__ . " {$v} ";
                    fgl_s();
                } else {
                    if ($v == '-') {
                        $Sc = count($S);
                        $ve = array_pop($S);
                        $S[] = array_pop($S) - $ve;
                    } else {
                        if ($v == '===') {
                            $S[] = array_pop($S) === array_pop($S);
                        } else {
                            $S[] = $v;
                        }
                    }
                }
            }
        }
    } while ($vk < $Z);
}
function fgl_fp()
{
    global $S;
    $S[] = $S[array_pop($S)];
}
function fgl_copy()
{
    global $S;
    copy(array_pop($S), array_pop($S));
}
function fgl_php()
{
    global $argv, $S, $SS, $xk, $xs, $SC, $SL;
    $a = array_pop($S);
    $a = preg_replace('/\\s+/', ' ', $a);
    $a = explode(' ', $a);
    $SS[] = array(0, $a);
    $xc = count($SS);
    $xk =& $SS[$xc - 1][0];
    $xs =& $SS[$xc - 1][1];
    $xl = count($SS[$xc - 1][1]);
    $vk = $xk;
    $Z = $xl;
    if (isset($D)) {
        echo "\n" . __FUNCTION__ . " start " . __LINE__ . " vk " . $vk . " Z " . $Z . " SS " . var_src($SS) . "\n";
    }
    $S[] = $vk;
    $t = array_pop($S);
    $CC = $t[0];
    do {
        $vk = $xk;
        $v = trim($xs[$xk]);
        if (isset($D)) {
            echo "\n xs: " . __LINE__ . " ";
            echo " v " . $v . " length " . count($v) . " ord " . ord($v) . " vk " . $vk . " " . var_src($xs);
        }
        if ($v == ">:" || $v == "<:") {
            $S[] = $v;
        } else {
            $l = strlen($v);
            if ($v[$l - 1] == ":") {
                $l = strlen($v);
                $fn = substr($v, 0, $l - 1);
                if (function_exists("fgl_" . $fn)) {
                    if (isset($D)) {
                        echo " xs: line " . __LINE__ . " fgl_" . $fn . " ";
                    }
                    call_user_func("fgl_" . $fn);
                    if (is_array(end($S))) {
                        $va = end($S);
                        if (isset($va[0])) {
                            if ($va[0] == "prg_ctr") {
                                $va = array_pop($S);
                                $vk = $va[1];
                                $xk = $vk;
                                if (isset($D)) {
                                    echo "\n xs: " . __LINE__ . " v " . $v . " xk " . $xk . " vk " . $vk . " Z " . $Z . " SC[CC][3] " . $SC[$CC][3] . "\n";
                                }
                            }
                        }
                    }
                } else {
                    if ($fn == "r") {
                        echo __LINE__ . " r: ";
                        $s = array_pop($S);
                        $S[] = implode(' ', array_slice($xs, $xk + 1));
                        $S[] = '$S[]=$' . $s . '; ';
                        $S[] = ':r:';
                        fgl_s();
                        return;
                    } else {
                        if ($fn == "v") {
                            echo "\n" . __LINE__ . " v: ";
                            $sa = array_pop($S);
                            $sb = array_pop($S);
                            $S[] = implode(' ', array_slice($xs, $xk + 1));
                            $S[] = '$' . $sa . '=' . $sb . '; ';
                            $S[] = ':v:';
                            fgl_s();
                            return;
                        } else {
                            if ($fn == "a") {
                                echo "\n" . __LINE__ . " v: ";
                                $sa = array_pop($S);
                                $sc = count($S);
                                $se = $S[$sc - $sa];
                                for ($si = 0; $si < $sa; $si++) {
                                }
                                $sb = array_pop($S);
                                $S[] = implode(' ', array_slice($xs, $xk + 1));
                                $S[] = '$' . $sa . '=' . $sb . '; ';
                                $S[] = ':v:';
                                fgl_s();
                                return;
                            } else {
                                if ($fn == "count") {
                                    echo __LINE__ . " r: ";
                                    fgl_s();
                                    $S[] = '$S[]=count(' . array_pop($S) . '); ';
                                } else {
                                    if ($fn == "bz") {
                                        echo " bz: ";
                                        fgl_s();
                                        $bx = array_pop($S);
                                        if (array_pop($S) == 0) {
                                            $xk = $bx;
                                        }
                                        continue;
                                    } else {
                                        if ($fn == "bnz") {
                                            $bx = $SL[array_pop($S)];
                                            fgl_dup();
                                            if (array_pop($S) != 0) {
                                                $xk = $bx + 1;
                                                continue;
                                            }
                                        } else {
                                            echo " line " . __LINE__ . " fgl_" . $fn . " error.\n";
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            } else {
                if (ord($v) == 0) {
                    echo " null char ";
                } else {
                    if ($v[0] == '_') {
                        if ($v == '_') {
                            $S[] = $v;
                        }
                    } else {
                        if ($v == '.s') {
                            echo "\nline " . __LINE__ . " {$v} ";
                            fgl_s();
                        } else {
                            if ($v == '-') {
                                $sa = array_pop($S);
                                $sb = array_pop($S);
                                $S[] = $sb - $sa;
                            } else {
                                if ($v == '+') {
                                    $sa = array_pop($S);
                                    $sb = array_pop($S);
                                    $S[] = $sb + $sa;
                                } else {
                                    if ($v == '.') {
                                        array_pop($S);
                                    } else {
                                        if ($v == '===') {
                                            $S[] = array_pop($S) === array_pop($S);
                                        } else {
                                            $S[] = $v;
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        $xk++;
        if ($xk >= $xl) {
            break;
        }
    } while ($vk < $xl);
}
function FGL_no_CDW($a)
{
    global $argv, $S, $SS, $xk, $xs, $SC, $SL;
    $a = preg_replace('/\\s+/', ' ', $a);
    $a = explode(' ', $a);
    $SS[] = array(0, $a);
    $xc = count($SS);
    $xk =& $SS[$xc - 1][0];
    $xs =& $SS[$xc - 1][1];
    $xl = count($SS[$xc - 1][1]);
    $vk = $xk;
    $Z = $xl;
    if (isset($D)) {
        echo "\n" . __FUNCTION__ . " start " . __LINE__ . " vk " . $vk . " Z " . $Z . " SS " . var_src($SS) . "\n";
    }
    $S[] = $vk;
    $t = array_pop($S);
    $CC = $t[0];
    do {
        $vk = $xk;
        $v = trim($xs[$xk]);
        if (isset($D)) {
            echo "\n xs: " . __LINE__ . " ";
            echo " v " . $v . " length " . count($v) . " ord " . ord($v) . " vk " . $vk . " " . var_src($xs);
        }
        if ($v == ">:" || $v == "<:") {
            $S[] = $v;
        } else {
            $l = strlen($v);
            if ($v[$l - 1] == ":") {
                $l = strlen($v);
                $fn = substr($v, 0, $l - 1);
                if (function_exists("fgl_" . $fn)) {
                    if (isset($D)) {
                        echo " xs: line " . __LINE__ . " fgl_" . $fn . " ";
                    }
                    call_user_func("fgl_" . $fn);
                    if (is_array(end($S))) {
                        $va = end($S);
                        if (isset($va[0])) {
                            if ($va[0] == "prg_ctr") {
                                $va = array_pop($S);
                                $vk = $va[1];
                                $xk = $vk;
                                if (isset($D)) {
                                    echo "\n xs: " . __LINE__ . " v " . $v . " xk " . $xk . " vk " . $vk . " Z " . $Z . " SC[CC][3] " . $SC[$CC][3] . "\n";
                                }
                            }
                        }
                    }
                } else {
                    if ($fn == "r") {
                        echo __LINE__ . " r: ";
                        $s = array_pop($S);
                        $S[] = implode(' ', array_slice($xs, $xk + 1));
                        $S[] = '$S[]=$' . $s . '; ';
                        $S[] = ':r:';
                        fgl_s();
                        return;
                    } else {
                        if ($fn == "v") {
                            echo "\n" . __LINE__ . " v: ";
                            $sa = array_pop($S);
                            $sb = array_pop($S);
                            $S[] = implode(' ', array_slice($xs, $xk + 1));
                            $S[] = '$' . $sa . '=' . $sb . '; ';
                            $S[] = ':v:';
                            fgl_s();
                            return;
                        } else {
                            if ($fn == "a") {
                                echo "\n" . __LINE__ . " v: ";
                                $sa = array_pop($S);
                                $sc = count($S);
                                $se = $S[$sc - $sa];
                                for ($si = 0; $si < $sa; $si++) {
                                }
                                $sb = array_pop($S);
                                $S[] = implode(' ', array_slice($xs, $xk + 1));
                                $S[] = '$' . $sa . '=' . $sb . '; ';
                                $S[] = ':v:';
                                fgl_s();
                                return;
                            } else {
                                if ($fn == "count") {
                                    echo __LINE__ . " r: ";
                                    fgl_s();
                                    $S[] = '$S[]=count(' . array_pop($S) . '); ';
                                } else {
                                    if ($fn == "bz") {
                                        echo " bz: ";
                                        fgl_s();
                                        $bx = array_pop($S);
                                        if (array_pop($S) == 0) {
                                            $xk = $bx;
                                        }
                                        continue;
                                    } else {
                                        if ($fn == "bnz") {
                                            $bx = $SL[array_pop($S)];
                                            fgl_dup();
                                            if (array_pop($S) != 0) {
                                                $xk = $bx + 1;
                                                continue;
                                            }
                                        } else {
                                            echo " line " . __LINE__ . " fgl_" . $fn . " error.\n";
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            } else {
                if (ord($v) == 0) {
                    echo " null char ";
                } else {
                    if ($v[0] == '_') {
                        if ($v == '_') {
                            $S[] = $v;
                        }
                    } else {
                        if ($v == '.s') {
                            echo "\nline " . __LINE__ . " {$v} ";
                            fgl_s();
                        } else {
                            if ($v == '-') {
                                $sa = array_pop($S);
                                $sb = array_pop($S);
                                $S[] = $sb - $sa;
                            } else {
                                if ($v == '+') {
                                    $sa = array_pop($S);
                                    $sb = array_pop($S);
                                    $S[] = $sb + $sa;
                                } else {
                                    if ($v == '.') {
                                        array_pop($S);
                                    } else {
                                        if ($v == '===') {
                                            $S[] = array_pop($S) === array_pop($S);
                                        } else {
                                            $S[] = $v;
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        $xk++;
        if ($xk >= $xl) {
            break;
        }
    } while ($vk < $xl);
    $S[] = ":END:";
}
function FGL($a)
{
    global $argv, $S, $SS, $xk, $xs, $SC, $SL, $CDW;
    $a = preg_replace('/\\s+/', ' ', $a);
    $a = explode(' ', trim($a));

    $SS[] = array(0, $a); // call stack
    if (isset($D)) echo "\n\n".__FUNCTION__." ".__LINE__." ".var_src($SS);

    $xc = count($SS);
    $xk =& $SS[$xc - 1][0];
    $xs =& $SS[$xc - 1][1];
    $xl = count($SS[$xc - 1][1]);
    $vk = $xk;
    $Z = $xl;
    if (isset($D)) {
        echo "\n" . __FUNCTION__ . " start " . __LINE__ . " vk " . $vk . " Z " . $Z . " SS " . var_src($SS) . "\n";
        $S[] = $vk;
        $t = array_pop($S);
        $CC = $t[0];
    }
    do {
        $vk = $xk;
        $v = trim($xs[$xk]);
        if (isset($D)) {
            echo "\n xs: " . __LINE__ . " ";
            echo " v " . $v . " length " . count($v) . " ord " . ord($v) . " vk " . $vk . " " . var_src($xs);
        }
        if (in_array($v, array_keys($CDW))) {
            $WA = $CDW[$v];
            array_pop($WA);
            FGLA($WA);
        } else {
            if ($v == ">:" || $v == "<:") {
                $S[] = $v;
            } else {
                $l = strlen($v);
                if ($v[0] == ":" && $l == 1) { // Colon Definition
                    $xk++;
                    $vk = $xk;
                    $v = trim($xs[$xk]);
                    $CDW[$v] = array();
                    $w0 = $v;
                    $xk++;
                    do {
                        $vk = $xk;
                        $v = trim($xs[$xk]);
                        $CDW[$w0][] = $v;
                        $l = strlen($v);
                        if ($v[0] == ";" && $l == 1) {
                            break;
                        }
                        $xk++;
                    } while (1);
                } else {
                    if ($v[$l - 1] == ":") {
                        $l = strlen($v);
                        $fn = substr($v, 0, $l - 1);
                        if (function_exists("fgl_" . $fn)) {
                            if (isset($D)) {
                                echo " xs: line " . __LINE__ . " fgl_" . $fn . " ";
                            }
                            call_user_func("fgl_" . $fn);
                            if (is_array(end($S))) {
                                $va = end($S);
                                if (isset($va[0])) {
                                    if ($va[0] == "prg_ctr") {
                                        $va = array_pop($S);
                                        $vk = $va[1];
                                        $xk = $vk;
                                        if (isset($D)) {
                                            echo "\n xs: " . __LINE__ . " v " . $v . " xk " . $xk . " vk " . $vk . " Z " . $Z . " SC[CC][3] " . $SC[$CC][3] . "\n";
                                        }
                                    }
                                }
                            }
                        } else {
                            if (in_array($fn . ":", array_keys($CDW))) {
                                echo __LINE__ . " in CDW " . var_src($CDW[$fn . ":"]);
                                $WA = $CDW[$fn . ":"];
                                array_pop($WA);
                                FGLA($WA);
                            } else {
                                if ($fn == "r") {
                                    echo __LINE__ . " r: ";
                                    $s = array_pop($S);
                                    $S[] = implode(' ', array_slice($xs, $xk + 1));
                                    $S[] = '$S[]=$' . $s . '; ';
                                    $S[] = ':r:';
                                    fgl_s();
                                    return;
                                } else {
                                    if ($fn == "v") {
                                        echo "\n" . __LINE__ . " v: ";
                                        $sa = array_pop($S);
                                        $sb = array_pop($S);
                                        $S[] = implode(' ', array_slice($xs, $xk + 1));
                                        $S[] = '$' . $sa . '=' . $sb . '; ';
                                        $S[] = ':v:';
                                        fgl_s();
                                        return;
                                    } else {
                                        if ($fn == "a") {
                                            echo "\n" . __LINE__ . " v: ";
                                            $sa = array_pop($S);
                                            $sc = count($S);
                                            $se = $S[$sc - $sa];
                                            for ($si = 0; $si < $sa; $si++) {
                                            }
                                            $sb = array_pop($S);
                                            $S[] = implode(' ', array_slice($xs, $xk + 1));
                                            $S[] = '$' . $sa . '=' . $sb . '; ';
                                            $S[] = ':v:';
                                            fgl_s();
                                            return;
                                        } else {
                                            if ($fn == "count") {
                                                echo __LINE__ . " r: ";
                                                fgl_s();
                                                $S[] = '$S[]=count(' . array_pop($S) . '); ';
                                            } else {
                                                if ($fn == "bz") {
                                                    echo " bz: ";
                                                    fgl_s();
                                                    $bx = array_pop($S);
                                                    if (array_pop($S) == 0) {
                                                        $xk = $bx;
                                                    }
                                                    continue;
                                                } else {
                                                    if ($fn == "bnz") {
                                                        $bx = $SL[array_pop($S)];
                                                        fgl_dup();
                                                        if (array_pop($S) != 0) {
                                                            $xk = $bx + 1;
                                                            continue;
                                                        }
                                                    } else {
                                                        echo " line " . __LINE__ . " fgl_" . $fn . " error.\n";
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    } else {
                        if (ord($v) == 0) {
                            echo " null char ";
                        } else {
                            if ($v[0] == '_') {
                                if ($v == '_') {
                                    $S[] = $v;
                                }
                            } else {
                                if ($v == '.s') {
                                    echo "\nline " . __LINE__ . " {$v} ";
                                    fgl_s();
                                } else {
                                    if ($v == '-') {
                                        $sa = array_pop($S);
                                        $sb = array_pop($S);
                                        $S[] = (int) $sb - (int) $sa;
                                    } else {
                                        if ($v == '+') {
                                            $sa = array_pop($S);
                                            $sb = array_pop($S);
                                            $S[] = $sb + $sa;
                                        } else {
                                            if ($v == '.') {
                                                array_pop($S);
                                            } else {
                                                if ($v == '===') {
                                                    $S[] = array_pop($S) === array_pop($S);
                                                } else {
                                                    $S[] = $v;
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        $xk++;
        if ($xk >= $xl) {
            break;
        }
    } while ($vk < $xl);
    
    array_pop($SS); // 2020_09_15
}
function FGLA($a)
{
    global $argv, $S, $SS, $xk, $xs, $SC, $SL, $BV, $CDW;

    $SS[] = array(0, $a); // this is call stack?
    if (isset($D)) echo "\n\n".__FUNCTION__." ".__LINE__." ".var_src($SS);
           
    $xc = count($SS);
    $xk =& $SS[$xc - 1][0];
    $xs =& $SS[$xc - 1][1];
    $xl = count($SS[$xc - 1][1]);
    $vk = $xk;
    $Z = $xl;

    // get AUTH PASS elapsed time
    // if > THR break

    if (isset($_SESSION)) {
      FGL("AUTH gsv: PASS i: m: dts: m: -");
      if (array_pop($S)<-60) {
        echo "  AUTH elapsed  ";
        return;
      }
    }
    
    do {
        $vk = $xk;
        $BV['xk'] = $xk;
        $v = trim($xs[$xk]);
        if (isset($D)) {
            echo "\n FGLA: " . __LINE__ . " ";
            echo " v " . $v . " length " . count($v) . " ord " . ord($v) . " vk " . $vk . " " . var_src($xs);
            echo "\n" . __LINE__ . " ";
            fgl_stv();
        }
        if (preg_match_all('/\\${+(.*?)}/', $v, $m)) {
            foreach ($m[1] as $mk => $me) {
                if (isset($BV[$me])) {
                    $v = preg_replace('/\\${' . $me . '}/', $BV[$me], $v);
                }
                $S[] = $v;
            }
        } else {
            if (in_array($v, array_keys($CDW))) {
                $WA = $CDW[$v];
                array_pop($WA); // pop semicolon, last element in array
                FGLA($WA); // need call stack; first level allow limited CDW for unauthenticated users
            } else {
                if ($v == ">:" || $v == "<:") {
                    $S[] = $v;
                } else {
                    $l = strlen($v);
                    if ($v[0] == ":" && $l == 1) { // Colon Definition
                        // echo "is colon; ";
                        $xk++;
                        $vk = $xk;
                        $v = trim($xs[$xk]);
                        // echo __LINE__ . " WORD to define: " . $v . " " . $vk . " " . $xk . "    ";
                        $CDW[$v] = array();
                        // echo var_src($CDW);
                        // echo __LINE__ . " WORD to define: " . $v . " " . $vk . " " . $xk . "    ";
                        
                        $w0 = $v;
                        $xk++;
                        do {
                            $vk = $xk;
                            $v = trim($xs[$xk]);
                            // echo __LINE__ . " " . $v . " " . $vk . " " . $xk . "    ";
                            $CDW[$w0][] = $v;
                            $l = strlen($v);
                            if ($v[0] == ";" && $l == 1) {
                                // echo "\n" . __LINE__ . " is semi-colon; ";
                                // echo var_src($CDW); // will cause internal error??
                                break;
                            }
                            $xk++;
                        } while (1);
                    } else {
                        if ($v[$l - 1] == ":") {
                            $l = strlen($v);
                            $fn = substr($v, 0, $l - 1);
                            if (function_exists("fgl_" . $fn)) {
                                if (isset($D)) {
                                    echo " FGLA: line " . __LINE__ . " fgl_" . $fn . " ";
                                }
                                call_user_func("fgl_" . $fn);
                                if (is_array(end($S))) {
                                    $va = end($S);
                                    if (isset($va[0])) {
                                        if ($va[0] == "prg_ctr") {
                                            $va = array_pop($S);
                                            $vk = $va[1];
                                            $xk = $vk;
                                            if (isset($D)) {
                                                echo "\n xs: " . __LINE__ . " v " . $v . " xk " . $xk . " vk " . $vk . " Z " . $Z . " SC[CC][3] " . $SC[$CC][3] . "\n";
                                            }
                                        }
                                    }
                                }
                            } else {
                                if (in_array($fn . ":", array_keys($CDW))) {
                                    echo __LINE__ . " in CDW " . var_src($CDW[$fn . ":"]);
                                } else {
                                    if ($fn == "r") {
                                        echo __LINE__ . " r: ";
                                        $s = array_pop($S);
                                        $S[] = implode(' ', array_slice($xs, $xk + 1));
                                        $S[] = '$S[]=$' . $s . '; ';
                                        $S[] = ':r:';
                                        fgl_s();
                                        return;
                                    } else {
                                        if ($fn == "v") {
                                            echo "\n" . __LINE__ . " v: ";
                                            $sa = array_pop($S);
                                            $sb = array_pop($S);
                                            $S[] = implode(' ', array_slice($xs, $xk + 1));
                                            $S[] = '$' . $sa . '=' . $sb . '; ';
                                            $S[] = ':v:';
                                            fgl_s();
                                            return;
                                        } else {
                                            if ($fn == "a") {
                                                echo "\n" . __LINE__ . " v: ";
                                                $sa = array_pop($S);
                                                $sc = count($S);
                                                $se = $S[$sc - $sa];
                                                for ($si = 0; $si < $sa; $si++) {
                                                }
                                                $sb = array_pop($S);
                                                $S[] = implode(' ', array_slice($xs, $xk + 1));
                                                $S[] = '$' . $sa . '=' . $sb . '; ';
                                                $S[] = ':v:';
                                                fgl_s();
                                                return;
                                            } else {
                                                if ($fn == "count") {
                                                    echo __LINE__ . " r: ";
                                                    fgl_s();
                                                    $S[] = '$S[]=count(' . array_pop($S) . '); ';
                                                } else {
                                                    if ($fn == "bz") {
                                                        echo " bz: ";
                                                        fgl_s();
                                                        $bx = array_pop($S);
                                                        if (array_pop($S) == 0) {
                                                            $xk = $bx;
                                                        }
                                                        continue;
                                                    } else {
                                                        if ($fn == "bnz") {
                                                            $bx = $SL[array_pop($S)];
                                                            fgl_dup();
                                                            if (array_pop($S) != 0) {
                                                                $xk = $bx + 1;
                                                                continue;
                                                            }
                                                        } else {
                                                            echo " line " . __LINE__ . " fgl_" . $fn . " error.\n";
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        } else {
                            if (ord($v) == 0) {
                                echo " null char ";
                            } else {
                                if ($v[0] == '_') {
                                    if ($v == '_') {
                                        $S[] = $v;
                                    }
                                } else {
                                    if ($v == '.s') {
                                        echo "\nline " . __LINE__ . " {$v} ";
                                        fgl_s();
                                    } else {
                                        if ($v == '-') {
                                            $sa = array_pop($S);
                                            $sb = array_pop($S);
                                            $S[] = $sb - $sa;
                                        } else {
                                            if ($v == '+') {
                                                $sa = array_pop($S);
                                                $sb = array_pop($S);
                                                $S[] = $sb + $sa;
                                            } else {
                                                if ($v == '.') {
                                                    array_pop($S);
                                                } else {
                                                    if ($v == '===') {
                                                        $S[] = array_pop($S) === array_pop($S);
                                                    } else {
                                                        $S[] = $v;
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        $xk++;
        if (isset($BV['skip'])) if ($BV['skip']>0) {
          $xk += $BV['skip'];
          $BV['skip'] = 0;
        } // after ifeq: ife:
        if ($xk >= $xl) {
            break;
        }
    } while ($vk < $xl);
    array_pop($SS); // 2020_09_15
}
function fgl_xs()
{
    global $argv, $S, $SS, $xk, $xs, $SC;
    $a = array_pop($S);
    $a = explode(' ', $a);
    $SS[] = array(0, $a);
    $xc = count($SS);
    $xk =& $SS[$xc - 1][0];
    $xs =& $SS[$xc - 1][1];
    $xl = count($SS[$xc - 1][1]);
    $vk = $xk;
    $Z = $xl;
    if (isset($D)) {
        echo "\n" . __FUNCTION__ . " start " . __LINE__ . " vk " . $vk . " Z " . $Z . " SS " . var_src($SS) . "\n";
    }
    $S[] = $vk;
    $t = array_pop($S);
    $CC = $t[0];
    do {
        $vk = $xk;
        $v = trim($xs[$xk]);
        if (isset($D)) {
            echo "\n xs: " . __LINE__ . " ";
            echo " v " . $v . " length " . count($v) . " ord " . ord($v) . " vk " . $vk . " " . var_src($xs);
        }
        if ($v == ">:" || $v == "<:") {
            $S[] = $v;
        } else {
            if (strpos($v, ":")) {
                $l = strlen($v);
                $fn = substr($v, 0, $l - 1);
                if (function_exists("fgl_" . $fn)) {
                    if (isset($D)) {
                        echo " xs: line " . __LINE__ . " fgl_" . $fn . " ";
                    }
                    call_user_func("fgl_" . $fn);
                    if (is_array(end($S))) {
                        $va = end($S);
                        if (isset($va[0])) {
                            if ($va[0] == "prg_ctr") {
                                $va = array_pop($S);
                                $vk = $va[1];
                                $xk = $vk;
                                if (isset($D)) {
                                    echo "\n xs: " . __LINE__ . " v " . $v . " xk " . $xk . " vk " . $vk . " Z " . $Z . " SC[CC][3] " . $SC[$CC][3] . "\n";
                                }
                            }
                        }
                    }
                } else {
                    echo " line " . __LINE__ . " fgl_" . $fn . " error.\n";
                }
            } else {
                if (ord($v) == 0) {
                    echo " null char ";
                } else {
                    if ($v[0] == '_') {
                        if ($v == '_') {
                            $S[] = $v;
                        }
                    } else {
                        if ($v == '.s') {
                            echo "\nline " . __LINE__ . " {$v} ";
                            fgl_s();
                        } else {
                            if ($v == '-') {
                                $S[] = array_pop($S) - array_pop($S);
                            } else {
                                if ($v == '===') {
                                    $S[] = array_pop($S) === array_pop($S);
                                } else {
                                    $S[] = $v;
                                }
                            }
                        }
                    }
                }
            }
        }
        $xk++;
        if ($xk >= $xl) {
            break;
        }
    } while ($vk < $xl);
}
function fgl_user()
{
    global $S;
    $S[] = getenv("USER");
}
function fgl_dt()
{
    global $S;
    $S[] = date("Ymd_Hi");
}
function fgl_tz()
{
    global $S;
    date_default_timezone_set("Asia/Kuala_Lumpur");
    $date = new DateTime(null, new DateTimeZone('Asia/Kuala_Lumpur'));
    $tz = $date->getTimezone();
    $S[] = $tz->getName();
}
function fgl_fe()
{
    global $S;
    $S[] = file_exists(array_pop($S));
}
function fgl_mkdir()
{
    global $S;
    mkdir(array_pop($S));
}
function fgl_glob()
{
    global $S;
    $S[] = glob(array_pop($S));
}
function fgl_chdir()
{
    global $S;
    $S[] = chdir(array_pop($S));
}
function fgl_ncl()
{
    global $S;
    $a = "ncftpls -u emasplus -p emas2018 ";
    $S[] = system($a . array_pop($S));
}
function fgl_ncp()
{
    global $S;
    $a = "ncftpput -u emasplus -p emas2018 ";
    $S[] = system($a . array_pop($S));
}
function fgl_pop()
{
    global $S;
    array_pop($S);
}
function fgl_ncg()
{
    global $S;
    $a = "ncftpget -u emasplus -p emas2018 ";
    $S[] = system($a . array_pop($S));
}
