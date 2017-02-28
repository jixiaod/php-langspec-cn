#语法结构

##脚本

[脚本]（04-basic-concepts.md＃program-structure）是一个有序的字符序列。通常，
脚本与文件系统中的文件是一一对应关系，但是这种对应不是必需的。

从概念上讲，使用以下步骤翻译脚本：

1. 转换，转换从特定字符的脚本汇编和编码方案转换为8位字符序列。

2. 词汇分析，将输入字符流转换成一个令牌流。

3. 语法分析，将令牌流转换成可执行代码。

一致性实现必须接受使用UTF-8编码的脚本编码形式（由Unicode标准定义），并对它们进行变换
转换为字符序列。实现可以选择接受和变换附加字符编码方案。


##语法

本规范显示了使用两个语法的PHP编程语言的语法。词法语法定义源字符如何组合以形成空格，注释和令牌。语法语法定义了所得到的令牌如何组合以形成PHP程序。

使用语法生成来呈现语法，每个语法定义非终端符号和该非终端符号可能扩展成非终端或终端符号的序列。在制作中，非终端符号以这样的倾斜类型示出，并且终端符号以这样的固定宽度字体示出。

语法生产的第一行是定义的非终端符号的名称，后面是用于语法语法生成的一个冒号，以及用于词法语法生成的两个冒号。每个相继的缩进线包含作为非终端或终端符号序列给出的非终端的可能扩展。例如，生产：


<!-- GRAMMAR
single-line-comment-example::
  '//' input-characters?
  '#' input-characters?
-->

<pre>
<i id="grammar-single-line-comment-example">single-line-comment-example::</i>
   //   <i><a href="#grammar-input-characters">input-characters</a></i><sub>opt</sub>
   #   <i><a href="#grammar-input-characters">input-characters</a></i><sub>opt</sub>
</pre>

将词法语法生产单行注释定义为终端`//`或`＃`，后跟可选的输入字符。 每个扩展单独列出。

尽管替换方案通常在单独的行上列出，但是当存在大数量时，简写短语“一个”可以在单个行上给出的扩展列表之前。 例如，

<!-- GRAMMAR
hexadecimal-digit-example:: one of
  '0' '1' '2' '3' '4' '5' '6' '7' '8' '9'
  'a' 'b' 'c' 'd' 'e' 'f'
  'A' 'B' 'C' 'D' 'E' 'F'
-->

<pre>
<i id="grammar-hexadecimal-digit-example">hexadecimal-digit-example:: one of</i>
   0   1   2   3   4   5   6   7   8   9
   a   b   c   d   e   f
   A   B   C   D   E   F
</pre>

##词法分析

###概述

生产*输入文件*是脚本的词法结构的根本。 每个脚本必须符合此生产。

**语法**

<!-- GRAMMAR
input-file::
  input-element
  input-file input-element

input-element::
  comment
  white-space
  token
-->

<pre>
<i id="grammar-input-file">input-file::</i>
   <i><a href="#grammar-input-element">input-element</a></i>
   <i><a href="#grammar-input-file">input-file</a></i>   <i><a href="#grammar-input-element">input-element</a></i>

<i id="grammar-input-element">input-element::</i>
   <i><a href="#grammar-comment">comment</a></i>
   <i><a href="#grammar-white-space">white-space</a></i>
   <i><a href="#grammar-token">token</a></i>
</pre>

**语义**

脚本的基本元素是注释，空格和符号。

脚本的词法处理涉及减少该脚本
成为成为输入的[tokens](#tokens)序列
句法分析。 令牌可以由[空格]（#white-space）和
delimited [comments](#comments)。

词法处理总是导致创建最长的
可能的词汇元素。 （例如，`$a+++++$b`必须解析为
`$a++ ++ +$b`，在语法上无效）。


###注释

支持两种形式的注释：*分隔注释*和*单行注释*。

**语法**

<!-- GRAMMAR
comment::
  single-line-comment
  delimited-comment

single-line-comment::
  '//' input-characters?
  '#' input-characters?

input-characters::
  input-character
  input-characters input-character

input-character::
  "Any source character except" new-line

new-line::
  "Carriage-return character (U+000D)"
  "Line-feed character (U+000A)"
  "Carriage-return character (U+000D) followed by line-feed character (U+000A)"

delimited-comment::
  '/*' "No characters or any source character sequence except */" '*/'
-->

<pre>
<i id="grammar-comment">comment::</i>
   <i><a href="#grammar-single-line-comment">single-line-comment</a></i>
   <i><a href="#grammar-delimited-comment">delimited-comment</a></i>

<i id="grammar-single-line-comment">single-line-comment::</i>
   //   <i><a href="#grammar-input-characters">input-characters</a></i><sub>opt</sub>
   #   <i><a href="#grammar-input-characters">input-characters</a></i><sub>opt</sub>

<i id="grammar-input-characters">input-characters::</i>
   <i><a href="#grammar-input-character">input-character</a></i>
   <i><a href="#grammar-input-characters">input-characters</a></i>   <i><a href="#grammar-input-character">input-character</a></i>

<i id="grammar-input-character">input-character::</i>
   Any source character except   <i><a href="#grammar-new-line">new-line</a></i>

<i id="grammar-new-line">new-line::</i>
   Carriage-return character (U+000D)
   Line-feed character (U+000A)
   Carriage-return character (U+000D) followed by line-feed character (U+000A)

<i id="grammar-delimited-comment">delimited-comment::</i>
   /*   No characters or any source character sequence except */   */
</pre>

**语义**

除了在字符串文字或注释中，字符`/*`开始以分隔符注释，以字符`*/`结束。 
除了在字符串文字或注释中，字符`//`或`＃`开始单行注释，以一行结束。 
那个新行不是评论的一部分。 但是，如果单行注释是嵌入脚本中的最后一个
源元素，则可以省略结尾的新行。 （注意：这允许使用`<?php ... // ...?>`）。

分隔的注释可以发生在可能出现空格的脚本中的任何位置。 
(例如;`/*...*/$c/*...*/=/*...*/567/*...*/;/*...*/` 被解析成 `$c=567;`, 
`$k = $i+++/*...*/++$j;` 被解析成 `$k = $i+++ ++$j;`).

**实现注意事项**

在标记化期间，实现可以将分隔的注释看作是空白。

###空格

空格由一个或多个的任意组合组成新行，空格和水平制表符。

**语法**

<!-- GRAMMAR
white-space::
  white-space-character
  white-space white-space-character

white-space-character::
  new-line
  "Space character (U+0020)"
  "Horizontal-tab character (U+0009)"
-->

<pre>
<i id="grammar-white-space">white-space::</i>
   <i><a href="#grammar-white-space-character">white-space-character</a></i>
   <i><a href="#grammar-white-space">white-space</a></i>   <i><a href="#grammar-white-space-character">white-space-character</a></i>

<i id="grammar-white-space-character">white-space-character::</i>
   <i><a href="#grammar-new-line">new-line</a></i>
   Space character (U+0020)
   Horizontal-tab character (U+0009)
</pre>

**语义**

空格和水平制表符视为*水平空格字符*。

###符号

####概述

有几种源*符号*：

**语法**

<!-- GRAMMAR
token::
  variable-name
  name
  keyword
  integer-literal
  floating-literal
  string-literal
  operator-or-punctuator
-->

<pre>
<i id="grammar-token">token::</i>
   <i><a href="#grammar-variable-name">variable-name</a></i>
   <i><a href="#grammar-name">name</a></i>
   <i><a href="#grammar-keyword">keyword</a></i>
   <i><a href="#grammar-integer-literal">integer-literal</a></i>
   <i><a href="#grammar-floating-literal">floating-literal</a></i>
   <i><a href="#grammar-string-literal">string-literal</a></i>
   <i><a href="#grammar-operator-or-punctuator">operator-or-punctuator</a></i>
</pre>

###名称

**语法**

<!-- GRAMMAR
variable-name::
  '$' name

namespace-name::
  name
  namespace-name '\' name

namespace-name-as-a-prefix::
  '\'
  '\'? namespace-name '\'
  'namespace' '\'
  'namespace' '\' namespace-name '\'

qualified-name::
  namespace-name-as-a-prefix? name

name::
  name-nondigit
  name name-nondigit
  name digit

name-nondigit::
  nondigit
  "one of the characters U+0080–U+00ff"

nondigit:: one of
  '_'
  'a' 'b' 'c' 'd' 'e' 'f' 'g' 'h' 'i' 'j' 'k' 'l' 'm'
  'n' 'o' 'p' 'q' 'r' 's' 't' 'u' 'v' 'w' 'x' 'y' 'z'
  'A' 'B' 'C' 'D' 'E' 'F' 'G' 'H' 'I' 'J' 'K' 'L' 'M'
  'N' 'O' 'P' 'Q' 'R' 'S' 'T' 'U' 'V' 'W' 'X' 'Y' 'Z'
-->

<pre>
<i id="grammar-variable-name">variable-name::</i>
   $   <i><a href="#grammar-name">name</a></i>

<i id="grammar-namespace-name">namespace-name::</i>
   <i><a href="#grammar-name">name</a></i>
   <i><a href="#grammar-namespace-name">namespace-name</a></i>   \   <i><a href="#grammar-name">name</a></i>

<i id="grammar-namespace-name-as-a-prefix">namespace-name-as-a-prefix::</i>
   \
   \<sub>opt</sub>   <i><a href="#grammar-namespace-name">namespace-name</a></i>   \
   namespace   \
   namespace   \   <i><a href="#grammar-namespace-name">namespace-name</a></i>   \

<i id="grammar-qualified-name">qualified-name::</i>
   <i><a href="#grammar-namespace-name-as-a-prefix">namespace-name-as-a-prefix</a></i><sub>opt</sub>   <i><a href="#grammar-name">name</a></i>

<i id="grammar-name">name::</i>
   <i><a href="#grammar-name-nondigit">name-nondigit</a></i>
   <i><a href="#grammar-name">name</a></i>   <i><a href="#grammar-name-nondigit">name-nondigit</a></i>
   <i><a href="#grammar-name">name</a></i>   <i><a href="#grammar-digit">digit</a></i>

<i id="grammar-name-nondigit">name-nondigit::</i>
   <i><a href="#grammar-nondigit">nondigit</a></i>
   one of the characters U+0080–U+00ff

<i id="grammar-nondigit">nondigit:: one of</i>
   _
   a   b   c   d   e   f   g   h   i   j   k   l   m
   n   o   p   q   r   s   t   u   v   w   x   y   z
   A   B   C   D   E   F   G   H   I   J   K   L   M
   N   O   P   Q   R   S   T   U   V   W   X   Y   Z
</pre>

**语义**

名称用于标识以下内容：[常量](06-constants.md#general)，[变量](07-variables.md#general)，
[标签](11-statements.md#labeled-statements)，[函数](13-functions.md#function-definitions)，
[类](14-classes.md#class-declarations)，[类成员](14-classes.md#class-members)，
[接口](15-interfaces.md#interface-declarations)，[traits](16-traits.md#general)，
[命名空间](18-namespaces.md#general)和[heredoc](#heredoc-string-literals)和[nowdoc](#nowdoc-string-literals)注释中的名称。

名称以下划线(_)，名称无引号或扩展名称字符开头，范围为U+0080–-U+00ff。后续字符也可以包括数字。变量名是带有前导美元($)的名称。

除非另有说明（[函数](13-functions.md#function-definitions)，[类](14-classes.md#class-declarations)，[方法](14-classes.md#methods)，[接口](15-interfaces.md#interface-declarations)，[traits](16-traits.md#trait-declarations)，[命名空间](18-namespaces.md#defining-namespaces)），名称区分大小写，并且名称中的每个字符都是重要的。

以两个下划线(__)开头的名称由PHP语言保留，不应由用户代码定义。

以下名称不能用作类，接口或traits的名称：`bool`，`FALSE`，`float`，`int`，`NULL`，`string`，`TRUE`，`iterable`和`void`。

以下名称保留供将来使用，不应用作类，接口或traits的名称：`mixed`, `numeric`, `object`, and `resource`。

除了`class`之外，所有[关键字](#keywords)都可以用作类，接口或trait的成员的名称。但是，`class`可以用作属性或方法的名称。

变量名和函数名（当在函数调用上下文中使用时）不需要定义为源令牌; 他们也可以在创建
运行时使用[简单变量表达式](10-expressions.md#simple-variable). (例如, 给出`$a = "Total"; $b = 3; $c = $b + 5;`, `${$a.$b.$c} = TRUE;`
相当于 `$Total38 = TRUE;`, `${$a.$b.$c}()` 相当于 `Total38()`).

**例子**

```PHP
const MAX_VALUE = 100;
function getData() { /*...*/ }
class Point { /*...*/ }
interface ICollection { /*...*/ }
```

**注意事项**

不建议使用对名称长度的任意限制。

####关键字

*关键字*是保留的名称类字符序列，并且不能用作名称。

**语法**

<!-- GRAMMAR
keyword:: one of
  'abstract' 'and' 'array' 'as' 'break' 'callable' 'case' 'catch' 'class' 'clone'
  'const' 'continue' 'declare' 'default' 'die' 'do' 'echo' 'else' 'elseif' 'empty'
  'enddeclare' 'endfor' 'endforeach' 'endif' 'endswitch' 'endwhile' 'eval' 'exit'
  'extends' 'final' 'finally' 'for' 'foreach' 'function' 'global'
  'goto' 'if' 'implements' 'include' 'include_once' 'instanceof'
  'insteadof' 'interface' 'isset' 'list' 'namespace' 'new' 'or' 'print' 'private'
  'protected' 'public' 'require' 'require_once' 'return' 'static' 'switch'
  'throw' 'trait' 'try' 'unset' 'use' 'var' 'while' 'xor' 'yield' 'yield from'
-->

<pre>
<i id="grammar-keyword">keyword:: one of</i>
   abstract   and   array   as   break   callable   case   catch   class   clone
   const   continue   declare   default   die   do   echo   else   elseif   empty
   enddeclare   endfor   endforeach   endif   endswitch   endwhile   eval   exit
   extends   final   finally   for   foreach   function   global
   goto   if   implements   include   include_once   instanceof
   insteadof   interface   isset   list   namespace   new   or   print   private
   protected   public   require   require_once   return   static   switch
   throw   trait   try   unset   use   var   while   xor   yield   yield from
</pre>

**语义**

关键字不区分大小写。

注意，`yield from` 是一个包含空格的单个符号。 但是，在空格中不允许[注释](#comments)。

此外，所有[*魔术常量*](06-constants.md#context-dependent-constants)也被视为关键字。

####语法

代表一个值的源代码被称作*文本*。[*文本翻译参考*](http://hax.iteye.com/blog/160003)

#####整型文本

**语法**

<!-- GRAMMAR
integer-literal::
  decimal-literal
  octal-literal
  hexadecimal-literal
  binary-literal

decimal-literal::
  nonzero-digit
  decimal-literal digit

octal-literal::
  '0'
  octal-literal octal-digit

hexadecimal-literal::
  hexadecimal-prefix hexadecimal-digit
  hexadecimal-literal hexadecimal-digit

hexadecimal-prefix:: one of
  '0x' '0X'

binary-literal::
  binary-prefix binary-digit
  binary-literal binary-digit

binary-prefix:: one of
  '0b' '0B'

digit:: one of
  '0' '1' '2' '3' '4' '5' '6' '7' '8' '9'

nonzero-digit:: one of
  '1' '2' '3' '4' '5' '6' '7' '8' '9'

octal-digit:: one of
  '0' '1' '2' '3' '4' '5' '6' '7'

hexadecimal-digit:: one of
  '0' '1' '2' '3' '4' '5' '6' '7' '8' '9'
  'a' 'b' 'c' 'd' 'e' 'f'
  'A' 'B' 'C' 'D' 'E' 'F'

binary-digit:: one of
  '0' '1'
-->

<pre>
<i id="grammar-integer-literal">integer-literal::</i>
   <i><a href="#grammar-decimal-literal">decimal-literal</a></i>
   <i><a href="#grammar-octal-literal">octal-literal</a></i>
   <i><a href="#grammar-hexadecimal-literal">hexadecimal-literal</a></i>
   <i><a href="#grammar-binary-literal">binary-literal</a></i>

<i id="grammar-decimal-literal">decimal-literal::</i>
   <i><a href="#grammar-nonzero-digit">nonzero-digit</a></i>
   <i><a href="#grammar-decimal-literal">decimal-literal</a></i>   <i><a href="#grammar-digit">digit</a></i>

<i id="grammar-octal-literal">octal-literal::</i>
   0
   <i><a href="#grammar-octal-literal">octal-literal</a></i>   <i><a href="#grammar-octal-digit">octal-digit</a></i>

<i id="grammar-hexadecimal-literal">hexadecimal-literal::</i>
   <i><a href="#grammar-hexadecimal-prefix">hexadecimal-prefix</a></i>   <i><a href="#grammar-hexadecimal-digit">hexadecimal-digit</a></i>
   <i><a href="#grammar-hexadecimal-literal">hexadecimal-literal</a></i>   <i><a href="#grammar-hexadecimal-digit">hexadecimal-digit</a></i>

<i id="grammar-hexadecimal-prefix">hexadecimal-prefix:: one of</i>
   0x   0X

<i id="grammar-binary-literal">binary-literal::</i>
   <i><a href="#grammar-binary-prefix">binary-prefix</a></i>   <i><a href="#grammar-binary-digit">binary-digit</a></i>
   <i><a href="#grammar-binary-literal">binary-literal</a></i>   <i><a href="#grammar-binary-digit">binary-digit</a></i>

<i id="grammar-binary-prefix">binary-prefix:: one of</i>
   0b   0B

<i id="grammar-digit">digit:: one of</i>
   0   1   2   3   4   5   6   7   8   9

<i id="grammar-nonzero-digit">nonzero-digit:: one of</i>
   1   2   3   4   5   6   7   8   9

<i id="grammar-octal-digit">octal-digit:: one of</i>
   0   1   2   3   4   5   6   7

<i id="grammar-hexadecimal-digit">hexadecimal-digit:: one of</i>
   0   1   2   3   4   5   6   7   8   9
   a   b   c   d   e   f
   A   B   C   D   E   F

<i id="grammar-binary-digit">binary-digit:: one of</i>
   0   1
</pre>

**语义**

使用基数10计算十进制整数文本的值; 那
的八进制整数文本，基数是8; 十六进制整数
文本，基数是16; 二进制整数文本，基数是2。

如果由整数文本表示的值可以适合int类型，
这将是结果值的类型; 否则，类型将是float，
如下所述。

因为负数在PHP中表示为正数的相反数字，最小的负值（32位的-2147483648和64位的-9223372036854775808）
不能表示为十进制整数文本。 如果是非负数
值太大，而不能表示为一个`int`，它将变成`float`，然后加上负号。

使用十六进制，八进制或二进制符号写的文本被认为具有非负值。

整数文本通常是常量表达式。

An integer literal is always a constant expression.

**例子**

```PHP
$count = 10;      // decimal 10

0b101010 >> 4;    // binary 101010 and decimal 4

0XAF << 023;      // hexadecimal AF and octal 23
```

一个使用32位整代表的实现

```
2147483648 -> 2147483648 (too big for int, so is a float)

-2147483648 -> -2147483648 (too big for int, so is a float, negated)

-2147483647 - 1 -> -2147483648 fits in int

0x80000000 -> 2147483648 (too big for int, so is a float)
```

#####浮点型文本

**语法**

<!-- GRAMMAR
floating-literal::
  fractional-literal exponent-part?
  digit-sequence exponent-part

fractional-literal::
  digit-sequence? '.' digit-sequence
  digit-sequence '.'

exponent-part::
  'e' sign? digit-sequence
  'E' sign? digit-sequence

sign:: one of
  '+' '-'

digit-sequence::
  digit
  digit-sequence digit
-->

<pre>
<i id="grammar-floating-literal">floating-literal::</i>
   <i><a href="#grammar-fractional-literal">fractional-literal</a></i>   <i><a href="#grammar-exponent-part">exponent-part</a></i><sub>opt</sub>
   <i><a href="#grammar-digit-sequence">digit-sequence</a></i>   <i><a href="#grammar-exponent-part">exponent-part</a></i>

<i id="grammar-fractional-literal">fractional-literal::</i>
   <i><a href="#grammar-digit-sequence">digit-sequence</a></i><sub>opt</sub>   .   <i><a href="#grammar-digit-sequence">digit-sequence</a></i>
   <i><a href="#grammar-digit-sequence">digit-sequence</a></i>   .

<i id="grammar-exponent-part">exponent-part::</i>
   e   <i><a href="#grammar-sign">sign</a></i><sub>opt</sub>   <i><a href="#grammar-digit-sequence">digit-sequence</a></i>
   E   <i><a href="#grammar-sign">sign</a></i><sub>opt</sub>   <i><a href="#grammar-digit-sequence">digit-sequence</a></i>

<i id="grammar-sign">sign:: one of</i>
   +   -

<i id="grammar-digit-sequence">digit-sequence::</i>
   <i><a href="#grammar-digit">digit</a></i>
   <i><a href="#grammar-digit-sequence">digit-sequence</a></i>   <i><a href="#grammar-digit">digit</a></i>
</pre>

**约束**

浮点文本的值必须可以通过其类型表示。

**语义**

`浮点文本`的类型是`float`。

常量[INF](06-constants.md#core-predefined-constants)和[NAN](06-constants.md#core-predefined-constants)分别提供对无穷大和非数字的浮点值的访问。

浮点数文本总是一个常量表达式。

**例子**

```PHP
$values = array(1.23, 3e12, 543.678E-23);
```

#####字符串文本

**语法**

<!-- GRAMMAR
string-literal::
  single-quoted-string-literal
  double-quoted-string-literal
  heredoc-string-literal
  nowdoc-string-literal
-->

<pre>
<i id="grammar-string-literal">string-literal::</i>
   <i><a href="#grammar-single-quoted-string-literal">single-quoted-string-literal</a></i>
   <i><a href="#grammar-double-quoted-string-literal">double-quoted-string-literal</a></i>
   <i><a href="#grammar-heredoc-string-literal">heredoc-string-literal</a></i>
   <i><a href="#grammar-nowdoc-string-literal">nowdoc-string-literal</a></i>
</pre>

**语义**

字符串文本是以某种方式分隔的零个或多个字符的序列。 分隔符不是文字内容的一部分。

字符串文本的类型是`string`。

######单引号字符串文本

**语法**

<!-- GRAMMAR
single-quoted-string-literal::
  b-prefix? '''' sq-char-sequence? ''''

sq-char-sequence::
  sq-char
  sq-char-sequence sq-char

sq-char::
  sq-escape-sequence
  '\'? "any member of the source character set except single-quote (') or backslash (\)"

sq-escape-sequence:: one of
  '\''' '\\'

b-prefix:: one of
  'b' 'B'
-->

<pre>
<i id="grammar-single-quoted-string-literal">single-quoted-string-literal::</i>
   <i><a href="#grammar-b-prefix">b-prefix</a></i><sub>opt</sub>   '   <i><a href="#grammar-sq-char-sequence">sq-char-sequence</a></i><sub>opt</sub>   '

<i id="grammar-sq-char-sequence">sq-char-sequence::</i>
   <i><a href="#grammar-sq-char">sq-char</a></i>
   <i><a href="#grammar-sq-char-sequence">sq-char-sequence</a></i>   <i><a href="#grammar-sq-char">sq-char</a></i>

<i id="grammar-sq-char">sq-char::</i>
   <i><a href="#grammar-sq-escape-sequence">sq-escape-sequence</a></i>
   \<sub>opt</sub>   any member of the source character set except single-quote (') or backslash (\)

<i id="grammar-sq-escape-sequence">sq-escape-sequence:: one of</i>
   \'   \\

<i id="grammar-b-prefix">b-prefix:: one of</i>
   b   B
</pre>

**语义**

A single-quoted string literal is a string literal delimited by
single-quotes (`'`, U+0027). The literal can contain any source character except
single-quote (`'`) and backslash (`\\`), which can only be represented by
their corresponding escape sequence.

The optional *b-prefix* is reserved for future use in dealing with
so-called *binary strings*. For now, a *single-quoted-string-literal*
with a *b-prefix* is equivalent to one without.

单引号字符串文本是由单引号(', U+0027)分隔的字符串文字。 文本可以包含除单引号(')和反斜杠(\\)之外的任何源字符，只能由其相应的转义序列表示。

可选的`b-prefix`保留以供将来在处理所谓的*二进制字符串*时使用。 现在，带有`b-prefix`的单引号字符串文本相当于没有。

单引号字符串文本通常是一个常量表达式。

**例子**

```
'This text is taken verbatim'

'Can embed a single quote (\') and a backslash (\\) like this'
```

######双引号字符串文本

**语法**

<!-- GRAMMAR
double-quoted-string-literal::
  b-prefix? '"' dq-char-sequence? '"'

dq-char-sequence::
  dq-char
  dq-char-sequence dq-char

dq-char::
  dq-escape-sequence
  "any member of the source character set except double-quote ("") or backslash (\)"
  '\' "any member of the source character set except ""\$efnrtvxX or" octal-digit

dq-escape-sequence::
  dq-simple-escape-sequence
  dq-octal-escape-sequence
  dq-hexadecimal-escape-sequence
  dq-unicode-escape-sequence

dq-simple-escape-sequence:: one of
  '\"' '\\' '\$' '\e' '\f' '\n' '\r' '\t' '\v'

dq-octal-escape-sequence::
  '\' octal-digit
  '\' octal-digit octal-digit
  '\' octal-digit octal-digit octal-digit

dq-hexadecimal-escape-sequence::
  '\x' hexadecimal-digit hexadecimal-digit?
  '\X' hexadecimal-digit hexadecimal-digit?

dq-unicode-escape-sequence::
  '\u{' codepoint-digits '}'

codepoint-digits::
   hexadecimal-digit
   hexadecimal-digit codepoint-digits
-->

<pre>
<i id="grammar-double-quoted-string-literal">double-quoted-string-literal::</i>
   <i><a href="#grammar-b-prefix">b-prefix</a></i><sub>opt</sub>   &quot;   <i><a href="#grammar-dq-char-sequence">dq-char-sequence</a></i><sub>opt</sub>   &quot;

<i id="grammar-dq-char-sequence">dq-char-sequence::</i>
   <i><a href="#grammar-dq-char">dq-char</a></i>
   <i><a href="#grammar-dq-char-sequence">dq-char-sequence</a></i>   <i><a href="#grammar-dq-char">dq-char</a></i>

<i id="grammar-dq-char">dq-char::</i>
   <i><a href="#grammar-dq-escape-sequence">dq-escape-sequence</a></i>
   any member of the source character set except double-quote (&quot;) or backslash (\)
   \   any member of the source character set except &quot;\$efnrtvxX or   <i><a href="#grammar-octal-digit">octal-digit</a></i>

<i id="grammar-dq-escape-sequence">dq-escape-sequence::</i>
   <i><a href="#grammar-dq-simple-escape-sequence">dq-simple-escape-sequence</a></i>
   <i><a href="#grammar-dq-octal-escape-sequence">dq-octal-escape-sequence</a></i>
   <i><a href="#grammar-dq-hexadecimal-escape-sequence">dq-hexadecimal-escape-sequence</a></i>
   <i><a href="#grammar-dq-unicode-escape-sequence">dq-unicode-escape-sequence</a></i>

<i id="grammar-dq-simple-escape-sequence">dq-simple-escape-sequence:: one of</i>
   \&quot;   \\   \$   \e   \f   \n   \r   \t   \v

<i id="grammar-dq-octal-escape-sequence">dq-octal-escape-sequence::</i>
   \   <i><a href="#grammar-octal-digit">octal-digit</a></i>
   \   <i><a href="#grammar-octal-digit">octal-digit</a></i>   <i><a href="#grammar-octal-digit">octal-digit</a></i>
   \   <i><a href="#grammar-octal-digit">octal-digit</a></i>   <i><a href="#grammar-octal-digit">octal-digit</a></i>   <i><a href="#grammar-octal-digit">octal-digit</a></i>

<i id="grammar-dq-hexadecimal-escape-sequence">dq-hexadecimal-escape-sequence::</i>
   \x   <i><a href="#grammar-hexadecimal-digit">hexadecimal-digit</a></i>   <i><a href="#grammar-hexadecimal-digit">hexadecimal-digit</a></i><sub>opt</sub>
   \X   <i><a href="#grammar-hexadecimal-digit">hexadecimal-digit</a></i>   <i><a href="#grammar-hexadecimal-digit">hexadecimal-digit</a></i><sub>opt</sub>

<i id="grammar-dq-unicode-escape-sequence">dq-unicode-escape-sequence::</i>
   \u{   <i><a href="#grammar-codepoint-digits">codepoint-digits</a></i>   }

<i id="grammar-codepoint-digits">codepoint-digits::</i>
   <i><a href="#grammar-hexadecimal-digit">hexadecimal-digit</a></i>
   <i><a href="#grammar-hexadecimal-digit">hexadecimal-digit</a></i>   <i><a href="#grammar-codepoint-digits">codepoint-digits</a></i>
</pre>

**语义**

双引号字符串文本是由分隔的字符串文本
双引号(`"`，U+0022)。除了文本可以包含任何源字符
双引号('"')和反斜杠(`\\`)，它们只能用表示
它们相应的转义序列。 某些其他（有时
不可打印）字符也可以表示为转义序列。

可选的*b-prefix*保留以供将来使用
所谓的*二进制字符串*。 现在，一个带有*b-prefix*前缀的
*双引号字符串文字*相当于没有这个前缀。

如所描述的，转义序列表示单字符编码
在下表中：

Escape sequence | Character name | Unicode character
--------------- | --------------| ------
\$  | Dollar sign | U+0024
\"  | Double quote | U+0022
\\  | Backslash | U+005C
\e  | Escape | U+001B
\f  | Form feed | U+000C
\n  | New line | U+000A
\r  | Carriage Return | U+000D
\t  | Horizontal Tab | U+0009
\v  | Vertical Tab | U+000B
\ooo |  1–3-digit octal digit value ooo
\xhh or \Xhh  | 1–2-digit hexadecimal digit value hh
\u{xxxxxx} | UTF-8 encoding of Unicode codepoint U+xxxxxx | U+xxxxxx

在双引号字符串文本中，除非被识别为转义序列的开始，否则反斜杠(\\)将逐个保留。

在双引号字符串文本中，不使用反斜杠(\\)转义的美元($)字符使用下面描述的变量替换规则处理。

`\u{xxxxxx}`转义序列使用大括号中指定的十六进制数字生成Unicode代码点的UTF-8编码。
实现不允许超出 U+10FFFF 的 Unicode 代码点，因为这超出了UTF-8可以编码的范围（参见[RFC 3629](http://tools.ietf.org/html/rfc3629#section-3)）。
如果指定大于 U+10FFFF 的码点，则实现必须出错。实现必须通过`\u`逐字，如果没有后面跟一个开始`{`，但是如果是，
实现必须产生一个错误，如果没有终止`}`或内容不是有效的代码点，不解释它作为一个转义序列。
实现必须支持前导零，但不能支持开头和结尾括号之间的代码点的前导或尾随空格。实现必须
允许不是Unicode标量值的Unicode代码点，例如高和低代理。

无法通过变量替换创建Unicode转义序列。例如，给定`$v = "41"`，`"\u{$v}"`将生成 `"\u41"`，
长度为4的字符串，而`"\u{0$v}"`和`"\u{{$v}}"`包含不合格的Unicode转义序列。


**变量替换**

变量替换遵循以下语法：

<!-- GRAMMAR
string-variable::
  variable-name offset-or-property?
  '${' expression '}'

offset-or-property::
  offset-in-string
  property-in-string

offset-in-string::
  '[' name ']'
  '[' variable-name ']'
  '[' integer-literal ']'

property-in-string::
  '->' name
-->

<pre>
<i id="grammar-string-variable">string-variable::</i>
   <i><a href="#grammar-variable-name">variable-name</a></i>   <i><a href="#grammar-offset-or-property">offset-or-property</a></i><sub>opt</sub>
   ${   <i><a href="10-expressions.md#grammar-expression">expression</a></i>   }

<i id="grammar-offset-or-property">offset-or-property::</i>
   <i><a href="#grammar-offset-in-string">offset-in-string</a></i>
   <i><a href="#grammar-property-in-string">property-in-string</a></i>

<i id="grammar-offset-in-string">offset-in-string::</i>
   [   <i><a href="#grammar-name">name</a></i>   ]
   [   <i><a href="#grammar-variable-name">variable-name</a></i>   ]
   [   <i><a href="#grammar-integer-literal">integer-literal</a></i>   ]

<i id="grammar-property-in-string">property-in-string::</i>
   -&gt;   <i><a href="#grammar-name">name</a></i>
</pre>

*表达式*的工作方式与[简单变量表达式](10-expressions.md#simple-variable)的工作方式相同。

在评估由上述语法定义的变量后，根据[字符串转换规则](08-conversions.md#converting-to-string-type)将其值
转换为字符串，并将其值代入变量替换表达式中的字符串。

由*字符串中的偏移量*和*字符串中的属性*定义的下标或属性访问分别根据[下标运算符](10-expressions.md#subscript-operator)
和[成员访问运算符](10-expressions.md#member-access-operator)的规则来解析。例外是，
在*字符串内的偏移量*被解释为一个字符串文本，即使它没有引号。

如果`$`后的字符序列不作为*名称*解析，并且不以`{`开头，则`$`字符将逐字地解释，并且不执行变量替换。

变量替代也为表达式的评估提供有限的支持。这是通过在一对匹配
大括号(`{...}`)中包含一个表达式来实现的。开头的大括号必须紧跟一个美元(`$`)，
没有任何中间的空格，并且美元必须开始一个变量名。如果不是这样，大括号是逐字
处理的。如果大括号(`{`)被转义，它不会被解释为嵌入表达式的开始，而是逐字解释。

表达式的值根据[字符串转换规则](08-conversions.md#converting-to-string-type)转换
为字符串，并替换为代替替换表达式的字符串。

双引号字符串文字是一个常量表达式，如果它不包含任何变量替换。

**例子**

```PHP
$x = 123;
echo ">\$x.$x"."<"; // → >$x.123<
// -----------------------------------------
$colors = array("red", "white", "blue");
$index = 2;
echo "\$colors[$index] contains >$colors[$index]<\n";
  // → $colors[2] contains >blue<
// -----------------------------------------
class C {
    public $p1 = 2;
}
$myC = new C();
echo "\$myC->p1 = >$myC->p1<\n";  // → $myC->p1 = >2<
```

######Heredoc 字符串文本

**语法**

<!-- GRAMMAR
heredoc-string-literal::
  b-prefix? '<<<' hd-start-identifier new-line hd-body? hd-end-identifier ';'? new-line

hd-start-identifier::
  name
  '"' name '"'

hd-end-identifier::
  name

hd-body::
  hd-char-sequence? new-line

hd-char-sequence::
  hd-char
  hd-char-sequence hd-char

hd-char::
  hd-escape-sequence
  "any member of the source character set except backslash (\)"
  "\ any member of the source character set except \$efnrtvxX or" octal-digit

hd-escape-sequence::
  hd-simple-escape-sequence
  dq-octal-escape-sequence
  dq-hexadecimal-escape-sequence
  dq-unicode-escape-sequence

hd-simple-escape-sequence:: one of
  '\\' '\$' '\e' '\f' '\n' '\r' '\t' '\v'
-->

<pre>
<i id="grammar-heredoc-string-literal">heredoc-string-literal::</i>
   <i><a href="#grammar-b-prefix">b-prefix</a></i><sub>opt</sub>   &lt;&lt;&lt;   <i><a href="#grammar-hd-start-identifier">hd-start-identifier</a></i>   <i><a href="#grammar-new-line">new-line</a></i>   <i><a href="#grammar-hd-body">hd-body</a></i><sub>opt</sub>   <i><a href="#grammar-hd-end-identifier">hd-end-identifier</a></i>   ;<sub>opt</sub>   <i><a href="#grammar-new-line">new-line</a></i>

<i id="grammar-hd-start-identifier">hd-start-identifier::</i>
   <i><a href="#grammar-name">name</a></i>
   &quot;   <i><a href="#grammar-name">name</a></i>   &quot;

<i id="grammar-hd-end-identifier">hd-end-identifier::</i>
   <i><a href="#grammar-name">name</a></i>

<i id="grammar-hd-body">hd-body::</i>
   <i><a href="#grammar-hd-char-sequence">hd-char-sequence</a></i><sub>opt</sub>   <i><a href="#grammar-new-line">new-line</a></i>

<i id="grammar-hd-char-sequence">hd-char-sequence::</i>
   <i><a href="#grammar-hd-char">hd-char</a></i>
   <i><a href="#grammar-hd-char-sequence">hd-char-sequence</a></i>   <i><a href="#grammar-hd-char">hd-char</a></i>

<i id="grammar-hd-char">hd-char::</i>
   <i><a href="#grammar-hd-escape-sequence">hd-escape-sequence</a></i>
   any member of the source character set except backslash (\)
   \ any member of the source character set except \$efnrtvxX or   <i><a href="#grammar-octal-digit">octal-digit</a></i>

<i id="grammar-hd-escape-sequence">hd-escape-sequence::</i>
   <i><a href="#grammar-hd-simple-escape-sequence">hd-simple-escape-sequence</a></i>
   <i><a href="#grammar-dq-octal-escape-sequence">dq-octal-escape-sequence</a></i>
   <i><a href="#grammar-dq-hexadecimal-escape-sequence">dq-hexadecimal-escape-sequence</a></i>
   <i><a href="#grammar-dq-unicode-escape-sequence">dq-unicode-escape-sequence</a></i>

<i id="grammar-hd-simple-escape-sequence">hd-simple-escape-sequence:: one of</i>
   \\   \$   \e   \f   \n   \r   \t   \v
</pre>

**约束**

开始和结束标识符名称必须相同。 在`<<<`和起始标识符之间只允许水平空格。 
在开始标识符和后面的新行之间不允许有空格。 在新行和后面的结束标识符之间
不允许有空格。 除了可选的分号(`;`)之外，在结束标识符和终止该源行的新行之间
不允许有字符 -- 甚至不包括注释或空格。

**语义**

heredoc字符串文本是由"`<<< name`"和"`name`"分隔的字符串文字。 文字可以包含任何源字符。 
某些其他（有时不可打印）字符也可以表示为转义序列。

heredoc字符串文本支持对[双引号字符串文本](#double-quoted-string-literals)定义的变量替换。

heredoc字符串文本是一个常量表达式，如果它不包含任何变量替换。

可选的*b-prefix*没有效果。

**例子**

```PHP
$v = 123;
$s = <<<    ID
S'o'me "\"t e\txt; \$v = $v"
Some more text
ID;
echo ">$s<";
// → >S'o'me "\"t e  xt; $v = 123"
// Some more text<
```

######Nowdoc 字符串文本

**语法**

<!-- GRAMMAR
nowdoc-string-literal::
  b-prefix? '<<<' '''' name '''' new-line hd-body? name ';'? new-line
-->

<pre>
<i id="grammar-nowdoc-string-literal">nowdoc-string-literal::</i>
   <i><a href="#grammar-b-prefix">b-prefix</a></i><sub>opt</sub>   &lt;&lt;&lt;   '   <i><a href="#grammar-name">name</a></i>   '   <i><a href="#grammar-new-line">new-line</a></i>   <i><a href="#grammar-hd-body">hd-body</a></i><sub>opt</sub>   <i><a href="#grammar-name">name</a></i>   ;<sub>opt</sub>   <i><a href="#grammar-new-line">new-line</a></i>
</pre>

**约束**

开始和结束标识符名称必须相同。 在开始标识符名称及其包含的单引号(`'`)之间不允许有空格。 
另请参见[heredoc字符串文本](#heredoc-string-literals)。

**语义**

一个nowdoc字符串文本看起来像一个[heredoc字符串文本](#heredoc-string-literals)，除了在前者
开始标识符名称用单引号(`'`)括起来。 字符串文本的两种形式具有
相同的语义和约束，除了nowdoc字符串文本不受变量替换（如单引号字符串）。

nowdoc字符串文本是一个常量表达式。

可选的*b-prefix*没有效果。

**例子**

```PHP
$v = 123;
$s = <<<    'ID'
S'o'me "\"t e\txt; \$v = $v"
Some more text
ID;
echo ">$s<\n\n";
// → >S'o'me "\"t e\txt; \$v = $v"
// Some more text<
```

####操作符与标点符号

**语法**

<!-- GRAMMAR
operator-or-punctuator:: one of
  '[' ']' '(' ')' '{' '}' '.' '->' '++' '--' '**' '*' '+' '-' '~' '!'
  '$' '/' '%' '<<' '>>' '<' '>' '<=' '>=' '==' '===' '!=' '!==' '^' '|'
  '&' '&&' '||' '?' ':' ';' '=' '**=' '*=' '/=' '%=' '+=' '-=' '.=' '<<='
  '>>=' '&=' '^=' '|=' ',' '??' '<=>' '...' '\'
-->

<pre>
<i id="grammar-operator-or-punctuator">operator-or-punctuator:: one of</i>
   [   ]   (   )   {   }   .   -&gt;   ++   --   **   *   +   -   ~   !
   $   /   %   &lt;&lt;   &gt;&gt;   &lt;   &gt;   &lt;=   &gt;=   ==   ===   !=   !==   ^   |
   &amp;   &amp;&amp;   ||   ?   :   ;   =   **=   *=   /=   %=   +=   -=   .=   &lt;&lt;=
   &gt;&gt;=   &amp;=   ^=   |=   ,   ??   &lt;=&gt;   ...   \
</pre>

**语义**

操作符和标点符号是具有独立语法和语义意义的符号。 在表达式中
使用*运算符*来描述涉及一个或多个*操作对象*的操作，并产生结果值，
产生副作用或其某种组合。 *标点符号*用于分组和分离。


