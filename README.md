# insider-game_backend
Backend repository, for insider_game

# laravelサイト
http://localhost:8000/

# papMyAdmin
http://localhost:3000/

# 初回起動
$ make insgm-build - 以下３コマンドを実行
$ docker-compose build
$ docker-compose up -d
$ docker ps - 3コンテナが起動されているか確認

# laravel導入
$ docker exec -it insgm-app bash
$ composer create-project "laravel/laravel=~8.0" --prefer-dist insgm

# DB接続
$ cd insgm
$ php artisan migrate

# appに入る
$ docker exec -it insgm-app bash

# dbに入る
$ docker exec -it insgm-db bash
$ mysql -uroot -p (パス: ****)

mysql> show databases; - DBの全体を見る
mysql> show tables; - テーブルの全体を見る
