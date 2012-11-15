# Pblog #

a simple blog program powered by [simple html dom](http://simplehtmldom.sourceforge.net/) .


一个基于[simple html dom](http://simplehtmldom.sourceforge.net/)的简单博客程序。通过简单的创建html文件更新博客，统一网页样式。伪静态，分页，单文章页功能实现。无rss，无pingback。 

Notice: Nginx 配置文件里面需要添加如下代码：

> 		location / {
>                 if (!-e $request_filename){
>                         rewrite ^/(.*)$ /index.php?s=/$1 last;
>                 }
>                 index    index.php;
>         }


pblog@cyrilis.com