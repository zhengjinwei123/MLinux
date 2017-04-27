# 正则表达式
> 工作中遇到的复杂的字符串处理我们都会想到使用正则表达式，它已经是不可或缺的一部分，掌握正则尤为重要。

#### 常用规则一览表

| 字符       	| 描述           |
| ------------- |:-------------:|
| \				| 将下一个字符标记为一个特殊字符、或一个原义字符、或一个 向后引用、或一个八进制转义符。例如，'n' 匹配字符 "n"。'\n' 匹配一个换行符。序列 '\\' 匹配 "\" 而 "\(" 则匹配 "("。|
| ^				| 匹配输入字符串的开始位置。如果设置了 RegExp 对象的 Multiline 属性，^ 也匹配 '\n' 或 '\r' 之后的位置。|
| $				| 匹配输入字符串的结束位置。如果设置了RegExp 对象的 Multiline 属性，$ 也匹配 '\n' 或 '\r' 之前的位置。|
| *				| 匹配前面的子表达式零次或多次。例如，zo* 能匹配 "z" 以及 "zoo"。* 等价于{0,}。|
| +				| 匹配前面的子表达式一次或多次。例如，'zo+' 能匹配 "zo" 以及 "zoo"，但不能匹配 "z"。+ 等价于 {1,}。|
| ?				| 匹配前面的子表达式零次或一次。例如，"do(es)?" 可以匹配 "do" 或 "does" 中的"do" 。? 等价于 {0,1}。|
| {n}			| n 是一个非负整数。匹配确定的 n 次。例如，'o{2}' 不能匹配 "Bob" 中的 'o'，但是能匹配 "food" 中的两个 o。|
| {n,}			| n 是一个非负整数。至少匹配n 次。例如，'o{2,}' 不能匹配 "Bob" 中的 'o'，但能匹配 "foooood" 中的所有 o。'o{1,}' 等价于 'o+'。'o{0,}' 则等价于 'o*'。|
| {n,m}			| m 和 n 均为非负整数，其中n <= m。最少匹配 n 次且最多匹配 m 次。例如，"o{1,3}" 将匹配 "fooooood" 中的前三个 o。'o{0,1}' 等价于 'o?'。请注意在逗号和两个数之间不能有空格。|
| ?				| 当该字符紧跟在任何一个其他限制符 (*, +, ?, {n}, {n,}, {n,m}) 后面时，匹配模式是非贪婪的。非贪婪模式尽可能少的匹配所搜索的字符串，而默认的贪婪模式则尽可能多的匹配所搜索的字符串。例如，对于字符串 "oooo"，'o+?' 将匹配单个 "o"，而 'o+' 将匹配所有 'o'。|
| .				| 匹配除 "\n" 之外的任何单个字符。要匹配包括 '\n' 在内的任何字符，请使用象 '[.\n]' 的模式。|
| (pattern)		| 匹配 pattern 并获取这一匹配。所获取的匹配可以从产生的 Matches 集合得到，在VBScript 中使用 SubMatches 集合，在JScript 中则使用 $0…$9 属性。要匹配圆括号字符，请使用 '\(' 或 '\)'。|
| (?:pattern)	| 匹配 pattern 但不获取匹配结果，也就是说这是一个非获取匹配，不进行存储供以后使用。这在使用 "或" 字符 (/) 来组合一个模式的各个部分是很有用。例如， 'industr(?:y/ies) 就是一个比 'industry/industries' 更简略的表达式。(`这里的斜杠表示竖杠`)|
| (?=pattern)	| 正向预查，在任何匹配 pattern 的字符串开始处匹配查找字符串。这是一个非获取匹配，也就是说，该匹配不需要获取供以后使用。例如，'Windows (?=95/98/NT/2000)' 能匹配 "Windows 2000" 中的 "Windows" ，但不能匹配 "Windows 3.1" 中的 "Windows"。预查不消耗字符，也就是说，在一个匹配发生后，在最后一次匹配之后立即开始下一次匹配的搜索，而不是从包含预查的字符之后开始。(`这里的斜杠表示竖杠`)|
| (?!pattern)	| 负向预查，在任何不匹配 pattern 的字符串开始处匹配查找字符串。这是一个非获取匹配，也就是说，该匹配不需要获取供以后使用。例如'Windows (?!95/98/NT/2000)' 能匹配 "Windows 3.1" 中的 "Windows"，但不能匹配 "Windows 2000" 中的 "Windows"。预查不消耗字符，也就是说，在一个匹配发生后，在最后一次匹配之后立即开始下一次匹配的搜索，而不是从包含预查的字符之后开始 (`这里的斜杠表示竖杠`)|
| x/y			(`这里的斜杠表示竖杠`)| 匹配 x 或 y。例如，'z/food' 能匹配 "z" 或 "food"。'(z/f)ood' 则匹配 "zood" 或 "food"。(`这里的斜杠表示竖杠`)|
| [xyz]			| 字符集合。匹配所包含的任意一个字符。例如， '[abc]' 可以匹配 "plain" 中的 'a'。|
| [^xyz]		| 负值字符集合。匹配未包含的任意字符。例如， '[^abc]' 可以匹配 "plain" 中的'p'。|
| [a-z]			| 字符范围。匹配指定范围内的任意字符。例如，'[a-z]' 可以匹配 'a' 到 'z' 范围内的任意小写字母字符。|
| [^a-z]		| 负值字符范围。匹配任何不在指定范围内的任意字符。例如，'[^a-z]' 可以匹配任何不在 'a' 到 'z' 范围内的任意字符。
| \b			| 匹配一个单词边界，也就是指单词和空格间的位置。例如， 'er\b' 可以匹配"never" 中的 'er'，但不能匹配 "verb" 中的 'er'。|
| \B			| 匹配非单词边界。'er\B' 能匹配 "verb" 中的 'er'，但不能匹配 "never" 中的 'er'。|
| \cx			| 匹配由 x 指明的控制字符。例如， \cM 匹配一个 Control-M 或回车符。x 的值必须为 A-Z 或 a-z 之一。否则，将 c 视为一个原义的 'c' 字符。|
| \d			| 匹配一个数字字符。等价于 [0-9]。|
| \D			| 匹配一个非数字字符。等价于 [^0-9]。|
| \f			| 匹配一个换页符。等价于 \x0c 和 \cL。|
| \n			| 匹配一个换行符。等价于 \x0a 和 \cJ。|
| \r			| 匹配一个回车符。等价于 \x0d 和 \cM。|
| \s			| 匹配任何空白字符，包括空格、制表符、换页符等等。等价于 [ \f\n\r\t\v]。|
| \S			| 匹配任何非空白字符。等价于 [^ \f\n\r\t\v]。|
| \t			| 匹配一个制表符。等价于 \x09 和 \cI。|
| \v			| 匹配一个垂直制表符。等价于 \x0b 和 \cK。|
| \w			| 匹配包括下划线的任何单词字符。等价于'[A-Za-z0-9_]'。|
| \W			| 匹配任何非单词字符。等价于 '[^A-Za-z0-9_]'。|
| \xn			| 匹配 n，其中 n 为十六进制转义值。十六进制转义值必须为确定的两个数字长。例如，'\x41' 匹配 "A"。'\x041' 则等价于 '\x04' & "1"。正则表达式中可以使用 ASCII 编码。|
| \num			| 匹配 num，其中 num 是一个正整数。对所获取的匹配的引用。例如，'(.)\1' 匹配两个连续的相同字符。|
| \n			| 标识一个八进制转义值或一个向后引用。如果 \n 之前至少 n 个获取的子表达式，则 n 为向后引用。否则，如果 n 为八进制数字 (0-7)，则 n 为一个八进制转义值。|
| \nm			| 标识一个八进制转义值或一个向后引用。如果 \nm 之前至少有 nm 个获得子表达式，则 nm 为向后引用。如果 \nm 之前至少有 n 个获取，则 n 为一个后跟文字 m 的向后引用。如果前面的条件都不满足，若 n 和 m 均为八进制数字 (0-7)，则 \nm 将匹配八进制转义值 nm。|
| \nml			| 如果 n 为八进制数字 (0-3)，且 m 和 l 均为八进制数字 (0-7)，则匹配八进制转义值 nml。|
| \un			| 匹配 n，其中 n 是一个用四个十六进制数字表示的 Unicode 字符。例如， \u00A9 匹配版权符号 (?)。|

## javascript 中正则表达式的使用
> javascript 中使用 `RegExp`对象 表示正则表达式,使用它可以对字符串进行模式匹配
> 正则表达式的基本语法有2种：</br>
> 1.直接量语法:</br>
> /pattern/attributes </br>
> 2.创建RegExp对象</br>
> new RegExp(pattern,attributes); </br>
> 参数说明:参数pattern 是一个字符串，指定了正则表达式模式；参数attributes 是一个可选的参数，包含属性g,i,m,分别表示全局匹配、不区分大小写、多行匹配。</br>
> 返回值：一个新的RegExp对象，具有指定的模式和标志

### js 提供的API
##### `search()方法`

``` javascript
该方法用于检索字符串中指定的子字符串，或检索与正 则表达式相匹配的字符串。

基本语法：stringObject.search(regexp);
        @param 参数regexp可以需要在stringObject中检索的字符串，也可以 是需要检索的RegExp对象。
        @return(返回值) stringObject中第一个与regexp对象相匹配的子串的起 始位置。如果没有找到任何匹配的子串，则返回-1；

注意：search()方法不执行全局匹配，它将忽略标志g，同时它也没有regexp对象的lastIndex的属性，且总是从字符串开始位置进行查找，总是返回的是stringObject匹配的第一个位置。

例如:
var str = "hello world,hello world";
// 返回匹配到的第一个位置(使用的regexp对象检索)
console.log(str.search(/hello/)); // 0
// 没有全局的概念 总是返回匹配到的第一个位置
console.log(str.search(/hello/g)); //0
console.log(str.search(/world/)); // 6
// 也可以是检索字符串中的字符
console.log(str.search("wo")); // 6
// 如果没有检索到的话，则返回-1
console.log(str.search(/longen/)); // -1
// 我们检索的时候 可以忽略大小写来检索
var str2 = "Hello";
console.log(str2.search(/hello/i)); // 0
```

##### `match()方法`

``` javascript
该方法用于在字符串内检索指定的值，或找到一个或者多个正则表达式的匹配。该方法类似于indexOf()或者lastIndexOf(); 但是它返回的是指定的值，而不是字符串的位置；

基本语法：

   stringObject.match(searchValue) 或者stringObject.match(regexp)

   @param(参数)

   searchValue 需要检索字符串的值；

    regexp: 需要匹配模式的RegExp对象；

   @return(返回值) 存放匹配成功的数组; 它可以全局匹配模式，全局匹配的话，它返回的是一个数组。如果没有找到任何的一个匹配，那么它将返回的是null；返回的数组内有三个元素，第一个元素的存放的是匹配的文本，还有二个对象属性；index属性表明的是匹配文本的起始字符在stringObject中的位置；input属性声明的是对stringObject对象的引用；

例如：
var str = "hello world";
console.log(str.match("hello")); // ["hello", index: 0, input: "hello world"]
console.log(str.match("Hello")); // null
console.log(str.match(/hello/)); // ["hello", index: 0, input: "hello world"]
// 全局匹配
var str2="1 plus 2 equal 3"
console.log(str2.match(/\d+/g)); //["1", "2", "3"]
```

##### `replace()方法`

``` javascript
该方法用于在字符串中使用一些字符替换另一些字符，或者替换一个与正则表达式匹配的子字符串；

    基本语法：stringObject.replace(regexp/substr,replacement);

   @param(参数)

    regexp/substr; 字符串或者需要替换模式的RegExp对象。

    replacement：一个字符串的值，被替换的文本或者生成替换文本的函数。

   @return(返回值)  返回替换后的新字符串

   注意：字符串的stringObject的replace()方法执行的是查找和替换操作，替换的模式有2种，既可以是字符串，也可以是正则匹配模式，如果是正则匹配模式的话，那么它可以加修饰符g,代表全局替换，否则的话，它只替换第一个匹配的字符串；

replacement 既可以是字符串，也可以是函数，如果它是字符串的话，那么匹配的将与字符串替换，replacement中的$有具体的含义，如下：

1,1,2,3....3....99 含义是：与regexp中的第1到第99个子表达式相匹配的文本。
$& 的含义是：与RegExp相匹配的子字符串。
lastMatch或RegExp["$_"]的含义是：返回任何正则表达式搜索过程中的最后匹配的字符。
lastParen或 RegExp["$+"]的含义是：返回任何正则表达式查找过程中最后括号的子匹配。
leftContext或RegExp["$`"]的含义是：返回被查找的字符串从字符串开始的位置到最后匹配之前的位置之间的字符。
rightContext或RegExp["$'"]的含义是：返回被搜索的字符串中从最后一个匹配位置开始到字符串结尾之间的字符。

例如：
var str = "hello world";
// 替换字符串
var s1 = str.replace("hello","a");
console.log(s1);// a world
// 使用正则替换字符串
var s2 = str.replace(/hello/,"b");
console.log(s2); // b world

// 使用正则全局替换 字符串
var s3 = str.replace(/l/g,'');
console.log(s3); // heo word

// $1,$2 代表的是第一个和第二个子表达式相匹配的文本
// 子表达式需要使用小括号括起来,代表的含义是分组
var name = "longen,yunxi";
var s4 = name.replace(/(\w+)\s*,\s*(\w+)/,"$2 $1");
console.log(s4); // "yunxi,longen"

// $& 是与RegExp相匹配的子字符串
var name = "hello I am a chinese people";
var regexp = /am/g;
if(regexp.test(name)) {
    //返回正则表达式匹配项的字符串
    console.log(RegExp['$&']);  // am

    //返回被搜索的字符串中从最后一个匹配位置开始到字符串结尾之间的字符。
    console.log(RegExp["$'"]); // a chinese people

    //返回被查找的字符串从字符串开始的位置到最后匹配之前的位置之间的字符。
    console.log(RegExp['$`']);  // hello I

    // 返回任何正则表达式查找过程中最后括号的子匹配。
    console.log(RegExp['$+']); // 空字符串

    //返回任何正则表达式搜索过程中的最后匹配的字符。
    console.log(RegExp['$_']);  // hello I am a chinese people
}

// replace 第二个参数也可以是一个function 函数
var name2 = "123sdasadsr44565dffghg987gff33234";
name2.replace(/\d+/g,function(v){
    console.log(v);
    /*
     * 第一次打印123
     * 第二次打印44565
     * 第三次打印987
     * 第四次打印 33234
     */
});
/*
 * 如下函数，回调函数参数一共有四个
 * 第一个参数的含义是 匹配的字符串
 * 第二个参数的含义是 正则表达式分组内容，没有分组的话，就没有该参数,
 * 如果没有该参数的话那么第四个参数就是undefined
 * 第三个参数的含义是 匹配项在字符串中的索引index
 * 第四个参数的含义是 原字符串
 */
 name2.replace(/(\d+)/g,function(a,b,c,d){
    console.log(a);
    console.log(b);
    console.log(c);
    console.log(d);
    /*
     * 如上会执行四次，值分别如下(正则使用小括号，代表分组)：
     * 第一次： 123,123,0,123sdasadsr44565dffghg987gff33234
     * 第二次： 44565,44565,11,123sdasadsr44565dffghg987gff33234
     * 第三次： 987,987,22,123sdasadsr44565dffghg987gff33234
     * 第四次： 33234,33234,28,123sdasadsr44565dffghg987gff33234
     */
 });
```

##### `split()方法`

``` javascript
该方法把一个字符串分割成字符串数组。

 基本语法如：stringObject.split(separator,howmany);

@param(参数)

   1. separator[必填项]，字符串或正则表达式，该参数指定的地方分割stringObject;

   2. howmany[可选] 该参数指定返回的数组的最大长度，如果设置了该参数，返回的子字符串不会多于这个参数指定的数组。如果没有设置该参数的话，整个字符串都会被分割，不考虑他的长度。

  @return(返回值) 一个字符串数组。该数组通过在separator指定的边界处将字符串stringObject分割成子字符串。

例如：
  var str = "what are you doing?";
// 以" "分割字符串
console.log(str.split(" "));
// 打印 ["what", "are", "you", "doing?"]

// 以 "" 分割字符串
console.log(str.split(""));
/*
 * 打印：["w", "h", "a", "t", " ", "a", "r", "e", " ", "y", "o", "u", " ", "d", "o", "i", "n",
 * "g", "?"]
 */
// 指定返回数组的最大长度为3
console.log(str.split("",3));
// 打印 ["w", "h", "a"]
```
##### `test()方法`

``` javascript
该方法用于检测一个字符串是否匹配某个模式；

   基本语法：RegExpObject.test(str);

   @param(参数) str是需要检测的字符串；

   @return (返回值) 如果字符串str中含有与RegExpObject匹配的文本的话，返回true，否则返回false；
例如:
var str = "longen and yunxi";
console.log(/longen/.test(str)); // true
console.log(/longlong/.test(str)); //false

// 或者创建RegExp对象模式
var regexp = new RegExp("longen");
console.log(regexp.test(str)); // true
```

##### `exec()方法`

``` javascript
该方法用于检索字符串中的正则表达式的匹配。

 基本语法：RegExpObject.exec(string)

@param(参数)：string【必填项】要检索的字符串。

@return(返回值)：返回一个数组，存放匹配的结果，如果未找到匹配，则返回值为null；

注意：该返回的数组的第一个元素是与正则表达式相匹配的文本，该方法还返回2个属性，index属性声明的是匹配文本的第一个字符的位置；input属性则存放的是被检索的字符串string；该方法如果不是全局的话，返回的数组与match()方法返回的数组是相同的。

例如:
var str = "longen and yunxi";
console.log(/longen/.exec(str));
// 打印 ["longen", index: 0, input: "longen and yunxi"]

// 假如没有找到的话，则返回null
console.log(/wo/.exec(str)); // null
```

##### 参考资料
[资料1](http://www.cnblogs.com/tugenhua0707/p/5037811.html)</br>
[资料2](http://www.cnblogs.com/yirlin/archive/2006/04/12/373222.html)
