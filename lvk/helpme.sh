rm -R var/cache 2> /dev/null;
rm -R var/di 2> /dev/null;
rm -R var/generation 2> /dev/null;
rm -R var/page_cache 2> /dev/null;
rm -R var/view_preprocessed 2> /dev/null;

/Applications/XAMPP/bin/php bin/magento setup:upgrade;

rm -R pub/static/_requirejs 2> /dev/null;
rm -R pub/static/adminhtml 2> /dev/null;
rm -R pub/static/frontend 2> /dev/null;

while getopts cde opt
do
   case $opt in
       c) /Applications/XAMPP/bin/php bin/magento setup:di:compile;;
       d) /Applications/XAMPP/bin/php bin/magento setup:static-content:deploy;;
       e) /Applications/XAMPP/bin/php bin/magento setup:static-content:deploy de_DE;;
   esac
done

printf "\nhelping process took $SECONDS seconds\n\n";

osascript -e 'display notification "May the VOLLKORN PASTA be always with you!" with title "Lord Vollkorn says: JOB DONE in '$SECONDS' seconds" sound name "Glass"';
