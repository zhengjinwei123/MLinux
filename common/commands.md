
## 强制杀进程
````
ps -ef | grep php-fpm | grep -v grep | awk '{print $2}' | xargs kill -9
````
--------------------------------------------------

## 增加别名
````
# vi ~/.bashrc
alias hdcraft='cd /mnt/hgfs/sharedir/hdcraft/trunk/program/server/src'
alias lxh='cd /mnt/hgfs/sharedir/lxh/trunk/program/server/src'
alias lxh_share='cd /mnt/hgfs/sharedir/share/lxh_gs'
alias dh2='cd /mnt/hgfs/sharedir/s2/trunk/program/server/src'
# source ~/.bashrc
````
--------------------------------------------------

## 防火墙firewall-cmd
````
帮助
# firewall-cmd --help

查看运行状态
# firewall-cmd --state

查看指定级别的所有信息，譬如 public
# firewall-cmd --zone=public --list-all

开放一个tcp端口
# firewall-cmd --zone=public --add-port=8000/tcp --permanent
# firewall-cmd --zone=public --add-port=8000-9000/tcp --permanent
# firewall-cmd --reload
# firewall-cmd --list-all
````
--------------------------------------------------
