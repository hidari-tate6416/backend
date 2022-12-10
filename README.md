# insider-game_backend
Backend repository, for tate_app

# laravelサイト
http://localhost:8000/

# papMyAdmin
http://localhost:3000/

# 初回起動
$ make backend-build - 以下３コマンドを実行
$ docker-compose build
$ docker-compose up -d
$ docker ps - 3コンテナが起動されているか確認

# laravel導入
$ docker exec -it tate-app bash
$ composer create-project "laravel/laravel=~8.0" --prefer-dist backend

# DB接続
html/backend/.envのBD接続内容を書き換える
***
DB_CONNECTION=mysql
DB_HOST=tate-db
DB_PORT=3306
DB_DATABASE=laraveldb
DB_USERNAME=dbuser
DB_PASSWORD=dbpass
***
$ cd backend
$ php artisan migrate

# appに入る
$ docker exec -it tate-app bash

# dbに入る
$ docker exec -it tate-db bash
$ mysql -uroot -p (パス: ****)
$ mysql -u root -p
> CREATE USER 'dbuser'@'192.168.240.3' IDENTIFIED BY 'dbpass';
> GRANT ALL ON *.* TO 'dbuser'@'192.168.240.3';
> FLUSH PRIVILEGES;

mysql> show databases; - DBの全体を見る
mysql> show tables; - テーブルの全体を見る
