#!/bin/bash

PHP_PATH="/Applications/XAMPP/bin/php"

$PHP_PATH bin/magento maintenance:enable;

rm -R var/generation 2> /dev/null;

rm -R var/cache 2> /dev/null;
rm -R var/page_cache 2> /dev/null;
rm -R var/view_preprocessed 2> /dev/null;

rm -R var/di 2> /dev/null;
mkdir var/di;

while getopts "abcdghlrstu" opt
do
    case $opt in
        # analyze with custom tool
        a ) /usr/bin/osascript -e 'tell application "System Events" to tell process "Terminal" to keystroke "k" using command down'
            $PHP_PATH helpme.phar -h -ss -p app/code/Iways
        ;;
        # full backend deploy
        b ) #rm -R pub/static/_requirejs 2> /dev/null
            rm -R pub/static/adminhtml 2> /dev/null
            $PHP_PATH bin/magento setup:static-content:deploy --area adminhtml
            $PHP_PATH bin/magento setup:static-content:deploy --area adminhtml de_DE
        ;;
        # compilation
        c ) $PHP_PATH bin/magento setup:di:compile
        ;;
        # base frontend deploy
        d ) rm -R pub/static/_requirejs 2> /dev/null
            rm -R pub/static/frontend 2> /dev/null
            $PHP_PATH bin/magento setup:static-content:deploy --area frontend --exclude-theme Magento/luma
        ;;
        # german frontend deploy
        g ) $PHP_PATH bin/magento setup:static-content:deploy --area frontend de_DE --exclude-theme Magento/luma
        ;;
        #
        h ) printf "b) full backend deploy
a) analyze with custom tool        
b) full backend deploy
c) compilation
d) base frontend deploy
g) german frontend deploy
h) this help information
l) clears layouts cache
r) reindex all indexes
s) scan directory with php sniffer
t) clears translations cache
u) magento setup upgrade"
        ;;
        # clears layouts cache
        l ) $PHP_PATH bin/magento cache:clean layout
        ;;
        # reindex all indexes   
        r ) $PHP_PATH bin/magento indexer:info
            $PHP_PATH bin/magento indexer:status
            $PHP_PATH bin/magento indexer:reindex
        ;;
        # scan i-ways app directory with phpcs
        s ) $PHP_PATH vendor/bin/phpcs -h
            EXTENSIONS_TO_CHECK="inc,php,phtml,js,json,css"
            #PATH_TO_SNIFF="app/code/Iways/DeveloperToolBox"
            #$PHP_PATH vendor/bin/phpcs $PATH_TO_SNIFF --extensions=$EXTENSIONS_TO_CHECK
           
            PATH_TO_SNIFF="app/code/Iways"
            $PHP_PATH vendor/bin/phpcs --standard=EcgM2 $PATH_TO_SNIFF --extensions=$EXTENSIONS_TO_CHECK --ignore=DeveloperToolBox
            $PHP_PATH vendor/bin/phpcs --standard=PSR2 $PATH_TO_SNIFF --extensions=$EXTENSIONS_TO_CHECK --ignore=DeveloperToolBox
            $PHP_PATH vendor/bin/phpcs --standard=PSR1 $PATH_TO_SNIFF --extensions=$EXTENSIONS_TO_CHECK --ignore=DeveloperToolBox
            $PHP_PATH vendor/bin/phpcs $PATH_TO_SNIFF --extensions=$EXTENSIONS_TO_CHECK --ignore=DeveloperToolBox # to be deleted
            if [ -d "app/code/Vollkorn" ]; then
                PATH_TO_SNIFF="app/code/Vollkorn"
                $PHP_PATH vendor/bin/phpcs --standard=EcgM2 $PATH_TO_SNIFF --extensions=$EXTENSIONS_TO_CHECK
                $PHP_PATH vendor/bin/phpcs --standard=PSR2 $PATH_TO_SNIFF --extensions=$EXTENSIONS_TO_CHECK
                $PHP_PATH vendor/bin/phpcs --standard=PSR1 $PATH_TO_SNIFF --extensions=$EXTENSIONS_TO_CHECK
                $PHP_PATH vendor/bin/phpcs $PATH_TO_SNIFF --extensions=$EXTENSIONS_TO_CHECK
		    fi
		    
            PATH_TO_SNIFF="app/design/frontend/Iways"
            $PHP_PATH vendor/bin/phpcs --standard=EcgM2 $PATH_TO_SNIFF --extensions=$EXTENSIONS_TO_CHECK
            $PHP_PATH vendor/bin/phpcs --standard=PSR2 $PATH_TO_SNIFF --extensions=$EXTENSIONS_TO_CHECK
            $PHP_PATH vendor/bin/phpcs --standard=PSR1 $PATH_TO_SNIFF --extensions=$EXTENSIONS_TO_CHECK
            $PHP_PATH vendor/bin/phpcs $PATH_TO_SNIFF --extensions=$EXTENSIONS_TO_CHECK
            if [ -d "app/design/frontend/Vollkorn" ]; then
                PATH_TO_SNIFF="app/design/frontend/Vollkorn"
                $PHP_PATH vendor/bin/phpcs --standard=EcgM2 $PATH_TO_SNIFF --extensions=$EXTENSIONS_TO_CHECK
                $PHP_PATH vendor/bin/phpcs --standard=PSR2 $PATH_TO_SNIFF --extensions=$EXTENSIONS_TO_CHECK
                $PHP_PATH vendor/bin/phpcs --standard=PSR1 $PATH_TO_SNIFF --extensions=$EXTENSIONS_TO_CHECK
                $PHP_PATH vendor/bin/phpcs $PATH_TO_SNIFF --extensions=$EXTENSIONS_TO_CHECK
		    fi
        ;;
        # clears translations cache
        t) $PHP_PATH bin/magento cache:clean translate
        ;;
        # magento setup upgrade
        u) $PHP_PATH bin/magento setup:upgrade
        ;;
    esac
done

printf "\nhelping process took $SECONDS seconds\n\n";

osascript -e 'display notification "May the VOLLKORN PASTA be always with you!" with title "Lord Vollkorn says: FERTIG in '$SECONDS' seconds" sound name "Glass"';

$PHP_PATH bin/magento maintenance:disable;
