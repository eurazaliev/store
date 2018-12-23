#git clone http://github.com/eurazaliev/store
#build application
composer install
#install assets (css & js)
yarn add sass-loader node-sass --dev
yarn run encore dev --watch
yarn add jquery --dev
#initialize mariadb DB structure
./update_schema.sh
#load fixtures
./fixtures.sh
#
echo "ready to dockerize app"