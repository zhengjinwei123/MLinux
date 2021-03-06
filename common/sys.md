# 系统基础配置

## sysctl

````
# 使用sysrq组合键是了解系统目前运行情况，为安全起见设为0关闭
kernel.sysrq = 0
# 控制core文件的文件名是否添加pid作为扩展
kernel.core_uses_pid = 1
# 每个消息队列的容量(单位：字节)限制
kernel.msgmnb = 65536
# 一条消息的最大长度(单位：字节)限制
kernel.msgmax = 65536
# 单个共享内存段的大小（单位：字节）限制，计算公式64G*1024*1024*1024(字节)
kernel.shmmax = 68719476736
# 所有内存大小（单位：页，1页 = 4Kb），计算公式16G*1024*1024*1024/4KB(页)
kernel.shmall = 4294967296
# 系统中同时运行的最大的消息队列的个数
kernel.msgmni = 1024
# SEMMSL:每个信号集中的最大信号量数目;
# SEMMNS:系统范围内的最大信号量总数目;
# SEMOPM:每个信号发生时的最大系统操作数目;
# SEMMNI:系统范围内的最大信号集总数目;
kernel.sem = 250 256000 32 2048

# 每一个端口最大的监听队列的长度,默认值为128(但nginx 定义的NGX_LISTEN_BACKLOG 默认为511)
net.core.somaxconn = 256
# 每个网络接口接收数据包的速率比内核处理包的速率快时，允许送到队列的数据包的最大数目，默认300
net.core.netdev_max_backlog = 1000
# sockets可写最大buffer -- 单位为页
net.core.wmem_max = 873200
# socket可读最大buffer -- 单位为页
net.core.rmem_max = 873200
# socket buffer的最大初始化值,默认10K
net.core.optmem_max = 10K
# ip转发是否开启 -- 即路由功能
net.ipv4.ip_forward = 0
# 反向过滤 -- ip不符合要求
net.ipv4.conf.default.rp_filter = 1
# 是否接受含有源路由信息的ip包
net.ipv4.conf.default.accept_source_route = 0

# 允许系统打开的端口范围
net.ipv4.ip_local_port_range 1024 65535
# timewait的最大数量，默认是180000
net.ipv4.tcp_max_tw_buckets = 6000
# 开启timewait快速回收 -- 依赖于tcp_timestamps
net.ipv4.tcp_tw_recycle = 1
# 开启timewait重用 -- 允许将TIME-WAIT sockets重新用于新的TCP连接
net.ipv4.tcp_tw_reuse = 1
# 默认开启 -- TCP缓存每个连接最新的时间戳，后续请求中如果时间戳小于缓存的时间戳，即视为无效，相应的数据包会被丢弃(时间戳可以避免序列号的卷绕)
net.ipv4.tcp_timestamps = 0

# 开启SYN Cookies -- 当出现SYN 等待队列溢出时，启用cookies 来处理，可防范少量SYN攻击，默认关闭
net.ipv4.tcp_syncookies = 1
# SYN队列的长度，默认为1024,容纳更多等待连接的网络连接数
net.ipv4.tcp_max_syn_backlog = 262144
# 系统中最多有多少个TCP sockets不被关联到任何一个用户文件句柄上 -- 孤儿
net.ipv4.tcp_max_orphans = 262144
# syn-ack握手状态重试次数，默认5，遭受syn-flood攻击时改为1或2
net.ipv4.tcp_synack_retries = 2
# 外向syn握手重试次数，默认4
net.ipv4.tcp_syn_retries = 2
# 如果套接字由本端要求关闭，这个参数决定了它保持在FIN-WAIT-2状态的时间
net.ipv4.tcp_fin_timeout = 1

# 开启keepalive的闲置时长 --  默认2小时
net.ipv4.tcp_keepalive_time = 1800
# keepalive探测包的发送间隔
net.ipv4.tcp_keepalive_intvl = 30
# 如果对方不予应答(超过tcp_keepalive_time)，探测包的发送次数。如果probes多次以后不成功，内核彻底放弃，认为连接失效
net.ipv4.tcp_keepalive_probes = 3

# TCP可写最大buffer -- 有3个值，单位为页
net.ipv4.tcp_wmem 8192 436600 873200
# TCP可读最大buffer -- 有3个值，单位为页
net.ipv4.tcp_rmem 32768 436600 873200
# TCP可用最大内存 -- 有3个值，单位为页
net.ipv4.tcp_mem 786432 1048576 1572864

# 开启有选择的应答
net.ipv4.tcp_sack = 1  
# 支持更大的TCP窗口. 如果TCP窗口最大超过65535(64K), 必须设置该数值为1
net.ipv4.tcp_window_scaling = 1
# 一个tcp连接关闭后,把这个连接曾经有的参数比如慢启动门限snd_sthresh,拥塞窗口snd_cwnd 还有srtt等信息保存到dst_entry中
# 只要dst_entry没有失效,下次新建立相同连接的时候就可以使用保存的参数来初始化这个连接
net.ipv4.tcp_no_metrics_save = 1

# 表示文件句柄的最大数量
fs.file-max = 102400
# 指定HugePages的页数
vm.nr_hugepages=512
````

 *ipv4网络协议的默认配置可以在`/proc/sys/net/ipv4/`下查看*
 `sysctl -p`读取配置文件，重新生成系统配置

## HugePages

系统进程通过虚拟地址访问内存，cpu将虚拟地址和物理内存地址进行转换；为了提升转换效率，cpu会缓存最近的虚拟内存地址和物理内存地址之间的映射关系，并保存在一个cpu维护的映射表中。
linux中，内存以页的形式存在，默认每页是4K。物理内存很大时，映射表条目也会很多，影响cpu检索效率。内存大小固定，若要减小条目数，只能增加页的size。HugePages主要提供4k及以上大小的page。

- TLB: 在cpu中分配的一个固定大小的buffer,用于保存“page table”的部分内容，使CPU更快的访问并进行地址转换。
- hugetlb: hugetlb 是记录在TLB 中条目并指向到Hugepage。
- hugetlbfs: 内存文件系统，如同tmpfs。

1、修改内核参数memlock，单位是kb，size要稍小于物理内；修改/etc/security/limits.conf

````
*  soft  memlock    12582912
*  hard  memlock    12582912
````

使用`ulimit -l`查看配置是否生效

2、修改/etc/sysctl.conf，指定HugePages的页数
````
vm.nr_hugepages=512
````

3、查看内存信息中的HugePages信息

````
$ cat /proc/meminfo | grep Huge
AnonHugePages:    876544 kB
HugePages_Total:      64
HugePages_Free:       64
HugePages_Rsvd:        0
HugePages_Surp:        0
Hugepagesize:       2048 kB
````

4、查看具体应用使用HugePages数量，根据text大小和Hugepagesize计算出使用的HugePages数量(考虑对齐)

````
$ size /usr/sbin/php-fpm
text	   data	    bss	    dec	    hex	filename
3819252	 558142	 113096	4490490	 4484fa	/usr/sbin/php-fpm
````

## limit

修改配置/etc/security/limits.conf，重启或者注销用户后，配置才会生效

````
# 修改最大进程
* soft nproc 11000
* hard nproc 11000

# 最大文件打开数限制
* soft nofile 65536
* hard nofile 65536
````

通过`ulimit -n`查看

## systemd

## 用户登陆选项

通过`/etc/passwd`可以查看用户的登陆选项，分为三种:

- **/bin/shell**，指定登陆时用户的shell，可以是`/bin/bash`、`/bin/zsh`等
- **/sbin/nologin**，禁用用户登陆系统，登陆时能看到报错
- **/bin/false**，禁用用户登陆系统，不会有任何错误提示
