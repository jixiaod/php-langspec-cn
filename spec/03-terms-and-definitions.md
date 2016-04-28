#术语和定义
为了编写该PHP规范文档，使用以下的术语和规范：

<dl>
    <dt>参数(实参)</dt>
    <dd>传递给函数的一个值，把这个值映射给函数绑定的参数(形参)。</dd>

    <dt>行为</dt>
    <dd>外部表现或动作。</dd>

    <dt>实现定义的行为</dt>
    <dd>具体的行为实现，且该实现必须对该行为进行记录。</dd>

    <dt>未定义的行为</dt>
    <dd>行为不保证产生具体的结果。通常是因为错误的程序或者数据造成的。</dd>

    <dt>未指明的行为</dt>
    <dd>说明中未做要求的行为。</dd>

    <dt>约束</dt>
    <dd>限制语法和语义在作为语言元素时如何使用。</dd>

    <dt>致命错误</dt>
    <dd>系统不能再继续执行脚本的情况，必须终止执行。</dd>

    <dt>可捕捉的致命错误</dt>
    <dd>能够被用户定义的处理程序捕捉的致命错误。</dd>

    <dt>非致命的错误</dt>
    <dd>不是一个致命错误，允许系统继续执行该程序。</dd>

    <dt>左值</dt>
    <dd>指定一个位置来存储一个值的表达式。</dd>

    <dt>可修改的左值</dt>
    <dd>一个值能够被修改的左值。</dd>

    <dt>不能修改的左值</dt>
    <dd>一个值不能被修改的左值。</dd>

    <dt>提示</dt>
    <dd>通知用户代码可能无法正常工作的消息。</dd>

    <dt>参数（形参）</dt>
    <dd>声明函数时，在函数参数列表中一个变量。将会在函数被调用时，被映射并绑定一个参数（实参）。</dd>

    <dt>PHP运行时引擎</dt>
    <dd>执行PHP程序的软件。在该PHP编码规范文档中，被称作 <em>引擎</em>。</dd>

    <dt>值</dt>
    <dd>具有一个类型，并且会对应该类型会有另外一个存储的内容，能够被引擎做数据操作的原始单元。</dd>
</dl>

如果有其他的术语和定义，根据需要，可以参照以上的排版添加到这里。


