# vmstat
> vmstat 作为linux下常用的性能监控工具，可以统计内存，io以及cpu的使用情况，而且可以按一定间隔统计

### 使用
每秒统计一次，直到用户按下`CTRL+C`为止
```
[root@localhost robot]# vmstat 1
procs -----------memory---------- ---swap-- -----io---- -system-- ------cpu-----
 r  b   swpd   free   buff  cache   si   so    bi    bo   in   cs us sy id wa st
 0  0 352676  96952      0 480480    0    0     8    45   38   21  1  3 96  0  0
 0  0 352676  96936      0 480480    0    0     0     5  278  524  0  1 99  0  0
 0  0 352676  96936      0 480480    0    0     0    16  221  443  1  1 99  0  0
 0  0 352676  96812      0 480480    0    0     0    71  242  482  0  0 100  0  0
```

```
vmstat 2 3           每2秒统计一次，统计3次后结束
vmstat               统计一次后结束
```
