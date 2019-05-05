#!/bin/bash

cd /var/www

#npm install -g @angular/cli
#
#ng new lifeaddicted --skipTests=true --directory=./ --style=scss --routing

npm install
chmod 777 ./
npm audit fix

npm run-script start

#npm run-script build
#chmod 777 -R dist

#echo "Cleaning project"
#rm -rf node_modules
