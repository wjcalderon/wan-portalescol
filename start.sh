#!/bin/bash
ACTUAL_VERSION_FILE="/var/www/html/efs/VERSION"
DEPLOY_VERSION_FILE="/var/www/html/VERSION"

cat /etc/os-release
cat /etc/hostname
cat /etc/resolv.conf

#printenv
echo "Iniciando-readonlyfilesystem-true v2"

#rm -rf /var/www/html/docroot/sites/default/files
#rm -rf /var/www/html/docroot/sites/sponsors/files
#echo "Creando-link-symbolico..."
#ln -sf /var/www/html/efs/files/default/files /var/www/html/docroot/sites/default/files
#ln -s /var/www/html/efs/files/default/files /var/www/html/docroot/sites/default/
#ln -s /var/www/html/efs/files/sponsors/files /var/www/html/docroot/sites/sponsors/

#ln -s /var/www/html/vendor/bin/drush /usr/local/bin/drush
#echo "Agredando-permisos..."
#chown -R nginx:nginx /var/www/html/docroot/sites/default/files
#chmod -R 755 /var/www/html/docroot/sites/default/files

# chown -R nginx:nginx /var/www/html/efs
# chown -R nginx:nginx /var/www/html/docroot/sites/default
# chown -R nginx:nginx /var/www/html/docroot/sites/sponsors
 
# echo "104.69.219.12 nonprodportal.libertyseguros.co aliados-nonprod.libertyseguros.co" >> /etc/hosts

cat /etc/hosts

if [ -n "$CICD" ]; then
    echo "Run on action"
else
  if [ -f "$ACTUAL_VERSION_FILE" ]; then
    if cmp -s "$ACTUAL_VERSION_FILE" "$DEPLOY_VERSION_FILE"; then
      echo "same version"
    else
      cp "$DEPLOY_VERSION_FILE" "$ACTUAL_VERSION_FILE"

      #Comandos para hacer el drush cr en tiempo de ejecucion
      echo "start drush commands"
      # drush sync:import
      drush advagg-caf
      drush cr
      echo "finish drush commands"

    fi
  else
    echo "no file version"
    cp "$DEPLOY_VERSION_FILE" "$ACTUAL_VERSION_FILE"

    #Comandos para hacer el drush cr en tiempo de ejecucion
    echo "start drush commands"
    # drush sync:import
    drush advagg-caf
    drush cr
    echo "finish drush commands"
  fi
fi

php-fpm81 && nginx -g 'daemon off;'

echo "Fin start."
