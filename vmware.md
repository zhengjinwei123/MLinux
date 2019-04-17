#### vmware workstation 虚拟机共享文件夹

```
1. 下载VMwareTools-9.9.0-2304977.tar.gz
2. tar -zxvf VMwareTools-9.9.0-2304977.tar.gz 解压这个文件
3. cd vmware-tools-distrib
4. ./vmware-install.pl
5. 如果报错执行：yum install gcc gcc-c++ automake make
6. 打开虚拟机客户端菜单设置->选项->共享文件夹，添加共享文件夹
7. 重启centos
8. 之后我们就能在/mnt/hgfs/下看到共享的文件了
9. 如果看不到文件夹，使用命令挂载:(server-share是第6步中挂载的文件夹名称)
  sudo vmhgfs-fuse .host:/server-share /mnt/hgfs/server-share -o allow_other -o nonempty
```
