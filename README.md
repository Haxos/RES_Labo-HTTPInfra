# RES Labo-HTTPInfra

## Introduction
For the static content server, we choose to use the Apache httpd server.

We are also using php for dynamic pages generation.

For this lab, we decided to use php-fpm so we can run php in a different container than the static web server.
This environment allows easier performance scaling (load-balancing from a single web server across multiple php servers for example) as well as the ability to swap the web server for something like nginx.
This also makes building images faster because if we change an apache configuration, we don't need to rebuild the php image.

For the dynamic content server, we choose to use ExpressJS (called Express later).

Because we need to use different containers, we decided to use docker-compose to ease the use of launch for many containers with all the ports and volumes bindings.
To build the different containers, the commandline `docker-compose build` is used.
To run the different containers, the commandline `docker-compose up -d` is used.
Finally, for shuting down all the container, the commandline `docker-compose down` is used.

The different images for Docker are present on `docker-images/`.

The docker version used is the Windows Docker Desktop `19.03.8` and the docker-compose version is the `1.25.5`.

## STEP 1
### Docker-compose
Docker-compose is used to manage the different containers.
The ports and volumes binding are realise through the `docker-compose.yml` config but the ports expositions are treated by the Dockerfiles.
The container dependencies (e.g. running php-fpm before apache) are also treated through docker-compose.

### Apache
#### Configuration
To get a default apache httpd.conf, the following command has been used : `docker run --rm httpd:2.4 cat /usr/local/apache2/conf/httpd.conf > docker-images/apache/httpd.conf`.

In `httpd.conf`, the following operations have been executed:
- Uncommenting the following lines. This is required to pass requests to php-fpm:
  - `LoadModule proxy_module modules/mod_proxy.so`.
  - `LoadModule proxy_fcgi_module modules/mod_proxy_fcgi.so`.
- Adding after `DocumentRoot` the following line: `ProxyPassMatch ^/(.*\.php)$ fcgi://php-fpm:9000/var/www/html/$1`. This will actually forward the processing of all php files to php-fpm.
- In `DocumentRoot` and `<Directory>`, the path `/usr/local/apache2/htdocs/` has been changed into the current used path by the server `/var/www/html/`.
- In `<IfModule dir_module>`, `DirectoryIndex index.html` has been changed to `DirectoryIndex index.php index.html`. This will make sure that Apache try to serve the `index.php` file instead of `index.html` when the URI matches a directory.

#### Dockerfile
The Apache image is based on the image `httpd:2.4`.
We decided to precise the major and minor version to avoid major breakdown between versions.

The configuration file is directly copied into the Apache image instead of binding via a volume because we wont change its configuration on runtime so there is no interest into binding it in a volume.
We prefer to rebuild the container if we want to apply a new config.

The source files of the website is bound through a volume because we don't want to shutdown the container if we have modification to do on the different pages.
Our source files are placed under `./public/`.
The image set the working directory on `/var/www/html/`.

The port `80` is exposed and can be access on the host via the port `8080`.
This is no longer the case after the step 3 realize on the branch `feature-feature-ngnix-reverse-proxy`.
Then it's access through the reverse proxy on `http://<docker_ip>:8080/`.

### Composer
This container is used to run the composer installation with the different dependencies for PHP.

### PHP-FPM
PHP-FPM is used to separate the functionalities of PHP and Apache.

## STEP 2
### Express
The Express image is based on NodeJS version ``14.2`` and the Express version used is ``4.17.1``.

The container can be access on port ``3000`` on the container and host machine.
This is no longer the case after the step 3 realize on the branch `feature-feature-ngnix-reverse-proxy`.
Then it's access through the reverse proxy on `http://<docker_ip>:8080/api`.

The server generate a random array of JSON representing transactions using ChanceJS ``1.1.5``.

Note that because of problems running npm install with docker on Windows trough VirtualBox (the symlinks doesn't work with node for linux writing to a ntfs filesystem), we needed to use the flag `--no-bin-links`.
We could also run npm install using node for Windows (outside of docker), but we think it's better to do this step using docker.

## STEP 3
### Nginx
For the reverse proxy part, we decided to use Nginx instead of Apache because of the following reasons:
- It has better performance
- It was made for being a reverse proxy so the configuration is simpler
- We already had experiences with Apache but wanted to test Nginx

We had to edit the default config files using the following commands:
- Get the default Nginx config : `docker run --rm nginx:1.17 cat /etc/nginx/nginx.conf > docker-images/nginx-reverse-proxy/nginx.conf`.
- Get the default Nginx proxy : `docker run --rm nginx:1.17 cat /etc/nginx/conf.d/default.conf > docker-images/nginx-reverse-proxy/proxy.conf`

We didn't modify anything in nginx.conf but we decided to version it anyway because it may be useful to add some global directives here in the future.

In the proxy.conf file, we added 2 `location` nodes (one for Apache and one for Express). Each node contains a `proxy_pass` directive that forwards requests and responses between the client and the appropriate container.
Note that with Nginx there is no need to define the reverse path for the response.

Warning : when copying the config files above from the base image, it was saved in UTF-16 LE encoding. After copying back these files to our image, Nginx had problems parsing them. We had to convert them back to UTF-8.

We removed some ports mapping from our docker-compose.yml file so that we cannot access our Apache and Express containers without going trough the reverse proxy.

Because we use docker compose, unlike in the webcasts we don't need to specify manually the ip addresses of the Apache and Express containers. In our config files we use the hostnames assigned by docker-compose instead, which gives us more robustness.

## STEP 4

## STEP 5
### Docker-compose
For these step, we begun to use docker-compose to manage the dynamic reverse proxy configuration because we use these technology professionally.
But we will still detailed the definitive configuration here.

The docker-compose file version used is the latest (`3`).

#### Containers
The different container created are the followings :
- `apache` the apache server used for the dynamic pages. Its image is located in `./docker-images/apache/`.
- `composer` : container used for running the packet manager composer  for the installation of PHP dependencies. Its image is located in `./docker-images/composer/`.
- `express` : the expressJS server used for generating dynamic data. Its image is located in `./docker-images/express/`.
- `php-fpm` : container used for interpreting the PHP scripts. Its image is located in `./docker-images/express/`.
- `reverse-proxy` : the reverse proxy of our application. Its image is located in `./docker-images/nginx-reverse-proxy/`.

#### Networks
Two networks are created : `backend` and `frontend`.
The `backend` network is used for all the containers that need to communicate between them without having to communicate with the client.
On the other hand, the `frontend` network is used for all the containers that need to communicate with the client.
It create a supplementary layer between the containers use by client and the others.

The `php-fpm` container uses only the `backend` network because the client doesn't need to execute PHP script.
The `reverse-proxy` and `express` containers use the `frontend` container because they need only to communicate with the client and doesn't need others resources given by others containers.
The `apache` container uses both networks because it need resources given by another container (`php-fpm` in these case) and need to give resources to the client.
Finally, `composer` doesn't need any network because it's launch as a standalone and doesn't depend on anything.

#### Dependencies
Some containers need that certain containers are launch before hand. These dependencies are describe by the instruction `depends_on`.

The tree is as follow :
```
reverse-proxy
  |
  +- express
  |
  +- apache
      |
      +- php-fpm
          |
          +- composer
```
So `reverse-proxy` need to have `express` and `apache` launch before it can be launch. `apache` need `php-fpm` and the later need `composer`.
