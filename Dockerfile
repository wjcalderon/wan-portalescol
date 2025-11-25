FROM ghcr.io/hdiseguroscol/php-nginx-docker:v1.0.6 AS base

WORKDIR /var/www/html/
COPY . .

FROM base AS deps
RUN composer install --ignore-platform-reqs --optimize-autoloader

FROM deps AS files

RUN mkdir -p docroot/sites/default/files && \
  chmod 777 docroot/sites/default/files -R && \
  chmod 777 docroot/sites/default/settings.php

RUN mkdir -p efs
RUN chown nginx:nginx efs
RUN chmod 755 efs

RUN mkdir -p docroot/sites/sponsors/files
RUN chmod 777 docroot/sites/sponsors/files -R
COPY start.sh /opt/start.sh

RUN mkdir -p /var/www/html/efs/tmp && \
  ln -sf /var/www/html/efs/tmp /tmp && \
  ln -s /var/www/html/efs/files/default/files /var/www/html/docroot/sites/default/files && \
  ln -s /var/www/html/efs/files/sponsors/files /var/www/html/docroot/sites/sponsors/files && \
  ln -s /var/www/html/vendor/bin/drush /usr/local/bin/drush

RUN ls -altrh

FROM files AS final

RUN chown -R nginx:nginx /var/www/html/ && chmod -R 755 /var/www/html/
#RUN chown -R nginx:nginx /var/www/html/efs/

RUN ls -altrh

EXPOSE 80

STOPSIGNAL SIGTERM

RUN dos2unix /opt/start.sh
# RUN bash /opt/start.sh

ENTRYPOINT ["sh","/opt/start.sh"]
