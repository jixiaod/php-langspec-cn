#异常处理

##常规
*exception*是在普通预期之外的一些不寻常的情况.在处理中资源是需要的,但它
不可用,并且超出了计算范围.因此,异常需要特殊的处理.本章介绍了如何创建和
处理异常.

每当在运行时检测到异常时,一个异常被*thrown*.一个指定的异常处理程序可以
*catch*抛出的异常并且处理它.在其他情况下,处理程序可以完全恢复(允许脚本
继续执行),它可能会继续工作,然后得到帮助,或者会清理行为和停止脚本.可能会
抛出异常或者显示源代码.

异常处理涉及一下关键字:

-   [`try`](11-statements.md#the-try-statement), 允许*try-block*的代码包含一个或者多个可能的产生异常的代码被尝试.
-   [`catch`](11-statements.md#the-try-statement), 定义处理捕获来自try-block或函数调用抛出具体类型的异常
-   [`finally`](11-statements.md#the-try-statement), 无论有没有在try-block发生异常，都允许执行try-block的*finally-block*(例如,一些清理的工作).
-   [`throw`](11-statements.md#the-throw-statement), 从调用throw的地方产生一个给定类型的异常

当一个异常被抛出, 一个类型为[`Exception`](#class-exception)的*exception object*,或这个类型的子类,被创建并且
第一个捕获程序可以捕获它.在其他方面,异常对象包含*exception message* 和 *exception code*,两者都可以由一个程序
决定如何处理这种情况.

PHP错误也可以通过类转化成异常[`ErrorException`](http://php.net/manual/class.errorexception.php)
(这不是本规范的一部分).

##`Exception`类

`Excetpion`类是所有异常类型的基础类.这个类定义如下:

```PHP
class Exception implements Throwable
{
  protected $message = 'Unknown exception';
  protected $code = 0;
  protected $file;
  protected $line;

  public function __construct($message = "", $code = 0,
               Throwable $previous = NULL);

  final private function __clone();
}
```
关于异常嵌套和异常的回溯,请看[trace exception](#tracing-exception).

关于基本接口信息,请看[Throwable](15-interfaces.md#interface-throwable).

注意在异常类中从Throwable集成的方法是`final`, 这意味着继承的类无法重写.

类的成员定义如下:

Name  | Purpose
----    | -------
`$code` | `int`; 异常代码(通过construct提供)
`$file` | `string`; 引起异常的脚本名
`$line` | `int`; 在脚本中引起异常的行号
`$message`  | `string`; 异常信息(通过construct提供)
`__construct` | 需要三个参数- `string`: 异常信息(默认为""), `int`:异常代码(默认为0), 和`Exception`:异常链的初部分(默认为`NULL`)
`__clone` | 阻止克隆异常对象

##异常追踪

当一个异常被捕获,在`Exception`中`get*`函数提供有用的信息.如果一个或多个嵌套
函数调用在某处获取到了一个异常,还会记录这些调用记录, 可用`getTrace`获取到
*function stack trace* 或者简单的`*trace*`

让我们吧脚本的最高级别称为*function-level* 0.
Function-level 1 是function-level 0内调用的任何函数.
Function-level 2 是function-level 1内调用的任何函数.
等等. 方法`getTrace`返回一个数组.另外在 function-level 0内没有函数调用,
在这种情况下,`getTrace`返回一个空数组.

每个通过`getTrace`返回的数组元素的信息中都指定了函数级别.让我们称这个数组
*trace-array* 和数组元素个数*call-level*.trace-array的每个元素的类型是int,
并且区间从0到call-level - 1. 例如,top-level脚本调用`f1`, 再调用`f2`, 再调
`f3`,再产生一个异常,现在有4个函数级别, 0- 3，并且有三批异常信息,一个全的调用
级别.tarce-array包含三个元素,并且是各自对应的函数调用的倒序.例如, `trace-array[0]`
是调用函数`f2`, `trace-array[1]`是调用函数`f2`, `trace-array[2]`是调用函数`f1`.

在tarce-array中的每一个元素都是数组,数组包含一下的键值元素:

Key | Value Type  | Value
--- | ----------    | -----
"args"  | `array` | 传递给函数的参数
"class" | `string` |  函数父类的名字
"file"  | `string` |  函数调用的脚本名
"function"  | `string` |  函数或类方法的名字
"line"  | `int` | 函数在资源被调用的行数
"object" |  `object` | 当前的对象
"type"  | `string` |  调用类型;实例的方法调用使用`->`,静态方法调用使用`::`,对于普通函数调用,返回空字符串(`""`).

键为`args`的值是另一种数组.那个我们应该称为*argument-array*.这个数组包含一组值,改值
对应于传递给相应函数的值的集合.关于元素的顺序,`argument-array[0]`对应左边的参数,
`argument-array[1]`对应它右边的下一个参数,等等.

注意 只有实参才会传递到函数的报告中.考虑到函数参数有默认值的情况.
如果函数调用没有使用参数并且也没有默认参数,则在参数数组中没有对应的参数.只有在函数调用上
出现的参数才会记录在参数数组中.

另见,方法库`debug_backtrace`](http://www.php.net/debug_backtrace) 和
[`debug_print_backtrace`](http://www.php.net/debug_print_backtrace).

##用户自定义异常类

简单通过继承类[`Exception`](#class-exception)来定义异常类.
然而,类的`__clone`方法是[`final`](14-classes.md#methods)声明,异常对象不能克隆.

当一个异常类被定义,通常,把构造类调用父类的构造类作为第一个操作是为了确保适当的
初始化新对象的基类部分.他们还提供[`__toString()`](14-classes.md#method-__toString)
的实现.


