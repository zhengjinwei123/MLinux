
# top
> top命令是Linux下常用的性能分析工具，能够实时显示系统中各个进程的资源占用状况，类似于Windows的任务管理器。


```
top - 18:24:02 up 4 days, 20:37,  6 users,  load average: 0.00, 0.01, 0.05
Tasks: 409 total,   1 running, 408 sleeping,   0 stopped,   0 zombie
%Cpu(s):  0.3 us,  0.8 sy,  0.0 ni, 98.5 id,  0.0 wa,  0.0 hi,  0.3 si,  0.0 st
KiB Mem :  1868688 total,   101256 free,  1271736 used,   495696 buff/cache
KiB Swap:  2097148 total,  1744332 free,   352816 used.   350880 avail Mem

   PID USER      PR  NI    VIRT    RES    SHR S  %CPU %MEM     TIME+ COMMAND
  3461 root      20   0  188140  27124   1064 S   0.7  1.5 102:52.40 redis-server
 18432 root      20   0  296268  47232   5928 S   0.7  2.5   0:31.07 php
 18434 root      20   0  294220  44988   5768 S   0.7  2.4   0:21.57 php
```
分析：
```
18:24:02                          当前时间
up 4 days, 20:37                  系统运行时间
6 users                           当前登录用户数
load average: 0.00, 0.01, 0.05    系统负载，即任务队列的平均长度。三个数值分别为 1分钟、5分钟、15分钟前到现在的平均值
Tasks: 409 total                  当前进程总数
1 running                         正在运行的进程数
408 sleeping                      处于睡眠状态的进程数
0 stopped,   0 zombie             停止的进程数和处于僵尸状态的进程数(僵尸进程即失去控制的进程,一般都是主进程挂掉的子进程)

Cpu(s):
0.3 us          用户空间占用CPU百分比
0.8 sy          内核空间占用CPU百分比
0.0 ni          用户进程空间内改变过优先级的进程占用CPU百分比
98.5 id         空闲CPU百分比
0.0 wa          等待输入输出的CPU时间百分比
0.0 hi          硬件CPU中断占用百分比
0.3 si          软中断占用百分比
0.0 st          虚拟机占用百分比

KiB Mem :
1868688 total       物理内存总量
101256 free         使用的物理内存总量
1271736 used        空闲内存总量
495696 buff/cache   用作内核缓存的内存量

KiB Swap:
 2097148 total     交换区总量
 1744332 free      空闲交换区总量
 352816 used       使用的交换区总量
 350880 avail Mem  缓冲的交换区总量,内存中的内容被换出到交换区，而后又被换入到内存，但使用过的交换区尚未被覆盖，该数值即为这些内容已存在于内存中的交换区的大小,相应的内存再次被换出时可不必再对交换区写入


 序号  列名    含义
 a    PID     进程id
 b    PPID    父进程id
 c    RUSER   Real user name
 d    UID     进程所有者的用户id
 e    USER    进程所有者的用户名
 f    GROUP   进程所有者的组名
 g    TTY     启动进程的终端名。不是从终端启动的进程则显示为 ?
 h    PR      优先级
 i    NI      nice值。负值表示高优先级，正值表示低优先级
 j    P       最后使用的CPU，仅在多CPU环境下有意义
 k    %CPU    上次更新到现在的CPU时间占用百分比
 l    TIME    进程使用的CPU时间总计，单位秒
 m    TIME+   进程使用的CPU时间总计，单位1/100秒
 n    %MEM    进程使用的物理内存百分比
 o    VIRT    进程使用的虚拟内存总量，单位kb。VIRT=SWAP+RES
 p    SWAP    进程使用的虚拟内存中，被换出的大小，单位kb。
 q    RES     进程使用的、未被换出的物理内存大小，单位kb。RES=CODE+DATA
 r    CODE    可执行代码占用的物理内存大小，单位kb
 s    DATA    可执行代码以外的部分(数据段+栈)占用的物理内存大小，单位kb
 t    SHR     共享内存大小，单位kb
 u    nFLT    页面错误次数
 v    nDRT    最后一次写入到现在，被修改过的页面数。
 w    S       进程状态(D=不可中断的睡眠状态,R=运行,S=睡眠,T=跟踪/停止,Z=僵尸进程)
 x    COMMAND 命令名/命令行
 y    WCHAN   若该进程在睡眠，则显示睡眠中的系统函数名
 z    Flags   任务标志，参考 sched.h
```

> 默认情况下仅显示比较重要的 PID、USER、PR、NI、VIRT、RES、SHR、S、%CPU、%MEM、TIME+、COMMAND 列。可以通过下面的快捷键来更改显示内容。
> 更改显示内容通过 f 键可以选择显示的内容。按 f 键之后会显示列的列表，按 a-z 即可显示或隐藏对应的列，最后按回车键确定。
> 按 o 键可以改变列的显示顺序。按小写的 a-z 可以将相应的列向右移动，而大写的 A-Z 可以将相应的列向左移动。最后按回车键确定。
> 按大写的 F 或 O 键，然后按 a-z 可以将进程按照相应的列进行排序。而大写的 R 键可以将当前的排序倒转。

### 命令使用
```
top [-] [d] [p] [q] [c] [C] [S] [s]  [n]

d 指定每两次屏幕信息刷新之间的时间间隔。当然用户可以使用s交互命令来改变之。
p 通过指定监控进程ID来仅仅监控某个进程的状态。
q 该选项将使top没有任何延迟的进行刷新。如果调用程序有超级用户权限，那么top将以尽可能高的优先级运行。
S 指定累计模式
s 使top命令在安全模式中运行。这将去除交互命令所带来的潜在危险。
i 使top不显示任何闲置或者僵死进程。
c 显示整个命令行而不只是显示命令名


Ctrl+L 擦除并且重写屏幕。
h或者? 显示帮助画面，给出一些简短的命令总结说明。
k       终止一个进程。系统将提示用户输入需要终止的进程PID，以及需要发送给该进程什么样的信号。一般的终止进程可以使用15信号；如果不能正常结束那就使用信号9强制结束该进程。默认值是信号15。在安全模式中此命令被屏蔽。
i 忽略闲置和僵死进程。这是一个开关式命令。
q 退出程序。
r 重新安排一个进程的优先级别。系统提示用户输入需要改变的进程PID以及需要设置的进程优先级值。输入一个正值将使优先级降低，反之则可以使该进程拥有更高的优先权。默认值是10。
S 切换到累计模式。
s 改变两次刷新之间的延迟时间。系统将提示用户输入新的时间，单位为s。如果有小数，就换算成m s。输入0值则系统将不断刷新，默认值是5 s。需要注意的是如果设置太小的时间，很可能会引起不断刷新，从而根本来不及看清显示的情况，而且系统负载也会大大增加。
f或者F 从当前显示中添加或者删除项目。
o或者O 改变显示项目的顺序。
l 切换显示平均负载和启动时间信息。
m 切换显示内存信息。
t 切换显示进程和CPU状态信息。
c 切换显示命令名称和完整命令行。
M 根据驻留内存大小进行排序。
P 根据CPU使用百分比大小进行排序。
T 根据时间/累计时间进行排序。
W 将当前设置写入~/.toprc文件中。这是写top配置文件的推荐方法。


top   //每隔5秒显式所有进程的资源占用情况
top -d 2  //每隔2秒显式所有进程的资源占用情况
top -c  //每隔5秒显式进程的资源占用情况，并显示进程的命令行参数(默认只有进程名)
top -p 12345 -p 6789//每隔5秒显示pid是12345和pid是6789的两个进程的资源占用情况
top -d 2 -c -p 123456 //每隔2秒显示pid是12345的进程的资源使用情况，并显式该进程启动的命令行参数
```