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
