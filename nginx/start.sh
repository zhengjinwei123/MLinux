#!/bin/bash
PATH=/usr/local/sbin:/usr/local/bin:/usr/sbin:/usr/bin:/root/bin


res=`ps -ef | grep nginx | awk "{print $8}"`

echo $res


if [[ ${res} == "grep" ]]; then
    /usr/local/nginx/sbin/nginx
    unset -v res
    res=`ps -ef | grep nginx | awk "{print $8}"`
    if [[ ${res} == "grep" ]];then
        echo "nginx启动失败"
    else
        echo "nginx启动成功"
    fi
else
   echo "===nginx正在运行中，是否停止(yes/no)==="
   read select

   if [[ ${select} == "yes" ]];then
       pkill nginx
       sleep 3
       /usr/local/nginx/sbin/nginx
       unset -v res
       res=`ps -ef | grep nginx | awk "{print $8}"`
       if [[ ${res} == "grep" ]];then
           echo "启动失败"
       else
           echo "启动成功"
       fi
    else
        echo "您选择了${select}"
    fi
fi
