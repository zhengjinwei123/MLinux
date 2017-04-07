# php opcache 配置与说明
> opcache通过将php脚本预编译的字节码存储到共享内存中来提升php的运行性能，存储预编译的字节码的好处就是省去了每次加载和解析php脚本的开销.php 5.5.0以及后续版本中已经绑定了opcache扩展。

### 1. 安装
``` shell
wget http://pecl.php.net/get/zendopcache-7.0.2.tgz
tar zxvf zendopcache-7.0.2.tgz
cd zendopcache-7.0.2
/usr/local/php/bin/phpize
./configure --with-php-config=/usr/local/php/bin/php-config
make && make install
ls /usr/local/php/lib/php/extensions/no-debug-non-zts-20090626/
```
可以看到opcache.so文件说明已经安装成功

### 2.启动配置
找到php.ini,查找方法：
``` shell
1.find / -name 'php.ini'
2.whereis php.ini
3.创建一个php文件：
<?php phpinfo();?>
```
php.ini中加入
``` shell
[Zend Opcache]
;启用操作码缓存。如果禁用此选项，则不会优化和缓存代码。 在运行期使用 ini_set() 函数只能禁用 opcache.enable 设置，不可以启用此设置。 如果在脚本中尝试启用此设置项会产生警告。
opcache.enable=1
;so 链接库地址
zend_extension = /usr/local/php/lib/php/extensions/no-debug-non-zts-20090626/opcache.so
;可用内存大小，单位为M
opcache.memory_consumption=64
;zend optimizer +暂存池中字符串的占内存总量，单位M
opcache.interned_strings_buffer=8
;最大缓存的文件数目，当命中率较低时可以提高这个值
opcache.max_accelerated_files=4000
;如果缓存处于非激活状态，等待多少秒之后计划重启。 如果超出了设定时间，则 OPcache 模块将杀除持有缓存锁的进程， 并进行重启
opcache.force_restart_timeout=180
;查脚本时间戳是否有更新的周期，以秒为单位。 设置为 0 会导致针对每个请求， OPcache 都会检查脚本更新
opcache.revalidate_freq=60
;如果启用，则会使用快速停止续发事件。 所谓快速停止续发事件是指依赖 Zend 引擎的内存管理模块 一次释放全部请求变量的内存，而不是依次释放每一个已分配的内存块。
opcache.fast_shutdown=1
;仅针对 CLI 版本的 PHP 启用操作码缓存。 通常被用来测试和调试
opcache.enable_cli=1
```

### 3.注意事项
> 因为开启了opcache，所以会导致更新php文件不会马上生效，最好的办法是重启php-fpm

#### 重启php-fpm方法：
1.通过信号
``` shell
关闭
kill -SIGINT `cat /usr/local/php/var/run/php-fpm.pid`
重启
kill -SIGUSR2 `cat /usr/local/php/var/run/php-fpm.pid`
```
2.centos 7已经集成了systemctl,可以方便的进行进程管理
``` shell
启动
systemctl start php-fpm
停止
systemctl stop php-fpm
重启
systemctl restart php-fpm
```
> 开发阶段可以修改php.ini中的`revalidate_freq`字段来实现快速生效

### 4.程序API
> opcache提供了api用于在程序中管理缓存
1. `opcache_reset()` 此函数用来重置所有缓存
2. `opcache_invalidate(PHPfileDir,true)` 此函数用来重置指定某个缓存文件
3. 例子：
``` php
// 清理opcache
if (function_exists('opcache_reset')) {
   opcache_reset();
}
```
