#命名空间

##一般

在管理大型项目时会遇到在相同的命名空间下相同的命名却做不同的事的问题.
对于支持模块化和组件库的语言特别成问题.

命名空间是一套容器(关联了) classes, interfaces, tarits, functions, 和
constants的定义.
命名空间的两个作用:

-   有助于避免命名冲突.
-   允许简短的名称访问某些较长的命名,更方便,更易读,更容易命名.

一个命名空间可以有子命名空间,其中一个子命名空间可以与其他命名空间共享
一个公共的前缀.举个例子,命名空间`Graphics`有对应二维和三维的子命名空间
`Graphics\D2` 和 `Graphics\D3`.它们除了有公共的前缀,它及其他的子命名空间
没有特殊的关联.前缀是命名空间的一部分,不需要实际存在的子命名空间,所以说
`NS1\Sub`不需要`NS1`的存在.

本身,在没有定义命名空间的情况下,随后定义的classes,interfaces, traits,
functions,和constants都应该在*默认的命名空间*中,只是它没有命名.

命名空间`PHP`,`php` 和 以这些为前缀开始的子命名空间是PHP保留的.

##定义命名空间

**语法**

<pre>
  <i>namespace-definition:</i>
    namespace  <i>name</i>  ;
    namespace  <i>name<sub>opt</sub>   compound-statement</i>
</pre>

**其他定义**

* [*命名*](09-lexical-structure.md#names)
* [*复合语句*](11-statements.md#compound-statements)

**约束**

除了空格和[*声明语句*](11-statements.md#the-declare-statement),在脚本中命名空间定义必须是第一
件事.

在一个脚本所有的*命名空间定义*必须有*复合语句*的形式或者必须没有这种形式;两者不能在脚本中混合
使用.

当一段不在命名空间内的代码,和在一个命名空间内代码在一个脚本中时,命名空间的代码必须使用复合语句
的形式定义命名空间.

*复合语句必须不包含命名空间定义.

**语义**

尽管一个命名空间可以包含任何php代码,但事实上包含在命名空间中的代码影响了classes, interfaces, traits,
functions,和constants的声明和定义.如果他们使用的是[不合格或者合格的命名](#name-lookup),当前的命名
空间会被添加到指定的名称中.注意,在定义一个简短的命名时,通过引擎是可以获取到全名的,或可以指定完全
限定的名称,由当前的命名空间名称和指定的名称或者[引入](#namespace-use-declarations)组成.

命名空间和子命名空间的命名不区分大小写.

预先定义的[`__NAMESPACE__`](06-constants.md#context-dependent-constants)常量包含在当前命名空间下.

当相同的命名空间被定义在不同的脚本中,并且这些脚本被合并到同一个项目内,命名空间会考虑把他们合并.

命名空间定义的非*复合语句*的范围会一直持续到脚本结束,或者有下一个*命名空间定义*的语法开始.*复合语句*
的范围是这个*复合语句*

**Examples**

Script1.php:
```PHP
namespace NS1;
...       // __NAMESPACE__ is "NS1"
namespace NS3\Sub1;
...       // __NAMESPACE__ is "NS3\Sub1"
```

Script2.php:
```PHP
namespace NS1
{
...       // __NAMESPACE__ is "NS1"
}
namespace
{
...       // __NAMESPACE__ is ""
}
namespace NS3\Sub1;
{
...       // __NAMESPACE__ is "NS3\Sub1"
}
```

##命名空间使用说明

**语法**

<pre>
  <i>namespace-use-declaration:</i>
    use  <i>namespace-function-or-const<sub>opt</sub></i> <i>namespace-use-clauses</i>  ;
    use  <i>namespace-function-or-const</i>  \<i><sub>opt</sub>  namespace-name</i>  \
       {  <i>namespace-use-group-clauses-1</i>  }  ;
    use  \<i><sub>opt</sub>   namespace-name</i>   \   {  <i>namespace-use-group-clauses-2</i>  }  ;

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

  <i>namespace-use-group-clauses-1:</i>
    <i>namespace-use-group-clause-1</i>
    <i>namespace-use-group-clauses-1</i>  ,  <i>namespace-use-group-clause-1</i>

  <i>namespace-use-group-clause-1:</i>
    <i>namespace-name</i>  <i>namespace-aliasing-clause<sub>opt</sub></i>

  <i>namespace-use-group-clauses-2:</i>
    <i>namespace-use-group-clause-2</i>
    <i>namespace-use-group-clauses-2</i>  ,  <i>namespace-use-group-clause-2</i>

  <i>namespace-use-group-clause-2:</i>
    <i>namespace-function-or-const<sub>opt</sub></i>  <i>namespace-name</i>  <i>namespace-aliasing-clause<sub>opt</sub></i>
</pre>

**其他定于**

* [*名称*](09-lexical-structure.md#names)
* [*命名空间名*](09-lexical-structure.md#names)
* [*限定名*](09-lexical-structure.md#names)

**约束**

*命名空间的使用声明*不应该在顶部或者*命名空间定义*的上下文中.

如果在相同的作用域下多次引入相同的*限定名*,*名称*,*命名空间名*,每一个必须有不同的别名.

**语义**

如果*namespace-use-declaration* 有一个*namespace-function-or-const*的值是`function`, 这个语法引入了一个或多个
函数.如果*namespace-use-declaration*有一个*namespace-function-or-const*的值是`const`,这个语法引入了一个或多个
常量.否则*namespace-use-declaration* 不包含 *namespace-function-or-const*.在这种情况下,如果*namespace-use-clauses*
是存在的,被导入的命名应该是classes/interfaces/traits.否则 *namespace-use-group-clauses-2*是存在的,在这种情况下,
被导入的命名应该是functions,costants,或者classes/interface/traits基于各自存在的`function`或者`const`, 

If *namespace-use-declaration* has a *namespace-function-or-const* with value `function`, the statement imports
one or more functions. If *namespace-use-declaration* has a *namespace-function-or-const* with value `const`, the statement imports one or more constants. Otherwise, *namespace-use-declaration* has no *namespace-function-or-const*. In that case, if *namespace-use-clauses* is present, the names being imported are considered to be classes/interfaces/traits. Otherwise, *namespace-use-group-clauses-2* is present, in which case, the names being imported are considered to be functions, constants, or classes/interfaces/traits based on the respective presence of `function` or `const`, or the absence of *namespace-function-or-const* on each *namespace-name* in subordinate *namespace-use-group-clause-2*s.

注意constant, function 和class导入到不同的空间中,因此可以使用相同名称做为constant, function和class的入口,
并且适用于class 和 function,彼此不会受到干扰.

*namespace-use-declaration* *imports* 是为一个范围内的一个或多个名称提供别名, 这些名称每一个都可以指定
一个命名空间,一个子命名空间,一个类，一个interface,或者 trait.如果当前是*namespace-aliasing-clause*,
它的*name*是*qualified-name*, *name*, 或 *namespace-name*的别名.否则,在*qualified-name*最右边的名字
是*qualified-name*的隐含别名.

**例子**

```PHP
namespace NS1
{
  const CON1 = 100;
  function f() { ... }
  class C { ... }
  interface I { ... }
  trait T { ... }
}

namespace NS2
{
  use \NS1\C, \NS1\I, \NS1\T;
  class D extends C implements I
  {
    use T;  // trait (and not a namespace use declaration)
  }
  $v = \NS1\CON1; // explicit namespace still needed for constants
  \NS1\f();   // explicit namespace still needed for functions

  use \NS1\C as C2; // C2 是 \NS1\C 类的别名
  $c2 = new C2;

  // 引入一组类和接口
  use \NS\{C11, C12, I10};

  // 引入函数 
  use function \My\Full\functionName;

  // 函数的别名 
  use function \NS1\f as func;
  use function \NS\{f1, g1 as myG};

  // 引入常量 
  use const \NS1\CON1;
  use \NS\{const CON11, const CON12};

  $v = CON1; // 导入常量 
  func();   // 导入函数 

  // 导入类,常量,函数
  use \NS\ { C2 as CX, const CON2 as CZ, function f1 as FZ };
}
```

注意,即使 *适当的命名* 没有以`\`开始,但还是会被当作绝对路径对待.

例如:

```PHP
namespace b
{
  class B
  {
    function foo(){ echo "goodbye"; }
  }
}

namespace a\b
{
  class B
  {
    function foo(){ echo "hello"; }
  }
}

namespace a
{
  $b = new b\B();
  $b->foo(); // hello
  use b\B as C;
  $b = new C();
  $b->foo(); // goodbye
}
```

##名称查找

在源代码中使用现成的名称时,引擎必须确定如何才能在命名空间的查找中找到该名称.为了
这个目的，命名可以有以下三种形式之一.

-   非限定名称:
    在代码`$p = new Point(3,5)` 类`Point`仅仅是没有任何前缀的简单命名.如果
    当前的命名空间是默认的,`Point`的绝对路径就是`Point`.在不限定函数或常量的名称
    的情况下,如果名称在当前命名空间不存在,就使用该名称的公共的函数或常量.
-   限定名称: 
    有这样一个命名,是在class,interface,trait,function或constant名称之前,有一个有前缀
    的命名空间和一级或多级的子命名空间的名称.这样的命名是相对的.例如,`D2\Point` 可以
    用来指类`Point`在子命名空间`D2`的空间内. 其中一个特殊的情况是，当名字的第一个组件
    是的关键词是`namespace`.这意味着在当前空间.

-   完全限定名称:
    命名已反斜杠(`\`)开始并且紧跟着可选择命名空间名称和一级或者多级的子命名空间的名称
    和最后的class, interface, traitm,function或constant的名称.这是绝对路径的名称.例如:
    `\Graphics\D2\Point` 可以用来指在命名空间中`Graphics`,子命名空间`D2`的明确的类
    `Point`

但是,在非默认的命名空间中使用非限定的名称,如果在这个命名空间中没有这个名称的常量函数
被定义,就会使用全局的.

例如:
```PHP
<?php
namespace A\B\C;
function strlen($str)
{
    return 42;
}
print strlen("Life, Universe and Everything"); // 打印 42
print mb_strlen("Life, Universe and Everything"); // 调用公共的函数 打印 29
```

标准的类型命名 (例如 `Exception`), 常量 (例如 `PHP_INT_MAX`), 和函数 
(例如 `is_null`)是定义在任何命名空间之外的. 要明确使用这样的名称,可以使用反斜线(`\`), 如
`\Exception`, `\PHP_INT_MAX`, 和 `\is_null`.
