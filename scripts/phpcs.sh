#!/bin/sh

if [ "$1" == "fix" ]; then
  ./vendor/bin/phpcbf --standard=Drupal,DrupalPractice --extensions=php,module,inc,install,test,profile,theme,css,info,txt,md,yml docroot/modules/custom/liberty_form/liberty_form.module
else
  ./vendor/bin/phpcs --standard=Drupal,DrupalPractice --extensions=php,module,inc,install,test,profile,theme,css,info,txt,md,yml docroot/modules/custom/liberty_form/liberty_form.module
fi
