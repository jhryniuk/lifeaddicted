#!/bin/bash

cd /var/www

npm install -g @angular/cli
#
#ng new lifeaddicted --skipTests=true --directory=./ --style=scss --routing

npm update
npm audit fix --force
npm install
chmod 777 ./
npm audit fix

#npm run-script start
ng serve --host 0.0.0.0

#npm run-script build
#chmod 777 -R dist

#echo "Cleaning project"
#rm -rf node_modules
