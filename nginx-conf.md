# nginx 配置说明
> nginx 是常用的http服务器之一(例如还有apache),它还可以作为反向代理服务器，支持fastCGI,ssl,virtual host,gzip,rewrite等功能。

### 1.nginx 作为代理服务器
> 代理服务器通常分为两类：即转发代理(forward proxy)服务器和反向代理（reverse proxy）服务器.转发代理服务器通常称为代理服务器。

转发代理服务器(一对一关系)
> 普通的转发代理服务器是客户端和原始服务器之间的中间服务器，为了从原始服务器获取内容，客户端发送请求到代理服务器，然后代理服务器从原始服务器中获取内容再返回给客户端，客户端必须专门地配置转发代理来访问其他站点。例如我们常用vpn来访问国外网站，这就用到了代理服务的技术。总的来说，客户端不能直接访问原始服务器，需要一个桥梁作为双方的沟通，这个桥梁就是代理服务器。转发代理服务器的一个典型应用就是为处于防火墙后的内部客户端提供访问外部Internet网，比如校园网用户通过代理访问国外网站，公司内网用户通过公司的统一代理访问外部Internet网站等。转发代理服务器也能够使用缓存来缓解原始服务器负载，提供响应速度.客户端需要做代理服务器配置(host,port)

反向代理服务器(一对多关系)
> 客户端发送请求给反向代理服务器，不需要做任何其他配置，就好像访问真实服务器一般，反向代理服务器的一个典型应用就是为处于防火墙后的服务器提供外部Internet用户的访问。反向代理能够用于在多个后端服务器提供负载均衡，或者为较慢的后端服务器提供缓存。此外，反向代理还能够简单地将多个服务器映射到同一个URL空间。

区别

> 两者的相同点在于都是用户和服务器之间的中介，完成用户请求和结果的转发。主要的不同在于：
(1)转发代理的内部是客户端，而反向代理的内部是服务器。即内网的客户端通过转发代理服务器访问外部网络，而外部的用户通过反向代理访问内部的服务器。
(2)转发代理通常接受客户端发送的任何请求，而反向代理通常只接受到指定服务器的请求。如校园网内部用户可以通过转发代理访问国外的任何站点(如果不加限制的话)，而只有特定的请求才发往反向代理，然后又反向代理发往内部服务器。


### 2.nginx 基本配置说明
``` shell
user  root root;#定义nginx运行的用户和用户组
worker_processes  4;#nginx进程数，建议设置为cpu核心数
worker_cpu_affinity 0001 0010 0100 1000;#cpu亲和性设置 nginx默认是没有开启利用多核cpu的配置的。需要通过增加worker_cpu_affinity配置参数来充分利用多核cpu，cpu是任务处理，当计算最费时的资源的时候，cpu核使用上的越多，性能就越好

error_log  logs/error.log warn;#全局错误日志路径和类型定义[debug|info|notice|error|warn|crit]
pid        logs/nginx.pid;# 进程文件
worker_rlimit_nofile 65535;# 一个nginx进程打开的最多文件描述符数目，理论值应该是最多打开文件数(系统的值ulimit -n)与nginx进程数相除，但是nginx分配请求并不均匀，所以建议与ulimit -n 的值保持一致

events {
    use epoll;# 事件并发类型[kqueue|epoll|select|poll|/dev/poll|rtsig] epoll 是linux 2.6以上版本内核中高性能的网络io模型，如果在freebsd上，就用kqueue模型
    worker_connections  65535;#单个进程最大连接数(最大连接数=连接数*进程数)
}


http {
    include       ./mime.types;# 文件扩展名和文件类型映射表
    default_type  application/octet-stream;# 默认问价类型

    log_format  main  '$remote_addr - $remote_user [$time_local] "$request" '
                      '$status $body_bytes_sent "$http_referer" '
                      '"$http_user_agent" "$http_x_forwarded_for"';# 日志显示内容

    access_log  logs/access.log  main;## 访问日志
    server_names_hash_bucket_size 128;# 服务器名字的hash表大小
    client_header_buffer_size 8k;# 上传文件大小限制
    large_client_header_buffers 4 16k;#
    client_max_body_size 8m;#此指令设置NGINX能处理的最大请求主体大小。 如果请求大于指定的大小，则NGINX发回HTTP 413（Request Entity too large）错误。 如果服务器处理大文件上传，则该指令非常重要。默认情况下，该指令值为1m

    server_tokens off;#并不会让nginx执行的速度更快，但它可以关闭在错误页面中的nginx版本数字，这样对于安全性是有好处的
    sendfile      on;#开启高效文件传输模式，sendfile指令指定nginx是否调用sendfile函数来输出文件，对于普通应用设为 on，如果用来进行下载等应用磁盘IO重负载应用，可设置为off，以平衡磁盘与网络I/O处理速度，降低系统的负载。注意：如果图片显示不正常把这个改成off。
    tcp_nopush    on;# on 会设置调用tcp_cork方法，这个也是默认的，结果就是数据包不会马上传送出去，等到数据包最大时，一次性的传输出去，这样有助于解决网络堵塞,告诉nginx在一个数据包里发送所有头文件，而不一个接一个的发送
    tcp_nodelay   on;# TCP_NODELAY和TCP_CORK基本上控制了包的“Nagle化”，Nagle化在这里的含义是采用Nagle算法把较小的包组装为更大的帧 ,on禁用了Nagle 算法, 告诉nginx不要缓存数据，而是一段一段的发送--当需要及时发送数据时，就应该给应用设置这个属性，这样发送一小块数据信息时就不能立即得到返回值。
禁用了Nagle 算法
    keepalive_timeout  10;# 长连接超时时间，单位是秒
    client_header_timeout 10;#设置请求头的超时时间。我们也可以把这个设置低些
    client_body_timeout 10;#设置请求体的超时时间。我们也可以把这个设置低些
    reset_timedout_connection on;#告诉nginx关闭不响应的客户端连接。这将会释放那个客户端所占有的内存空间
    send_timeout 10;#指定客户端的响应超时时间。这个设置不会用于整个转发器，而是在两次客户端读取操作之间。如果在这段时间内，客户端没有读取任何数据，nginx就会关闭连接

    gzip  on;# 是告诉nginx采用gzip压缩的形式发送数据。这将会减少我们发送的数据量
    gzip_min_length  1k;# 设置对数据启用压缩的最少字节数。如果一个请求小于1000字节，我们最好不要压缩它，因为压缩这些小的数据会降低处理此请求的所有进程的速度。
    gzip_buffers     4 16k;
    gzip_http_version 1.0;
    gzip_comp_level 2;
    gzip_types       text/plain application/x-javascript text/css application/xml;
    gzip_vary on;

    #FastCGI相关参数是为了改善网站的性能：减少资源占用，提高访问速度。下面参数看字面意思都能理解。
    fastcgi_connect_timeout 300;
    fastcgi_send_timeout 300;
    fastcgi_read_timeout 300;
    fastcgi_buffer_size 16k;
    fastcgi_buffers 16 16k;
    fastcgi_busy_buffers_size 32k;
    fastcgi_temp_file_write_size 32k;

    # 加载虚拟主机配置
    include conf.d/*.conf;
}
```

设置完成后需要重启nginx:
`service nginx restart`
> 打开`nginx.conf`所在文件夹下的conf.d文件夹，配置虚拟主机,由于nginx.conf内配置了`include conf.d/*.conf`，所以nginx会自动加载conf.d文件夹下后缀名为`conf`的配置文件，虚拟主机的好处是可以监听多个服务。


例子：

``` shell
server {
    listen       9012;
    server_name  localhost;

    location / {
        root   /mnt/hgfs/myserver;
        index  index.html index.htm;
    }

    error_page   500 502 503 504  /50x.html;
    location = /50x.html {
        root  ./html;
    }
    location ~ \.php$ {
        root           html;
        fastcgi_pass   127.0.0.1:9000;
        fastcgi_index  index.php;
        fastcgi_param  SCRIPT_FILENAME  /mnt/hgfs/myserver$fastcgi_script_name;
        include        fastcgi_params;
        #chunked_transfer_encoding      off;
    }
}
```
