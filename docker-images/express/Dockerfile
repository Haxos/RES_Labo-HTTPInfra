FROM node:14.2

ENV DIRPATH /opt/app

VOLUME ${DIRPATH}

EXPOSE 3000

WORKDIR ${DIRPATH}

CMD npm install --no-bin-links && node index.js
