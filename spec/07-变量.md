#变量

##概述

*变量*是一个包含 PHP 值的存储数据的命名域。变量可以用[VSlot](04-basic-concepts.md#general)来描述。通过对变量的[赋值](04-basic-concepts.md#assignment)来创建变量。如果一个变量被定义，但是没有初始化的话，它的值就是`NULL`。

变量的销毁既可以取消它的设置，又可以显示的调用[`unset`](10-expressions.md#unset)方法，或者被PHP引擎销毁。[`isset`](10-expressions.md#isset) 可以用来判断一个变量是否存在或者没有设置为`NULL`。


变量有[名称](09-lexical-structure.md#names)。命名相同的俩个独立变量可能会分别在不同的[作用域](04-basic-concepts.md#scope)里。

一旦被初始化，值就不会在改变的变量叫做[常量](06-constants.md#general)。

根据被声明的上下文，变量会有一个[作用域](04-basic-concepts.md#scope)和[存储周期](04-basic-concepts.md#storage-duration)。


*超全局*变量是即使没有经过[*全局声明*](#global-variables)，也能够在全局自动生效的变量。

应该能够在 PHP 开发中遇到以下不同的变量种类：

-   [常量](#constants).
-   [局部变量](local-variables).
-   [数组元素](#array-elements).
-   [函数静态变量](#function-statics).
-   [全局变量](#global-variables).
-   [实例属性](#instance-properties).
-   [静态类属性](#static-properties).
-   [Class and interface constant](#class-and-interface-constants).

##变量的种类

###常量

**语法**

参考 [常量部分](06-constants.md#general).

**约束**

在类或者接口外，c-constant 只能被定义在 PHP 脚本的最上层。

**语义**

参考[常量](06-constants.md#general) 和 [类的常量](14-classes.md#constants)。

定义在类和接口外的常量是[超全局](#general)变量。常量有静态[存储期](04-basic-concepts.md#storage-duration)，并且是不能修改的左值。

**实例**

```PHP
const MAX_HEIGHT = 10.5;        // define two c-constants
const UPPER_LIMIT = MAX_HEIGHT;
define('COEFFICIENT_1', 2.345); // define two d-constants
define('FAILURE', TRUE);
```

###局部变量

**语法**

参考以下的语义。

**语义**

除非是函数的参数，否则局部变量不会显示的定义。换言之，当局部变量第一次被赋值时，它才被创建。
局部变量可以被赋值并作为一个[函数定义](13-functions.md#function-definitions)的参数列表中的其中一个参数，或者在任何的[复合语句](11-statements.md#compound-statements)中。并且会拥有函数的[作用域](04-basic-concepts.md#scope)和[存储生命周期](04-basic-concepts.md#storage-duration)。
一个局部变量是可以修改的左值。

**实例**

```PHP
function doit($p1)  // assigned the value TRUE when called
{
  $count = 10;
    ...
  if ($p1)
  {
    $message = "Can't open master file.";
    ...
  }
  ...
}
doit(TRUE);
// -----------------------------------------
function f()
{
  $lv = 1;
  echo "\$lv = $lv\n";
  ++$lv;
}
for ($i = 1; $i <= 3; ++$i)
  f();
```

跟[函数内的静态变量](#function-statics)不同, 函数 `f` 的输出每次都是
"`$lv = 1`"。

参见在[存储周期部分](04-basic-concepts.md#storage-duration)递归函数的实例。

###数组元素

**语法**

[数组](12-arrays.md#arrays)可以通过[数组运算符](10-expressions.md#array-creation-operator)或特有的[`array`](10-expressions.md#array)
来创建。创建数组同时，也可以同时创建数据内的一个或多个元素。New elements are inserted into an
existing array via the [simple-assignment operator](10-expressions.md#simple-assignment) in
conjunction with the subscript [operator `[]`](10-expressions.md#subscript-operator). 
数组内的元素可以通过[`unset`内建函数](10-expressions.md#unset)删除。


**语义**

数组元素的[作用域](04-basic-concepts.md#scope)跟该数组的变量名的作用域是一样的。一个数组元素也有它的[生命周期](04-basic-concepts.md#storage-duration)。


**实例**

```PHP
$colors = ["red", "white", "blue"]; // create array with 3 elements
$colors[] = "green";                // insert a new element
```

###函数静态变量

**语法**

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
</pre>

**在别处的定义**

* [*variable-name*](09-lexical-structure.md#names)
* [*constant-expression*](10-expressions.md#constant-expressions)

**约束**

必须是在函数内的定义。

**语义**

一个函数静态变量可以在任何[复合语句](11-statements.md#compound-statements)中定义。
它是一个可以被改变的左值。

函数内的静态变量有函数的[作用域](04-basic-concepts.md#scope)和静态[生命周期](04-basic-concepts.md#storage-duration)。

函数静态变量的值在它的母函数被调用是是被一直保留的。每次包含静态变量的母函数被调用，都会去执行调用静态变量的一个[别名](04-basic-concepts.md#general)。
只有当这个别名被执行[特定的`unset`](10-expressions.md#unset)时，才会被销毁。等到下一次函数调用，会创建一个新的别名。

**实例**

```PHP
function f()
{
  static $fs = 1;
  echo "\$fs = $fs\n";
  ++$fs;
}
for ($i = 1; $i <= 3; ++$i)
  f();
```

不像[局部变量](#local-variables), 函数`f` 会输出"`$fs
= 1`", "`$fs = 2`", 和 "`$fs = 3`", 因为 `$fs` 在函数调用期间保留了这个值。

###全局变量

**语法**

<pre>
  <i>global-declaration:</i>
    global <i>variable-name-list</i> ;

  <i>variable-name-list:</i>
    <i>global-variable</i>
    <i>variable-name-list</i>  ,  <i>global-variable</i>

  <i>global-variable:</i>
    <i>variable-name</i>
	<i>variable-name-creation-expression</i>
</pre>

**在别处的定义**

* [*expression*](10-expressions.md#general-6)
* [*variable-name*](09-lexical-structure.md#names)
* [*variable-name-creation-expression*](10-expressions.md#variable-name-creation-operator)

**约束**

Each *variable-name-creation-expression* must designate a simple variable name, i.e. it can not include array elements,
property accesses, etc. that are not inside braced expression.
每一个*变量名创建表达式*必须指定一个简单的变量名，比如它不能包括数组元素，属性访问等等that are not inside braced expression.

**语义**

全局变量重来不会显示的定义，而是在它第一次赋值时被创建。定义通常是在脚本的最上层进行，或者是从包含该变量声明的一个代码块中，并使用`global`关键字(*引入*它)。

One of the [predefined variables](#predefined-variables),
[`$GLOBALS`](http://php.net/manual/reserved.variables.globals.php) is
a [superglobal](#general) array whose elements' key/value pairs contain the
name and value, respectively, of each global variable currently defined.
As such, a global variable `gv` can be initialized with the value `v`,
and possibly be created, using the following form of assignment:

其中一个[预定义](#predefined-variables)变量[`$GLOBALS`](http://php.net/manual/reserved.variables.globals.php)是一个[超全局](#general)数组，它的元素都是键值对，分别包含 key 名称和值，从而定义了每一个全局变量。这样，一个全局变量`gv`能够用`v`值来初始化，并且被创建。用如下的形式来赋值：

`$GLOBALS['gv'] = v`

因为`$GLOBALS` 是一个超全局变量，`gv` 本身则不需要有*全局声明*。

一个全局变量有全局的[作用域](04-basic-concepts.md#scope)，且有它的[生命周期](04-basic-concepts.md#storage-duration)。
一个全局变量是一个可修改的左值。

当一个全局变量值被引入一个函数，每当该函数被调用，执行处理的只是该全局变量的一个[别名](04-basic-concepts.md#general)。
只有当该全局变量之行了[系统函数`unset`]时，别名才会被销毁。当再次调用该函数时，会根据该全局变量的当前值创建一个新的别名。

**实例**

```PHP
$colors = array("red", "white", "blue");
$GLOBALS['done'] = FALSE;
// -----------------------------------------
$min = 10; $max = 100; $average = NULL;
global $min, $max;         // allowed, but serves no purpose
function compute($p)
{
  global $min, $max;
  global $average;
  $average = ($max + $min)/2;

  if ($p)
  {
    global $result;
    $result = 3.456;  // initializes a global, creating it, if necessary
  }
}
compute(TRUE);
echo "\$average = $average\n";  // $average = 55
echo "\$result = $result\n";  // $result = 3.456
// -----------------------------------------
$g = 100;
function f()
{
  $v = 'g';
  global $$v;          // import global $g
  ...
}
```

###实例属性

该部分内容出现在[类的实例属性部分](14-classes.md#properties)。实例属性有类定义的[作用域](04-basic-concepts.md#scope)，
并且分配了[生命周期](04-basic-concepts.md#storage-duration)。访问实例属性是被类的[可见性规则](14-classes.md#general)控制。

###静态属性

该部分内容出现在[类的静态属性部分](14-classes.md#properties)。静态属性有类定义的[作用域](04-basic-concepts.md#scope),
并且有静态[生命周期](04-basic-concepts.md#storage-duration)。访问静态属性是被类的[可见性规则](14-classes.md#general)控制。

###类和接口常量

该部分内容出现在[类的静态属性部分](14-classes.md#properties) 和 [接口常量部分](15-interfaces.md#constants)。静态属性有类定义的[作用域](04-basic-concepts.md#scope)，并且有静态[生命周期](04-basic-concepts.md#storage-duration)。

##预定义变量

下述的全局变量在在脚本的任何地方都可以使用的：

变量名称  |   描述
-------------   |    -----------
`$argc` | `int`; 传递给脚本的命令行参数个数。最小值是1。（参考下面的`$argv`）。在非命令行下编译的引擎中是不可用的。
`$argv` | `array`; 传递给脚本的参数数组。第一个参数总是当前脚本的文件名，因此 `$argv[0]` 就是脚本文件名。
`$_COOKIE` |  `array`; 通过 HTTP Cookies 传递给当前脚本的变量。
`$_ENV` | `array`; 通过环境方式传递给当前脚本的变量的数组。这些变量被从 PHP 解析器的运行环境导入到 PHP 的全局命名空间。很多是由支持 PHP 运行的 Shell 提供的，并且不同的系统很可能运行着不同种类的 Shell，所以不可能有一份确定的列表。请查看你的 Shell 文档来获取定义的环境变量列表。
`$_FILES` | `array`; 通过 HTTP POST 方法传递给当前脚本的上传项目。
`$_GET` | `array`;  用过 URL 参数传递给当前脚本的变量。
`$GLOBALS` |  `array`; 引用[全局作用域](#general)中可用的全部变量，一个包含了全部变量的全局组合数组。变量的名字就是数组的键。
`$_POST` |  `array`; 通过 HTTP POST 方法传递给当前脚本的变量。
`$_REQUEST` | `array`; 默认包含`$_COOKIE`, `$_GET`, 和 `$_POST` 的内容，根据引擎的配置可能包含其他内容。
`$_SERVER` |  `array`; 服务器和运行环境的信息。比如头信息（headers）、路径（path）和脚本位置（script location）等等。这个数组中的项目由 Web 服务器创建。
`$_SESSION` | `array`; 该 session 变量在当前脚本中有效。该全局变量只有当一个[session](http://php.net/manual/en/book.session.php) 激活是才是被定义的。

所有以上的 `$_*` 变量都是超全局的。变量包含的精确内容要取决于实现、编译的引擎和具体的环境。
