
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

The Phoscript code to achieve this is described below：

1. Display the Colon Definition Words array in json string format:
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

```js
{
"h0":["hello","enl:",";"],
"h1":["there","enl:",";"],
"h2":["general","enl:",";"],
"h3":["kenobi","enl:",";"],
"g_hello":["h0","h1",";"],
"g_kenobi":["h0","h1","h2","h3",";"]
}
```

- Explanation
  - `cdw:` loads `$CDW` array to data stack `$S`.
  - `je:` converts TOS (top of stack item) using `json_encdoe()`.
  - `s:` displays all items on the stack `$S`.


2. Add `h2` and `h3` to `g_hello`:
```
php phos.php \
: h0 hello   enl: \; \
: h1 there   enl: \; \
: h2 general enl: \; \
: h3 kenobi  enl: \; \
\
: g_hello  h0 h1 \; \
: g_kenobi h0 h1 h2 h3 \; \
cdw: =g_hello cdwka: av: 0 i: s: \
=h2 dc0: ap: asw: \
=h3 dc0: ap: asw: \
s:
```

<img src="https://github.com/udexon/GEISHA/blob/main/img/g_append_hello.png" width=600>

- Explanation
  - `cdw:` loads `$CDW` array to data stack `$S`.
  - `=g_hello cdwka:` extracts colon definition of `g_hello`. `=` is an escape character to prevent execution of `g_hello`.
  - `av:` executes `array_values()`.
  - `0 i:` extracts first element of array.
  - `s:` displays data stack `$S`.

- At this point, `$S` is:
```
fgl_s 298 < 3 > array ( 0 => 'phos.php', 1 => array ( 'h0' => array ( 0 => 'hello', 1 => 'enl:', 2 => ';', ), 'h1' => array ( 0 => 'there', 1 => 'enl:', 2 => ';', ), 'h2' => array ( 0 => 'general', 1 => 'enl:', 2 => ';', ), 'h3' => array ( 0 => 'kenobi', 1 => 'enl:', 2 => ';', ), 'g_hello' => array ( 0 => 'h0', 1 => 'h1', 2 => ';', ), 'g_kenobi' => array ( 0 => 'h0', 1 => 'h1', 2 => 'h2', 3 => 'h3', 4 => ';', ), ), 2 => array ( 0 => 'h0', 1 => 'h1', 2 => ';', ), )
```
- TOS is:
  - `2 => array ( 0 => 'h0', 1 => 'h1', 2 => ';', ), )`

- Further operations:
  - `=h2 dc0: ap: asw:` adds `h2` to TOS.
  - `=h3 dc0: ap: asw:` adds `h3` to TOS.
    - `=h2 dc0:` drops first character of `=h2`. `=` is an escape character to prevent executing `h2`.
    - `ap:` appends `h2` to TOS.
    - `asw:` swaps last two elements of array, as `;` is the last element.
    
- Finally, `$S` is:
```
fgl_s 298 < 3 > array ( 0 => 'phos.php', 1 => array ( 'h0' => array ( 0 => 'hello', 1 => 'enl:', 2 => ';', ), 'h1' => array ( 0 => 'there', 1 => 'enl:', 2 => ';', ), 'h2' => array ( 0 => 'general', 1 => 'enl:', 2 => ';', ), 'h3' => array ( 0 => 'kenobi', 1 => 'enl:', 2 => ';', ), 'g_hello' => array ( 0 => 'h0', 1 => 'h1', 2 => ';', ), 'g_kenobi' => array ( 0 => 'h0', 1 => 'h1', 2 => 'h2', 3 => 'h3', 4 => ';', ), ), 2 => array ( 0 => 'h0', 1 => 'h1', 2 => 'h2', 3 => 'h3', 4 => ';', ), )
```
- TOS is:
```
2 => array ( 0 => 'h0', 1 => 'h1', 2 => 'h2', 3 => 'h3', 4 => ';', )
```

We shall stop here and let readers figure out how to put this array into `$CDW`, the global array for Colon Definition Words.

Phoscript and Forth simplifies programming and metaprogramming by removing the list of parameters from the function definition, as the stack machine mechanisms handle them elegantly. This perhaps removes the biggest obstacle in metaprogramming.
