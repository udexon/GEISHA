### B. 

- B1. In this section, we use GEISHA(0)/G0 to analyze 2 simple programs:
  - Program g_hello: `print "hello\n" "there\n"`
  - Program g_kenobi: `print "hello\n" "there\n" "general\n" "kenobi\n"`

1. Program g_hello: print "hello\n" "there\n"
- Phoscript:
```
php phos.php \
: g_hello hello enl: there enl: \; \
g_hello
```
<img src="https://github.com/udexon/GEISHA/blob/main/img/g_hello.png" width=600>

- PHP:
```php
<?php

enl("hello");
enl("there");

function enl($s)
{
    echo $s."\n";
}
```
<img src="https://github.com/udexon/GEISHA/blob/main/img/g_hello_php.png" width=600>


2. Program g_kenobi: print "hello\n" "there\n" "general\n" "kenobi\n"
- Phoscript:
```
php phos.php \
: g_kenobi hello enl: there enl: general enl: kenobi enl: \; \
g_kenobi
```
<img src="https://github.com/udexon/GEISHA/blob/main/img/g_kenobi.png" width=600>

- PHP:
```php
<?php

enl("hello");
enl("there");
enl("general");
enl("kenobi");

function enl($s)
{
    echo $s."\n";
}
```
<img src="https://github.com/udexon/GEISHA/blob/main/img/g_kenobi_php.png" width=600>

- B2. Let us consider the task given to a programmer, to simply extend `g_hello` to `g_kenobi`.

We believe the readers would agree that any programmer with minimal competence KNOWS how to do it.

- _However, is it possible to describe this task (B2) in code?_

So, this is the secret of metaprogramming &mdash; _to write a piece of code that describes the process of producing another piece of code_.

Here, Phoscript, derived from Forth, provides a solution.

Consider the "colon definition" for `g_hello` and `g_kenobi`:
```
: g_hello hello enl: there enl: \; \
: g_kenobi hello enl: there enl: general enl: kenobi enl: \; \
```

Let us further simplify the code above:
```
: h0 hello   enl: \; \
: h1 there   enl: \; \
: h2 general enl: \; \
: h3 kenobi  enl: \; \
\
: g_hello  h0 h1 \; \
: g_kenobi h0 h1 h2 h3 \; \
```

So the solution for task B2 is, in pseudocode:
```
append h2 h3 to g_hello
```

We shall not over-complicate the discussions for now with the detailed internal structure of Phoscript PHP where the colon definition words (CDW) are kept in an array. We shall satisfy ourselves with a solution in the form of psedocode, and we invite interested readers to work out the complete solution, which we shall explain in a future tutorial.

Phoscript and Forth simplifies programming and metaprogramming by removing the list of parameters from the function definition, as the stack machine mechanisms handle them elegantly. This perhaps removes the biggest obstacle in metaprogramming.


```
php phos.php \
: h0 hello   enl: \; \
: h1 there   enl: \; \
: h2 general enl: \; \
: h3 kenobi  enl: \; \
\
: g_hello  h0 h1 \; \
: g_kenobi h0 h1 h2 h3 \; \
cdw: je: s:
```

<img src="https://github.com/udexon/GEISHA/blob/main/img/g_hello_cdw.png" width=600>
