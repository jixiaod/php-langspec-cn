#类型转换

##概述

显式的类型转换使用[强制类型转换运算符](10-expressions.md#cast-operator)。
如果一个操作或者语言结构期望操作对象是某一种类型，但是提供的是另外一种类型的值时，
隐式（自动）类型转换就会执行。在大多数内部函数中也会有隐式的类型转换，
然而有些函数会根据参数类型不同,从而去执行不同的操作，
这种情况下不会执行类型转换。

如果一个类型被转换成自己原来的类型，则结果的类型和值跟原来是相同的。

不允许转换为`资源`和`null`类型。

##转换为布尔类型

转换的[结果类型](http://www.php.net/manual/en/language.types.boolean.php#language.types.boolean.casting) 是 [`布尔型`](05-types.md#the-boolean-type)。

如果原类型是`int`或`float`，并且原值为 0 ，转换后的结果是`FALSE`；否则，结果值是`TRUE`。

如果原值是`NULL`，结果值是`FALSE`。

如果原值是一个空字符串或者字符串“0”，结果值是`FALSE`；否则结果值是`TRUE`。

如果原值是一个包涵 0 个元素的数组，结果值是`FALSE`；否则值是`TRUE`。

如果原值是一个对象，结果值是`TRUE`。

如果原值是资源类型，结果值是`TRUE`。

内置函数[`boolval`](http://www.php.net/boolval)能够获取变量的布尔值。

##转换为整型

转换的[结果类型](http://www.php.net/manual/en/language.types.integer.php#language.types.integer.casting)是[`整型`](05-types.md#the-integer-type)。

如果原类型是`布尔型`，并且值是`FALSE`，结果值是 0 ；否则结果值是 1 。

If the source type is `float`, for the values `INF`, `-INF`, and `NAN`, the
result value is zero. For all other values, if the
precision can be preserved (that is, the float is within the range of an
integer), the fractional part is rounded towards zero. If the precision cannot
be preserved, the following conversion algorithm is used, where *X* is
defined as two to the power of the number of bits in an integer (for example,
2 to the power of 32, i.e. 4294967296):

如果原值类型是`float`，对于值是`INF`、`-INF`、`NAN`时，结果值是 0 (PHP7 下测试是 0，PHP5.6 是-9223372036854775808)。
如果浮点数在精度范围内，浮点数向零取整，小数部分趋近于零。（以下内容没有理解透彻，暂不翻译）

 1. We take the floating point remainder (wherein the remainder has the same
    sign as the dividend) of dividing the float by *X*, rounded towards zero.
 2. If the remainder is less than zero, it is rounded towards
    infinity and *X* is added.
 3. This result is converted to an unsigned integer.
 4. This result is converted to a signed integer by treating the unsigned
    integer as a two's complement representation of the signed integer.


这种转换可以使用不同的方法实现（比如，在某些架构可能有特定的硬件支持特定的转换模式），
只要转换结果相同即可。 

如果原值是`NULL`，结果值是 0。

字符串转换为整型。如果是一个[数字字符串或者以数字开头的字符串](05-types.md#the-string-type)，拥有整型的格式，
而且精度可以保留，则结果值是该字符串的整型值；否则结果是 undefined。如果是一个数字字符串或者以数字开头的字符串，
但是数字是浮点数类型的格式，根据上面的转换`浮点数`的方法转换字符串中的浮点数值。忽略字符串中的非数字后缀被。对于其他字符串，
结果值是 0 。

从数组转换为整型。如果是从一个只有0个元素的数组转换为整型，结果值是 0 ；否则结果值是 1 。

从Object 转换成整型，如果类实现定义了一个转换方法函数，则结果根据该函数获得（这个目前只有在内置类中可用）。
如果没有定义转换函数，则转换非法，结果被假定为 1，且抛出一个非致命错误。

如果从资源类型转换为整型，结果值是资源的唯一 ID 。

内置函数[`intval`](http://php.net/manual/function.intval.php) 可以转换一个值为`整型`。

##转换为浮点数类型

转换的[结果类型](http://www.php.net/manual/en/language.types.float.php#language.types.float.casting) 是 [`浮点数`](05-types.md#the-floating-point-type)。

If the source type is `int`, if the precision can be preserved the result
value is the closest approximation to the source value; otherwise, the
result is undefined.

从整型转换为浮点数类型，如果精度可以保留，则结果值是一个最接近原值的浮点数；
否则结果不可预期。（觉得此处原文有问题，整型转换为浮点数没那么复杂，不过对于过长整型数字会有如下自动转换。）

```
// 64位系统，PHP 5.6 / PHP 7
$int = 9223372036854775807;
$float = (float)$int;
var_dump($int);
var_dump($float);


output:
int(9223372036854775807)
float(9.2233720368548E+18)
```

对于字符串转换为浮点类型，如果是一个[数字字符串或者以数字开头的字符串](05-types.md#the-string-type)，拥有整型的格式，
而且精度可以保留，则结果值是该字符串的整型值；如果是浮点数形式或者是以浮点数形势开头的字符串，结果值是跟字符串中浮点数最接近的一个值。
忽略字符串中的非数字后缀被。对于其他字符串，结果值是 0 。

对于一个对象，如果类实现定义了一个转换函数，转换结果由该函数决定（这种情况目前只有在内置函数中实现）。
如果没有转换函数，则转换是非法的，结果值被假定为 1.0 ，且会抛出一个非致命错误。

对于其他所有类型，转换结果需要遵循[转换为整型](#converting-to-integer-type)，然后在转换为`float`。

内置函数[`floatval`](http://www.php.net/floatval)能够获取变量的浮点数值。

##转换为字符串类型

转换的[结果类型](http://www.php.net/manual/en/language.types.string.php#language.types.string.casting) 是 [`字符串`](05-types.md#the-string-type)。

如果原类型是`bool`，并且原值是`FALSE`，那么结果值是空字符串；否则结果值是"1"。

如果原类型是`int`或`float`，那么结果值是原值的文本的一个字符串（可以用库函数[`sprintf`](http://www.php.net/sprintf)来说明）。

如果原值是`NULL`，结果值是一个空字符串。

如果原类型是一个数组，那么转换是非法的。转换的结果值是一个"Array"字符串，并且抛出一个非致命错误。

如果原类型是一个 Object 对象，并且如果该对象有[`__toString`方法](14-classes.md#method-__tostring)，则该结果值
即是由该`__toString`方法返回的字符串；否则，转换是无效的，且抛出一个致命错误。

If the source is a resource, the result value is an
implementation-defined string.

如果原类型是资源类型，结果值是运行时定义的一个字符串。（形式是"Resource id #1" 的字符串，其中的 1 是 PHP 在运行时分配给该 resource 的唯一值。） 

库函数[`strval`](http://www.php.net/strval)可以用来转换一个值为字符串。

##转换为数组

转换后的[结果类型](http://www.php.net/manual/en/language.types.array.php#language.types.array.casting)是[`数组`](05-types.md#the-array-type)。

如果原值是`NULL`，则结果值是一个 0 个元素的空数组。

如果原类型是标量类型或者`资源类型`，并且是非`NULL`，则结果值是元素是一个以 0 为 key，转换前原的值为对应值的数组。

如果原类型是一个对象，则结果是一个包含 0 个或多个元素的[数组](http://php.net/manual/language.types.array.php)，
并且数组的元素是该[对象]((http://php.net/manual/language.types.object.php))实例属性的键值对。并且元素插入数组中的顺序
是按照[*类成员声明*](14-classes.md#class-members)实例属性列表的顺序。

对于 Public 的实例属性，数组元素的键值跟属性名称是一样的。

Private 实例属性的键值的格式是"\\0*class*\\0*name*"，其中 *class* 是类的名称，*name* 是属性的名称。

Protected 实例属性的键值格式是"\\0\*\\0*name*"，*name* 是属性的名称。

每个 key 对应的值即是赋予这个属性的值，如果属性没有初始化，值就是`NULL`。

##转换为对象类型

转换[结果类型](http://www.php.net/manual/en/language.types.object.php#language.types.object.casting) 是[`对象`](05-types.md#objects)。

如果一个其他任意类型的值被转换成对象，将会创建一个内置类[`stdClass`](14-classes.md#class-stdclass)。
如果该值为`NULL`，则新的实例为空。如果该值是一个标量类型且非`NULL`，或者是一个`资源类型`，则转换后的实例
会包含一个叫做`scalar`的成员成员变量，对应的值是原值。数组转换成对象将使键名成为属性名并具有相对应的值，属性的顺序同
数组插入的顺序。

