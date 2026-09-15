# CakePHP 3.x Docker 環境

PHP 7.4 (Apache + mod_php) + MySQL 5.7 の開発環境です。

## 構成

| サービス | 内容 | ポート（既定 / 現在の `.env`） |
|----------|------|--------|
| `app` | PHP 7.4 / Apache（intl, pdo_mysql, mbstring, zip, composer 同梱） | 8080 / **http://localhost:8081** |
| `db`  | MySQL 5.7（utf8mb4） | 3306 / **localhost:3307** |
| `adminer` | DB 管理画面（Adminer 4.8.1） | 8082 / **http://localhost:8082** |

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

#### 2-1. Composer の事前設定（Composer 2.9 では必須）

CakePHP 3.x は EOL（2023年サポート終了）で既知の脆弱性 advisory が残っているため、
Composer 2.9 の「脆弱性ブロック」に引っかかって**そのままでは install できません**。
また Composer 2.2 以降は、インストール時にコードを実行するプラグインを明示許可する必要があります。

```bash
docker compose exec app bash -lc "
  export COMPOSER_ALLOW_SUPERUSER=1
  composer config --global policy.advisories.block false
  composer config --global --no-plugins allow-plugins.cakephp/plugin-installer true
  composer config --global --no-plugins allow-plugins.dealerdirect/phpcodesniffer-composer-installer true
"
```

| 設定 | 意味 |
|------|------|
| `COMPOSER_ALLOW_SUPERUSER=1` | root 実行時の警告を抑止（コンテナ内は root のため） |
| `policy.advisories.block false` | 脆弱性 advisory があるパッケージのインストール拒否を解除 |
| `allow-plugins.cakephp/plugin-installer` | CakePHP プラグインの配置先を登録するプラグインを許可 |
| `allow-plugins.dealerdirect/...` | コード規約チェッカ（PHP_CodeSniffer）登録プラグインを許可 |

> ⚠️ 新規開発なら CakePHP **4.x / 5.x** を推奨します。上記は「3.x をあえて使う」ための回避策です。

#### 2-2. アプリ生成

```bash
docker compose exec app bash -lc \
  "COMPOSER_ALLOW_SUPERUSER=1 composer create-project --prefer-dist --no-interaction 'cakephp/app:^3.10' /tmp/app \
   && cp -a /tmp/app/. /var/www/html/ \
   && rm -f /var/www/html/.gitkeep \
   && rm -rf /tmp/app \
   && chown -R www-data:www-data /var/www/html/tmp /var/www/html/logs"
```

| コマンド | 意味 |
|----------|------|
| `docker compose exec app` | 起動中の `app` コンテナ内でコマンドを実行（`run` と違い新規コンテナを作らない） |
| `bash -lc "…"` | ログインシェルで `"…"` を実行。`&&` で複数コマンドを繋ぐため |
| `composer create-project --prefer-dist` | パッケージを zip 配布版で取得してアプリ雛形を生成（`--prefer-source` より高速） |
| `cp -a /tmp/app/. …` | `-a` は権限・タイムスタンプを保持した再帰コピー。末尾 `/.` で隠しファイル（`.htaccess` 等）も含めて中身だけコピー |
| `chown -R www-data:www-data tmp logs` | Apache 実行ユーザがキャッシュ／ログを書けるように所有者変更 |

> 一度 `/tmp/app` に作ってからコピーするのは、`create-project` が**空でないディレクトリを拒否する**ためです。
> `./src` はバインドマウントで既に存在しているので直接は生成できません。

> CI など TTY の無い環境から実行する場合は `docker compose exec -T app …` と `-T`（TTY を割り当てない）を付けてください。

> 生成後、`./src` にCakePHPの一式（`webroot/`, `src/`, `config/` など）が展開されます。

### 3. データベース接続の設定 → **追加作業は不要**

このコンポーズは `DATABASE_URL` 環境変数を渡しています。
CakePHP 3.10 のスケルトンは DB 設定を `src/config/app.php` ではなく
**`src/config/app_local.php`**（Git 管理外・生成時に自動作成）に持ち、
そこに最初から次の行が入っているため、そのまま接続できます。

```php
// src/config/app_local.php
'Datasources' => [
    'default' => [
        // …
        'url' => env('DATABASE_URL', null),   // ← docker-compose の環境変数を読む
    ],
],
```

`url` が指定されている場合、CakePHP はそれを解析して `host` / `username` などを**上書き**します。
環境変数を使わず直書きしたい場合は `app_local.php` を次のように編集します。

```php
'host' => 'db',          // サービス名がホスト名になります
'username' => 'cake',
'password' => 'cakepass',
'database' => 'cake_app',
```

### 4. 動作確認

ブラウザで http://localhost:8081 （`.env` の `APP_PORT`）を開くと CakePHP のウェルカムページが表示されます。
（拡張の状態や DB 接続が緑のチェックになっていれば成功です）

CLI から確認する場合:

```bash
# ページを取得して DB 接続の判定文だけ抜き出す（-s は進捗表示を出さない）
curl -s http://localhost:8081/ | grep -o "CakePHP is able to connect to the database"

# CakePHP CLI が動くか確認
docker compose exec app bin/cake version
```

## DB の中身を見る（Adminer）

http://localhost:8082 （`.env` の `ADMINER_PORT`）を開いてログインします。

| 項目 | 値 |
|------|-----|
| データベース種類 | MySQL |
| サーバ | `db` ← **`localhost` ではない**。Compose のサービス名がコンテナ間のホスト名になります（初期値として自動入力済み） |
| ユーザ名 | `cake` |
| パスワード | `cakepass` |
| データベース | `cake_app` |

```bash
# Adminer だけ起動 / 停止（サービス名を指定すると app・db は再作成されない）
docker compose up -d adminer
docker compose stop adminer
```

> `webroot/adminer.php` を直接置く方式もありますが、DB 管理画面がアプリと同じ URL 空間に露出し、
> コミットやデプロイに紛れ込む事故が起きやすいため、この構成では**独立コンテナ**にしています。
> CakePHP 側のファイルには一切触れません。

> Adminer 5.x は PHP 8 系前提のため、この環境では 4.8.1 を使っています。
> `adminer` イメージは arm64 ネイティブ対応なので、MySQL と違い `platform: linux/amd64` の指定は不要です。

## よく使うコマンド

```bash
# 起動 / 停止（-d はバックグラウンド起動、down はコンテナ削除）
docker compose up -d
docker compose down

# app コンテナに入る（対話シェル）
docker compose exec app bash

# bin/cake … CakePHP の CLI ツール
docker compose exec app bin/cake migrations create CreateArticles  # マイグレーション雛形作成
docker compose exec app bin/cake migrations migrate                # 未適用のマイグレーションを実行
docker compose exec app bin/cake migrations status                 # 適用状況を一覧表示
docker compose exec app bin/cake bake all Articles                 # テーブルから Model/Controller/View を自動生成

# MySQL に接続（-u ユーザ名 / -p パスワード、-p とパスワードの間にスペースを入れない）
docker compose exec db mysql -ucake -pcakepass cake_app

# ログ確認（-f は tail -f 相当で追従表示、Ctrl+C で終了）
docker compose logs -f app

# Composer で依存を追加（コンテナ内で実行すること。ホストの PHP バージョン差異を避けるため）
docker compose exec app composer require <package>
```

## 注意点

- **MySQL 5.7 は arm64（Apple Silicon）向けイメージが無い**ため、`docker-compose.yml` で
  `platform: linux/amd64` を指定してエミュレーション起動しています。動作は問題ありませんが、
  ネイティブより若干遅くなります。ネイティブ動作を優先する場合は MariaDB 10.x への変更を検討してください。
- DB のデータは名前付きボリューム `db_data` に永続化されます。完全に初期化したい場合は
  `docker compose down -v` を実行してください。
