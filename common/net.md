## 网卡配置(修改配置文件)

查看以太网网卡

````
$ lspci | grep "Ethernet"
````

查看网络接口配置

````
$ ifconfig
````

编辑文件/etc/sysconfig/network-scripts/ifcfg-[网卡名称]

````
HWADDR=00:0C:29:F6:FA:53
TYPE=Ethernet
BOOTPROTO=none
DEFROUTE=yes
IPV4_FAILURE_FATAL=no
IPV6INIT=yes
IPV6_AUTOCONF=yes
IPV6_DEFROUTE=yes
IPV6_FAILURE_FATAL=no
NAME=eno16777736
UUID=fb9fdcba-76ff-406d-8ee5-0b1038e8e854
ONBOOT=yes
DNS1=223.5.5.5
DNS2=8.8.8.8
IPADDR=192.168.2.101
PREFIX=32
GATEWAY=192.168.2.1
IPV6_PEERDNS=yes
IPV6_PEERROUTES=yes
````

重启网络服务

````
$ sudo systemctl restart network.service
````

## 网络配置(伪图形界面)

````
$ nmtui
````

##
