# IP 地址
> ip(Internet Protocol),即网络之间互联的协议，每台计算机(或者手机等各种上网设备)都有一个唯一的ip地址,例如：192.168.2.109,以点分十进制的形式表示(ipv4)
> 我们常用的都是IPv4(ip的第4版),它的下一个版本就是IPv6。IPv6正处在不断发展和完善的过程中，它在不久的将来将取代目前被广泛使用的IPv4.

### 格式
> IPv4中规定IP地址长度为32（按TCP/IP参考模型划分) ，即有2^32-1个地址。
> 一般的书写法为4个用小数点分开的十进制数。也有人把4位数字化成一个十进制长整数，但这种标示法并不常见。另一方面，IPv6使用的128位地址所采用的位址记数法，
> 在IPv4也有人用，但使用范围更少。 过去IANAIP地址分为A,B,C,D 4类，>>>把32位的地址分为两个部分：前面的部分代表网络地址，由IANA分配，后面部分代表局域网地址。
> 如在C类网络中，前24位为网络地址，后8位为局域网地址，可提供254个设备地址(因为有两个地址不能为网络设备使用: 255为广播地址，0代表此网络本身) 。
> 网络掩码(Netmask) 限制了网络的范围，1代表网络部分，0代表设备地址部分，例如C类地址常用的网络掩码为255.255.255.0。

### 查看ip地址
linux 下使用命令:
`ifconfig`

``` bash
[root@localhost conf.d]# ifconfig
eno16777736: flags=4163<UP,BROADCAST,RUNNING,MULTICAST>  mtu 1500
        inet 192.168.2.150  netmask 255.255.255.255  broadcast 192.168.2.150
        inet6 fe80::20c:29ff:fe2e:40fe  prefixlen 64  scopeid 0x20<link>
        ether 00:0c:29:2e:40:fe  txqueuelen 1000  (Ethernet)
        RX packets 1578244  bytes 350877948 (334.6 MiB)
        RX errors 0  dropped 0  overruns 0  frame 0
        TX packets 1548982  bytes 647151946 (617.1 MiB)
        TX errors 0  dropped 0 overruns 0  carrier 0  collisions 0

lo: flags=73<UP,LOOPBACK,RUNNING>  mtu 65536
        inet 127.0.0.1  netmask 255.0.0.0
        inet6 ::1  prefixlen 128  scopeid 0x10<host>
        loop  txqueuelen 0  (Local Loopback)
        RX packets 2993579  bytes 1000125679 (953.7 MiB)
        RX errors 0  dropped 0  overruns 0  frame 0
        TX packets 2993579  bytes 1000125679 (953.7 MiB)
        TX errors 0  dropped 0 overruns 0  carrier 0  collisions 0

```
##### 其中:
1. `inet 192.168.2.150 ` 是 IPv4 格式的 ip地址
2. `netmask 255.255.255.255` 是子网掩码
3. `broadcast 192.168.2.150` 是广播地址
4. `inet6 fe80::20c:29ff:fe2e:40fe` 是IPv6格式的 ip地址
5. `ether 00:0c:29:2e:40:fe` 是网卡的硬件地址

#### 还可以使用：
`vi /etc/sysconfig/network-scripts/ifcfg-eno16777736`
查看ip地址,其中ifcfg-eno16777736是网卡设备名（通过`ifconfig`查看）


### 修改ip地址
1. 动态修改:
输入 ifconfig eno16777736 （默认是第一个网卡） 后面接IP地址， 网络掩码和 网关，如果不设置，就使用默认的掩码，例如：
```
ifconfig eno16777736 192.168.2.150
```
注意：`注意这种方法修改只是临时修改，重启网卡或服务器后又会还原`

2. 静态修改，永久生效

``` bash
[root@localhost conf.d]# vi /etc/sysconfig/network-scripts/ifcfg-eno16777736

TYPE="Ethernet"   #网卡类型为以太网
BOOTPROTO=static  ##协议类型 dhcp bootp none
DEFROUTE="yes"
IPV4_FAILURE_FATAL="no"
IPV6INIT="yes"
IPV6_AUTOCONF="yes"
IPV6_DEFROUTE="yes"
IPV6_FAILURE_FATAL="no"
NAME="eno16777736"
UUID="aab2af22-20e6-4043-b572-99981eea8fcf"
DEVICE="eno16777736"   # 设备名
ONBOOT="yes"  #启动时是否激活 yes | no
DNS1=223.5.5.5  #首选 dns 域名查询服务器(这里是阿里云的dns服务器)
DNS2=8.8.8.8    # 备用 dns 服务器
IPADDR=192.168.2.150   #网络IP地址
NETMASK=255.255.255.0  #网络子网地址
PREFIX=32
GATEWAY=192.168.2.1   #网关地址 一般是路由器或者交换机地址
IPV6_PEERDNS=yes
IPV6_PEERROUTES=yes

```
##### 再执行:
`/etc/init.d/network reload ` 或者 `service network restart` 重启网卡 ，
命令有start | restart | stop | reload

### 网关
> GATEWAY 一般是具有信息路由功能的ip地址，例如路由器，交换机等
> 网关在网络中扮演重要角色，在一个局域网内所有信息都需要通过网关转发，所以网关设备是影响网络流量的重要设备
> 计算机中的网关地址一般就是指所在网络的 路由器的地址

### nmtui工具
> nmtui 是以ui界面存在的修改ip地址信息的工具，使用简单方便，按上下左右键和回车操控即可生效

### 网络不通问题
```
1. ip地址在所在局域网内与其他计算机的ip地址产生冲突,换一个ip即可
2. dns 服务器地址配置错误，修改dns服务器即可
3. 没有网卡驱动，安装即可(具体可上网搜索)
```
