<p align="center"><a href="#" target="_blank"><img src="https://raw.githubusercontent.com/minhthienhuynh/laravel-chat/chat-app/resources/assets/images/auth-img.png" width="400" alt="Laravel Chat Logo"><br>( ﾉ ﾟｰﾟ)ﾉ <b>Laravel Chat</b> ＼(ﾟｰﾟ＼)</a></p>

## About Laravel Chat

Laravel Chat is a web chat application based on Laravel framework. Laravel Chat uses great technologies from open sources, such as:

- [Laravel Framework](https://laravel.com/docs/master).
- [Laravel Jetstream](https://jetstream.laravel.com/3.x/introduction.html).
- [Laravel Livewire](https://laravel-livewire.com/).
- [Laravel WebSockets 🛰](https://beyondco.de/docs/laravel-websockets/getting-started/introduction).
- [Pusher Channels PHP SDK](https://github.com/pusher/pusher-http-php#pusher-channels-http-php-library).
- [Pusher Channels Javascript Client](https://pusher.com/docs/channels/getting_started/javascript/).
- [Laravel Echo](https://github.com/laravel/echo#introduction).

### Setup

```shell
cp .env.example .env
```

###### Setup .env

```dotenv
DB_CONNECTION=pgsql
DB_HOST=pgsql
DB_PORT=5432
DB_DATABASE=laravel
DB_USERNAME=sail
DB_PASSWORD=password
```

```shell
docker-compose up -d --build
```

```shell
docker exec laravel-chat-laravel.test-1 composer install
docker exec laravel-chat-laravel.test-1 php artisan key:generate
docker exec laravel-chat-laravel.test-1 php artisan migrate
```

```shell
docker exec laravel-chat-laravel.test-1 npm i
docker exec laravel-chat-laravel.test-1 npm run build
```

#### Setup Laravel WebSockets

###### Setup .env

```dotenv
PUSHER_APP_ID=123
PUSHER_APP_KEY=abc
PUSHER_APP_SECRET=xyz
PUSHER_HOST=127.0.0.1
PUSHER_PORT=6001
PUSHER_SCHEME=http
PUSHER_APP_CLUSTER=mt1
```

##### GOTO [Laravel Chat](http://localhost)

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
