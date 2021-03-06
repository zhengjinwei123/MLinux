# Linux 下统计命令
> 开发后期阶段都需要对程序进行优化，linux下有一些关于CPU,内存,网络IO,磁盘io等的统计命令，用来统计系统的各项指标。

### 1.cpu
> cpu就是系统核心,软件程序中的涉及到的逻辑部分都需要cpu完成，现在系统一般都有多核，支持同一时刻并发执行多个程序，
> cpu利用率是程序性能指标，一台机器上多个程序都在操作系统管理下执行，操作系统通过算法切换上下文分配时间片给各个程序运行，如果某个程序一直占着cpu不放，其他程序就无法运行，只能等待释放cpu为止。

### 2.内存
> 程序运行中需要分配的运行时堆栈，静态存储区等都在内存中处理，所以内存是系统性能优化一个重要指标，如果物理内存不足程序直接崩溃，虽然系统有虚拟内存交换分区，但速度不足.

### 3.网络io
> 作为服务端程序，服务基于网络，所以网络输入输出bit数是一项只要指标，如果网络io过高,所在网络带宽无法承载时，会导致数据包滞后或者丢失，严重影响用户体验.

### 4.磁盘io
> 所谓磁盘io和网络io是同一个概念，就是程序对它操作时的输入输出,用户程序需要调用系统内核api去操控磁盘，在磁盘上操纵数据需要寻道和读取,是一项很耗时的操作,单位时间内操作的数据数即为磁盘io的性能指标(byte / s)。
>
> bps = byte /s (每秒的字节数)
>
> kbps = bps / 1024
>
> mbps = kbps / 1024

# 监测工具
```
top          查看进程活动状态以及一些系统状况
htop         top的高级版,支持图形化，过滤，查找
vmstat       查看系统状态，硬件和系统信息
iostat       查看cpu负载，硬盘状态
sar          综合工具，对系统进行分析
mpstat       查看多处理器状态
netstat      网络监控
iptraf       实时网络监控
tcpdump      抓取数据包
netperf      网络带宽工具
dstat        综合工具，综合了 vmstat, iostat, ifstat, netstat 等多个信息
```

### [参考资料](https://my.oschina.net/chape/blog/159640)

### 目录
1. [top](https://github.com/zhengjinwei123/MLinux/blob/master/top.md)
2. [htop](https://github.com/zhengjinwei123/MLinux/blob/master/htop.md)
3. [vmstat](https://github.com/zhengjinwei123/MLinux/blob/master/vmstat.md)
4. [iostat](https://github.com/zhengjinwei123/MLinux/blob/master/iostat.md)
5. [dstat](https://github.com/zhengjinwei123/MLinux/blob/master/dstat.md)
6. [iftop](https://github.com/zhengjinwei123/MLinux/blob/master/iftop.md)
