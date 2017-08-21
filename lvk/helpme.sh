#!/bin/bash

/Applications/XAMPP/bin/php bin/magento maintenance:enable;

rm -R var/generation 2> /dev/null;

rm -R var/cache 2> /dev/null;
rm -R var/page_cache 2> /dev/null;
rm -R var/view_preprocessed 2> /dev/null;

rm -R var/di 2> /dev/null;
mkdir var/di;

while getopts "bcdghltu" opt
do
   case $opt in
       # full backend deploy
       b) #rm -R pub/static/_requirejs 2> /dev/null
          rm -R pub/static/adminhtml 2> /dev/null
          /Applications/XAMPP/bin/php bin/magento setup:static-content:deploy --area adminhtml
          /Applications/XAMPP/bin/php bin/magento setup:static-content:deploy --area adminhtml de_DE
          ;;
       # compilation
       c) /Applications/XAMPP/bin/php bin/magento setup:di:compile
          ;;
       # base frontend deploy
       d) rm -R pub/static/_requirejs 2> /dev/null
          rm -R pub/static/frontend 2> /dev/null
          /Applications/XAMPP/bin/php bin/magento setup:static-content:deploy --area frontend --exclude-theme Magento/luma --exclude-theme Ece/alstertal
          ;;
       # german frontend deploy
       g) /Applications/XAMPP/bin/php bin/magento setup:static-content:deploy --area frontend de_DE --exclude-theme Magento/luma --exclude-theme Ece/alstertal
          ;;
       #
       h) printf "b) full backend deploy
c) compilation
d) base frontend deploy
g) german frontend deploy
l) clears layouts cache
t) clears translations cache
u) magento setup upgrade"
          ;;
       # clears layouts cache
       l) /Applications/XAMPP/bin/php bin/magento cache:clean layout
          ;;
       # clears translations cache
       t) /Applications/XAMPP/bin/php bin/magento cache:clean translate
          ;;
       # magento setup upgrade
       u) /Applications/XAMPP/bin/php bin/magento setup:upgrade
          ;;
   esac
done

printf "\nhelping process took $SECONDS seconds\n\n";

osascript -e 'display notification "May the VOLLKORN PASTA be always with you!" with title "Lord Vollkorn says: FERTIG in '$SECONDS' seconds" sound name "Glass"';

/Applications/XAMPP/bin/php bin/magento maintenance:disable;
