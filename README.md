# RES Labo-HTTPInfra

## Installation & configuration
For the static content server, we choose to use the Apache httpd server.
We are also using php for dynamic content generation.

For this lab, we decided to use php-fpm so we can run php in a different container than the static web server.
This environment allows easier performance scaling (load-balancing from a single web server across multiple php servers for example) as well as the ability to swap the web server for something like nginx.
This also makes building images faster because if we change an apache configuration, we don't need to rebuild the php image.

For the dynamic content server, we choose to use ExpressJS (called Express later).

Because we need to use different containers, we decided to use docker-compose to ease the use of launch for many containers with all the ports and volumes bindings.
To run the different containers, we use the commandline `docker-compose up -d` and for shuting down all the container, we use `docker-compose down`.

### Apache
Get a default apache httpd.conf : `docker run --rm httpd:2.4 cat /usr/local/apache2/conf/httpd.conf > docker-images/apache/httpd.conf`

In `httpd.conf`:
- Uncomments the following lines. This is required to pass requests to php-fpm:
  - `LoadModule proxy_module modules/mod_proxy.so`
  - `LoadModule proxy_fcgi_module modules/mod_proxy_fcgi.so`
- Add after `DocumentRoot` the following line: `ProxyPassMatch ^/(.*\.php)$ fcgi://php-fpm:9000/var/www/html/$1`. This will actually forward the processing of all php files to php-fpm
- In `DocumentRoot` and `<Directory>` change the path `/usr/local/apache2/htdocs` into the current use path `/var/www/html`
- In `<IfModule dir_module>` change `DirectoryIndex index.html` to `DirectoryIndex index.php index.html`. This will make Apache try to serve the index.php file instead of index.html when the uri matches a directory.

The Apache container can be access on port `80` and, with our docker-compose config, it can be access from the host on port `8080`.

### Express
The Express image is based on NodeJS version ``14.2`` and the Express version used is ``4.17.1``.

The container can be access on port ``3000`` on the container and host machine.

The server generate a random array of JSON representing transactions using ChanceJS ``1.1.5``.
