## ps

## netstat

显示和网络相关信息

````
[--route|-r]        显示内核路由表
[--groups|-g]       显示多重广播群组成员名单(ipv4/ipv6)
{--interfaces=|-I=|-i}    [iface]   显示所有或指定的网络接口信息
[--masquerade|-M]   显示伪装连接(无效连接)
[--statistics|-s]   显示每个协议的汇总统计
[--verbose|-v]      显示详细信息(在输出末尾有一些不支持信息)
[--wide|-W]         不截断ip地址
[-c|--continuous]   每秒执行netstat一次
[-e|--extend]       显示扩展信息(如uid)
[-o|--timers]       包括网络定时器相关信息
[--program|-p]      显示每个套接字所对应的程序的PID和名称
[--numeric|-n]      显示数字地址，而不是主机、端口、用户名的别名
--numeric-hosts     显示数字主机地址
--numeric-ports     显示数字端口号
--numeric-users     显示数字用户id
-F                  从FIB打印路由信息
-C                  从路由缓存打印路由信息
delay               一定延迟的周期性统计信息

协议参数:
--protocol={inet,inet6,unix,ipx,ax25,netrom,ddp,... }|-A
[--tcp|-t]          tcp协议
[--udp|-u]          udp协议
[--udplite|-U]      udp-lite协议
[--sctp|-S]         sctp协议
[--unix|-x]         unix socket协议
[--raw|-w]          raw socket(裸套接字)协议
[--l2cap|-2]        l2cap(蓝牙相关)协议
[--rfcomm|-f]       rfcomm串口协议
[--inet|-4]         ipv4协议
[--inet6|-6]        ipv6协议
--ipx
--ax25
--netrom
--ddp
--bluetooth

状态参数:
[--all|-a]          所有状态
[--listening|-l]    显示listen监听状态(默认被忽略)
````

## lsof

## ifconfig

## pkill

## 句柄

## sudo和su

## curl

## head、tail

## awk

## sed

## grep

## chown和chmod

## htop

````
cpu区域数字：代表处理器或核心数量
cpu占用：蓝色代表低优先级，绿色是用户空间占用，红色是内核空间占用

task区域：分别对应任务数量，线程数量，当前运行数量
负载区域：分别对应1分钟、5分钟、15分钟间隔内的系统负载平均值(运行队列中的平均进程数)
运行时间区域：显示系统已经运行多长时间

内存区域：绿色是进程占用内存，蓝色是buffer占用内存，黄色是磁盘缓存

PID：进程ID
USER：进程所有者
PRI：进程的内核空间优先级(0-139)
NI：进程的nice值或用户空间的优先级，从-20(最高)到19(最低)
VIRT：进程需要的虚拟内存大小，并不是实际使用量，只是申请量
RES：进程的常驻内存大小(当前使用的内存大小，不包括swap out，包括其他进程的共享)
SHR：进程的共享内存大小
S：进程状态(D=不可中断的睡眠状态，R=运行，S=可中断的睡眠，T=跟踪/停止，Z=僵尸进程)
CPU%：进程当前的CPU占用时间百分比
MEM%：等于RES/总内存，进程使用的物理内存百分比
TIME+：进程使用的CPU时间总计，单位为1/100s
Command：命令
````

## /proc/meminfo

````
MemTotal:        内存总容量
MemFree:         2153984 kB
MemAvailable:    4130172 kB
Buffers:          182772 kB
Cached:          1993296 kB
SwapCached:            0 kB
Active:          5060128 kB
Inactive:         405964 kB
Active(anon):    3290620 kB
Inactive(anon):    26364 kB
Active(file):    1769508 kB
Inactive(file):   379600 kB
Unevictable:           0 kB
Mlocked:               0 kB
SwapTotal:             0 kB
SwapFree:              0 kB
Dirty:                28 kB
Writeback:             0 kB
AnonPages:       3290100 kB
Mapped:            72560 kB
Shmem:             26928 kB
Slab:             131128 kB
SReclaimable:      97160 kB
SUnreclaim:        33968 kB
KernelStack:        7280 kB
PageTables:        47552 kB
NFS_Unstable:          0 kB
Bounce:                0 kB
WritebackTmp:          0 kB
CommitLimit:     3939684 kB
Committed_AS:    6464120 kB
VmallocTotal:   34359738367 kB
VmallocUsed:       21432 kB
VmallocChunk:   34359707388 kB
HardwareCorrupted:     0 kB
AnonHugePages:   2699264 kB
HugePages_Total:      64
HugePages_Free:       55
HugePages_Rsvd:       55
HugePages_Surp:        0
Hugepagesize:       2048 kB
DirectMap4k:       71552 kB
DirectMap2M:     4122624 kB
DirectMap1G:     6291456 kB
````
