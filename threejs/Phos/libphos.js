import { f_tank, f_target } from '../tank.js';

// export { Phos };



function Phos()
{
var $ = this;
// this.S = [];

$.S = [];

var S = $.S;

var $SL = [],
    $xk;
    
    
function fgl_cl() { // cell
    var RC=S.pop();
    S.push( document.getElementById( "c_"+RC  ).innerHTML );
}

function f_oe() // Object.entries()
{
    S.push( Object.entries( S.pop() ) );
}

function f_cells() // T cells: T.cells
{
    S.push( S.pop().cells );
}

function f_slice() // T cells: T.cells
{
    var j = S.pop();
    var i = S.pop();
    var A = S.pop()
    S.push( A.slice( i, j ) );
}



function getElementByXpath(path) {
  return document.evaluate(path, document, null, XPathResult.FIRST_ORDERED_NODE_TYPE, null).singleNodeValue;
}

function fgl_gex() // getElementByXpath
{
    S.push( getElementByXpath( S.pop() ) );
}

function fgl_it() // innerText
{
    var E = S.pop();
    S.push( E.innerText );
}

function ROW(T, R)
{
// C=CL.charCodeAt(0)-65
// R=parseInt(CL.charAt(1))-1
return T.rows[R]
}

function f_row()
{
    var R = S.pop();
    var T = S.pop();
    S.push( T.rows[R] );
}

function fgl_sa() { // setAttribute
    
    var a = S.pop();
    var v = S.pop();
    var t = S.pop();
    t.setAttribute(a, v);
    S.push( t ); 
}



function fgl_ce() {
    // var tag = document.createElement("p");
    S.push( document.createElement( S.pop() ) ); 
}
   
function fgl_ctn() {
    S.push( document.createTextNode( S.pop() ) ); 
}   

function fgl_getn() {
    S.push( document.getElementsByTagName( S.pop() ) ); 
}   

function fgl_geid() {
    this.S.push( document.getElementById( S.pop() ) ); 
}   

this.fgl_geid = function () {

    // var S = this.S; // declare scope == PHP global $S;
    // var S = this.S;

    console.log("  in this.fgl_geid ");
    // this.S.push( document.getElementById( this.S.pop() ) );
    S.push( document.getElementById( S.pop() ) ); 
}   

$.f_geid = function() 
{

    // var S = this.S; // declare scope == PHP global $S;
    // var S = this.S;

    console.log("  in this.fgl_geid ");
    // this.S.push( document.getElementById( this.S.pop() ) );
    S.push( document.getElementById( S.pop() ) ); 
}   

$.f_gex = function() // getElementByXpath
{
    S.push( getElementByXpath( S.pop() ) );
}


function fgl_i(){
    var a = S.pop();
    var b = S.pop();
    S.push( b[a] );
}

   
function fgl_ac() {
    var child = S.pop();
    var parent = S.pop();
    parent.appendChild( child );
    S.push( parent );
}   


function count(a) {
    return a.length;
}
function fgl_explode() {
    S.push(explode(S.pop(), S.pop()));
}
function fgl_now() {
    var d = new Date();
    S.push(d.toISOString());
}
function fgl_colon() {
    S.push(':');
}
function fgl_timeout() {
    setTimeout(eval("fgl_now"), S.pop());
    console.log("2019 1217 1421");
}
function func_num_args() {
}

// 2020-09-12 B = Back End
function B() {
    console.log( arguments );

    F("nxhr: phos.php xo: xsqrh:")
    // sets up ajax connection

    F( arguments[0], "je: xsend:" )
    // sends Phos commands from browser front end to back end via ajax 

}

function CHAT(target, msg)
{

    var d = new Date();
    console.log(d.toISOString());
    // console.log( {msg: [ {target: target}, {msg: msg} ] } );
    // console.log( {target: target, msg: msg}  )
    var j = {to: target, msg: msg}
    // return JSON.stringify({msg: [ {target: target}, {msg: msg} ] })
    
    B(btoa(JSON.stringify(j)) +" chat")
    // return JSON.stringify({target: target, msg: msg}  )
}

function U(j) // Update, U of CRUD
{
    var d = new Date();
    console.log(d.toISOString());

    // var j = {msg: msg}
    
    B(btoa(JSON.stringify(j)) +" update")
}

// 2020-09-18 onreadystatechange
function BX() {
    console.log( arguments );

    F("nxhr: phos.php xo: xsqrh:")
    // sets up ajax connection

    F( arguments[0], "je: xsend:" )
    // sends Phos commands from browser front end to back end via ajax 

}

function B_AUTH(c) {
    console.log( arguments );

    F("nxhr: phos.php xo: xsqrh:")
    // sets up ajax connection

    t = S.length - 1;    
    ajax=S[t]
    S[t].onreadystatechange = function() {
        if (ajax.readyState==4 && ajax.status==200) {
            console.log(ajax.responseText);
            
            console.log(c.decrypt(ajax.responseText));
            
            B(c.decrypt(ajax.responseText)+" AUTH gsv: SP i: cmp: 0 ifeq: auth_pass b")
            
        }
    }
    
    F(btoa(c.getPublicKey()) +' req_auth', "je: xsend:" )

}



// 2020-09-12 F = Front End
// function F() {   // push args 0 .... [N-2] execute arguments[N-1] convenient for adding string

this.F = function() { 
    var e;
    var $count = 0;
    if (func_num_args() == 0) {
        return false;
    } else {
        for (var $i = 0; $i < arguments.length - 1; $i++) {
            e = arguments[$i];
            S.push(e);
        }
        this.FGL(arguments[$i]);
    }
}
function fgl_b64e() {
    S.push(btoa(S.pop()));
}
function fgl_je() {
    S.push(JSON.stringify(S.pop()));
}
function fgl_dup() {
    S.push(end(S));
}

function fgl_swap() {
    var a = S.pop();
    var b = S.pop();
    S.push(a);
    S.push(b);
}

function fgl_l() {
    $S = S;
    $SL[array_pop($S)] = $xk;
}
function end(a) {
    return a[a.length - 1];
}

//function function_exists(f) {   // in this.FGL calls function_exists() is global, not local, hence this is undefined?
this.function_exists = function(f) {
    return (eval("typeof " + f) === "function");
}
function is_array(f) {
    return (typeof f === "object");
}
function isset(f) {
    return (typeof f === "undefined");
}
function substr(s, n, l) {
    return s.substr(n, l);
}
function fgl_ne() {
    $S = S;
    $n = array_pop($S);
    if ($n == 0) {
        e = eval("return " + array_pop($S) + "();");
        S.push(e);
    } else {
        if (0) {
            $s = array_pop($S) + "(" + "array_pop(\$S)";
            while ($n-- > 1) {
                $s = $s + ", " + "array_pop(\$S)";
            }
            e = eval("return " + $s + ");");
            S.push(e);
        } else {
            $s = array_pop($S) + "(" + array_pop($S);
            while ($n-- > 1) {
                $s = $s + ", " + "array_pop(\$S)";
            }
            console.log($s);
            e = eval($s + ")");
            S.push(e);
        }
    }
}
function ord(n) {
    return n.charCodeAt(0);
}
function strlen(s) {
    return s.length;
}
function in_array(e, a) {
    return (a.indexOf(e) != -1);
}
function array_keys(a) {
    return Object.keys(a);
}
function array_pop(s) {
    return s.pop();
}
function explode(c, a) {
    var s;
    s = a.split(c);
    return s;
}
function preg_replace(p, r, a) {
    return a.replace(p, r);
}
function fgl_nxhr() {
    S.push(new XMLHttpRequest());
}
function fgl_xo() {
    var a = S.pop();
    var xmlhttp = end(S);
    xmlhttp.open("POST", a, true);
}
function fgl_xsrqh() {
    var xmlhttp = end(S);
    xmlhttp.setRequestHeader("Content-type", "application/json");
}
function fgl_xsend() {
    var a = S.pop();
    var xmlhttp = end(S);
    xmlhttp.send(a);
}
function trim(a) {
    return a.trim();
}
function fgl_cl() {
    console.log(S.pop());
}
function fgl_s() {
    console.log(S);
}
function preProc(str) {
    S.push(str);
    fgl_xs();
    sa = S.pop();
    str1 = JSON.stringify(sa);
    alert('preProc ' + str1 + ' sa ' + sa + ' str ' + str);
    if (str.length == 0) {
        document.getElementById("txtHint").innerHTML = "";
        return;
    } else {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                alert("postProc_g() " + this.responseText);
                postProc_g(this.responseText);
            }
        };
        xmlhttp.open("POST", "fgl_ajax.php", true);
        xmlhttp.setRequestHeader("Content-type", "application/json");
        id = "rpbox";
        xmlhttp.send(str1);
    }
}
var $CDW = {}, // $CDW=[], {} [] are different in JavaScript, same in PHP
    // S = [],
    $v, s0 = "";

// function FGL($a) { // when this function gets called, the scope is global, hence variable scope is also global, so it ignores this.S ??

this.FGL = function($a) { 

    var S = this.S;
    console.log(S);

    s0 = preg_replace('/\s+/', ' ', $a);
    var $a = explode(' ', trim(s0));
    var $SS = [],
        $xl = 0;
    var $xk = 0;
    var $xs = $a;
    var $xl = count($a);
    var $vk = $xk;
    var $Z = $xl;
    S.push($vk);
    var $t = array_pop(S);
    var $CC = $t[0];
    do {
        $vk = $xk;
        $v = trim($xs[$xk]);
        if (in_array($v, array_keys($CDW))) {
            $WA = $CDW[$v];
            array_pop($WA);
            FGLA($WA);
        } else if ($v == ">:" || $v == "<:") {
            S.push($v);
        } else {
            var $l = strlen($v);
            if ($v[0] == ":" && $l == 1) {
            
                // 2020-09-29
                console.log("colon definition");
            
                $xk++;
                $vk = $xk;
                $v = trim($xs[$xk]);
                console.log("  v ", $v);
                
                $CDW[$v] = [];
                $w0 = $v;
                $xk++;
                do {
                    $vk = $xk;
                    $v = trim($xs[$xk]);
                    $CDW[$w0].push($v);
                    $l = strlen($v);
                    if ($v[0] == ";" && $l == 1) {
                        break;
                    }
                    $xk++;
                } while (1);
            } else if ($v[$l - 1] == ":") {
                $l = strlen($v);
                var $fn = substr($v, 0, $l - 1);
                
                console.log("typeof this "+typeof this);
                console.log(eval("typeof this.fgl_" + $fn) + " function exists " + $fn +" "+ $.function_exists("this.fgl_" + $fn));
                if (eval("typeof this.fgl_" + $fn) === "function") {
                // if (function_exists("this.fgl_" + $fn)) {
                    console.log("this.fgl_" + $fn + " function exists ");
                    eval("this.fgl_" + $fn + "()");
                }
                else if (eval("typeof this.f_" + $fn) === "function") {
                // if (function_exists("this.fgl_" + $fn)) {
                    console.log("this.f_" + $fn + " function exists ");
                    eval("this.f_" + $fn + "()");
                }
                else if ($.function_exists("f_" + $fn)) {
                    console.log("f_" + $fn + " function exists ");
                    eval("f_" + $fn + "()");
                }                
                else if ($.function_exists("fgl_" + $fn)) {
                    eval("fgl_" + $fn + "()");
                    if (is_array(end(S))) {
                        $va = end(S);
                        if (isset($va[0]))
                            if ($va[0] == "prg_ctr") {
                                $va = array_pop(S);
                                $vk = $va[1];
                                $xk = $vk;
                            }
                    }
                } else if (in_array($fn + ":", array_keys($CDW))) {
                    $WA = $CDW[$fn + ":"];
                    array_pop($WA);
                    FGLA($WA);
                } else if ($fn == "r") {
                    $s = array_pop(S);
                    S.push(implode(' ', array_slice($xs, $xk + 1)));
                    S.push('$S[]=$' + $s + '; ');
                    S.push(':r:');
                    fgl_s();
                } else if ($fn == "v") {
                    $sa = array_pop(S);
                    $sb = array_pop(S);
                    S.push(implode(' ', array_slice($xs, $xk + 1)));
                    S.push('$' + $sa + '=' + $sb + '; ');
                    S.push(':v:');
                    fgl_s();
                } else if ($fn == "a") {
                    $sa = array_pop(S);
                    $sc = count(S);
                    $se = S[$sc - $sa];
                    for ($si = 0; $si < $sa; $si++) {
                    }
                    $sb = array_pop(S);
                    S.push(implode(' ', array_slice($xs, $xk + 1)));
                    S.push('$' + $sa + '=' + $sb + '; ');
                    S.push(':v:');
                    fgl_s();
                } else if ($fn == "count") {
                    fgl_s();
                    S.push('$S[]=count(' + array_pop(S) + '); ');
                } else if ($fn == "bz") {
                    fgl_s();
                    $bx = array_pop(S);
                    if (array_pop(S) == 0) $xk = $bx;
                    continue;
                } else if ($fn == "bnz") {
                    $bx = $SL[array_pop($S)];
                    fgl_dup();
                    if (array_pop(S) != 0) {
                        $xk = $bx + 1;
                        continue;
                    }
                } else {}
            } else {
                if (ord($v) == 0);
                else
                if ($v[0] == '_') {
                    if ($v == '_') S.push($v);
                } else {
                    if ($v == '.s') {
                        fgl_s();
                    } else {
                        if ($v == '-') {
                            $sa = array_pop(S);
                            $sb = array_pop(S);
                            S.push($sb - $sa);
                        } else if ($v == '+') {
                            console.log(' < in + >');
                            var $sa = array_pop(S);
                            var $sb = array_pop(S);
                            console.log(' < in + > ' + $sa + ' ' + $sb + ' ' + ($sa + $sb));
                            S.push(parseInt($sb) + parseInt($sa));
                        } else if ($v == '.') {
                            array_pop(S);
                        } else {
                            if ($v == '===') {
                                S.push(array_pop(S) === array_pop(S));
                            } else {
                                S.push($v);
                            }
                        }
                    }
                }
            }
        }
        $xk++;
        if ($xk >= $xl) break;
    }
    while ($vk < $xl);
}
function FGLA($a) {
    console.log($a);
    var $SS = [],
        $xk = 0,
        $xl = 0;
    $xs = $a;
    console.log($xs);
    $xl = count($a);
    $vk = $xk;
    $Z = $xl;
    S.push($vk);
    $t = array_pop(S);
    $CC = $t[0];
    do {
        $vk = $xk;
        $v = trim($xs[$xk]);
        console.log($v + ' vk ' + $vk + ' xl ' + $xl + ' S ' + S);
        if (in_array($v, array_keys($CDW))) {
            $WA = $CDW[$v];
            array_pop($WA);
            FGLA($WA);
        } else if ($v == ">:" || $v == "<:") {
            S.push($v);
        } else {
            $l = strlen($v);
            if ($v[0] == ":" && $l == 1) {
                $xk++;
                $vk = $xk;
                $v = trim($xs[$xk]);
                $CDW[$v] = [];
                $w0 = $v;
                $xk++;
                do {
                    $vk = $xk;
                    $v = trim($xs[$xk]);
                    $CDW[$w0].push($v);
                    $l = strlen($v);
                    if ($v[0] == ";" && $l == 1) {
                        break;
                    }
                    $xk++;
                } while (1);
            } else if ($v[$l - 1] == ":") {
                $l = strlen($v);
                $fn = substr($v, 0, $l - 1);
                console.log(function_exists("fgl_" + $fn) + ' ' + ("fgl_" + $fn));
                if (function_exists("fgl_" + $fn)) {
                    eval("fgl_" + $fn + "()");
                    if (is_array(end(S))) {
                        $va = end(S);
                        if (isset($va[0]))
                            if ($va[0] == "prg_ctr") {
                                $va = array_pop(S);
                                $vk = $va[1];
                                $xk = $vk;
                            }
                    }
                } else if (in_array($fn + ":", array_keys($CDW))) {
                    $WA = $CDW[$fn + ":"];
                    array_pop($WA);
                    FGLA($WA);
                } else if ($fn == "r") {
                    $s = array_pop(S);
                    S.push(implode(' ', array_slice($xs, $xk + 1)));
                    S.push('$S[]=$' + $s + '; ');
                    S.push(':r:');
                    fgl_s();
                } else if ($fn == "v") {
                    $sa = array_pop(S);
                    $sb = array_pop(S);
                    S.push(implode(' ', array_slice($xs, $xk + 1)));
                    S.push('$' + $sa + '=' + $sb + '; ');
                    S.push(':v:');
                    fgl_s();
                } else if ($fn == "a") {
                    $sa = array_pop(S);
                    $sc = count(S);
                    $se = S[$sc - $sa];
                    for ($si = 0; $si < $sa; $si++) {
                    }
                    $sb = array_pop(S);
                    S.push(implode(' ', array_slice($xs, $xk + 1)));
                    S.push('$' + $sa + '=' + $sb + '; ');
                    S.push(':v:');
                    fgl_s();
                } else if ($fn == "count") {
                    fgl_s();
                    S.push('$S[]=count(' + array_pop(S) + '); ');
                } else if ($fn == "bz") {
                    fgl_s();
                    $bx = array_pop(S);
                    if (array_pop(S) == 0) $xk = $bx;
                    continue;
                } else if ($fn == "bnz") {
                    $bx = $SL[array_pop($S)];
                    fgl_dup();
                    if (array_pop(S) != 0) {
                        $xk = $bx + 1;
                        continue;
                    }
                } else {}
            } else {
                if (ord($v) == 0);
                else
                if ($v[0] == '_') {
                    if ($v == '_') S.push($v);
                } else {
                    if ($v == '.s') {
                        fgl_s();
                    } else {
                        if ($v == '-') {
                            $sa = array_pop(S);
                            $sb = array_pop(S);
                            S.push($sb - $sa);
                        } else if ($v == '+') {
                            console.log(' < in + >');
                            $sa = array_pop(S);
                            $sb = array_pop(S);
                            console.log(' < in + > ' + $sa + ' ' + $sb + ' ' + ($sa + $sb));
                            S.push(parseInt($sb) + parseInt($sa));
                        } else if ($v == '.') {
                            array_pop(S);
                        } else {
                            if ($v == '===') {
                                S.push(array_pop(S) === array_pop(S));
                            } else {
                                S.push($v);
                            }
                        }
                    }
                }
            }
        }
        $xk++;
        if ($xk >= $xl) break;
    }
    while ($vk < $xl);
}

}

window.Phos = Phos;
