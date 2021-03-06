# runlevel

## Linux有7个运行级别(runlevel)

 > 0：系统停机状态，系统默认运行级别不能设为0，否则不能正常启动
 > 1：单用户工作状态，root权限，用于系统维护，禁止远程登陆
 > 2：多用户状态(没有NFS)
 > 3：完全的多用户状态(有NFS)，登陆后进入控制台命令行模式
 > 4：系统未使用，保留
 > 5：X11控制台，登陆后进入图形GUI模式
 > 6：系统正常关闭并重启，默认运行级别不能设为6，否则不能正常启动


## 修改runlevel(暂时生效)

查看当前runlevel
````
$ runlevel
````

切换到其它runlevel
````
$ inti N
````


## 修改runlevel(永久生效)

查看default.target当前指向的runlevel
````
$ ls -al /etc/systemd/system/default.target
````

删除default.target
````
$ sudo rm -f /etc/systemd/system/default.target
````

### 创建default.target链接文件，到所需runlevel

切换图形界面
````
$ sudo ln -s /lib/systemd/system/graphical.target /etc/systemd/system/default.target
#或者
$ sudo ln -s /lib/systemd/system/runleve5.target /etc/systemd/system/default.target
````

切换命令行界面
````
$ sudo ln -s /lib/systemd/system/multi-user.target /etc/systemd/system/default.target
#或者
$ sudo ln -s /lib/systemd/system/runleve3.target /etc/systemd/system/default.target
````
