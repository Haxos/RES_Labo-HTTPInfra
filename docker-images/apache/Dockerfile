FROM httpd:2.4

ENV DIRPATH /var/www/html

COPY ./httpd.conf /usr/local/apache2/conf/httpd.conf

VOLUME ${DIRPATH}

EXPOSE 80

WORKDIR $DIRPATH
