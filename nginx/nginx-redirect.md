## nginx 重定向
> 当网页的目录结构变动，网页重命名，网页扩展名改变，网站域名改变等都需要对网站进行重定向，否则
> 用户只会得到404 错误

### 案例
> 工作过程中因为做了一个api服务中心，因为不在一个域名下，微信页面访问时导致跨域问题，最后选择在
> 微信页面的域名下放置我的api服务，这样我的api服务就在一个域名的一个端口下，不会出现跨域问题
> 我所使用的是基于lumen的php框架，首页是 apiCenter/public/index.php， 需要对nginx进行配置，要求是访问的地址中
> 不能出现public路径,这就需要用到重定向了，我的配置如下

www80.conf
```
server
{
        listen       80;
        server_name  www.zbjoy.com;
        charset utf-8;

        # discuz伪静态
        rewrite ^([^\.]*)/topic-(.+)\.html$ $1/portal.php?mod=topic&topic=$2 last;
        rewrite ^([^\.]*)/article-([0-9]+)-([0-9]+)\.html$ $1/portal.php?mod=view&aid=$2&page=$3 last;
        #rewrite ^([^\.]*)/forum-(\w+)-([0-9]+)\.html$ $1/forum.php?mod=forumdisplay&fid=$2&page=$3 last;
        #rewrite ^([^\.]*)/thread-([0-9]+)-([0-9]+)-([0-9]+)\.html$ $1/forum.php?mod=viewthread&tid=$2&extra=page%3D$4&page=$3 last;
        #rewrite ^([^\.]*)/group-([0-9]+)-([0-9]+)\.html$ $1/forum.php?mod=group&fid=$2&page=$3 last;
        #rewrite ^([^\.]*)/space-(username|uid)-(.+)\.html$ $1/home.php?mod=space&$2=$3 last;
        #rewrite ^([^\.]*)/blog-([0-9]+)-([0-9]+)\.html$ $1/home.php?mod=space&uid=$2&do=blog&id=$3 last;
        #rewrite ^([^\.]*)/(fid|tid)-([0-9]+)\.html$ $1/index.php?action=$2&value=$3 last;
        #rewrite ^([^\.]*)/([a-z]+[a-z0-9_]*)-([a-z0-9_\-]+)\.html$ $1/plugin.php?id=$2:$3 last;
        #if (!-e $request_filename) {
        #       return 404;
        #}

        location / {
                root    /website/forum;
                index   index.html, index.htm, index.php;
        }

        location /zbApiCenter/ {
                root /website/www/zbApiCenter/public;
                #try_files $uri $uri/ @rewriteApiCenter;
                try_files $uri $uri/ /zbApiCenter/public/index.php?$query_string;
                index index.php index.html index.htm;
        }
        #location @rewriteApiCenter {
        #     rewrite ^/zbApiCenter/(.*)$ /zbApiCenter/public/index.php?$1 last;
        #}

        #limit_conn   crawler  20;
        #php-fpm
        location ~ \.php$ {
                fastcgi_pass    127.0.0.1:9000;
                fastcgi_index   index.php;
                include         fastcgi_params;
                fastcgi_param   SCRIPT_FILENAME  /website/forum$fastcgi_script_name;
        }

        # serve static files directly
        location ~* ^.+.(jpg|jpeg|gif|css|png|js|ico|html|xml|txt)$ {
                root              /website/forum;
                access_log        off;
                expires           max;
        }
}

```

#### 附上不进行重定向的lumen配置
```
server {
    listen       9018;
    server_name  localhost;
    set $root_path '/mnt/hgfs/commonTool/zbApiCenter/public';
    root $root_path;

    index index.php index.html index.htm;

    #try_files $uri $uri/ @rewrite;

    #location @rewrite {
    #   rewrite ^/(.*)$ /index.php?_url=/$1;
    #}

    location / {
        try_files $uri $uri/ /index.php?$query_string;
        index index.php index.html index.htm;
    }


    error_page   500 502 503 504  /50x.html;

    location ~ \.php$ {
        fastcgi_pass   127.0.0.1:9000;
        fastcgi_split_path_info       ^(.+\.php)(/.+)$;
        fastcgi_param PATH_INFO       $fastcgi_path_info;
        fastcgi_param PATH_TRANSLATED $root_path$fastcgi_path_info;
        fastcgi_param SCRIPT_FILENAME $root_path$fastcgi_script_name;
        include                   fastcgi_params;
    }


    location /myCenter{
        root '/mnt/hgfs/commonTool/zbApiCenter/myCenter/public';
        index  index.html index.htm index.php;
        try_files $uri $uri/ /public/index.php?$query_string;
   }

    location ~* ^/(css|img|js|flv|swf|download)/(.+)$ {
        root $root_path;
    }

    location ~ /\.ht {
        deny all;
    }
}

```
