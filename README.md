This is a open source repository for pointscontrol, witch is hosted in www.pointscontrol.com

PointsControl is a software to manage loyalty miles, it use and cost of generate.

-- With stacks PointsControl use
PointsControl was build to rum in a docker-compose container with PHP using laravel framework, mySQL, javascript and phpmyadmin.
React components will be included soon.

-- How to install
1. Clone this repository
2. change the file .env_exemple to .env and define the user and passwords required
2. run "docker-compose up -d" (to create the containers and active it)
3. run "docker-compose exec app bash" (to access the app container)
4. run "php artisan migrate" (this will create database)
5. run "php artisan key:generate" (to generate the laravel key on .env file)
6. Done!

--troubeshooting
- After run install steps, if you recieve error 500 on http access, check the permission for www-data user, in "storage bootstrap/cache" and "bootstrap/cache" inside of app container

Note: If you will use in production, have to change lines 29 and 30 on app.php.