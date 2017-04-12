#### PHP7编译安装
去官网下载：http://php.net/get/php-7.1.3.tar.gz/from/a/mirror
然后编译安装
````
./configure --prefix=/data/php7\
 --with-config-file-path=/data/php7/etc\
 --enable-fpm\
 --with-fpm-user=zbgame\
 --with-fpm-group=zbgame\
 --with-fpm-systemd\
 --enable-mysqlnd\
 --with-mysqli=mysqlnd\
 --with-pdo-mysql=mysqlnd\
 --enable-opcache\
 --enable-pcntl\
 --enable-mbstring\
 --with-mcrypt\
 --enable-soap\
 --with-curl\
 --enable-shmop\
 --enable-zip\
 --enable-ftp\
 --enable-intl\
 --with-iconv\
 --enable-calendar\
 --enable-bcmath\
 --enable-sockets\
 --with-openssl\
 --with-mhash\
 --with-zlib\
 --with-gettext\
 --with-gd\
 --with-xmlrpc\
 --enable-exif\
 --enable-gd-native-ttf\
 --enable-gd-jis-conv\
 --with-zlib-dir=/usr/lib\
 --with-png-dir=/usr/lib\
 --with-jpeg-dir=/usr/lib\
 --with-freetype-dir=/usr/lib\
 --with-libxml-dir=/usr/lib
 ````

ICU 相关错误
错误：Unable to detect ICU prefix or /usr//bin/icu-config failed. Please verify ICU install prefix and make sure icu-config works
解决办法：yum install -y icu libicu libicu-devel
关于 ICU 的编译参数：./configure –with-icu-dir=/usr

systemd相关错误
错误：configure: error: Your system does not support systemd
解决办法：yum install -y systemd systemd-devel

错误：Cannot find OpenSSL's <evp.h>
解决办法：yum install openssl openssl-devel

错误：Please reinstall the libcurl distribution
解决办法：yum -y install curl-devel

错误：jpeglib.h not found
解决办法：yum -y install libjpeg-devel libpng-devel freetype-devel

错误：checking for BZip2 in default path... not found
configure: error: Please reinstall the BZip2 distribution
这是bzip2软件包没有安装
解决办法：yum install -y bzip2 bzip2-devel

错误：configure: error: xpm.h not found.
解决办法：yum -y install libXpm-devel

错误：error: Unable to locate gmp.h
解决办法：yum -y install gmp-devel

错误：mcrypt.h not found. Please reinstall libmcrypt.
解决办法：yum -y install  php-mcrypt  libmcrypt  libmcrypt-devel

错误： configure: error: Cannot find libpq-fe.h. Please specify correct PostgreSQL installation path
解决办法：yum -y install postgresql-devel

错误 ： configure: error: xslt-config not found. Please reinstall the libxslt >= 1.1.0 distribution
解决： yum -y install libxslt-devel


#关闭所有php-fpm进程
ps -ef | grep php-fpm | grep -v grep | awk '{print $2}' | xargs kill -9

#### hiredis编译安装
hiredis下载地址：https://github.com/redis/hiredis
make -j
make install
ldconfig (编译安装完记得执行该命令，否则PHP在引入swoole扩展时将出现类似如下红色字体部分错误)


#### Swoole编译安装
下载地址：https://github.com/swoole/swoole-src/releases

````
/data/php7/bin/phpize
./configure --with-php-config=/data/php7/bin/php-config --enable-sockets --enable-openssl --with-openssl-dir --enable-http2 --enable-async-redis
make
make install
````

注意不要启动ringBuffer,swoole中的这个功能不成熟

#### Xhprof of PHP7
````
git：https://github.com/Yaoguais/phpng-xhprof

````







# PHP说明

## 1、安装

````
## AWS上
$ sudo yum install php56 php56-opcache php56-devel php56-mbstring php56-mcrypt php56-mysqlnd php56-bcmath php56-pecl-memcached php56-pdo php56-fpm
## centos上
$ sudo rpm -ivh http://rpms.famillecollet.com/enterprise/remi-release-7.rpm
$ sudo yum clean all && yum makecache
$ sudo yum install --enablerepo=remi --enablerepo=remi-php56 php php-opcache php-devel php-mbstring php-mcrypt php-mysqlnd php-bcmath php-memcached php-shmop php-curl php-mysqli php-fpm
````

## 2、配置

修改/etc/php.ini

````
# 使php脚本在apache下有效
engine = On
# 开启垃圾回收
zend.enable_gc = On
# 每个脚本的最大执行时间 -- cli模式下该值被硬编码成-1
max_execution_time = 30
# 每个脚本可使用的内存
memory_limit = 128M

[Date]
# 设置时区
date.timezone = Asia/Shanghai

[swoole]
# 自动加载swoole扩展
extension=swoole.so

[opcache]
# 可以不加
zend_extension=opcache.so
# 开启opcache
opcache.enable=1
# opcache共享内存大小
opcache.memory_consumption=128
# 存储临时字符串的内存大小
opcache.interned_strings_buffer=8
# 最大缓存的文件数目
opcache.max_accelerated_files=4000
# 检查文件更新的间隔时间
opcache.revalidate_freq=60
# 打开快速关闭(回收内存的速度会提高)
opcache.fast_shutdown=1
# 不保存文件/函数的注释
opcache.save_comments=0
# opcache可以使用Hugepages
opcache.huge_code_pages=1
# Opcache把opcode缓存缓存到外部文件 -- 会有很明显的性能提，二进制导出文件可以跨PHP生命周期存在
opcache.file_cache=/tmp
````

## 3、启动php-fpm

````
## sysvinit或者UpStart
$ sudo chkconfig php-fpm on
$ sudo service php-fpm start
## systemd
$ sudo systemctl enable php-fpm.service
$ sudo systemctl start php-fpm.service
````

## 4、php-fpm配置

````

# 设置接受FastCGI请求的地址
listen [9000 | '/path/to/unix/socket']
# 错误日志的位置
error_log '/log/php-fpm.log'
# 日志错误级别，默认notice
log_level [alert(必须立即处理)|error(错误情况)|warning(警告情况)|notice(一般重要信息)|debug(调试信息)]
# fpm进程运行的用户和用户组
user zbgame
group zbgame
# 设置进程管理器如何管理子进程
pm [static | dynamic]
# pm 设置为 static 时表示创建的， pm 设置为 dynamic 时表示最大可创建的
pm.max_children = 50
# 设置启动时创建的子进程数目. 仅在 pm 设置为 dynamic 时使用。默认值: min_spare_servers + (max_spare_servers – min_spare_servers) / 2
pm.start_servers = 5
# 设置空闲服务进程的最低数目. 仅在 pm 设置为 dynamic 时使用
pm.min_spare_servers = 10
# 设置空闲服务进程的最大数目. 仅在 pm 设置为 dynamic 时使用
pm.max_spare_servers int = 50
# 设置每个子进程重生之前服务的请求数. 对于可能存在内存泄漏的第三方模块来说是非常有用的. 如果设置为'0'则一直接受请求
pm.max_requests = 30000
# fpm是否在后台运行
daemonize [no | yes]
# 子进程接受主进程复用信号的超时时间，默认值0.
process_control_timeout = 0
# 设置文件打开描述符的rlimit限制
rlimit_files = 1024
# 设置核心rlimit最大限制值，可用值: ‘unlimited’ 、0或者正整数
rlimit_core = 1024
````

### 5、提升php7性能

启用Opcache

````
zend_extension=opcache.so
opcache.enable=1
opcache.enable_cli=1"
````

使用新编译器，GCC4.8以上，使php开启Global Register for opline and execute_data支持

开启系统Hugepages

````
# 或者在/etc/sysctl.conf中添加
sysctl vm.nr_hugepages=512

cat /proc/meminfo  | grep Huge
````

开启Opcache file cache
````
opcache.file_cache=/tmp
````

使用PGO

 - 编译php时使用，`make prof-gen`
 - 使用项目训练php，`sapi/cgi/php-cgi -T 100 /data/project/index.php >/dev/null`
 - 第二次编译，`make prof-clean`， `make prof-use && make install`


## 6、错误解决方案

`/var/log/php-fpm/error.log`报错:
"WARNING: [pool www] seems busy (you may need to increase pm.start_servers, or pm.min/max_spare_servers), spawning 16 children, there are 0 idle, and 47 total children"
新生成了16个子进程，无空闲子进程，共有47个子进程

 原因：服务器并发数大于php-fpm的承载量

 解决方案：根据机器cpu，内存，以及php-fpm每个子进程消耗内存，修改
