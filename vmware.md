### 虚拟机vmware-workstation 安装centos7(php,mysql,c++)步骤

##### 1. network

``` sh
cd /etc/sysconfig/network-scripts
vi ifcfg-ens33
将文件里的 ONBOOT=no，改为ONBOOT=yes，然后保存并退出（不要忘记保存！！)
reboot 重启虚拟机
```

##### 2. ifconfig
``` sh
yum install net-tools.x86_64
```


##### 3. runtime library
``` sh
yum install epel-release
rpm -Uvh http://rpms.remirepo.net/enterprise/remi-release-7.rpm
yum install \
    mariadb mariadb-server nginx
yum install --enablerepo=remi-php56 \
    php-fpm php-pdo php-mysql php-xml php-curl php-opcache php-json

yum install \
    gcc-c++ make git \
    pcre-devel

yum install --enablerepo=remi-php56 \
    php-devel

安装mysql开发包
yum install mysql-devel
```
##### 4. CentOS.7 Env Settings
``` sh
yum install epel-release
rpm -Uvh http://rpms.remirepo.net/enterprise/remi-release-7.rpm
yum install \
    mariadb mariadb-server nginx
yum install --enablerepo=remi-php56 \
    php-cli php-fpm php-pdo php-mysql php-xml php-bcmath

# mysql config
systemctl enable mariadb.service
systemctl start mariadb.service
mysql_secure_installation
vi /etc/my.cnf.d/mysqld_user.cnf
    [mysqld]
    bind-address=127.0.0.1
    innodb_file_per_table
    innodb_file_format = Barracuda
    max_connections = 1000

# php config
vi /etc/php.ini
    date.timezone = 'Asia/Shanghai'

# check ulimit settings (fd/coredump)
vi /etc/security/limits.conf
    <user> hard nofile 65535
    <user> soft nofile 65535
    <user> hard core unlimited
    <user> soft core unlimited

# install dev packages
yum install \
    mariadb-devel \
    mono-devel \
    lrzsz net-tools man-pages \
    gcc-c++ gdb make \
    subversion vim htop \
    bash-completion bash-completion-extras colordiff \

# disable firewall
systemctl stop firewalld
systemctl disable firewalld

# disable selinux
vi /etc/selinux/config
    SELINUX=disabled

# dev mysql config
mysql -uroot
    # create user '<remote_access_user>'@'%' identified by '<password>';
    # grant all on *.* to '<remote_access_user>'@'%';
    flush privileges;

# enable svn colordiff
vi ~/.subversion/config
    diff-cmd = colordiff

###############################################################################
# other settings
yum install nginx
systemctl enable nginx.service
systemctl start nginx.service
```

##### 3. mysql
``` sh
systemctl enable mariadb.service
systemctl start mariadb.service

SET PASSWORD FOR 'root'@'localhost' = PASSWORD('newpass');
```

##### 4. 虚拟机挂载磁盘
``` sh
1. 下载VMwareTools-9.9.0-2304977.tar.gz
2. tar -zxvf VMwareTools-9.9.0-2304977.tar.gz 解压这个文件
3. cd vmware-tools-distrib
4. ./vmware-install.pl
5. 如果报错执行：yum install gcc gcc-c++ automake make
6. 打开虚拟机客户端菜单设置->选项->共享文件夹，添加共享文件夹
7. 重启centos(reboot)
8. 之后我们就能在/mnt/hgfs/下看到共享的文件了
9. 如果看不到文件夹，使用命令挂载:(server-share是第6步中挂载的文件夹名称)
  yum install open-vm-tools
  sudo vmhgfs-fuse .host:/server-share /mnt/hgfs/server-share -o allow_other -o nonempty
```
##### 5. php-fpm 管理

``` sh
run_type=$1
if [ $run_type == "start" ];  then
        php-fpm
elif [ $run_type == "stop" ];  then
        kill -INT `cat /run/php-fpm/php-fpm.pid`
else
        kill -USR2 `cat /run/php-fpm/php-fpm.pid`
fi
```

##### 6. 挂载磁盘注意事项

``` sh
挂载磁盘后磁盘下使用windows目录和window属性，注意权限问题
```

##### 7. 添加www 用户
``` sh
id www
groupadd www
useradd -g www -s /sbin/nologin www
id www
```
