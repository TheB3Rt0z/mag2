/Applications/XAMPP/bin/php bin/magento maintenance:enable;

rm -R var/generation 2> /dev/null;

rm -R var/cache 2> /dev/null;
rm -R var/page_cache 2> /dev/null;
rm -R var/view_preprocessed 2> /dev/null;

rm -R var/di 2> /dev/null;
mkdir var/di;
/Applications/XAMPP/bin/php bin/magento setup:upgrade;

while getopts bcdghlt opt
do
   case $opt in
       b) # full backend deploy
           rm -R pub/static/_requirejs 2> /dev/null;
           rm -R pub/static/adminhtml 2> /dev/null;
           /Applications/XAMPP/bin/php bin/magento setup:static-content:deploy --area adminhtml;
           /Applications/XAMPP/bin/php bin/magento setup:static-content:deploy --area adminhtml de_DE;;
       c) /Applications/XAMPP/bin/php bin/magento setup:di:compile;; # compilation
       d) # base global deploy
           rm -R pub/static/_requirejs 2> /dev/null;
           rm -R pub/static/adminhtml 2> /dev/null;
           rm -R pub/static/frontend 2> /dev/null;
           /Applications/XAMPP/bin/php bin/magento setup:static-content:deploy;;
       g) /Applications/XAMPP/bin/php bin/magento setup:static-content:deploy de_DE;; # german global deploy
       h) printf "\nDIOCANE\n\n";;
       l) /Applications/XAMPP/bin/php bin/magento cache:clean layout;; # clears layouts cache
       t) /Applications/XAMPP/bin/php bin/magento cache:clean translate;; # clears translations cache
   esac
done

printf "\nhelping process took $SECONDS seconds\n\n";

osascript -e 'display notification "May the VOLLKORN PASTA be always with you!" with title "Lord Vollkorn says: FERTIG in '$SECONDS' seconds" sound name "Glass"';

/Applications/XAMPP/bin/php bin/magento maintenance:disable;
