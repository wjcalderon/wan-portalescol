cat /etc/os-release
cat /etc/hostname
cat /etc/resolv.conf

printenv

rm -rf /var/www/html/docroot/sites/default/files
rm -rf /var/www/html/docroot/sites/sponsors/files

ln -s /var/www/html/efs/files/default/files /var/www/html/docroot/sites/default/
ln -s /var/www/html/efs/files/sponsors/files /var/www/html/docroot/sites/sponsors/

ln -s /var/www/html/vendor/bin/drush /usr/local/bin/drush

chown -R nginx:nginx /var/www/html/efs
chown -R nginx:nginx /var/www/html/docroot/sites/default
chown -R nginx:nginx /var/www/html/docroot/sites/sponsors

echo "104.69.219.12 nonprodportal.libertyseguros.co aliados-nonprod.libertyseguros.co" >> /etc/hosts

cat /etc/hosts

#Comandos para hacer el drush cr en tiempo de ejecucion
echo "start drush commands"
# drush sync:import
# drush advagg-caf
# drush cr
echo "finish drush commands"

php-fpm81 && nginx -g 'daemon off;'

echo "Fin start."
