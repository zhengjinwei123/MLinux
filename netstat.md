# netstat 网络命令
> netstat 命令用来显示各种网络相关信息，如网络连接，路由表，接口状态，多播成员等。

### 1. 简介
> 输入`netstat`命令

``` shell
[root@localhost ~]# netstat
Active Internet connections (w/o servers)
Proto Recv-Q Send-Q Local Address           Foreign Address         State
tcp        0      0 localhost:52741         localhost:6379          ESTABLISHED
tcp        0      0 localhost.localdoma:ssh 192.168.:stone-design-1 ESTABLISHED
tcp        0      0 localhost:62947         localhost:6379          ESTABLISHED
tcp        0      0 localhost:57218         localhost:mysql         ESTABLISHED
tcp        0      0 localhost:52743         localhost:6379          ESTABLISHED
tcp        0      0 localhost.localdo:hydap localhost.localdo:30664 ESTABLISHED
tcp        0      0 localhost:6379          localhost:62949         ESTABLISHED
tcp        0      0 localhost:6379          localhost:62953         ESTABLISHED
tcp6       0      0 localhost:mysql         localhost:5173          ESTABLISHED
tcp6       0      0 192.168.2.150:mysql     192.168.2.150:49397     ESTABLISHED
tcp6       0      0 192.168.2.150:mysql     192.168.2.150:35021     ESTABLISHED
tcp6       0      0 localhost:mysql         localhost:daqstream     ESTABLISHED
tcp6       0      0 localhost:mysql         localhost:57210         ESTABLISHED

Active UNIX domain sockets (w/o servers)
Proto RefCnt Flags       Type       State         I-Node   Path
unix  2      [ ]         DGRAM                    13830    /run/systemd/shutdownd
unix  2      [ ]         DGRAM                    7895     /run/systemd/notify
unix  5      [ ]         DGRAM                    7909     /run/systemd/journal/socket
unix  12     [ ]         DGRAM                    7911     /dev/log
unix  3      [ ]         STREAM     CONNECTED     22858
unix  3      [ ]         DGRAM                    251985
unix  3      [ ]         STREAM     CONNECTED     25973
```
从打印结果中分析到，`netstat` 输出分为两部分：
1. Active Internet connections ，即有源TCP连接，其中"Recv-Q"和"Send-Q"指%0A的是接收队列和发送队列。这些数字一般都应该是0。如果不是则表示软件包正在队列中堆积。这种情况只能在非常少的情况见到。
2. 另一个是Active UNIX domain sockets，称为有源Unix域套接口(和网络套接字一样，但是只能用于本机通信，性能可以提高一倍)。
Proto显示连接使用的协议,RefCnt表示连接到本套接口上的进程号,Types显示套接口的类型,State显示套接口当前的状态,Path表示连接到套接口的其它进程使用的路径名

### 2. 常见参数
``` shell
-a(all) 显示所有选项，默认不显示LISTEN选项
-t(tcp) 仅显示tcp相关选项
-u(udp) 仅显示udp相关选项
-n (number)拒绝显示别名，能显示数字的全部转化为数字
-l (listen)仅列出有listen(在监听)的服务
-p (process)显示程序名
-r (router) 显示路由信息，路由表
-e (ext)显示扩展信息
-s (statistic)按各个协议进行统计
-c 每隔一个固定时间，执行该netstat命令

提示：LISTEN和LISTENING的状态只有用-a或者-l才能看到
```

### 3.案例
* 列出所有端口(包括监听的和没有监听的)
> `netstat -a`
* 列出所有tcp端口
> `netstat -at`
* 列出所有udp端口
> `netstat -au`
* 列出所有处于监听状态的sockets
> `netstat -l`
* 列出所有监听tcp端口的socket
> `netstat -lt`
* 列出所有监听udp 端口的sockets
> `netstat -lu`
* 列出所有监听unix端口的socket
> `netstat -lx`

* 显示所有端口的统计信息
`netstat -s`

``` shell
[root@localhost ~]# netstat -s
Ip:
    6849816 total packets received
    0 forwarded
    0 incoming packets discarded
    6807373 incoming packets delivered
    8533054 requests sent out
Icmp:
    597 ICMP messages received
    32 input ICMP message failed.
    ICMP input histogram:
        destination unreachable: 6
        redirects: 587
        echo requests: 4
    2462 ICMP messages sent
    0 ICMP messages failed
    ICMP output histogram:
        destination unreachable: 2458
        echo replies: 4
IcmpMsg:
        InType3: 6
        InType5: 587
        InType8: 4
        OutType0: 4
        OutType3: 2458
Tcp:
    74767 active connections openings
    7651 passive connection openings
    968 failed connection attempts
    1033 connection resets received
    85 connections established
    6806756 segments received
    8488831 segments send out
    45695 segments retransmited
    11 bad segments received.
    3476 resets sent
Udp:
    20 packets received
    0 packets to unknown port received.
    0 packet receive errors
    20 packets sent
    0 receive buffer errors
    0 send buffer errors
UdpLite:
TcpExt:
    34 invalid SYN cookies received
    101 resets received for embryonic SYN_RECV sockets
    17 ICMP packets dropped because they were out-of-window
    9187 TCP sockets finished time wait in fast timer
    6405 TCP sockets finished time wait in slow timer
    1 packets rejects in established connections because of timestamp
    172755 delayed acks sent
    70 delayed acks further delayed because of locked socket
    Quick ack mode was activated 1516 times
    36 packets directly queued to recvmsg prequeue.
    500 bytes directly in process context from backlog
    3818 bytes directly received in process context from prequeue
    1805694 packet headers predicted
    126 packets header predicted and directly queued to user
    508906 acknowledgments not containing data payload received
    2021172 predicted acknowledgments
    26 congestion windows recovered without slow start by DSACK
    600 congestion windows recovered without slow start after partial ack
    2650 other TCP timeouts
    TCPLossProbes: 28982
    TCPLossProbeRecovery: 25573
    1533 DSACKs sent for old packets
    1104 DSACKs sent for out of order packets
    27105 DSACKs received
    344 connections reset due to unexpected data
    280 connections reset due to early user close
    2008 connections aborted due to timeout
    TCPDSACKIgnoredNoUndo: 18463
    TCPSackShiftFallback: 385
    TCPDeferAcceptDrop: 83
    TCPRcvCoalesce: 527946
    TCPOFOQueue: 459364
    TCPOFOMerge: 1104
    TCPChallengeACK: 72
    TCPSYNChallenge: 11
    TCPAutoCorking: 739
    TCPSynRetrans: 248
    TCPOrigDataSent: 4027543
    TCPHystartTrainDetect: 56
    TCPHystartTrainCwnd: 1044
    TCPHystartDelayDetect: 1
    TCPHystartDelayCwnd: 48
    TCPACKSkippedSynRecv: 1
IpExt:
    InNoRoutes: 1
    InMcastPkts: 949
    InBcastPkts: 20775
    InOctets: 4111913744
    OutOctets: 827182402
    InMcastOctets: 30368
    InBcastOctets: 3049348
    InNoECTPkts: 7637475
    InECT0Pkts: 7

```
* 显示tcp和udp端口的统计信息
> `netstat -st`
> `netstat -su`

* 持续显示netstat信息
> `netstat -c 2` (每隔2秒打印一次)
* 显示核心路由信息
> `netstat -r`

``` shell
[root@localhost ~]# netstat -r
Kernel IP routing table
Destination     Gateway         Genmask         Flags   MSS Window  irtt Iface
default         gateway         0.0.0.0         UG        0 0          0 eno16777736
gateway         0.0.0.0         255.255.255.255 UH        0 0          0 eno16777736
localhost.local 0.0.0.0         255.255.255.255 UH        0 0          0 eno16777736
```

* 找出程序运行的端口
> `netstat -ap | grep ssh`
* 找出运行在指定端口的进程
> `netstat -an | grep ':80'` （使用 `lsof -i:80`也可以实现此功能）
* 显示网络接口列表
> `netstat -i` （`ifconfig`也可以实现）

```
[root@localhost ~]# netstat -i
Kernel Interface table
Iface      MTU    RX-OK RX-ERR RX-DRP RX-OVR    TX-OK TX-ERR TX-DRP TX-OVR Flg
eno16777  1500  5525818      0      0 0       6396091      0      0      0 BMRU
lo       65536  2158846      0      0 0       2158846      0      0      0 LRU

```
* 查看指定端口的连接数
> `netstat -nt|grep -i "8002" |grep ESTABLISHED | wc -l`
