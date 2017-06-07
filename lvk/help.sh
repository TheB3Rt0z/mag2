START_TIME=0;

/Applications/XAMPP/bin/php bin/magento setup:upgrade;
rm -R var/cache;
rm -R var/di;
rm -R var/generation;
rm -R var/page_cache;
rm -R var/view_preprocessed;

while getopts c opt
do
   case $opt in
       c) /Applications/XAMPP/bin/php bin/magento setup:di:compile;;
   esac
done

rm -R pub/static/_requirejs;
rm -R pub/static/adminhtml;
rm -R pub/static/frontend;

while getopts d opt
do
   case $opt in
       d) /Applications/XAMPP/bin/php bin/magento setup:static-content:deploy de_DE;;
   esac
done

printf "\nhelping process took $SECONDS seconds\n\n";

osascript -e 'display notification "May the PASTA be always with you!" with title "Lord Vollkorn says:"';