# 包管理器

## 1、基本命令

安装软件包

````
$ sudo yum install [package]
````

本地安装软件包

````
$ sudo yum localinstall [package]
````

重装软件包

````
$ sudo yum reinstall [package]
````
卸载软件包

````
$ sudo yum remove [package]
$ sudo yum erase [package]
````

卸载软件包及其依赖

````
$ sudo yum autoremove [package]
````

安装一系列软件包

````
$ sudo yum groups [groups package]
````

列出仓库中可用的软件包

````
$ sudo yum list
````

显示软件包描述及其信息

````
$ sudo yum info [package]
````

显示提供该命令的软件包信息

````
$ sudo yum provides [command]
$ sudo yum whatprovides [command]
````

搜索仓库中是否有某软件包

````
$ sudo yum search [package]
````

显示给定软件的所需依赖

````
$ sudo yum deplist
````

显示软件仓库列表

````
$ sudo yum repolist
````

显示指定仓库信息

````
$ sudo yum repoinfo [repo]
````

将整个仓库当作软件包集合

````
$ sudo yum repository-packages [list/info/install/reinstall/]
````

更新仓库

````
$ sudo yum update
````

升级软件包

````
$ sudo yum upgrade
````

清除缓存

````
$ sudo yum clean [packages/headers/all]
````

将软件包在本地缓存

````
$ sudo yum makecache
````

显示事务和历史

````
$ sudo yum history
````

## 2、安装yum插件

````
$ sudo yum install yum-utils yum-plugin-fastestmirror
````

## 3、配置软件源

在/etc/yum.repos.d/目录下建立**.repo文件

````
[epel]
name=Extra Packages for Enterprise Linux 7 - $basearch
baseurl=http://epel.mirror.ucloud.cn/epel/7/$basearch
failovermethod=priority
enabled=1
gpgcheck=1
gpgkey=file:///etc/pki/rpm-gpg/RPM-GPG-KEY-EPEL-7
````

或者直接安装软件源仓库对应的软件包

````
$ sudo yum install epel.rpm
````

## 4、禁用/启用仓库

````
$ sudo yum-config-manager --disable mysql57-community
$ sudo yum-config-manager --enable mysql56-community
````

暂时启用

````
$ sudo yum install --enablerepo=remi --enablerepo=remi-php56 php php-fpm
````

## 5、查看yum安装历史

显示事务

````
$ sudo yum history
````

重做事务

````
$ sudo yum history redo [Transaction ID]
````

回滚事务

````
$ sudo yum history undo [Transaction ID]
````
在历史中搜索某个软件包
````
$ yum history list [package]
````

_/var/log/yum.log会记录yum安装历史_

## 扩展 -- dnf

### 禁用仓库

````
dnf config-manager --set-enabled remi-php70
dnf config-manager --set-disabled mysql57-community
dnf config-manager --set-enabled mysql56-community
````

### 系统版本升级

````
sudo dnf upgrade --refresh
sudo dnf install dnf-plugin-system-upgrade
## 有未解决的依赖问题取消升级
sudo dnf system-upgrade download --refresh --releasever=25 --best
## 解决依赖问题
sudo dnf system-upgrade download --refresh --releasever=25 --allowerasing
sudo dnf system-upgrade reboot
````
