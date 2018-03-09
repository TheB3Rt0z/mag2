#!/bin/bash

if [ -f bin/magento ]; then
	bin/magento maintenance:enable;
fi

rm -R var/generation 2> /dev/null;
rm -R generated 2> /dev/null;

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
            helpme.phar -h -ss -p app/code/Iways
        ;;
        # full backend deploy
        b ) #rm -R pub/static/_requirejs 2> /dev/null
            rm -R pub/static/adminhtml 2> /dev/null
            bin/magento setup:static-content:deploy -f --area adminhtml
            bin/magento setup:static-content:deploy -f --area adminhtml de_DE
        ;;
        # compilation
        c ) bin/magento setup:di:compile
        ;;
        # base frontend deploy
        d ) rm -R pub/static/_requirejs 2> /dev/null
            rm -R pub/static/frontend 2> /dev/null
            bin/magento setup:static-content:deploy -f --area frontend --exclude-theme Magento/luma
        ;;
        # german frontend deploy
        g ) bin/magento setup:static-content:deploy -f --area frontend de_DE --exclude-theme Magento/luma
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
        l ) bin/magento cache:clean layout
        ;;
        # reindex all indexes   
        r ) bin/magento indexer:info
            bin/magento indexer:status
            bin/magento indexer:reindex
        ;;
        # scan i-ways app directory with phpcs
        s ) ics/phpcs -h
            EXTENSIONS_TO_CHECK="inc,php,phtml,js,json,css"
            IGNORED_MODULES="--ignore=DeveloperToolBox --ignore=PayPalPlus --ignore=Slider --ignore=Widgerama"
            #PATH_TO_SNIFF="app/code/Iways/DeveloperToolBox"
            #ics/phpcs $PATH_TO_SNIFF --extensions=$EXTENSIONS_TO_CHECK
           
            PATH_TO_SNIFF="app/code/Iways"
            printf "\nsniffing $PATH_TO_SNIFF with EcgM2 standard:";
            ics/phpcs --standard=EcgM2 $PATH_TO_SNIFF --extensions=$EXTENSIONS_TO_CHECK $IGNORED_MODULES
            printf "\nsniffing $PATH_TO_SNIFF with PSR2 standard:";
            ics/phpcs --standard=PSR2 $PATH_TO_SNIFF --extensions=$EXTENSIONS_TO_CHECK $IGNORED_MODULES
            printf "\nsniffing $PATH_TO_SNIFF with PSR1 standard:";
            ics/phpcs --standard=PSR1 $PATH_TO_SNIFF --extensions=$EXTENSIONS_TO_CHECK $IGNORED_MODULES
            printf "\nsniffing $PATH_TO_SNIFF with default standard:";
            ics/phpcs $PATH_TO_SNIFF --extensions=$EXTENSIONS_TO_CHECK $IGNORED_MODULES # to be deleted
            if [ -d "app/code/Vollkorn" ]; then
                PATH_TO_SNIFF="app/code/Vollkorn"
                printf "\nsniffing $PATH_TO_SNIFF with EcgM2 standard:";
            	ics/phpcs --standard=EcgM2 $PATH_TO_SNIFF --extensions=$EXTENSIONS_TO_CHECK --ignore=Adminhtml # because of tricks
                printf "\nsniffing $PATH_TO_SNIFF with PSR2 standard:";
            	ics/phpcs --standard=PSR2 $PATH_TO_SNIFF --extensions=$EXTENSIONS_TO_CHECK
                printf "\nsniffing $PATH_TO_SNIFF with PSR1 standard:";
            	ics/phpcs --standard=PSR1 $PATH_TO_SNIFF --extensions=$EXTENSIONS_TO_CHECK
                printf "\nsniffing $PATH_TO_SNIFF with default standard:";
            	ics/phpcs $PATH_TO_SNIFF --extensions=$EXTENSIONS_TO_CHECK
		    fi
		    
            PATH_TO_SNIFF="app/design/frontend/Iways"
            printf "\nsniffing $PATH_TO_SNIFF with EcgM2 standard:";
            ics/phpcs --standard=EcgM2 $PATH_TO_SNIFF --extensions=$EXTENSIONS_TO_CHECK
            printf "\nsniffing $PATH_TO_SNIFF with PSR2 standard:";
            ics/phpcs --standard=PSR2 $PATH_TO_SNIFF --extensions=$EXTENSIONS_TO_CHECK
            printf "\nsniffing $PATH_TO_SNIFF with PRS1 standard:";
            ics/phpcs --standard=PSR1 $PATH_TO_SNIFF --extensions=$EXTENSIONS_TO_CHECK
            printf "\nsniffing $PATH_TO_SNIFF with default standard:";
            ics/phpcs $PATH_TO_SNIFF --extensions=$EXTENSIONS_TO_CHECK
            if [ -d "app/design/frontend/Vollkorn" ]; then
                PATH_TO_SNIFF="app/design/frontend/Vollkorn"
                printf "\nsniffing $PATH_TO_SNIFF with EcgM2 standard:";
            	ics/phpcs --standard=EcgM2 $PATH_TO_SNIFF --extensions=$EXTENSIONS_TO_CHECK
                printf "\nsniffing $PATH_TO_SNIFF with PSR2 standard:";
            	ics/phpcs --standard=PSR2 $PATH_TO_SNIFF --extensions=$EXTENSIONS_TO_CHECK
                printf "\nsniffing $PATH_TO_SNIFF with PSR1 standard:";
            	ics/phpcs --standard=PSR1 $PATH_TO_SNIFF --extensions=$EXTENSIONS_TO_CHECK
                printf "\nsniffing $PATH_TO_SNIFF with default standard:";
            	ics/phpcs $PATH_TO_SNIFF --extensions=$EXTENSIONS_TO_CHECK
		    fi
        ;;
        # clears translations cache
        t) bin/magento cache:clean translate
        ;;
        # magento setup upgrade
        u) bin/magento setup:upgrade
        ;;
    esac
done

printf "\nhelping process took $SECONDS seconds\n\n";

osascript -e 'display notification "May the VOLLKORN PASTA be always with you!" with title "Lord Vollkorn says: FERTIG in '$SECONDS' seconds" sound name "Glass"';

if [ -f bin/magento ]; then
bin/magento maintenance:disable;
fi
