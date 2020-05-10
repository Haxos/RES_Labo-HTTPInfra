# RES Labo-HTTPInfra

## Installation & configuration
For the static content server, we choose to use the Apache httpd server.

We are also using php for dynamic content generation.

For this lab, we decided to use php-fpm so we can run php in a different container than the web server.
This environment allows easier performance scaling (load-balancing from a single web server across multiple php servers for example) as well as the ability to swap the web server for something like nginx.
This also makes building images faster because if we change an apache configuration, we don't need to rebuild the php image.

### Apache
Get a default apache httpd.conf : `docker run --rm httpd:2.4 cat /usr/local/apache2/conf/httpd.conf > docker-images/apache/httpd.conf`

In `httpd.conf`:
- Uncomments the following lines. This is required to pass requests to php-fpm:
  - `LoadModule proxy_module modules/mod_proxy.so`
  - `LoadModule proxy_fcgi_module modules/mod_proxy_fcgi.so`
- Add after `DocumentRoot` the following line: `ProxyPassMatch ^/(.*\.php)$ fcgi://php-fpm:9000/var/www/html/$1`. This will actually forward the processing of all php files to php-fpm
- In `DocumentRoot` and `<Directory>` change the path `/usr/local/apache2/htdocs` into the current use path `/var/www/html`
- In `<IfModule dir_module>` change `DirectoryIndex index.html` to `DirectoryIndex index.php index.html`. This will make Apache try to serve the index.php file instead of index.html when the uri matches a directory.

