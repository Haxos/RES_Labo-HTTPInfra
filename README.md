# RES Labo-HTTPInfra

## Introduction
For the static content server, we choosed to use the Apache httpd server.

We are also using php for dynamic pages generation.

For this lab, we decided to use php-fpm so we can run php in a different container than the web server.
This environment allows easier performance scaling (load-balancing from a single web server across multiple php servers for example) as well as the ability to swap the web server for something like nginx.
This also makes building images faster because if we change an apache configuration, we don't need to rebuild the php image.

Because we need to use different containers, we decided to use docker-compose to ease the use of launch for many containers with all the ports and volumes bindings.
To build the different containers, the commandline `docker-compose build` is used.
To run the different containers, the commandline `docker-compose up -d` is used.
Finally, for shuting down all the container, the commandline `docker-compose down` is used.

The different images for Docker are present on `docker-images/`.

## Docker-compose


## Apache
### Configuration
To get a default apache httpd.conf, the following command has been used : `docker run --rm httpd:2.4 cat /usr/local/apache2/conf/httpd.conf > docker-images/apache/httpd.conf`.

In `httpd.conf`, the following operations have been executed:
- Uncommenting the following lines. This is required to pass requests to php-fpm:
  - `LoadModule proxy_module modules/mod_proxy.so`.
  - `LoadModule proxy_fcgi_module modules/mod_proxy_fcgi.so`.
- Adding after `DocumentRoot` the following line: `ProxyPassMatch ^/(.*\.php)$ fcgi://php-fpm:9000/var/www/html/$1`. This will actually forward the processing of all php files to php-fpm.
- In `DocumentRoot` and `<Directory>`, the path `/usr/local/apache2/htdocs/` has been changed into the current used path by the server `/var/www/html/`.
- In `<IfModule dir_module>`, `DirectoryIndex index.html` has been changed to `DirectoryIndex index.php index.html`. This will make sure that Apache try to serve the `index.php` file instead of `index.html` when the URI matches a directory.

### Dockerfile
The Apache image is based on the image `httpd:2.4`.
We decided to precise the major and minor version to avoid major breakdown between versions.

The configuration file is directly copied into the Apache image instead of binding via a volume because we wont change its configuration on runtime so there is no interest into binding it in a volume.
We prefer to rebuild the container if we want to apply a new config.

The source files of the website is binded through a volume because we don't want to shutdown the container if we have modification to do on the different pages.
Our source files are placed under `./public/`.
The image set the working directory on `/var/www/html/`.

The port 80 is exposed.

