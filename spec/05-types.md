#类型

#概述

一个值的含义是由它的“类型”决定的。PHP 语言的类型可以分为“标量类型”和“复合类型”。
标量类型有[Boolean](#the-boolean-type)，[integer](#the-integer-type), [floating point](#the-floating-point-type), [string](#the-string-type)和[null](#the-null-type)。复合类型有[array](#the-array-type)和[object](#objects)。
[resource](#resources)是一种隐含类型，它的内部结构没有明确定义，并且依赖于具体的实现。

标量类型是“值的类型”。也就是说，一个标量类型的变量就是它的值本身。（是数据结构中最基本单元，只能储存一个数据。）

复合类型除了包含它本身的变量以外，还可以包含其他变量。比如，数组还包含属于它的元素，对象还包含它的属性。

对象和资源都是“句柄类型”。句柄类型中包含了指向一个值的“句柄”信息。在理解了给函数赋值、传递参数给函数、函数的返回值的[语义](04-basic-concepts.md#the-memory-model)之后，值和句柄类型之间的差别就会变得更加明显。

变量并没有被明确的定义成某一个类型，而且一个变量的类型是在运行时根据它本身包含的值决定的。
在运行时的不同时刻，同一个变量有可能是任意不同的类型。

PHP 的内置函数中提供了几个有用的检查和设置类型的方法，包括
[`gettype`](http://www.php.net/gettype)， [`is_type`](http://www.php.net/is_type)， [`settype`](http://www.php.net/settype)，和[`var_dump`](http://www.php.net/var_dump)。

##标量类型

###概述

整型和浮点类型被统称为“算数类型”。库函数[`is_numeric`](http://www.php.net/is_numeric)用来判断一个值
是一个数字还是一个数字[字符串](#the-string-type)。

库函数[`is_scalar`](http://www.php.net/is_scalar)用来判断一个值是否是标量类型。该函数不认为`NULL`
是一个标量类型。可以用[`is_null`](http://www.php.net/is_null)来判断`NULL`。

某些类支持运算和标量运算，或者转换为标量类型（目前只在内部类中实现）。这些类和标量类型一起
被称作“兼容标量类型”。需要注意的是，同一个类对于一个运算可能是标量兼容的，但是对其他的运算可能并不是。

###布尔类型

布尔类型就是 `bool`，`bool`就是`boolean`的一个代名词。此类型包含俩个不同的值，分别对应
[`true`和`false`](06-constants.md#core-predefined-constants)。布尔类型的内部表示和它的值是不确定的。

库函数[`is_bool`](http://www.php.net/is_bool) 可以判断一个值是否是`布尔型`。

###整数类型

有一个整数类型`int`，他是`integer`的代名词。该类型是二进制的，有符号的，且用二进制补码表示负值。
整型的数值的取值范围是可以在 PHP 实现中定义的，[-2147483648, 2147483647]的这个范围是一定能够被系统
支持的。而且这个范围必须是有界限的，不能是无穷的。

整型类型的值在某些操作后，产生的数学结果不能被表示为一个整型。包含以下情况：

-   值增大后超过最大值，或者值减小后小于最小值。
-   对最小值赋予负号。
-   相乘、相加或相减俩个值。

在这些情况下，当计算完成，这些值的类型都被转换为`float`。

常量[`PHP_INT_SIZE`，`PHP_INT_MIN`和`PHP_INT_MAX`](06-constants.md#core-predefined-constants)确切的定义了`int`的属性。

库函数[`is_int`](http://www.php.net/is_int)用来判断一个值是否是`int`。

###浮点数类型

有一个浮点数类型`float`，它是`double`和`real`的代名词。浮点数类型需要至少支持
IEEE 754 64位双精度的取值范围的表示。

库函数[`is_float`](http://www.php.net/is_float) 用来判断类型是否是`float`。
库函数[`is_finite`](http://www.php.net/is_finite) 用来判断给定的值
是否是有限值。库函数[`is_infinite`](http://www.php.net/is_infinite) 用来判断是否是无限值。
[`is_nan`](http://www.php.net/is_nan) 用来判断是否是合法数值。

###字符串类型

一个字符串是一组零序列或多个字符的连续字节。

从概念上说，一个字符串可以被考虑成一个字节[数组](#array-types)，这个数组的键值是从零开始的`int`值。 
每个元素的类型都是`string`。然而一个字符串并*不是*一个集合，所以它不能被遍历。

一个长度为0的字符串是一个*空字符串*。

至于一个字符串中的字节是如何转换成字符的是不确定的。

虽然字符串的用户可能会选择把特殊的语义归咎于字节中有`\0`的值，从PHP的角度看，"null bytes"没有
特殊的意义。PHP 并没有假设字符串中包含任何特殊数据，或者把特殊的值赋予任何字节和语句。然而，很多库函数
假设它们接收到的参数是UTF-8的编码，但是往往没有明确提到这一点。

一个*数值字符串*是符合下面*str-numeric*模式定义的字符串。一个*数值前缀字符串*是
起始的字符符合数值字符串需求，后面的字符不是数值的字符串。不是一个数值字符串的
字符串成为一个*非数值字符串*。

<pre>
  <i>str-numeric::</i>
    <i>str-whitespace<sub>opt</sub>   sign<sub>opt</sub>   str-number</i>

  <i>str-whitespace::</i>
    <i>str-whitespace<sub>opt</sub>   str-whitespace-char</i>

  <i>str-whitespace-char::</i>
    <i>new-line</i>
    Space character (U+0020)
    Horizontal-tab character (U+0009)
    Vertical-tab character (U+000B)
    Form-feed character (U+000C)

  <i>str-number::</i>
    <i>digit-sequence</i>
    <i>floating-literal</i>
</pre>

**其他地方的定义**

* [*digit-sequence*](09-lexical-structure.md#floating-point-literals)
* [*floating-literal*](09-lexical-structure.md#floating-point-literals)
* [*new-line*](09-lexical-structure.md#comments)
* [*sign*](09-lexical-structure.md#floating-point-literals)

需要注意的是，数位序列被解释成10进制的数值（因此`"0377"`被视为有一个冗余前导零的
十进制数字377，而不是八进制的377）。

Only one mutation operation may be performed on a string, offset
assignment, which involves the simple assignment [operator =](10-expressions.md#simple-assignment).

判断一个值是否是字符串的库函数式[`is_string`](http://www.php.net/is_string)。

###Null 类型

Null 类型只有一个可能的值，[`NULL`](06-constants.md#core-predefined-constants)。它表示它的类型和值都是没有定义的。

用库函数[`is_null`](http://www.php.net/is_null) 来判断一个值是否是`NULL`。

##复合类型

###数组

数组是一个包含零个或多个元素的数据结构，它的值通过由类型是`int`或`string`的键值来访问。
更多细节，请移步 [arrays chapter](12-arrays.md#arrays)。

判断是否是数组的函数是[`is_array`](http://www.php.net/is_array)。

###对象

*对象*是[类](14-classes.md#classes)的一个实例。每个不同的[*类声明*](14-classes.md#class-declarations)都定义了一个新的类的类型，
每一个类的类型都是一个对象的类型。对象类型的表示是不确定的。

库函数[`is_object`](http://www.php.net/is_object)用来判断一个值是否是一个对象。[`get_class`](http://php.net/manual/function.get-class.php)返回对象的类名称。

###资源

[*资源*](http://php.net/manual/language.types.resource.php) 是外部资源的一个引用。
包括打开文件、数据库连接和网络套接字。

资源是一个表现不确定的抽象实体。资源只有在代码运行时被创建和销毁，而不是体现在PHP代码中。

每个不同的资源都有不同形式的唯一标识。

[`is_resource`](http://www.php.net/is_resource) 函数判断一个变量是否是资源类型。函数[`get_resource_type`]能够返回一个资源的类型。

##待完善内容
Callback 回调类型和伪类型

