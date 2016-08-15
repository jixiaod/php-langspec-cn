#类型转换

##概述

Explicit type conversion is performed using the [cast operator](10-expressions.md#cast-operator).
If an operation or language construct expects operand of one type and a value of another type is given,
implict (automatic) conversion will be performed. Same will happen with most internal functions, though some
functions may do different things depending on argument type and thus would not perform the conversion.

显示的类型转换使用[强制类型转换运算符](10-expressions.md#cast-operator)。
如果一个操作或者语言结构期望操作对象是某一种类型，但是提供的是另外一种类型的值时，
隐式（自动）类型转换就会执行。在大多数内部函数中也会有隐式的类型转换，然而有些函数会根据参数类型不行去执行不同的操作，
这种情况下不会执行类型转换。

If an expression is converted to its own type, the type and value of the
result are the same as the type and value of the expression.

如果一个表达式被转换成自己的类型，则结果的类型和值跟原表达式是相同的。

Conversions to `resource` and `null` types can not be performed.

转换为`资源`和`null`类型的操作是不能直行的。

##转换为布尔类型

The [result type] (http://www.php.net/manual/en/language.types.boolean.php#language.types.boolean.casting) is [`bool`](05-types.md#the-boolean-type).

[结果类型](http://www.php.net/manual/en/language.types.boolean.php#language.types.boolean.casting) 是 [`布尔型`](05-types.md#the-boolean-type)。

If the source type is `int` or `float`, then if the source value tests equal
to 0, the result value is `FALSE`; otherwise, the result value is `TRUE`.

如果原类型是`int`或`float`，并且原值为 0 ，转换后的结果是`FALSE`；否则，结果值是`TRUE`。

If the source value is `NULL`, the result value is `FALSE`.

如果原值是`NULL`，结果值是`FALSE`。

If the source is an empty string or the string "0", the result value is
`FALSE`; otherwise, the result value is `TRUE`.

如果原值是一个空字符串或者字符串“0”，结果值是`FALSE`；否则结果值是`TRUE`。

If the source is an array with zero elements, the result value is `FALSE`;
otherwise, the result value is `TRUE`.

如果原值是0个元素数组，结果值是`FALSE`；否则值是`TRUE`。

If the source is an object, the result value is `TRUE`.

如果原值是一个对象，结果值是`TRUE`。

If the source is a resource, the result value is `TRUE`.

如果原值是资源类型，结果值是`TRUE`。

The library function [`boolval`](http://www.php.net/boolval) allows values to be converted to
`bool`.

库函数[`boolval`](http://www.php.net/boolval)能够获取变量的布尔值。

##转换为整型

The [result type](http://www.php.net/manual/en/language.types.integer.php#language.types.integer.casting)  is [`int`](05-types.md#the-integer-type).

转换的[结果类型](http://www.php.net/manual/en/language.types.integer.php#language.types.integer.casting)是[`整型`](05-types.md#the-integer-type)。

If the source type is `bool`, then if the source value is `FALSE`, the
result value is 0; otherwise, the result value is 1.

如果原类型是`布尔型`，并且值是`FALSE`，结果值是 0 ；否则结果值是 1 。

If the source type is `float`, for the values `INF`, `-INF`, and `NAN`, the
result value is zero. For all other values, if the
precision can be preserved (that is, the float is within the range of an
integer), the fractional part is rounded towards zero. If the precision cannot
be preserved, the following conversion algorithm is used, where *X* is
defined as two to the power of the number of bits in an integer (for example,
2 to the power of 32, i.e. 4294967296):

如果原值类型是`float`，当值是`INF`、`-INF`、`NAN`时，结果值是 0 。对于是其他值，如果
精度可以保存（也就是说，浮动是在一个整数的范围内），小数部分是趋近于零的。
如果精度不能被保留，会使用下面的转换算法，其中*X*被定义为2平方的整数（例如，2的32次方，即4294967296）

 1. We take the floating point remainder (wherein the remainder has the same
    sign as the dividend) of dividing the float by *X*, rounded towards zero.
 2. If the remainder is less than zero, it is rounded towards
    infinity and *X* is added.
 3. This result is converted to an unsigned integer.
 4. This result is converted to a signed integer by treating the unsigned
    integer as a two's complement representation of the signed integer.

Implementations may implement this conversion differently (for example, on some
architectures there may be hardware support for this specific conversion mode)
so long as the result is the same.

If the source value is `NULL`, the result value is 0.

如果原值是`NULL`，结果值是 0。

If the source is a [numeric string or leading-numeric string](05-types.md#the-string-type)
having integer format, if the precision can be preserved the result
value is that string's integer value; otherwise, the result is
undefined. If the source is a numeric string or leading-numeric string
having floating-point format, the string's floating-point value is
treated as described above for a conversion from `float`. The trailing
non-numeric characters in leading-numeric strings are ignored.  For any
other string, the result value is 0.

If the source is an array with zero elements, the result value is 0;
otherwise, the result value is 1.

If the source is an object, if the class defines a conversion function,
the result is determined by that function (this is currently available only to internal classes).
If not, the conversion is invalid, the result is assumed to be 1 and a non-fatal error is produced.

If the source is a resource, the result is the resource's unique ID.

The library function [`intval`](http://php.net/manual/function.intval.php) allows values
to be converted to `int`.

##Converting to Floating-Point Type

The [result type](http://www.php.net/manual/en/language.types.float.php#language.types.float.casting) is [`float`](05-types.md#the-floating-point-type).

If the source type is `int`, if the precision can be preserved the result
value is the closest approximation to the source value; otherwise, the
result is undefined.

If the source is a [numeric string or leading-numeric string](05-types.md#the-string-type)
having integer format, the string's integer value is treated as
described above for a conversion from `int`. If the source is a numeric
string or leading-numeric string having floating-point format, the
result value is the closest approximation to the string's floating-point
value. The trailing non-numeric characters in leading-numeric strings
are ignored. For any other string, the result value is 0.

If the source is an object, if the class defines a conversion function,
the result is determined by that function (this is currently available only to internal classes).
If not, the conversion is invalid, the result is assumed to be 1.0 and a non-fatal error is produced.

For sources of all other types, the conversion result is obtained by first
[converting the source value to `int`](#converting-to-integer-type) and then to `float`.

The library function [`floatval`](http://www.php.net/floatval) allows values to be converted to
float.

##Converting to String Type

The [result type](http://www.php.net/manual/en/language.types.string.php#language.types.string.casting) is [`string`](05-types.md#the-string-type).

If the source type is `bool`, then if the source value is `FALSE`, the
result value is the empty string; otherwise, the result value is "1".

If the source type is `int` or `float`, then the result value is a string
containing the textual representation of the source value (as specified
by the library function [`sprintf`](http://www.php.net/sprintf)).

If the source value is `NULL`, the result value is the empty string.

If the source is an array, the conversion is invalid. The result value is
the string "Array" and a non-fatal error is produced.

If the source is an object, then if that object's class has a
[`__toString` method](14-classes.md#method-__tostring), the result value is the string returned
by that method; otherwise, the conversion is invalid and a fatal error is produced.

If the source is a resource, the result value is an
implementation-defined string.

The library function [`strval`](http://www.php.net/strval) allows values to be converted to
string.

##Converting to Array Type

The [result type](http://www.php.net/manual/en/language.types.array.php#language.types.array.casting) is [`array`](05-types.md#the-array-type).

If the source value is `NULL`, the result value is an array of zero
elements.

If the source type is scalar or `resource` and it is non-`NULL`, the result value is
an array of one element under the key 0 whose value is that of the source.

If the source is an object, the result is
an [array](http://php.net/manual/language.types.array.php) of
zero or more elements, where the elements are key/value pairs
corresponding to the
[object](http://php.net/manual/language.types.object.php)'s
instance properties. The order of insertion of the elements into the
array is the lexical order of the instance properties in the
[*class-member-declarations*](14-classes.md#class-members) list.

For public instance properties, the keys of the array elements would
be the same as the property name.

The key for a private instance property has the form "\\0*class*\\0*name*",
where the *class* is the class name, and the *name* is the property name.

The key for a protected instance property has the form "\\0\*\\0*name*",
where *name* is that of the property.

The value for each key is that from the corresponding property, or `NULL` if
the property was not initialized.

##转换为对象类型

The [result type](http://www.php.net/manual/en/language.types.object.php#language.types.object.casting) is [`object`](05-types.md#objects).

转换[结果类型](http://www.php.net/manual/en/language.types.object.php#language.types.object.casting) 是[`对象`](05-types.md#objects)。

If the source has any type other than object, the result is an instance
of the predefined class [`stdClass`](14-classes.md#class-stdclass). If the value of the source
is `NULL`, the instance is empty. If the value of the source has a scalar
type and is non-`NULL`, or is a `resource`, the instance contains a public property called
`scalar` whose value is that of the source. If the value of the source is
an array, the instance contains a set of public properties whose names
and values are those of the corresponding key/value pairs in the source.
The order of the properties is the order of insertion of the source's
elements.


