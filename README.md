# CakePHP 3.x Docker 環境

PHP 7.4 (Apache + mod_php) + MySQL 5.7 の開発環境です。

## 構成

| サービス | 内容 | ポート |
|----------|------|--------|
| `app` | PHP 7.4 / Apache（intl, pdo_mysql, mbstring, zip, composer 同梱） | http://localhost:8080 |
| `db`  | MySQL 5.7（utf8mb4） | localhost:3306 |

- アプリのソースは `./src` に置き、コンテナの `/var/www/html` にマウントされます。
- ドキュメントルートは `/var/www/html/webroot`（CakePHP の作法）です。
- 設定値（ポート・DBパスワード等）は `.env` で変更できます。

## セットアップ手順

### 1. コンテナをビルド・起動

```bash
docker compose up -d --build
```

### 2. CakePHP 3.x アプリを作成

`./src` はまだ空なので、Composer で CakePHP 3.10 系アプリを生成します。

```bash
docker compose exec app bash -lc \
  "composer create-project --prefer-dist 'cakephp/app:^3.10' /tmp/app \
   && cp -a /tmp/app/. /var/www/html/ \
   && rm -f /var/www/html/.gitkeep \
   && rm -rf /tmp/app \
   && chown -R www-data:www-data /var/www/html/tmp /var/www/html/logs"
```

> 生成後、`./src` にCakePHPの一式（`webroot/`, `src/`, `config/` など）が展開されます。

### 3. データベース接続の設定

このコンポーズは `DATABASE_URL` 環境変数を渡しています。CakePHP 側で参照するには
`src/config/app.php` の `Datasources.default` を次のように書き換えるのが簡単です。

```php
'default' => [
    'className' => 'Cake\Database\Connection',
    'driver' => 'Cake\Database\Driver\Mysql',
    'url' => env('DATABASE_URL', null),
],
```

もしくは `app.php` に直接以下を指定しても構いません。

```php
'host' => 'db',          // サービス名がホスト名になります
'username' => 'cake',
'password' => 'cakepass',
'database' => 'cake_app',
```

### 4. 動作確認

ブラウザで http://localhost:8080 を開くと CakePHP のウェルカムページが表示されます。
（拡張の状態や DB 接続が緑のチェックになっていれば成功です）

## よく使うコマンド

```bash
# 起動 / 停止
docker compose up -d
docker compose down

# app コンテナに入る
docker compose exec app bash

# bin/cake（マイグレーション等）
docker compose exec app bin/cake migrations migrate
docker compose exec app bin/cake bake all Articles

# MySQL に接続
docker compose exec db mysql -ucake -pcakepass cake_app

# ログ確認
docker compose logs -f app
```

## 注意点

- **MySQL 5.7 は arm64（Apple Silicon）向けイメージが無い**ため、`docker-compose.yml` で
  `platform: linux/amd64` を指定してエミュレーション起動しています。動作は問題ありませんが、
  ネイティブより若干遅くなります。ネイティブ動作を優先する場合は MariaDB 10.x への変更を検討してください。
- DB のデータは名前付きボリューム `db_data` に永続化されます。完全に初期化したい場合は
  `docker compose down -v` を実行してください。
