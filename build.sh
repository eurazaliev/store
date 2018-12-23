<<<<<<< HEAD
git clone http://github.com/eurazaliev/store
#edit .env
=======
#git clone http://github.com/eurazaliev/store
>>>>>>> 47e8fac5df544a01135cd5c634fba588fa2690fd
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
<<<<<<< HEAD
echo "ready to dockerize app"
=======
echo "ready to dockerize app"
>>>>>>> 47e8fac5df544a01135cd5c634fba588fa2690fd
