## nginx 配置

```nginx
  location / {
            index  index.html index.htmi index.php;
            try_files $uri $uri/ /index.php$uri?$args;
        }

        #error_page  404              /404.html;

        # redirect server error pages to the static page /50x.html
        #

        # proxy the PHP scripts to Apache listening on 127.0.0.1:80
        #
        #location ~ \.php$ {
        #    proxy_pass   http://127.0.0.1;
        #}

        # pass the PHP scripts to FastCGI server listening on 127.0.0.1:9000
        #
        location ~ \.php(/?.*)$ {
            include        fastcgi_params;
            fastcgi_split_path_info ^(.+?\.php)(/.*)$;
            fastcgi_pass   php-fpm-backend;
            fastcgi_index  index.php;
        }

```