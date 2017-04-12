# iftop
> iftop 是用来监控系统的实时网络流量状况的工具
> iftop 可以用来监控网卡的实时流量(可以指定网段)、反向解析IP、显示端口信息等。

### 安装
```
yum install iftop
```

### 使用
``` shell
 iftop -i eno16777736    指定网卡
```
![ii](https://www.vpser.net/uploads/2010/07/iftop-interface.jpg)

### 分析
``` shell
中间的<= =>这两个左右箭头，表示的是流量的方向
TX：发送流量
RX：接收流量
TOTAL：总流量
Cumm：运行iftop到目前时间的总流量
peak：流量峰值
rates：分别表示过去 2s 10s 40s 的平均流量
```

### 参数
``` shell
-i 设定监测的网卡                         如:iftop -i eth1
-B 以bytes为单位显示流量(默认为bits)       如: iftop -B
-n 使host信息默认直接显示IP               如:iftop -n
-N 使端口信息默认直接都显示端口号          如：iftop -N
-F 显示特定网段的进出流量                 如：iftop -F 10.10.1.0/24
-h 帮助
-p 使用这个参数后，中间的列表显示的本地主机信息，出现了本机以外的IP信息
-b 使流量图形条默认就显示;
-P 使host信息及端口信息默认就都显示;
-m 设置界面最上边的刻度的最大值，刻度分五个大段显示，例：# iftop -m 100M
```
### 英文参考
```
   -n                  don't do hostname lookups
   -N                  don't convert port numbers to services
   -p                  run in promiscuous mode (show traffic between other
                       hosts on the same network segment)
   -b                  don't display a bar graph of traffic
   -B                  Display bandwidth in bytes
   -i interface        listen on named interface
   -f filter code      use filter code to select packets to count
                       (default: none, but only IP packets are counted)
   -F net/mask         show traffic flows in/out of IPv4 network
   -G net6/mask6       show traffic flows in/out of IPv6 network
   -l                  display and count link-local IPv6 traffic (default: off)
   -P                  show ports as well as hosts
   -m limit            sets the upper limit for the bandwidth scale
   -c config file      specifies an alternative configuration file
   -t                  use text interface without ncurses

   Sorting orders:
   -o 2s                Sort by first column (2s traffic average)
   -o 10s               Sort by second column (10s traffic average) [default]
   -o 40s               Sort by third column (40s traffic average)
   -o source            Sort by source address
   -o destination       Sort by destination address

   The following options are only available in combination with -t
   -s num              print one single text output afer num seconds, then quit
   -L num              number of lines to print
```

### 快捷键
```
按h   切换是否显示帮助;

按n   切换显示本机的IP或主机名;

按s   切换是否显示本机的host信息;

按d   切换是否显示远端目标主机的host信息;

按t   切换显示格式为2行/1行/只显示发送流量/只显示接收流量;

按N   切换显示端口号或端口服务名称;

按S   切换是否显示本机的端口信息;

按D   切换是否显示远端目标主机的端口信息;

按p   切换是否显示端口信息;

按P   切换暂停/继续显示;

按b   切换是否显示平均流量图形条;

按B   切换计算2秒或10秒或40秒内的平均流量;

按T   切换是否显示每个连接的总流量;

按l   打开屏幕过滤功能，输入要过滤的字符，比如ip,按回车后，屏幕就只显示这个IP相关的流量信息;

按L   切换显示画面上边的刻度;刻度不同，流量图形条会有变化;

按j   或按k可以向上或向下滚动屏幕显示的连接记录;

按1或2或3   可以根据右侧显示的三列流量数据进行排序;

按<        根据左边的本机名或IP排序;

按>       根据远端目标主机的主机名或IP排序;

按o       切换是否固定只显示当前的连接;

按f       可以编辑过滤代码，这是翻译过来的说法，
```

[参考](https://www.vpser.net/manage/iftop.html)
