#语法

##一般

语法符号描述 [语法部分](09-lexical-structure.md#grammars).

##语法词汇

###一般

<pre>
  <i>input-file::</i>
    <i>input-element</i>
    <i>input-file   input-element</i>
  <i>input-element::</i>
    <i>comment</i>
    <i>white-space</i>
    <i>token</i>
</pre>

###注释

<pre>
  <i>comment::</i>
    <i>single-line-comment</i>
    <i>delimited-comment</i>

  <i>single-line-comment::</i>
    //   <i>input-characters<sub>opt</sub></i>
    #    <i>input-characters<sub>opt</sub></i>

  <i>input-characters::</i>
    <i>input-character</i>
    <i>input-characters   input-character</i>

  <i>input-character::</i>
    Any source character except <i>new-line</i>

  <i>new-line::</i>
    Carriage-return character (U+000D)
    Line-feed character (U+000A)
    Carriage-return character (U+000D) followed by line-feed character (U+000A)

  <i>delimited-comment::</i>
    /*   No characters or any source character sequence except */   */
</pre>

###空格

<pre>
  <i>white-space::</i>
    <i>white-space-character</i>
    <i>white-space   white-space-character</i>

  <i>white-space-character::</i>
    <i>new-line</i>
    Space character (U+0020)
    Horizontal-tab character (U+0009)
</pre>

###标记

####General

<pre>
  <i>token::</i>
    <i>variable-name</i>
    <i>name</i>
    <i>keyword</i>
    <i>literal</i>
    <i>operator-or-punctuator</i>
</pre>

####命名

<pre>
  <i>variable-name::</i>
    $   <i>name</i>

  <i>namespace-name::</i>
    <i>name</i>
    <i>namespace-name</i>   \   <i>name</i>

  <i>namespace-name-as-a-prefix::</i>
    \
    \<sub>opt</sub>   <i>namespace-name</i>   \
    namespace   \
    namespace   \   <i>namespace-name</i>   \

  <i>qualified-name::</i>
    <i>namespace-name-as-a-prefix<sub>opt</sub>   name</i>

  <i>name::</i>
    <i>name-nondigit</i>
    <i>name   name-nondigit</i>
    <i>name   digit</i>

  <i>name-nondigit::</i>
    <i>nondigit</i>
    one of the characters U+007f–U+00ff

  <i>nondigit:: one of</i>
    _
    a   b   c   d   e   f   g   h   i   j   k   l   m
    n   o   p   q   r   s   t   u   v   w   x   y   z
    A   B   C   D   E   F   G   H   I   J   K   L   M
    N   O   P   Q   R   S   T   U   V   W   X   Y   Z
</pre>

###关键词

<pre>
  <i>keyword:: one of</i>
    abstract   and   as   break   callable   case   catch   class   clone
    const   continue   declare   default   do   echo   else   elseif
    enddeclare   endfor   endforeach   endif   endswitch   endwhile
    extends   final   finally   for   foreach   function   global
    goto   if   implements   include   include_once   instanceof
    insteadof   interface   list   namespace   new   or   print   private
    protected   public   require   require_once   return static   switch
    throw   trait   try   use   var   while   xor   yield
</pre>

###常量

####一般

<pre>
  <i>literal::</i>
    <i>integer-literal</i>
    <i>floating-literal</i>
    <i>string-literal</i>
</pre>

####整数常量

<pre>
  <i>integer-literal::</i>
    <i>decimal-literal</i>
    <i>octal-literal</i>
    <i>hexadecimal-literal</i>
    <i>binary-literal</i>

    <i>decimal-literal::</i>
      <i>nonzero-digit</i>
      <i>decimal-literal   digit</i>

    <i>octal-literal::</i>
      0
      <i>octal-literal   octal-digit</i>

    <i>hexadecimal-literal::</i>
      <i>hexadecimal-prefix   hexadecimal-digit</i>
      <i>hexadecimal-literal   hexadecimal-digit</i>

    <i>hexadecimal-prefix:: one of</i>
      0x  0X

    <i>binary-literal::</i>
      <i>binary-prefix   binary-digit</i>
      <i>binary-literal   binary-digit</i>

    <i>binary-prefix:: one of</i>
      0b  0B

    <i>digit:: one of</i>
      0  1  2  3  4  5  6  7  8  9

    <i>nonzero-digit:: one of</i>
      1  2  3  4  5  6  7  8  9

    <i>octal-digit:: one of</i>
      0  1  2  3  4  5  6  7

    <i>hexadecimal-digit:: one of</i>
      0  1  2  3  4  5  6  7  8  9
      a  b  c  d  e  f
      A  B  C  D  E  F

    <i>binary-digit:: one of</i>
        0  1
</pre>

####浮点数常量

<pre>
  <i>ﬂoating-literal::</i>
    <i>fractional-literal   exponent-part<sub>opt</sub></i>
    <i>digit-sequence   exponent-part</i>

  <i>fractional-literal::</i>
    <i>digit-sequence<sub>opt</sub></i> . <i>digit-sequence</i>
    <i>digit-sequence</i> .

  <i>exponent-part::</i>
    e  <i>sign<sub>opt</sub>   digit-sequence</i>
    E  <i>sign<sub>opt</sub>   digit-sequence</i>

  <i>sign:: one of</i>
    +  -

  <i>digit-sequence::</i>
    <i>digit</i>
    <i>digit-sequence   digit</i>
</pre>

####字符串常量

<pre>
  <i>string-literal::</i>
    <i>single-quoted-string-literal</i>
    <i>double-quoted-string-literal</i>
    <i>heredoc-string-literal</i>
    <i>nowdoc-string-literal</i>

  <i>single-quoted-string-literal::</i>
    b<i><sub>opt</sub></i>  ' <i>sq-char-sequence<sub>opt</sub></i>  '

  <i>sq-char-sequence::</i>
    <i>sq-char</i>
    <i>sq-char-sequence   sq-char</i>

  <i>sq-char::</i>
    <i>sq-escape-sequence</i>
    \<i><sub>opt</sub></i>   any member of the source character set except single-quote (') or backslash (\)

  <i>sq-escape-sequence:: one of</i>
    \'  \\

  <i>double-quoted-string-literal::</i>
    b<i><sub>opt</sub></i>  " <i>dq-char-sequence<sub>opt</sub></i>  "

  <i>dq-char-sequence::</i>
    <i>dq-char</i>
    <i>dq-char-sequence   dq-char</i>

  <i>dq-char::</i>
    <i>dq-escape-sequence</i>
    any member of the source character set except double-quote (") or backslash (\)
    \  any member of the source character set except "\$efnrtvxX or <i>octal-digit</i>

  <i>dq-escape-sequence::</i>
    <i>dq-simple-escape-sequence</i>
    <i>dq-octal-escape-sequence</i>
    <i>dq-hexadecimal-escape-sequence</i>

  <i>dq-simple-escape-sequence:: one of</i>
    \"   \\   \$   \e   \f   \n   \r   \t   \v

  <i>dq-octal-escape-sequence::</i>
    \   <i>octal-digit</i>
    \   <i>octal-digit   octal-digit</i>
    \   <i>octal-digit   octal-digit   octal-digit</i>

  <i>dq-hexadecimal-escape-sequence::</i>
    \x  <i>hexadecimal-digit   hexadecimal-digit<sub>opt</sub></i>
    \X  <i>hexadecimal-digit   hexadecimal-digit<sub>opt</sub></i>

    <i>string-variable::</i>
        <i>variable-name</i>   <i>offset-or-property<sub>opt</sub></i>
        ${   <i>expression</i>   }

    <i>offset-or-property::</i>
        <i>offset-in-string</i>
        <i>property-in-string</i>

    <i>offset-in-string::</i>
        [   <i>name</i>   ]
        [   <i>variable-name</i>   ]
        [   <i>integer-literal</i>   ]

    <i>property-in-string::</i>
        ->   <i>name</i>

  <i>heredoc-string-literal::</i>
    &lt;&lt;&lt;  <i>hd-start-identifier   new-line   hd-char-sequence<sub>opt</sub>  new-line hd-end-identifier</i>  ;<i><sub>opt</sub>   new-line</i>

  <i>hd-start-identifier::</i>
    <i>name</i>
    "   <i>name</i>  "

  <i>hd-end-identifier::</i>
    <i>name</i>

  <i>hd-char-sequence::</i>
    <i>hd-char</i>
    <i>hd-char-sequence   hd-char</i>

  <i>hd-char::</i>
    <i>hd-escape-sequence</i>
    any member of the source character set except backslash (\)
    \  any member of the source character set except \$efnrtvxX or <i>octal-digit</i>

  <i>hd-escape-sequence::</i>
    <i>hd-simple-escape-sequence</i>
    <i>dq-octal-escape-sequence</i>
    <i>dq-hexadecimal-escape-sequence</i>

  <i>hd-simple-escape-sequence:: one of</i>
    \\   \$   \e   \f   \n   \r   \t   \v

  <i>nowdoc-string-literal::</i>
    &lt;&lt;&lt;  '  <i>name</i>  '  <i>new-line  hd-char-sequence<sub>opt</sub>   new-line name</i>  ;<i><sub>opt</sub>   new-line</i>
</pre>

###运算符和标点符号

<pre>
  <i>operator-or-punctuator:: one of</i>
    [   ]    (   )   {    }   .   ->   ++   --   **   *   +   -   ~   !
    $   /   %   &lt;&lt;    &gt;&gt;   &lt;   &gt;   &lt;=   &gt;=   ==   ===   !=   !==   ^   |
    &   &&   ||   ?   :   ; =   **=   *=   /=   %=   +=   -=   .=   &lt;&lt;=
    &gt;&gt;=   &=   ^=   |=   =&   ,
</pre>

##语法

###程序结构

<pre>
<i>script:</i>
<i> script-section</i>
<i> script   script-section</i>

<i>script-section:</i>
  <i> text<sub>opt</sub></i> <i>start-tag</i> <i>statement-list<sub>opt</sub></i> <i>end-tag</i><sub>opt</sub> <i>text<sub>opt</sub></i>

<i>start-tag:</i>
  &lt;?php
  &lt;?=

<i>end-tag:</i>
  ?&gt;

<i>text:</i>
  arbitrary text not containing any of <i>start-tag</i> sequences
</pre>

###变量

<pre>
  <i>function-static-declaration:</i>
    static <i>static-variable-name-list</i>  ;

  <i>static-variable-name-list:</i>
    <i>static-variable-declaration</i>
    <i>static-variable-name-list</i>  ,  <i>static-variable-declaration</i>

  <i>static-variable-declaration:</i>
    <i>variable-name</i> <i>function-static-initializer<sub>opt</sub></i>

  <i>function-static-initializer:</i>
    = <i>constant-expression</i>

  <i>global-declaration:</i>
    global <i>variable-name-list</i> ;

  <i>variable-name-list:</i>
    <i>expression</i>
    <i>variable-name-list</i>  ,  <i>expression</i>
</pre>

###表达式

####原子表达式

<pre>
  <i>primary-expression:</i>
    <i>variable-name</i>
    <i>qualified-name</i>
    <i>literal</i>
    <i>constant-expression</i>
    <i>intrinsic</i>
    <i>anonymous-function-creation-expression</i>
    (  <i>expression</i>  )
    $this

  <i>intrinsic:</i>
    <i>intrisic-construct</i>
    <i>intrisic-operator</i>

  <i>intrisic-construct:</i>
    <i>echo-intrinsic</i>
    <i>list-intrinsic</i>
    <i>unset-intrinsic</i>

  <i>intrinsic-operator:</i>
    <i>array-intrinsic</i>
    <i>empty-intrinsic</i>
    <i>eval-intrinsic</i>
    <i>exit-intrinsic</i>
    <i>isset-intrinsic</i>
    <i>print-intrinsic</i>

  <i>array-intrinsic:</i>
    array ( <i>array-initializer<sub>opt</sub></i>  )

  <i>echo-intrinsic:</i>
    echo  <i>expression</i>
    echo  <i>expression-list-two-or-more</i>

  <i>expression-list-two-or-more:</i>
    <i>expression</i>  ,  <i>expression</i>
    <i>expression-list-two-or-more</i>  ,  <i>expression</i>

  <i>empty-intrinsic:</i>
    empty ( <i>expression</i>  )

  <i>eval-intrinsic:</i>
    eval (  <i>expression</i>  )

  <i>exit-intrinsic:</i>
    exit  <i>expression<sub>opt</sub></i>
    exit  (  <i>expression<sub>opt</sub></i>  )
    die   <i>expression<sub>opt</sub></i>
    die   (   <i>expression<sub>opt</sub></i> )

  <i>isset-intrinsic:</i>
    isset  (  <i>expression-list-one-or-more</i>  )

  <i>expression-list-one-or-more</i>:
    <i>expression</i>
    <i>expression-list-one-or-more</i>  ,  <i>expression</i>

  <i>list-intrinsic:</i>
    list  (  <i>list-expression-list<sub>opt</sub></i>  )

  <i>list-expression-list:</i>
    <i>unkeyed-list-expression-list</i>
    <i>keyed-list-expression-list</i> ,<sub>opt</sub>

  <i>unkeyed-list-expression-list:</i>
    <i>list-or-variable</i>
    ,
    <i>unkeyed-list-expression-list</i>  ,  <i>list-or-variable<sub>opt</sub></i>

  <i>keyed-list-expression-list:</i>
    <i>expression</i>  =>  <i>list-or-variable</i>
    <i>keyed-list-expression-list</i>  ,  <i>expression</i>  =>  <i>list-or-variable</i>

  <i>list-or-variable:</i>
    <i>list-intrinsic</i>
    <i>expression</i>

  <i>print-intrinsic:</i>
    print  <i>expression</i>
    print  (  <i>expression</i>  )

  <i>unset-intrinsic:</i>
    unset  (  <i>expression-list-one-or-more</i>  )

  <i>anonymous-function-creation-expression:</i>
  static<sub>opt</sub> function  &<sub>opt</sub> (  <i>parameter-declaration-list<sub>opt<sub></i>  )  <i>anonymous-function-use-clause<sub>opt</sub></i>
      <i>compound-statement</i>

  <i>anonymous-function-use-clause:</i>
    use  (  <i>use-variable-name-list</i>  )

  <i>use-variable-name-list:</i>
    &amp;<sub>opt</sub>   <i>variable-name</i>
    <i>use-variable-name-list</i>  ,  &<sub>opt</sub>  <i>variable-name</i>

</pre>

####后缀运算符

<pre>
  <i>postfix-expression:</i>
    <i>primary-expression</i>
    <i>clone-expression</i>
    <i>object-creation-expression</i>
    <i>array-creation-expression</i>
    <i>subscript-expression</i>
    <i>function-call-expression</i>
    <i>member-selection-expression</i>
    <i>postfix-increment-expression</i>
    <i>postfix-decrement-expression</i>
    <i>scope-resolution-expression</i>
    <i>exponentiation-expression</i>

  <i>clone-expression:</i>
    clone  <i>expression</i>

  <i>object-creation-expression:</i>
    new  <i>class-type-designator</i>  (  <i>argument-expression-list<sub>opt</sub></i>  )
    new  <i>class-type-designator</i>

  <i>class-type-designator:</i>
    <i>qualified-name</i>
    <i>expression</i>

  <i>array-creation-expression:</i>
    array  (  <i>array-initializer<sub>opt</sub></i>  )
    [ <i>array-initializer<sub>opt</sub></i> ]

  <i>array-initializer:</i>
    <i>array-initializer-list</i>  ,<sub>opt</sub>

  <i>array-initializer-list:</i>
    <i>array-element-initializer</i>
    <i>array-element-initializer  ,  array-initializer-list</i>

  <i>array-element-initializer:</i>
    &<sub>opt</sub>   <i>element-value</i>
    <i>element-key</i>  =>  &<sub>opt</sub>   <i>element-value</i>

  <i>element-key:</i>
    <i>expression</i>

  <i>element-value</i>
    <i>expression</i>

  <i>subscript-expression:</i>
    <i>postfix-expression</i>  [  <i>expression<sub>opt</sub></i>  ]
    <i>postfix-expression</i>  {  <i>expression</i>  }   <b>[Deprecated form]</b>

  <i>function-call-expression:</i>
    <i>qualified-name</i>  (  <i>argument-expression-list<sub>opt</sub></i>  )
    <i>postfix-expression</i>  (  <i>argument-expression-list<sub>opt</sub></i>  )

  <i>argument-expression-list:</i>
    <i>argument-expression</i>
    <i>argument-expression-list</i>  ,  <i>argument-expression</i>

  <i>argument-expression:</i>
    <i>variadic-unpacking</i>
    <i>assignment-expression</i>

  <i>variadic-unpacking:</i>
    ... <i>assignment-expression</i>

  <i>member-selection-expression:</i>
    <i>postfix-expression</i>  ->  <i>member-selection-designator</i>

  <i>member-selection-designator:</i>
    <i>name</i>
    <i>expression</i>

  <i>postfix-increment-expression:</i>
    <i>unary-expression</i>  ++

  <i>postfix-decrement-expression:</i>
    <i>unary-expression</i>  --

  <i>scope-resolution-expression:</i>
    <i>scope-resolution-qualifier</i>  ::  <i>member-selection-designator</i>
    <i>scope-resolution-qualifier</i>  ::  class

  <i>scope-resolution-qualifier:</i>
    <i>relative-scope</i>
    <i>qualified-name</i>
    <i>expression</i>

  <i>relative-scope</i>:
    self
    parent
    static

  <i>exponentiation-expression:</i>
    <i>expression</i>  **  <i>expression</i>
</pre>

####一元运算符

<pre>
  <i>unary-expression:</i>
    <i>postfix-expression</i>
    <i>prefix-increment-expression</i>
    <i>prefix-decrement-expression</i>
    <i>unary-op-expression</i>
    <i>error-control-expression</i>
    <i>shell-command-expression</i>
    <i>cast-expression</i>
    <i>variable-name-creation-expression</i>

  <i>prefix-increment-expression:</i>
    ++ <i>unary-expression</i>

  <i>prefix-decrement-expression:</i>
    -- <i>unary-expression</i>

  <i>unary-op-expression:</i>
    <i>unary-operator cast-expression</i>

  <i>unary-operator: one of</i>
    +  -  !  ~

  <i>error-control-expression:</i>
    @   <i>expression</i>

  <i>shell-command-expression:</i>
    `  <i>dq-char-sequence<sub>opt</sub></i>  `

  <i>cast-expression:</i>
    <i>unary-expression</i>
    (  <i>cast-type</i>  ) <i>expression</i>

  <i>cast-type: one of</i>
    array  binary  bool  boolean  double  int  integer  float  object
    real  string  unset

  <i>variable-name-creation-expression:</i>
    $   <i>expression</i>
    $  {  <i>expression</i>  }

</pre>

####instanceof运算符 

<pre>
  <i>instanceof-expression:</i>
    <i>unary-expression</i>
    <i>instanceof-subject</i>  instanceof   <i>instanceof-type-designator</i>

  <i>instanceof-subject:</i>
    <i>expression</i>

  <i>instanceof-type-designator:</i>
    <i>qualified-name</i>
    <i>expression</i>
</pre>

####倒数运算符

<pre>
  <i>multiplicative-expression:</i>
    <i>instanceof-expression</i>
    <i>multiplicative-expression</i>  *  <i>instanceof-expression</i>
    <i>multiplicative-expression</i>  /  <i>instanceof-expression</i>
    <i>multiplicative-expression</i>  %  <i>instanceof-expression</i>
</pre>

####加性运算符

<pre>
  <i>additive-expression:</i>
    <i>multiplicative-expression</i>
    <i>additive-expression</i>  +  <i>multiplicative-expression</i>
    <i>additive-expression</i>  -  <i>multiplicative-expression</i>
    <i>additive-expression</i>  .  <i>multiplicative-expression</i>
</pre>

####位移运算符

<pre>
  <i>shift-expression:</i>
    <i>additive-expression</i>
    <i>shift-expression</i>  &lt;&lt;  <i>additive-expression</i>
    <i>shift-expression</i>  &gt;&gt;  <i>additive-expression</i>
</pre>

####关系型运算符

<pre>
  <i>relational-expression:</i>
    <i>shift-expression</i>
    <i>relational-expression</i>  &lt;   <i>shift-expression</i>
    <i>relational-expression</i>  &gt;   <i>shift-expression</i>
    <i>relational-expression</i>  &lt;=  <i>shift-expression</i>
    <i>relational-expression</i>  &gt;=  <i>shift-expression</i>
    <i>relational-expression</i>  &lt;=&gt; <i>shift-expression</i>
</pre>

####等式运算符

<pre>
  <i>equality-expression:</i>
    <i>relational-expression</i>
    <i>equality-expression</i>  ==  <i>relational-expression</i>
    <i>equality-expression</i>  !=  <i>relational-expression</i>
    <i>equality-expression</i>  &lt;&gt;  <i>relational-expression</i>
    <i>equality-expression</i>  ===  <i>relational-expression</i>
    <i>equality-expression</i>  !==  <i>relational-expression</i>
</pre>

####位运算符

<pre>
  <i>bitwise-AND-expression:</i>
    <i>equality-expression</i>
    <i>bit-wise-AND-expression</i>  &  <i>equality-expression</i>

  <i>bitwise-exc-OR-expression:</i>
    <i>bitwise-AND-expression</i>
    <i>bitwise-exc-OR-expression</i>  ^  <i>bitwise-AND-expression</i>

  <i>bitwise-inc-OR-expression:</i>
    <i>bitwise-exc-OR-expression</i>
    <i>bitwise-inc-OR-expression</i>  |  <i>bitwise-exc-OR-expression</i>
</pre>

####逻辑运算符 (form 1)

<pre>
  <i>logical-AND-expression-1:</i>
    <i>bitwise-incl-OR-expression</i>
    <i>logical-AND-expression-1</i>  &&  <i>bitwise-inc-OR-expression</i>

  <i>logical-inc-OR-expression-1:</i>
    <i>logical-AND-expression-1</i>
    <i>logical-inc-OR-expression-1</i>  ||  <i>logical-AND-expression-1</i>
</pre>

####三元运算符

<pre>
  <i>conditional-expression:</i>
    <i>logical-inc-OR-expression-1</i>
    <i>logical-inc-OR-expression-1</i>  ?  <i>expression<sub>opt</sub></i>  :  <i>conditional-expression</i>
</pre>

####联合操作符

<pre>
  <i>coalesce-expression:</i>
    <i>logical-inc-OR-expression</i>  ??  <i>expression</i>
</pre>

####赋值操作符

<pre>
  <i>assignment-expression:</i>
    <i>conditional-expression</i>
    <i>coalesce-expression</i>
    <i>simple-assignment-expression</i>
    <i>byref-assignment-expression</i>
    <i>compound-assignment-expression</i>

  <i>simple-assignment-expression:</i>
    <i>unary-expression</i>  =  <i>assignment-expression</i>

  <i>byref-assignment-expression:</i>
    <i>unary-expression</i>  =  &  <i>assignment-expression</i>

  <i>compound-assignment-expression:</i>
    <i>unary-expression   compound-assignment-operator   assignment-expression</i>

  <i>compound-assignment-operator: one of</i>
    **=  *=  /=  %=  +=  -=  .=  <<=  >>=  &=  ^=  |=
</pre>

####逻辑运算符 (form 2)

<pre>
  <i>logical-AND-expression-2:</i>
    <i>assignment-expression</i>
    <i>logical-AND-expression-2</i>  and  <i>assignment-expression</i>

  <i>logical-exc-OR-expression:</i>
    <i>logical-AND-expression-2</i>
    <i>logical-exc-OR-expression</i>  xor  <i>logical-AND-expression-2</i>

  <i>logical-inc-OR-expression-2:</i>
    <i>logical-exc-OR-expression</i>
    <i>logical-inc-OR-expression-2</i>  or  <i>logical-exc-OR-expression</i>

</pre>


####yield

<pre>
  <i>yield-expression:</i>
    <i>logical-inc-OR-expression-2</i>
    yield  <i>array-element-initializer</i>
</pre>

####脚本包含

<pre>
  <i>expression:</i>
    <i>yield-expression</i>
    <i>include-expression</i>
    <i>include-once-expression</i>
    <i>require-expression</i>
    <i>require-once-expression</i>

  <i>include-expression:</i>
    include  (  <i>expression</i>  )
    include  <i>expression</i>

  <i>include-once-expression:</i>
    include_once  (  <i>expression</i>  )
    include_once  <i>expression</i>

  <i>require-expression:</i>
    require  (  <i>expression</i>  )
    require  <i>expression</i>

  <i>require-once-expression:</i>
    require_once  (  <i>expression</i>  )
    require_once  <i>expression</i>
</pre>

###0常量表达式#

<pre>
  <i>constant-expression:</i>
    <i>array-creation-expression</i>
    <i>expression</i>
</pre>

###声明

####一般

<pre>

  <i>statement:</i>
    <i>compound-statement</i>
    <i>labeled-statement</i>
    <i>expression-statement</i>
    <i>selection-statement</i>
    <i>iteration-statement</i>
    <i>jump-statement</i>
    <i>declare-statement</i>
    <i>const-declaration</i>
    <i>function-definition</i>
    <i>class-declaration</i>
    <i>interface-declaration</i>
    <i>trait-declaration</i>
    <i>namespace-definition</i>
    <i>namespace-use-declaration</i>
    <i>global-declaration</i>
    <i>function-static-declaration</i>
</pre>

####符合语句

<pre>
  <i>compound-statement:</i>
    {   <i>statement-list<sub>opt</sub></i>  }

  <i>statement-list:</i>
    <i>statement</i>
    <i>statement-list   statement</i>
</pre>

####标记语句

<pre>
  <i>labeled-statement:</i>
    <i>named-label-statement</i>
    <i>case-statement</i>
    <i>default-statement</i>

  <i>named-label-statement:</i>
    <i>name</i>  :  <i>statement</i>

  <i>case-statement:</i>
    case   <i>expression   case-default-label-terminator   statement</i>

  <i>default-statement:</i>
    default  <i>case-default-label-terminator   statement</i>

  <i>case-default-label-terminator:</i>
    :
    ;
</pre>

####表达式

<pre>
   <i>expression-statement:</i>
     <i>expression<sub>opt</sub></i>  ;

  <i>selection-statement:</i>
    <i>if-statement</i>
    <i>switch-statement</i>

  <i>if-statement:</i>
    if   (   <i>expression</i>   )   <i>statement   elseif-clauses-1<sub>opt</sub>   else-clause-1<sub>opt</sub></i>
    if   (   <i>expression</i>   )   :   <i>statement-list   elseif-clauses-2<sub>opt</sub>   else-clause-2<sub>opt</sub></i>   endif   ;

  <i>elseif-clauses-1:</i>
    <i>elseif-clause-1</i>
    <i>elseif-clauses-1   elseif-clause-1</i>

  <i>elseif-clause-1:</i>
    elseif   (   <i>expression</i>   )   <i>statement</i>

  <i>else-clause-1:</i>
    else   <i>statement</i>

  <i>elseif-clauses-2:</i>
    <i>elseif-clause-2</i>
    <i>elseif-clauses-2   elseif-clause-2</i>

  <i>elseif-clause-2:</i>
    elseif   (   <i>expression</i>   )   :   <i>statement-list</i>

  <i>else-clause-2:</i>
    else   :   <i>statement-list</i>

  <i>switch-statement:</i>
    switch  (  <i>expression</i>  )  { <i>case-statements<sub>opt</sub></i> }
    switch  (  <i>expression</i>  )  :   <i>case-statements<sub>opt</sub></i>  endswitch;

  <i>case-statements:</i>
    <i>case-statement</i> <i>statement-list<sub>opt</sub></i> <i>case-statements<sub>opt</sub></i>
    <i>default-statement</i> <i>statement-list<sub>opt</sub></i> <i>case-statements<sub>opt</sub></i>

</pre>

####迭代

<pre>
  <i>iteration-statement:</i>
    <i>while-statement</i>
    <i>do-statement</i>
    <i>for-statement</i>
    <i>foreach-statement</i>

  <i>while-statement:</i>
    while  (  <i>expression</i>  )  <i>statement</i>
    while  (  <i>expression</i>  )  :   <i>statement-list</i>  endwhile ;

  <i>do-statement:</i>
    do  <i>statement</i>  while  (  <i>expression</i>  )  ;

  <i>for-statement:</i>
    for   (   <i>for-initializer<sub>opt</sub></i>   ;   <i>for-control<sub>opt</sub></i>   ;   <i>for-end-of-loop<sub>opt</sub></i>   )   <i>statement</i>
    for   (   <i>for-initializer<sub>opt</sub></i>   ;   <i>for-control<sub>opt</sub></i>   ;   <i>for-end-of-loop<sub>opt</sub></i>   )   :   <i>statement-list</i>   endfor   ;

  <i>for-initializer:</i>
    <i>for-expression-group</i>

  <i>for-control:</i>
    <i>for-expression-group</i>

  <i>for-end-of-loop:</i>
    <i>for-expression-group</i>

  <i>for-expression-group:</i>
    <i>expression</i>
    <i>for-expression-group</i>   ,   <i>expression</i>

  <i>foreach-statement:</i>
    foreach  (  <i>foreach-collection-name</i>  as  <i>foreach-key<sub>opt</sub>  foreach-value</i>  )   statement
    foreach  (  <i>foreach-collection-name</i>  as  <i>foreach-key<sub>opt</sub>  foreach-value</i>  )  :  <i>statement-list</i>  endforeach  ;

  <i>foreach-collection-name</i>:
    <i>expression</i>

  <i>foreach-key:</i>
    <i>expression</i>  =>

  <i>foreach-value:</i>
    &<sub>opt</sub>   <i>expression</i>
    <i>list-intrinsic</i>

</pre>

####跳转

<pre>
  <i>jump-statement:</i>
    <i>goto-statement</i>
    <i>continue-statement</i>
    <i>break-statement</i>
    <i>return-statement</i>
    <i>throw-statement</i>

  <i>goto-statement:</i>
    goto  <i>name</i>  ;

  <i>continue-statement:</i>
    continue   <i>breakout-level<sub>opt</sub></i>  ;

  <i>breakout-level:</i>
    <i>integer-literal</i>

  <i>break-statement:</i>
    break  <i>breakout-level<sub>opt</sub></i>  ;

  <i>return-statement:</i>
    return  <i>expression<sub>opt</sub></i>  ;

  <i>throw-statement:</i>
    throw  <i>expression</i>  ;
</pre>

####Try

<pre>
  <i>try-statement:</i>
    try  <i>compound-statement   catch-clauses</i>
    try  <i>compound-statement   finally-clause</i>
    try  <i>compound-statement   catch-clauses   finally-clause</i>

  <i>catch-clauses:</i>
    <i>catch-clause</i>
    <i>catch-clauses   catch-clause</i>

  <i>catch-clause:</i>
    catch  (  <i>qualified-name</i> <i>variable-name</i> )  <i>compound-statement</i>

  <i>finally-clause:</i>
    finally   <i>compound-statement</i>
</pre>

####declare

<pre>
  <i>declare-statement:</i>
    declare  (  <i>declare-directive</i>  )  <i>statement</i>
    declare  (  <i>declare-directive</i>  )  :  <i>statement-list</i>  enddeclare  ;
    declare  (  <i>declare-directive</i>  )  ;

  <i>declare-directive:</i>
    ticks  =  <i>literal</i>
    encoding  =  <i>literal</i>
    strict_types  =  <i>literal</i>

</pre>

###函数

<pre>
  <i>function-definition:</i>
    <i>function-definition-header   compound-statement</i>

  <i>function-definition-header:</i>
    function  &<sub>opt</sub>   <i>name</i> <i>return-type<sub>opt</sub></i> (  <i>parameter-declaration-list<sub>opt</sub></i>  )

  <i>parameter-declaration-list:</i>
    <i>simple-parameter-declaration-list</i>
    <i>variadic-declaration-list</i>

  <i>simple-parameter-declaration-list:</i>
    <i>parameter-declaration</i>
    <i>parameter-declaration-list</i>  ,  <i>parameter-declaration</i>

  <i>variadic-declaration-list:</i>
    <i>simple-parameter-declaration-list</i>  ,  <i>variadic-parameter</i>
    <i>variadic-parameter</i>

  <i>parameter-declaration:</i>
    <i>type-declaration<sub>opt</sub></i>  &<sub>opt</sub>  <i>variable-name   default-argument-specifier<sub>opt</sub></i>

  <i>variadic-parameter:</i>
	<i>type-declaration<sub>opt</sub></i>  &<sub>opt</sub>  ...  <i>variable-name</i>

  <i>return-type:</i>
    : <i>type-declaration</i>
    : void

  <i>type-declaration:</i>
    array
    callable
    <i>scalar-type</i>
    <i>qualified-name</i>

  <i>scalar-type:</i>
    bool
    float
    int
    string

  <i>default-argument-specifier:</i>
    =  <i>constant-expression</i>
</pre>

###类

<pre>
  <i>class-declaration:</i>
    <i>class-modifier<sub>opt</sub></i>  class  <i>name   class-base-clause<sub>opt</sub>  class-interface-clause<sub>opt</sub></i>   {   <i>trait-use-clauses<sub>opt</sub>   class-member-declarations<sub>opt</sub></i> }

  <i>class-modifier:</i>
    abstract
    final

  <i>class-base-clause:</i>
    extends  <i>qualified-name</i>

  <i>class-interface-clause:</i>
    implements  <i>qualified-name</i>
    <i>class-interface-clause</i>  ,  <i>qualified-name</i>

  <i>class-member-declarations:</i>
    <i>class-member-declaration</i>
    <i>class-member-declarations   class-member-declaration</i>

   <i>class-member-declaration:</i>
     <i>const-declaration</i>
     <i>property-declaration</i>
     <i>method-declaration</i>
     <i>constructor-declaration</i>
     <i>destructor-declaration</i>

  <i>const-declaration:</i>
    const  <i>name</i>  =  <i>constant-expression</i>   ;

  <i>property-declaration:</i>
    <i>property-modifier   variable-name   property-initializer<sub>opt</sub></i>  ;

  <i>property-modifier:</i>
    var
    <i>visibility-modifier   static-modifier<sub>opt</sub></i>
    <i>static-modifier   visibility-modifier<sub>opt</sub></i>

  <i>visibility-modifier:</i>
    public
    protected
    private

  <i>static-modifier:</i>
    static

  <i>property-initializer:</i>
    =  <i>constant-expression</i>

  <i>method-declaration:</i>
    <i>method-modifiers<sub>opt</sub>   function-definition</i>
    <i>method-modifiers   function-definition-header</i>  ;

  <i>method-modifiers:</i>
    <i>method-modifier</i>
    <i>method-modifiers   method-modifier</i>

  <i>method-modifier:</i>
    <i>visibility-modifier</i>
    <i>static-modifier</i>
    <i>class-modifier</i>

  <i>constructor-declaration:</i>
    <i>method-modifiers</i>  function &<sub>opt</sub>   __construct  (  <i>parameter-declaration-list<sub>opt</sub></i>  )  <i>compound-statement</i>
    <i>method-modifiers</i>  function &<sub>opt</sub>    <i>name</i>  (  <i>parameter-declaration-list<sub>opt</sub></i>  )  <i>compound-statement </i>    <b>[Deprecated form]</b>

  <i>destructor-declaration:</i>
    <i>method-modifiers</i>  function  &<sub>opt</sub>  __destruct  ( ) <i>compound-statement</i>

</pre>

###接口

<pre>
  <i>interface-declaration:</i>
    interface   <i>name   interface-base-clause<sub>opt</sub></i> {  <i>interface-member-declarations<sub>opt</sub></i>  }

  <i>interface-base-clause:</i>
    extends   <i>qualified-name</i>
    <i>interface-base-clause</i>  ,  <i>qualified-name</i>

  <i>interface-member-declarations:</i>
    <i>interface-member-declaration</i>
    <i>interface-member-declarations   interface-member-declaration</i>

  <i>interface-member-declaration:</i>
    <i>const-declaration</i>
    <i>method-declaration</i>
</pre>

###Traits

<pre>
  <i>trait-declaration:</i>
    trait   <i>name</i>   {   <i>trait-use-clauses<sub>opt</sub>   trait-member-declarations<sub>opt</sub></i>   }

  <i>trait-use-clauses:</i>
    <i>trait-use-clause</i>
    <i>trait-use-clauses   trait-use-clause</i>

  <i>trait-use-clause:</i>
    use   <i>trait-name-list   trait-use-specification</i>

  <i>trait-name-list:</i>
    <i>qualified-name</i>
    <i>trait-name-list</i>   ,   <i>qualified-name</i>

  <i>trait-use-specification:</i>
    ;
    {   <i>trait-select-and-alias-clauses<sub>opt</sub></i>   }

  <i>trait-select-and-alias-clauses:</i>
    <i>trait-select-and-alias-clause</i>
    <i>trait-select-and-alias-clauses   trait-select-and-alias-clause</i>

  <i>trait-select-and-alias-clause:</i>
    <i>trait-select-insteadof-clause</i> ;
    <i>trait-alias-as-clause</i> ;

  <i>trait-select-insteadof-clause:</i>
    <i>name</i>   insteadof   <i>name</i>

  <i>trait-alias-as-clause:</i>
    <i>name</i>   as   <i>visibility-modifier<sub>opt</sub>   name</i>
    <i>name</i>   as   <i>visibility-modifier   name<sub>opt</sub></i>

  <i>trait-member-declarations:</i>
    <i>trait-member-declaration</i>
    <i>trait-member-declarations   trait-member-declaration</i>

  <i>trait-member-declaration:</i>
    <i>property-declaration</i>
    <i>method-declaration</i>
    <i>constructor-declaration</i>
    <i>destructor-declaration</i>

</pre>

###命名空间

<pre>
  <i>namespace-definition:</i>
    namespace  <i>name</i>  ;
    namespace  <i>name<sub>opt</sub>   compound-statement</i>

  <i>namespace-use-declaration:</i>
    use  <i>namespace-function-or-const<sub>opt</sub></i> <i>namespace-use-clauses</i>  ;

  <i>namespace-use-clauses:</i>
    <i>namespace-use-clause</i>
    <i>namespace-use-clauses</i>  ,  <i>namespace-use-clause</i>

  <i>namespace-use-clause:</i>
    <i>qualified-name   namespace-aliasing-clause<sub>opt</sub></i>

  <i>namespace-aliasing-clause:</i>
    as  <i>name</i>

  <i>namespace-function-or-const:</i>
    function
    const
</pre>
