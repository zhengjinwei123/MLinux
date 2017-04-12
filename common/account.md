
## 增加用户组

````
groupadd zbgame
````

## 增加用户，指定加目录，指定用户组，设置为系统账号

`-r`等同于`--system`，指定为系统账号，能运行系统服务

````
useradd -r -m -g zbgame zbgame
````

## 修改ssh配置/etc/ssh/sshd_config

````
PasswordAuthentication yes => PasswordAuthentication no
````

## 配置ssh私钥

````
ssh-keygen -t rsa
cd /root/.ssh/
cat id_rsa.pub >> ～/.ssh/authorized_keys
````

将id_rsa.pub删除，将id_rsa下载至本地

#重启sshd
````
systemctl restart sshd
````
