<?php

$SHV = array();
function load_alias($fn)
{
    global $alias;
    $a = file($fn);
    $alias = json_decode($a[0], true);
    file_put_contents("o_init", "\n\n" . date("Y-m-d H:i:s") . "> " . json_encode($alias) . "\n", FILE_APPEND);
}
function fgl_load_alias()
{
    global $alias, $S;
    $a = file(array_pop($S));
    $alias = json_decode($a[0], true);
    $S[] = $alias;
    file_put_contents("o_init", "\n\n" . date("Y-m-d H:i:s") . "> " . json_encode($alias) . "\n", FILE_APPEND);
}
function fgl_space()
{
    global $S;
    $S[] = ' ';
}
function fgl_pshv()
{
    global $S, $SHV;
    $a = array_pop($S);
    $b = array_pop($S);
    $SHV[$a][] = $b;
}
function fgl_shv()
{
    global $S, $SHV;
    $a = array_pop($S);
    $b = array_pop($S);
    $SHV[$a] = $b;
}
function fgl_vv()
{
    global $S, $SHV;
    echo var_src($SHV[array_pop($S)]);
}
function fgl_rshv()
{
    global $S, $SHV;
    $S[] = $SHV[array_pop($S)];
}
function fgl_esv()
{
    global $argv, $S;
    $a = array_pop($S);
    foreach ($a as $vk => $v) {
        $v = trim($v);
        if (strlen($v) > 0) {
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
                            $ve = array_pop($S);
                            $S[] = array_pop($S) - $ve;
                        } else {
                            if (strpos($v, '${') !== false) {
                                echo __LINE__ . " " . $v . " shell var ";
                                global $SHV;
                                preg_match('/\\${[^}]+}/', $v, $m, PREG_OFFSET_CAPTURE);
                                $svn = $v[$m[0][1] + 2];
                                $svv = $SHV[$svn];
                                $v = str_replace($m[0][0], $svv, $v);
                                $S[] = $v;
                            } else {
                                if ($v == "'") {
                                    if ($a[$vk + 1] == "'") {
                                        $S[] = " ";
                                    }
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
function fgl_sys()
{
    global $S;
    system(array_pop($S));
}
function fgl_ax()
{
    global $S;
    $a = array_pop($S);
    $l = count($S);
    $S[$l - 1][] = $a;
}
function fgl_ess()
{
    global $S;
    $S[] = trim(array_pop($S));
    $S[] = explode(' ', array_pop($S));
    fgl_es();
}
function fgl_im()
{
    global $S;
    $S[] = implode(' ', array_pop($S));
}
function fgl_mss()
{
    global $S;
    $l = array_pop($S);
    $L = count($S);
    $s = $S[$L - $l];
    for ($i = $L - $l + 1; $i < $L; $i++) {
        $s = $s . " " . $S[$i];
    }
    array_splice($S, $L - $l);
    $S[] = $s;
}
function fgl_unindex()
{
    global $S;
    $a = array_pop($S);
    $b = array_pop($S);
    $S[] = $b[$a];
}
function fgl_mkindex()
{
    global $S;
    $a = array_pop($S);
    $b = array_pop($S);
    $S[] = array($a => $b);
}
function fgl_mkalias()
{
    global $S, $alias;
    $alias = array_pop($S);
    echo "<" . count($S) . "> " . preg_replace("/\\s+/", " ", var_export($alias, true)) . "\n";
}
function fgl_arp()
{
    fgl_array_push();
}
function fgl_array_push()
{
    global $S;
    $a = array_pop($S);
    $b = array_pop($S);
    $l = count($S);
    $S[$l - 1][$b] = $a;
}
function fgl_nat()
{
    fgl_native();
}
function fgl_native()
{
    global $S;
    $n = array_pop($S);
    if ($n == 0) {
        $S[] = array_pop($S) . "()";
    } else {
        $s = array_pop($S) . "(" . array_pop($S);
        while ($n-- > 1) {
            $s = $s . ", " . array_pop($S);
        }
        $S[] = $s . ")";
    }
}
function fgl_nx()
{
    global $S;
    $n = array_pop($S);
    if ($n == 0) {
        $S[] = array_pop($S) . "()";
    } else {
        if (1) {
            $s = array_pop($S) . "(" . "end(\$S)";
            while ($n-- > 1) {
                $s = $s . ", " . "array_pop(\$S)";
            }
            echo __LINE__ . " " . $s;
            $S[] = eval("return " . $s . ");");
        } else {
            $s = array_pop($S) . "(" . array_pop($S);
            while ($n-- > 1) {
                $s = $s . ", " . "array_pop(\$S)";
            }
            echo $s;
            $S[] = eval("return " . $s . ");");
        }
    }
}
function fgl_ne()
{
    global $S;
    $n = array_pop($S);
    if ($n == 0) {
        $S[] = array_pop($S) . "()";
    } else {
        if (0) {
            $s = array_pop($S) . "(" . "array_pop(\$S)";
            while ($n-- > 1) {
                $s = $s . ", " . "array_pop(\$S)";
            }
            echo __LINE__ . " " . $s;
            $S[] = eval("return " . $s . ");");
        } else {
            $s = array_pop($S) . "(" . array_pop($S);
            while ($n-- > 1) {
                $s = $s . ", " . "array_pop(\$S)";
            }
            echo $s;
            $S[] = eval("return " . $s . ");");
        }
    }
}
function fgl_xif()
{
    global $S, $vk, $xk, $xs, $SS;
    $c = array_pop($S);
    $xc = count($SS);
    $xk =& $SS[$xc - 1][0];
    $xs =& $SS[$xc - 1][1];
    $xl = count($SS[$xc - 1][1]);
    $a = $xs;
    $l = $xl;
    for ($i = $xk; $i < $l; $i++) {
        echo __LINE__ . " if: {$i} ";
        if ($xs[$i] == "endif:") {
            break;
        }
    }
    for ($j = $xk; $j < $i; $j++) {
        echo __LINE__ . " if: {$i} {$j} ";
        if ($xs[$j] == "else:") {
            break;
        }
    }
    echo "\n\n" . __LINE__ . " c " . $c . " xk " . $xk . " i " . $i . " j " . $j . "\n";
    if ($i == $j) {
        if ($c) {
            if ($i > $xk + 1) {
                $S[] = array($xk, $i);
                fgl_x();
            }
        }
    } else {
        if ($c) {
            $S[] = array($xk, $j);
            fgl_x();
            $S[] = array("prg_ctr", $j);
        } else {
            $S[] = array($j, $i);
            fgl_x();
            $S[] = array("prg_ctr", $i);
        }
    }
    echo "\n\n xif: " . __LINE__ . " c " . $c . " xk " . $xk . " i " . $i . " j " . $j;
    fgl_s();
    $xk = $i;
}
function fgl_do1()
{
    global $S, $xk, $xs, $SS, $SA, $SC;
    echo "\n" . __FUNCTION__ . " " . __LINE__ . " ";
    fgl_pss();
    fgl_s();
    $c = array_pop($S);
    $xc = count($SS);
    $xk =& $SS[$xc - 1][0];
    $xs =& $SS[$xc - 1][1];
    $xl = count($SS[$xc - 1][1]);
    $vk = $xk;
    $a = $xs;
    $l = $xl;
    $SC[] = array("do", $xc - 1, $xk);
    for ($i = $xk; $i < $l; $i++) {
        echo __LINE__ . " while: {$i} ";
        if ($xs[$i] == "while:") {
            break;
        }
    }
    $j = $i;
    if ($i == $j) {
        do {
            $L0 = count($S);
            $S[] = array($vk, $i);
            $LC = count($SC);
            $E = $LC - 1;
            $SC[$E][] = $vk;
            $SC[$E][] = $i;
            fgl_x();
            echo "\n\n do: " . __LINE__ . " ck " . $ck . " ce " . $ce . " count S " . count($S) . "\n";
            echo " do: " . __LINE__ . " pwd " . getcwd() . " ";
            $c = array_pop($S);
            while (count($S) > $L0) {
                $SA[] = array_pop($S);
            }
        } while ($c);
    } else {
        if ($c) {
            $S[] = array($xk, $j);
            fgl_x();
        } else {
            $S[] = array($j, $i);
            fgl_x();
        }
    }
    fgl_s();
    $xk = $i;
    $S[] = array("prg_ctr", $i);
}
function fgl_do()
{
    global $S, $xk, $xs, $SS, $SA, $SC;
    echo "\n\n\n" . __FUNCTION__ . " " . __LINE__ . " SS ";
    fgl_pss();
    fgl_s();
    $xc = count($SS);
    $xk =& $SS[$xc - 1][0];
    $xs =& $SS[$xc - 1][1];
    $xl = count($SS[$xc - 1][1]);
    $vk = $xk;
    $a = $xs;
    $l = $xl;
    $LC = count($SC);
    $E = $LC - 1;
    $CC = $LC;
    if ($LC == 0) {
        $SC[] = array("do", $xc - 1, $xk);
    } else {
        if (isset($SC[$E][2])) {
            if ($xk > $SC[$E][2]) {
                $SC[] = array("do", $xc - 1, $xk);
            }
        }
    }
    echo "\n do: " . __LINE__ . " CC " . $CC . " xk " . $xk . " SC < " . count($SC) . " > " . var_src($SC);
    for ($i = $xk; $i < $l; $i++) {
        echo __LINE__ . " while: {$i} ";
        if ($xs[$i] == "while:") {
            break;
        }
    }
    $j = $i;
    $L0 = count($S);
    $LC = count($SC);
    $E = $LC - 1;
    $SC[$E][2] = $vk;
    if (!isset($SC[$E][3])) {
        $SC[$E][] = $i;
    }
    echo "\n\n do: " . __LINE__ . " vk " . $vk . " ck " . " ce " . " CC " . $CC . " SC < " . count($SC) . " > " . var_src($SC);
    if ($i == $j) {
        do {
            echo "\n\n do: line " . __LINE__ . " " . __FILE__ . " vk " . $vk . " i " . $i . " count S " . count($S) . " CC " . $CC . " SC " . var_src($SC) . "\n";
            $S[] = array($vk, $i);
            fgl_x();
            $c = array_pop($S);
            if (isset($SC[$CC + 1][3])) {
                if ($SC[$CC + 1][3] == $SC[$CC][3]) {
                    echo " line " . __LINE__ . " " . $SC[$CC][3] . " " . $SC[$CC + 1][3] . " xk " . $xk . " l " . $l . " ";
                    for ($i = $xk + 1; $i < $l; $i++) {
                        echo __LINE__ . " while: i " . $i . " xk " . $xk . " ";
                        if ($xs[$i] == "while:") {
                            $SC[$CC][3] = $i;
                            break;
                        }
                    }
                    echo " line " . __LINE__ . " CC " . $CC . " " . $SC[$CC][3] . " " . $SC[$CC + 1][3] . " xk " . $xk . " l " . $l . " " . var_src($SC);
                    if ($i - $xk > 1) {
                        $S[] = array($xk, $i);
                        fgl_x();
                        $c = array_pop($S);
                    }
                }
            }
            while (count($S) > $L0) {
                $SA[] = array_pop($S);
            }
        } while ($c);
        if (0) {
            if (isset($SC[$CC + 1][3])) {
                echo " line " . __LINE__ . " " . $SC[$CC][3] . " " . $SC[$CC + 1][3] . " xk " . $xk . " l " . $l . " ";
                for ($i = $xk + 1; $i < $l; $i++) {
                    echo __LINE__ . " while: {$i} ";
                    if ($xs[$i] == "while:") {
                        break;
                    }
                }
                if ($i - $xk > 1) {
                    $S[] = array($vk, $i);
                    fgl_x();
                }
            }
        }
    } else {
        if ($c) {
            $S[] = array($xk, $j);
            fgl_x();
        } else {
            $S[] = array($j, $i);
            fgl_x();
        }
    }
    fgl_s();
    $xk = $i;
    $S[] = array("prg_ctr", $i);
}
function fgl_fgc()
{
    global $S;
    $S[] = file_get_contents(array_pop($S));
}
function fgl_gt()
{
    global $S;
    $S[] = array_pop($S) < array_pop($S);
}
function fgl_dec()
{
    global $S;
    $S[] = array_pop($S) - 1;
}
function fgl_f1()
{
    global $S, $xk, $xs, $SS, $SA, $SC;
    $xc = count($SS);
    $xk =& $SS[$xc - 1][0];
    $xs =& $SS[$xc - 1][1];
    $xl = count($SS[$xc - 1][1]);
    $vk = $xk;
    $a = $xs;
    $l = $xl;
    $LC = count($SC);
    $E = $LC - 1;
    if ($LC == 0) {
        $SC[] = array("f1", $xc - 1, $xk);
    } else {
        if (isset($SC[$E][2])) {
            if ($xk > $SC[$E][2]) {
                $SC[] = array("f1", $xc - 1, $xk);
            }
        }
    }
    if ($LC > 0) {
        $S[] = $vk;
        fgl_CC();
        $t = array_pop($S);
        $CC = $t[0];
    } else {
        $CC = $LC;
    }
    if (isset($D)) {
        echo "\n f1: " . __LINE__ . " xk " . $xk . " SC < " . count($SC) . " > " . var_src($SC);
    }
    if (isset($D)) {
        echo "\n\n\n" . __FUNCTION__ . " loop start " . __LINE__ . " SS ";
        fgl_pss();
        fgl_s();
    }
    $c = array_pop($S);
    if (isset($D)) {
        echo "\n f1: " . __LINE__ . " xk " . $xk . " SC < " . count($SC) . " > " . var_src($SC) . " c " . var_src($c) . " ";
    }
    for ($i = $xk; $i < $l; $i++) {
        if (isset($D)) {
            echo __LINE__ . " end: {$i} ";
        }
        if ($xs[$i] == "end:") {
            break;
        }
    }
    $j = $i;
    $L0 = count($S);
    $LC = count($SC);
    $E = $LC - 1;
    $SC[$E][2] = $vk;
    if (!isset($SC[$E][3])) {
        $SC[$E][] = $i;
    }
    if (isset($D)) {
        echo "\n\n f1: " . __LINE__ . " xk " . $xk . " vk " . $vk . " i " . $i . " SC < " . count($SC) . " > " . var_src($SC);
    }
    if (isset($SC[1][3])) {
        if ($SC[0][3] == $SC[1][3]) {
            for ($i = $i + 1; $i < $l; $i++) {
                if (isset($D)) {
                    echo __LINE__ . " end: {$i} ";
                }
                if ($xs[$i] == "end:") {
                    break;
                }
            }
            $SC[0][3] = $i;
        }
    }
    if (isset($D)) {
        echo "\n\n f1: " . __LINE__ . " CC " . $CC . " xk " . $xk . " vk " . $vk . " i " . $i . " SC < " . count($SC) . " > " . var_src($SC);
    }
    $j = $i;
    if ($i == $j) {
        if (isset($D)) {
            echo "\n\n f1: " . __LINE__ . " c " . var_src($c);
        }
        foreach ($c as $ck => $ce) {
            if (isset($D)) {
                echo "\n\n f1: " . __LINE__ . " CC " . $CC . " SC " . var_src($SC) . " vk " . $vk . " i " . $i . " ck " . $ck . " ce " . var_src($ce) . " count S " . count($S) . "\n";
                fgl_s();
            }
            $S[] = $ce;
            $S[] = array($vk, $SC[$CC][3]);
            fgl_x();
            if (isset($D)) {
                echo "\n\n\n f1: " . __LINE__ . " vk " . $vk . " i " . $i . " ck " . $ck . " ce " . var_src($ce) . " count S " . count($S) . " CC " . $CC . " SC " . var_src($SC) . "\n";
                fgl_s();
            }
            while (count($S) > $L0) {
                $SA[] = array_pop($S);
            }
        }
        if (isset($D)) {
            echo "\n f1: " . __LINE__ . " end foreach()\n";
        }
        if (0) {
            if (isset($SC[$CC + 1][3])) {
                echo " line " . __LINE__ . " " . $SC[$CC][3] . " " . $SC[$CC + 1][3] . " xk " . $xk . " l " . $l . " ";
                for ($i = $xk + 1; $i < $l; $i++) {
                    echo __LINE__ . " end: {$i} ";
                    if ($xs[$i] == "end:") {
                        break;
                    }
                }
                if ($i - $xk > 1) {
                    $S[] = array($vk, $i);
                    fgl_x();
                }
            }
        }
    } else {
        if ($c) {
            $S[] = array($xk, $j);
            fgl_x();
        } else {
            $S[] = array($j, $i);
            fgl_x();
        }
    }
    if (isset($D)) {
        echo "\n\n" . __FUNCTION__ . " " . __LINE__ . " CC " . $CC . " end " . $SC[$CC][3] . " i " . $i . " SA " . var_src($SA) . " ";
        fgl_s();
    }
    $xk = $i;
    $S[] = array("prg_ctr", $SC[$CC][3]);
}
function fgl_f1a()
{
    global $S, $xk, $xs, $SS, $SA, $SC;
    $xc = count($SS);
    if (1) {
        $S[] = 'SS r: c: xc v:';
        do {
            echo "\n" . __LINE__ . " ";
            fgl_s();
            echo "\n" . __LINE__ . " fgl_php() ";
            fgl_php();
            echo "\n" . __LINE__ . " ";
            fgl_s();
            array_pop($SS);
            $f = array_pop($S);
            $t = array_pop($S);
            if ($t == '') {
                $t = ":END:";
            }
            echo "\n" . __LINE__ . " {$t} :" . end($S) . ": ";
            fgl_s();
            if (end($S) == '') {
                break;
            }
            if ($t == ":END:") {
                break;
            } else {
                eval($t);
            }
            if ($f == ':r:') {
                fgl_swap();
            }
        } while ($t != ":END:" || end($S) != '');
        array_pop($S);
    }
    echo __LINE__ . " " . var_src($SS);
    echo __LINE__ . " " . var_src($SS);
    echo " " . count($SS) . "\n";
    $xk =& $SS[$xc - 1][0];
    $xs =& $SS[$xc - 1][1];
    $xl = count($SS[$xc - 1][1]);
    $vk = $xk;
    $a = $xs;
    $l = $xl;
    $LC = count($SC);
    $E = $LC - 1;
    if ($LC == 0) {
        $SC[] = array("f1", $xc - 1, $xk);
    } else {
        if (isset($SC[$E][2])) {
            if ($xk > $SC[$E][2]) {
                $SC[] = array("f1", $xc - 1, $xk);
            }
        }
    }
    if ($LC > 0) {
        $S[] = $vk;
        fgl_CC();
        $t = array_pop($S);
        $CC = $t[0];
    } else {
        $CC = $LC;
    }
    if (isset($D)) {
        echo "\n f1: " . __LINE__ . " xk " . $xk . " SC < " . count($SC) . " > " . var_src($SC);
    }
    if (isset($D)) {
        echo "\n\n\n" . __FUNCTION__ . " loop start " . __LINE__ . " SS ";
        fgl_pss();
        fgl_s();
    }
    $c = array_pop($S);
    if (isset($D)) {
        echo "\n f1: " . __LINE__ . " xk " . $xk . " SC < " . count($SC) . " > " . var_src($SC) . " c " . var_src($c) . " ";
    }
    for ($i = $xk; $i < $l; $i++) {
        if (isset($D)) {
            echo __LINE__ . " end: {$i} ";
        }
        if ($xs[$i] == "end:") {
            break;
        }
    }
    $j = $i;
    $L0 = count($S);
    $LC = count($SC);
    $E = $LC - 1;
    $SC[$E][2] = $vk;
    if (!isset($SC[$E][3])) {
        $SC[$E][] = $i;
    }
    if (isset($D)) {
        echo "\n\n f1: " . __LINE__ . " xk " . $xk . " vk " . $vk . " i " . $i . " SC < " . count($SC) . " > " . var_src($SC);
    }
    if (isset($SC[1][3])) {
        if ($SC[0][3] == $SC[1][3]) {
            for ($i = $i + 1; $i < $l; $i++) {
                if (isset($D)) {
                    echo __LINE__ . " end: {$i} ";
                }
                if ($xs[$i] == "end:") {
                    break;
                }
            }
            $SC[0][3] = $i;
        }
    }
    if (isset($D)) {
        echo "\n\n f1: " . __LINE__ . " CC " . $CC . " xk " . $xk . " vk " . $vk . " i " . $i . " SC < " . count($SC) . " > " . var_src($SC);
    }
    $j = $i;
    if ($i == $j) {
        if (isset($D)) {
            echo "\n\n f1: " . __LINE__ . " c " . var_src($c);
        }
        foreach ($c as $ck => $ce) {
            if (isset($D)) {
                echo "\n\n f1: " . __LINE__ . " CC " . $CC . " SC " . var_src($SC) . " vk " . $vk . " i " . $i . " ck " . $ck . " ce " . var_src($ce) . " count S " . count($S) . "\n";
                fgl_s();
            }
            $S[] = $ce;
            $S[] = array($vk, $SC[$CC][3]);
            fgl_x();
            if (isset($D)) {
                echo "\n\n\n f1: " . __LINE__ . " vk " . $vk . " i " . $i . " ck " . $ck . " ce " . var_src($ce) . " count S " . count($S) . " CC " . $CC . " SC " . var_src($SC) . "\n";
                fgl_s();
            }
            while (count($S) > $L0) {
                $SA[] = array_pop($S);
            }
        }
        if (isset($D)) {
            echo "\n f1: " . __LINE__ . " end foreach()\n";
        }
        if (0) {
            if (isset($SC[$CC + 1][3])) {
                echo " line " . __LINE__ . " " . $SC[$CC][3] . " " . $SC[$CC + 1][3] . " xk " . $xk . " l " . $l . " ";
                for ($i = $xk + 1; $i < $l; $i++) {
                    echo __LINE__ . " end: {$i} ";
                    if ($xs[$i] == "end:") {
                        break;
                    }
                }
                if ($i - $xk > 1) {
                    $S[] = array($vk, $i);
                    fgl_x();
                }
            }
        }
    } else {
        if ($c) {
            $S[] = array($xk, $j);
            fgl_x();
        } else {
            $S[] = array($j, $i);
            fgl_x();
        }
    }
    if (isset($D)) {
        echo "\n\n" . __FUNCTION__ . " " . __LINE__ . " CC " . $CC . " end " . $SC[$CC][3] . " i " . $i . " SA " . var_src($SA) . " ";
        fgl_s();
    }
    $xk = $i;
    $S[] = array("prg_ctr", $SC[$CC][3]);
}
function fgl_f1b()
{
    global $S, $xk, $xs, $SS, $SA, $SC;
    $xc = count($SS);
    fgl_s();
    if (0) {
        $S[] = 'SS r: c: xc v:';
        do {
            echo "\n" . __LINE__ . " ";
            fgl_s();
            echo "\n" . __LINE__ . " fgl_php() ";
            fgl_php();
            echo "\n" . __LINE__ . " ";
            fgl_s();
            $f = array_pop($S);
            $t = array_pop($S);
            if ($t == '') {
                $t = ":END:";
            }
            echo "\n" . __LINE__ . " {$t} :" . end($S) . ": ";
            fgl_s();
            if (end($S) == '') {
                break;
            }
            if ($t == ":END:") {
                break;
            } else {
                eval($t);
            }
            if ($f == ':r:') {
                fgl_swap();
            }
        } while ($t != ":END:" || end($S) != '');
        array_pop($S);
    }
    $xk =& $SS[$xc - 1][0];
    $xs =& $SS[$xc - 1][1];
    $xl = count($SS[$xc - 1][1]);
    $vk = $xk;
    $a = $xs;
    $l = $xl;
    $LC = count($SC);
    $E = $LC - 1;
    if ($LC == 0) {
        $SC[] = array("f1", $xc - 1, $xk);
    } else {
        if (isset($SC[$E][2])) {
            if ($xk > $SC[$E][2]) {
                $SC[] = array("f1", $xc - 1, $xk);
            }
        }
    }
    if ($LC > 0) {
        $S[] = $vk;
        fgl_CC();
        $t = array_pop($S);
        $CC = $t[0];
    } else {
        $CC = $LC;
    }
    if (isset($D)) {
        echo "\n f1: " . __LINE__ . " xk " . $xk . " SC < " . count($SC) . " > " . var_src($SC);
    }
    if (isset($D)) {
        echo "\n\n\n" . __FUNCTION__ . " loop start " . __LINE__ . " SS ";
        fgl_pss();
        fgl_s();
    }
    $c = array_pop($S);
    if (isset($D)) {
        echo "\n f1: " . __LINE__ . " xk " . $xk . " SC < " . count($SC) . " > " . var_src($SC) . " c " . var_src($c) . " ";
    }
    for ($i = $xk; $i < $l; $i++) {
        if (isset($D)) {
            echo __LINE__ . " end: {$i} ";
        }
        if ($xs[$i] == "end:") {
            break;
        }
    }
    $j = $i;
    $L0 = count($S);
    $LC = count($SC);
    $E = $LC - 1;
    $SC[$E][2] = $vk;
    if (!isset($SC[$E][3])) {
        $SC[$E][] = $i;
    }
    if (isset($D)) {
        echo "\n\n f1: " . __LINE__ . " xk " . $xk . " vk " . $vk . " i " . $i . " SC < " . count($SC) . " > " . var_src($SC);
    }
    if (isset($SC[1][3])) {
        if ($SC[0][3] == $SC[1][3]) {
            for ($i = $i + 1; $i < $l; $i++) {
                if (isset($D)) {
                    echo __LINE__ . " end: {$i} ";
                }
                if ($xs[$i] == "end:") {
                    break;
                }
            }
            $SC[0][3] = $i;
        }
    }
    if (isset($D)) {
        echo "\n\n f1: " . __LINE__ . " CC " . $CC . " xk " . $xk . " vk " . $vk . " i " . $i . " SC < " . count($SC) . " > " . var_src($SC);
    }
    $j = $i;
    if ($i == $j) {
        if (isset($D)) {
            echo "\n\n f1: " . __LINE__ . " c " . var_src($c);
        }
        foreach ($c as $ck => $ce) {
            if (isset($D)) {
                echo "\n\n f1: " . __LINE__ . " CC " . $CC . " SC " . var_src($SC) . " vk " . $vk . " i " . $i . " ck " . $ck . " ce " . var_src($ce) . " count S " . count($S) . "\n";
                fgl_s();
            }
            $S[] = $ce;
            $S[] = array($vk, $SC[$CC][3]);
            fgl_x();
            if (isset($D)) {
                echo "\n\n\n f1: " . __LINE__ . " vk " . $vk . " i " . $i . " ck " . $ck . " ce " . var_src($ce) . " count S " . count($S) . " CC " . $CC . " SC " . var_src($SC) . "\n";
                fgl_s();
            }
            while (count($S) > $L0) {
                $SA[] = array_pop($S);
            }
        }
        if (isset($D)) {
            echo "\n f1: " . __LINE__ . " end foreach()\n";
        }
        if (0) {
            if (isset($SC[$CC + 1][3])) {
                echo " line " . __LINE__ . " " . $SC[$CC][3] . " " . $SC[$CC + 1][3] . " xk " . $xk . " l " . $l . " ";
                for ($i = $xk + 1; $i < $l; $i++) {
                    echo __LINE__ . " end: {$i} ";
                    if ($xs[$i] == "end:") {
                        break;
                    }
                }
                if ($i - $xk > 1) {
                    $S[] = array($vk, $i);
                    fgl_x();
                }
            }
        }
    } else {
        if ($c) {
            $S[] = array($xk, $j);
            fgl_x();
        } else {
            $S[] = array($j, $i);
            fgl_x();
        }
    }
    if (isset($D)) {
        echo "\n\n" . __FUNCTION__ . " " . __LINE__ . " CC " . $CC . " end " . $SC[$CC][3] . " i " . $i . " SA " . var_src($SA) . " ";
        fgl_s();
    }
    $xk = $i;
    $S[] = array("prg_ctr", $SC[$CC][3]);
}
function fgl_f1f()
{
    global $S, $xk, $xs, $SS, $SA, $SC;
    global $V;
    $V = array();
    $xc = count($SS) + 1;
    $S[] = 'SS r: c: xc v:';
    do {
        echo "\n" . __LINE__ . " ";
        fgl_s();
        echo "\n" . __LINE__ . " fgl_php() ";
        fgl_php();
        echo "\n" . __LINE__ . " ";
        fgl_s();
        $f = array_pop($S);
        $t = array_pop($S);
        if ($t == '') {
            $t = ":END:";
        }
        echo "\n" . __LINE__ . " {$t} :" . end($S) . ": ";
        fgl_s();
        if (end($S) == '') {
            break;
        }
        if ($t == ":END:") {
            break;
        } else {
            eval($t);
        }
        if ($f == ':r:') {
            fgl_swap();
        }
    } while ($t != ":END:" || end($S) != '');
    $V["xc"] =& $xc;
    echo "\n\n" . __LINE__ . " V " . var_src($V) . " ; ";
    echo __LINE__ . " xc " . $xc . " ";
    $S[] = count($SS);
    $S[] = 'xc';
    fgl_va();
    echo __LINE__ . " xc " . $xc . " ; " . var_src(get_defined_vars());
    $xk =& $SS[$xc - 1][0];
    $xs =& $SS[$xc - 1][1];
    $xl = count($SS[$xc - 1][1]);
    $vk = $xk;
    $a = $xs;
    $l = $xl;
    $LC = count($SC);
    $E = $LC - 1;
    echo "\n\n" . __LINE__ . " xc " . $xc . " ; " . var_src(get_defined_vars());
    $vn = "xc";
    eval('$m = &$' . $vn . ';');
    $m = 726;
    echo __LINE__ . " xc " . $xc . " ; ";
    exit;
    if ($LC == 0) {
        $SC[] = array("f1", $xc - 1, $xk);
    } else {
        if (isset($SC[$E][2])) {
            if ($xk > $SC[$E][2]) {
                $SC[] = array("f1", $xc - 1, $xk);
            }
        }
    }
    if ($LC > 0) {
        $S[] = $vk;
        fgl_CC();
        $t = array_pop($S);
        $CC = $t[0];
    } else {
        $CC = $LC;
    }
    if (isset($D)) {
        echo "\n f1: " . __LINE__ . " xk " . $xk . " SC < " . count($SC) . " > " . var_src($SC);
    }
    if (isset($D)) {
        echo "\n\n\n" . __FUNCTION__ . " loop start " . __LINE__ . " SS ";
        fgl_pss();
        fgl_s();
    }
    $c = array_pop($S);
    if (isset($D)) {
        echo "\n f1: " . __LINE__ . " xk " . $xk . " SC < " . count($SC) . " > " . var_src($SC) . " c " . var_src($c) . " ";
    }
    for ($i = $xk; $i < $l; $i++) {
        if (isset($D)) {
            echo __LINE__ . " end: {$i} ";
        }
        if ($xs[$i] == "end:") {
            break;
        }
    }
    $j = $i;
    $L0 = count($S);
    $LC = count($SC);
    $E = $LC - 1;
    $SC[$E][2] = $vk;
    if (!isset($SC[$E][3])) {
        $SC[$E][] = $i;
    }
    if (isset($D)) {
        echo "\n\n f1: " . __LINE__ . " xk " . $xk . " vk " . $vk . " i " . $i . " SC < " . count($SC) . " > " . var_src($SC);
    }
    if (isset($SC[1][3])) {
        if ($SC[0][3] == $SC[1][3]) {
            for ($i = $i + 1; $i < $l; $i++) {
                if (isset($D)) {
                    echo __LINE__ . " end: {$i} ";
                }
                if ($xs[$i] == "end:") {
                    break;
                }
            }
            $SC[0][3] = $i;
        }
    }
    if (isset($D)) {
        echo "\n\n f1: " . __LINE__ . " CC " . $CC . " xk " . $xk . " vk " . $vk . " i " . $i . " SC < " . count($SC) . " > " . var_src($SC);
    }
    $j = $i;
    if ($i == $j) {
        if (isset($D)) {
            echo "\n\n f1: " . __LINE__ . " c " . var_src($c);
        }
        foreach ($c as $ck => $ce) {
            if (isset($D)) {
                echo "\n\n f1: " . __LINE__ . " CC " . $CC . " SC " . var_src($SC) . " vk " . $vk . " i " . $i . " ck " . $ck . " ce " . var_src($ce) . " count S " . count($S) . "\n";
                fgl_s();
            }
            $S[] = $ce;
            $S[] = array($vk, $SC[$CC][3]);
            fgl_x();
            if (isset($D)) {
                echo "\n\n\n f1: " . __LINE__ . " vk " . $vk . " i " . $i . " ck " . $ck . " ce " . var_src($ce) . " count S " . count($S) . " CC " . $CC . " SC " . var_src($SC) . "\n";
                fgl_s();
            }
            while (count($S) > $L0) {
                $SA[] = array_pop($S);
            }
        }
        if (isset($D)) {
            echo "\n f1: " . __LINE__ . " end foreach()\n";
        }
        if (0) {
            if (isset($SC[$CC + 1][3])) {
                echo " line " . __LINE__ . " " . $SC[$CC][3] . " " . $SC[$CC + 1][3] . " xk " . $xk . " l " . $l . " ";
                for ($i = $xk + 1; $i < $l; $i++) {
                    echo __LINE__ . " end: {$i} ";
                    if ($xs[$i] == "end:") {
                        break;
                    }
                }
                if ($i - $xk > 1) {
                    $S[] = array($vk, $i);
                    fgl_x();
                }
            }
        }
    } else {
        if ($c) {
            $S[] = array($xk, $j);
            fgl_x();
        } else {
            $S[] = array($j, $i);
            fgl_x();
        }
    }
    if (isset($D)) {
        echo "\n\n" . __FUNCTION__ . " " . __LINE__ . " CC " . $CC . " end " . $SC[$CC][3] . " i " . $i . " SA " . var_src($SA) . " ";
        fgl_s();
    }
    $xk = $i;
    $S[] = array("prg_ctr", $SC[$CC][3]);
}
function fgl_cforeach()
{
    global $S, $xk, $xs, $SS, $SA, $SC;
    $xc = count($SS);
    $xk =& $SS[$xc - 1][0];
    $xs =& $SS[$xc - 1][1];
    $xl = count($SS[$xc - 1][1]);
    $vk = $xk;
    $a = $xs;
    $l = $xl;
    $LC = count($SC);
    $E = $LC - 1;
    $CC = $LC;
    if ($LC == 0) {
        $SC[] = array("cforeach", $xc - 1, $xk);
    } else {
        if (isset($SC[$E][2])) {
            if ($xk > $SC[$E][2]) {
                $SC[] = array("cforeach", $xc - 1, $xk);
            }
        }
    }
    echo "\n\n\n" . __FUNCTION__ . " loop start " . __LINE__ . " SS ";
    fgl_pss();
    fgl_s();
    $c = array_pop($S);
    echo "\n cforeach: " . __LINE__ . " xk " . $xk . " SC < " . count($SC) . " > " . var_src($SC) . " c " . var_src($c) . " ";
    for ($i = $xk; $i < $l; $i++) {
        echo __LINE__ . " end: {$i} ";
        if ($xs[$i] == "end:") {
            break;
        }
    }
    $j = $i;
    $L0 = count($S);
    $LC = count($SC);
    $E = $LC - 1;
    $SC[$E][2] = $vk;
    if (!isset($SC[$E][3])) {
        $SC[$E][] = $i;
    }
    echo "\n\n cforeach: " . __LINE__ . " xk " . $xk . " vk " . $vk . " i " . $i . " SC < " . count($SC) . " > " . var_src($SC);
    if ($i == $j) {
        foreach ($c as $ck => $ce) {
            $S[] = $ce;
            $S[] = array($vk, $i);
            fgl_x();
            echo "\n\n\n cforeach: " . __LINE__ . " vk " . $vk . " ck " . $ck . " ce " . var_src($ce) . " count S " . count($S) . " CC " . $CC . " SC " . var_src($SC) . "\n";
            while (count($S) > $L0) {
                $SA[] = array_pop($S);
            }
        }
        echo "\n cforeach: " . __LINE__ . " end foreach()\n";
        if (isset($SC[$CC + 1][3])) {
            echo " line " . __LINE__ . " " . $SC[$CC][3] . " " . $SC[$CC + 1][3] . " xk " . $xk . " l " . $l . " ";
            for ($i = $xk + 1; $i < $l; $i++) {
                echo __LINE__ . " end: {$i} ";
                if ($xs[$i] == "end:") {
                    break;
                }
            }
            if ($i - $xk > 1) {
                $S[] = array($vk, $i);
                fgl_x();
            }
        }
    } else {
        if ($c) {
            $S[] = array($xk, $j);
            fgl_x();
        } else {
            $S[] = array($j, $i);
            fgl_x();
        }
    }
    echo "\n" . __FUNCTION__ . " " . __LINE__ . " ";
    fgl_s();
    $xk = $i;
    $S[] = array("prg_ctr", $i);
}
function fgl_xforeach()
{
    global $S, $xk, $xs, $SS, $SA;
    echo "\n" . __FUNCTION__ . " " . __LINE__ . " ";
    fgl_pss();
    fgl_s();
    $c = array_pop($S);
    $xc = count($SS);
    $xk =& $SS[$xc - 1][0];
    $xs =& $SS[$xc - 1][1];
    $xl = count($SS[$xc - 1][1]);
    $vk = $xk;
    $a = $xs;
    $l = $xl;
    for ($i = $xk; $i < $l; $i++) {
        echo __LINE__ . " end: {$i} ";
        if ($xs[$i] == "end:") {
            break;
        }
    }
    $j = $i;
    if ($i == $j) {
        foreach ($c as $ck => $ce) {
            $L0 = count($S);
            $S[] = $ce;
            $S[] = array($vk, $i);
            fgl_x();
            echo "\n\n xforeach " . __LINE__ . " ck " . $ck . " ce " . $ce . " count S " . count($S) . "\n";
            echo " xforeach " . __LINE__ . " pwd " . getcwd() . " ";
            while (count($S) > $L0) {
                $SA[] = array_pop($S);
            }
        }
    } else {
        if ($c) {
            $S[] = array($xk, $j);
            fgl_x();
        } else {
            $S[] = array($j, $i);
            fgl_x();
        }
    }
    fgl_s();
    $xk = $i;
    $S[] = array("prg_ctr", $i);
}
function fgl_rem()
{
    global $S, $xk, $xs, $SS, $SA;
    echo "\n" . __FUNCTION__ . " " . __LINE__ . " ";
    fgl_pss();
    fgl_s();
    $c = array_pop($S);
    $xc = count($SS);
    $xk =& $SS[$xc - 1][0];
    $xs =& $SS[$xc - 1][1];
    $xl = count($SS[$xc - 1][1]);
    $vk = $xk;
    $a = $xs;
    $l = $xl;
    for ($i = $xk; $i < $l; $i++) {
        echo __LINE__ . " end: {$i} ";
        if ($xs[$i] == "end:") {
            break;
        }
    }
    $j = $i;
    if (0) {
        if ($i == $j) {
            foreach ($c as $ck => $ce) {
                $L0 = count($S);
                $S[] = $ce;
                echo "\n\n xforeach " . __LINE__ . " ck " . $ck . " ce " . $ce . " count S " . count($S) . "\n";
                echo " xforeach " . __LINE__ . " pwd " . getcwd() . " ";
                while (count($S) > $L0) {
                    $SA[] = array_pop($S);
                }
            }
        } else {
            if ($c) {
            } else {
            }
        }
    }
    fgl_s();
    $xk = $i;
    $S[] = array("prg_ctr", $i);
}
function fgl_case()
{
    global $S, $vk, $xk, $xs, $SS;
    echo "\n" . __FUNCTION__ . " " . __LINE__ . " ";
    fgl_pss();
    $c = array_pop($S);
    $xc = count($SS);
    $xk =& $SS[$xc - 1][0];
    $xs =& $SS[$xc - 1][1];
    $xl = count($SS[$xc - 1][1]);
    $a = $xs;
    $l = $xl;
    for ($i = $xk; $i < $l; $i++) {
        echo __LINE__ . " endof: {$i} ";
        if ($xs[$i] == "endof:") {
            break;
        }
    }
    for ($j = $xk; $j < $i; $j++) {
        echo __LINE__ . " of: {$i} {$j} ";
        if ($xs[$j] == "of:") {
            break;
        }
    }
    $S[] = array($c, $xk, $i, $j, $xs[$xk], $xs[$i], $xs[$j]);
    if ($i == $j) {
        if ($c) {
            if ($i > $xk + 1) {
                $S[] = array($xk, $i);
                fgl_x();
            }
        }
    } else {
        $S[] = array("case", $i, $xs[$i], $xs[$i - 1], $xk, $j, $c);
        $S[] = array($xk, $j);
        fgl_x();
        if ($c == array_pop($S)) {
            echo __LINE__ . "\n";
            $S[] = array($j, $i);
            fgl_x();
        } else {
        }
    }
    fgl_s();
    $xk = $i;
}
function fgl_if()
{
    global $S, $vk;
    $a = array_pop($S);
    $l = count($S[0]);
    echo __LINE__ . " if: {$i} {$l} {$vk}";
    for ($i = $vk; $i < $l; $i++) {
        echo __LINE__ . " if: {$i} ";
        if ($S[0][$i] == "endif:") {
            break;
        }
    }
    for ($j = $vk; $j < $i; $j++) {
        echo __LINE__ . " if: {$i} {$j} ";
        if ($S[0][$j] == "else:") {
            break;
        }
    }
    if ($a) {
        $S[] = "if 1 {$a} {$vk} {$i} {$j}";
        $S[] = $vk + 1;
        $S[] = $j;
    } else {
        $S[] = "if 0 {$a} {$vk} {$i} {$j}";
        $S[] = $j + 1;
        $S[] = $i;
    }
    fgl_xblk();
}
function fgl_xblk()
{
    global $S;
    $a = array_pop($S);
    $b = array_pop($S);
    echo __LINE__ . "\n " . $a . " " . $b . "\n";
    $S[] = array_slice($S[0], $b + 1, $a - $b - 1);
    fgl_s();
    fgl_es();
}
function fgl_e()
{
    global $S;
    $S[] = eval("return " . array_pop($S) . ";");
}
function t_alias($n)
{
    global $alias;
    global $r, $lc, $k, $n1, $la, $logFile;
    $fn = __FUNCTION__;
    $fl = strlen($fn);
    $fk = substr($fn, 4);
    $ki = $lc[$k - 1];
    $lc[$k] = $fk;
    $p = $alias;
    $pk = array_keys($p);
    $c = $p[$pk[0]];
    $ck = array_keys($c);
    $jo = array($n, mb_detect_encoding($n), in_array($n, $ck), $ck);
    if (in_array($n, $ck)) {
        $tf = $c[$n];
    } else {
        $tf = 0;
    }
    file_put_contents("o_ta", "\n\n" . date("Y-m-d H:i:s") . "> " . json_encode($jo) . "\n", FILE_APPEND);
    return $tf;
}
function t_alias_chain($n)
{
    global $alias;
    global $r, $lc, $k, $n1, $la, $logFile;
    $fn = __FUNCTION__;
    $fl = strlen($fn);
    $fk = substr($fn, 4);
    $ki = $lc[$k - 1];
    $lc[$k] = $fk;
    $p = $alias;
    $pk = array_keys($p);
    $c = $p[$pk[0]];
    $ck = array_keys($c);
    $jo = array($n, mb_detect_encoding($n), in_array($n, $ck), $ck);
    if (in_array($n, $ck)) {
        $tf = $c[$n];
    } else {
        $tf = 0;
    }
    $i = 0;
    while (substr($tf, 0, 4) != "fws_" && substr($tf, 0, 2) != "s_" && $i < 10) {
        if (in_array($tf, $ck)) {
            $tf = $c[$tf];
        } else {
            $tf = 0;
        }
        $i++;
        file_put_contents("o_ta", "\n\n" . date("Y-m-d H:i:s") . "> " . json_encode(array("in loop ", $tf, $i)) . "\n", FILE_APPEND);
    }
    file_put_contents("o_ta", "\n\n" . date("Y-m-d H:i:s") . "> " . json_encode(array($tf, $jo)) . "\n", FILE_APPEND);
    return $tf;
}
function fgl_achn()
{
    fgl_alias_chain();
}
function fgl_alias_chain()
{
    global $alias, $S;
    $n = array_pop($S);
    global $r, $lc, $k, $n1, $la, $logFile;
    $fn = __FUNCTION__;
    $fl = strlen($fn);
    $fk = substr($fn, 4);
    $ki = $lc[$k - 1];
    $lc[$k] = $fk;
    $p = $alias;
    $pk = array_keys($p);
    $c = $p[$pk[0]];
    $ck = array_keys($c);
    $jo = array($n, mb_detect_encoding($n), in_array($n, $ck), $ck);
    if (in_array($n, $ck)) {
        $tf = $c[$n];
    } else {
        $tf = 0;
    }
    $S[] = $tf;
    return 0;
    $i = 0;
    while (substr($tf, 0, 4) != "fws_" && substr($tf, 0, 2) != "s_" && $i < 10) {
        if (in_array($tf, $ck)) {
            $tf = $c[$tf];
        } else {
            $tf = 0;
        }
        $i++;
        file_put_contents("o_ta", "\n\n" . date("Y-m-d H:i:s") . "> " . json_encode(array("in loop ", $tf, $i)) . "\n", FILE_APPEND);
    }
    file_put_contents("o_ta", "\n\n" . date("Y-m-d H:i:s") . "> " . json_encode(array($tf, $jo)) . "\n", FILE_APPEND);
    return $tf;
}
