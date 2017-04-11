# htop
> htop是linux下的一个进程查看器，也是top的高级版

###### 相比于top，htop有以下几个优点
```
1. 可以横向或者纵向滚动浏览进程列表，以便看到所有进程和完整的命令行
2. 启动比较快
3. 杀进程时不需要输入进程号
4. htop 支持鼠标操作
```
##### [htop官网](http://htop.sourceforge.net/)

### htop的安装
`yum install htop`

### 使用
```
Shortcut     Key	Function Key	                   Description
h, ?	     F1	 Invoke htop Help	               查看htop使用说明
S	        F2	 Htop Setup Menu	                htop 设定
/	        F3	 Search for a Process	           搜索进程
\	        F4	 Incremental process filtering	  增量进程过滤器
t	        F5	 Tree View	                      显示树形结构
<, >	     F6	 Sort by a column	               选择排序方式
[	        F7	 Nice - (change priority)	       可减少nice值，这样就可以提高对应进程的优先级
]	        F8	 Nice + (change priority)	       可增加nice值，这样就可以降低对应进程的优先级
k	        F9	 Kill a Process	                 可对进程传递信号
q	        F10	Quit htop	                      结束htop
```

#### 命令行选项
```
-C --no-color　　　　 　　  使用一个单色的配色方案

-d --delay=DELAY　　　　   设置延迟更新时间，单位秒

-h --help　　　　　　  　　 显示htop 命令帮助信息

-u --user=USERNAME　　     只显示一个给定的用户的过程

-p --pid=PID,PID…　　　    只显示给定的PIDs

-s --sort-key COLUMN　     依此列来排序

-v –version　　　　　　　   显示版本信息
```

#### 交互
```
上下键或PgUP, PgDn 选定想要的进程，左右键或Home, End 移动字段，当然也可以直接用鼠标选定进程；

Space    标记/取消标记一个进程。命令可以作用于多个进程，例如 "kill"，将应用于所有已标记的进程

U    取消标记所有进程

s    选择某一进程，按s:用strace追踪进程的系统调用

l    显示进程打开的文件: 如果安装了lsof，按此键可以显示进程所打开的文件

I    倒转排序顺序，如果排序是正序的，则反转成倒序的，反之亦然

+, -    When in tree view mode, expand or collapse subtree. When a subtree is collapsed a "+" sign shows to the left of the process name.

a (在有多处理器的机器上)    设置 CPU affinity: 标记一个进程允许使用哪些CPU

u    显示特定用户进程

M    按Memory 使用排序

P    按CPU 使用排序

T    按Time+ 使用排序

F    跟踪进程: 如果排序顺序引起选定的进程在列表上到处移动，让选定条跟随该进程。这对监视一个进程非常有用：通过这种方式，你可以让一个进程在屏幕上一直可见。使用方向键会停止该功能。

K    显示/隐藏内核线程

H    显示/隐藏用户线程

Ctrl-L    刷新

Numbers    PID 查找: 输入PID，光标将移动到相应的进程上
```
