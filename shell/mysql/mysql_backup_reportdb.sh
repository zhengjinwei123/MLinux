#!/bin/bash
PATH=/usr/local/bin:/usr/bin:/usr/local/sbin:/usr/sbin
savetime=`date '+%Y%m%d-%H%M%S'`
ipaddress="127.0.0.1"
mysql_psw="123456"
mysql_db="school"
mysql_tables="t_student"
mysql_user="root"

# 记录log
echo "----------------------------------------" >> /data/mysql_backup/backup.log
echo ${savetime} >> /data/mysql_backup/backup.log

# 数据上报数据库备份和清理

# 备份
folder="/data/mysql_backup/lxh_reportdb"
mkdir -p ${folder}
mysqldump -t ${mysql_db} --tables ${mysql_tables} --single-transaction --master-data=2 -u${mysql_user} -p${mysql_psw} -h ${ipaddress}  | gzip -c > ${folder}/${savetime}.gz
echo "${mysql_db} mysqldump" >> /data/mysql_backup/backup.log

# 删除40天前的数据
mysql -u${mysql_user} -p${mysql_psw} -h ${ipaddress} ${mysql_db} < /data/mysql/reportdb_clear.sql
echo "${mysql_db} clear" >> /data/mysql_backup/backup.log

echo "------------------------------------------" >> /data/mysql_backup/backup.log

