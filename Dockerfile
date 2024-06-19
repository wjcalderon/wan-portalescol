FROM ghcr.io/hdiseguroscol/php-nginx-docker:v1.0.2 AS base

WORKDIR /var/www/html/
COPY . .

FROM base AS files

RUN mkdir -p docroot/sites/default/files
RUN chmod 777 docroot/sites/default/files -R
RUN chmod 777 docroot/sites/default/settings.php

RUN mkdir -p efs
RUN chown nginx:root efs
RUN chmod 755 efs

RUN mkdir -p docroot/sites/sponsors/files
RUN chmod 777 docroot/sites/sponsors/files -R
COPY start.sh /opt/start.sh

FROM files AS final

EXPOSE 80

STOPSIGNAL SIGTERM

RUN dos2unix /opt/start.sh

ENTRYPOINT ["sh","/opt/start.sh"]
