#!/bin/bash
PATH=/usr/local/sbin:/usr/local/bin:/usr/sbin:/usr/bin:/root/bin

## 控制台颜色
echo -e "\e[1;30m 黑色 \e[0m"
echo -e "\e[1;31m 红色 \e[0m"
echo -e "\e[1;32m 绿色 \e[0m"
echo -e "\e[1;33m 黄色 \e[0m"
echo -e "\e[1;34m 蓝色 \e[0m"
echo -e "\e[1;35m 洋红 \e[0m"
echo -e "\e[1;36m 青色 \e[0m"
echo -e "\e[1;37m 白色 \e[0m"

## 函数
function prepend()
{
  [ -d "$2" ] && eval $1=\"$2':'\$$1\" && export $1
}

prepend PATH /data/mysql_backup/lxh_reportdb

echo $PATH

## 日期
savetime=`date '+%Y-%m-%d %H:%M:%S'`
echo 当前日期：${savetime}
## 20天前的日期
days=20
interval=$(( days * 86400 ))
today0=`date "+%Y-%m-%d 0:0:0"`
echo 今日凌晨：${today0}

## 时间戳
t1=`date -d "$today0" +%s`
t20=$(( t1 - interval ))

echo 今日凌晨的时间戳:${t1}
echo 20天前的时间戳:${t20}
echo 20天前的日期:`date -d @${t20} "+%Y-%m-%d $H:%M:%S"`


### 获取本机ip地址
ipaddress=`ifconfig | awk '/inet/{print substr($2,1)}' | grep -v "127.0.0.1" | grep "^192"`
echo 本机地址:$ipaddress


## 数组操作
arr=(1 2 3 4 5 6 7 8)
arrLen=${#arr[@]}
echo 第二个数是：${arr[1]}

arr[1]=20

for v in ${arr[@]}
do 
    echo $v
done
