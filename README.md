# これは何ですか？

Laravel のトレーニング用ボイラープレートです。実際の開発にありそうな設定等を用意してあり、実務に近い開発を学習するための最初のコードを提供します。

- https://laravel.com/docs/10.x/installation#getting-started-on-macos で使われる https://laravel.build/example-app の内容を調整して作成しています。
- formatter、lint 等の設定がなされており、GitHub Actions で CI が動作します。
- フロントエンド開発の環境を追加しています。

## ブランチについて

開発用のリポジトリではないので、ブランチ管理が少し独特です。トレーニングする際に促されるので、指定のブランチから学習を開始してください。

### 学習用ブランチ

以下は各種バージョンに対応した学習用ブランチです。学習するための最低限の実装が入っています。

- https://github.com/CircleAround/laravel-boilerplate/tree/base-php8-laravel9-node18-vue3

### バージョンブランチ

以下は各種バージョンの基本ブランチです。基本的に環境構築のみが行われていて、実装は入っていません

- https://github.com/CircleAround/laravel-boilerplate/tree/version-php8-laravel9-node18-vue3

# 使い方

## 準備

ご自身のマシンに以下の環境が整っている前提ですので、インストールして整えてください。

- Docker 環境
- VSCode

## コードの取得

このリポジトリを直接変更することは禁じられています。以下のどちらかのような方法で、ご自身のリポジトリに学習用ブランチの内容を移植して使ってください。

- `git clone` した後、 `git switch` 等で利用したいブランチに移動した上で `.git` ディレクトリを削除して Git の管理から外します。その後改めてご自身のリポジトリを作成して `git push` してください。
- GitHub の操作に明るい人であれば、Template 機能を使って新たなリポジトリを作成できるはずです。 `git clone` して開発を開始できます。

## 環境変数 .env の準備

環境変数は `.env` ファイルに書きます。最初はファイルが存在しないので `.env.example` の内容をコピーして利用すると良いでしょう。

```
cp .env.example .env
```

## 起動

### 1. composer install
必要な外部モジュールを事前にインストールするために、以下のコマンドをプロジェクトのルートディレクトリで行います。

```
docker run --rm -v "$(pwd)":/opt -w /opt laravelsail/php81-composer:latest bash -c "composer install"
```

この結果、 vendor ディレクトリが作成されて、中にディレクトリが多数できれば成功です。

### 2. VSCode の Dev Containerで開く

VSCode の Dev Container 機能が有効になっています。プロジェクトを VSCode で開くと Dev Container で再度開く旨が通知されるので、OK してください。初回は少し時間がかかるかもしれませんが、2度目以降は早く起動するようになるはずです。

### 3. DBの初期化

VSCodeのターミナルを新規に立ち上げて以下のコマンドを入力すると、DBを初期化することができます。

```
sail@3d84e5412bb8:/var/www/html$ php artisan migrate:fresh --seed
```

この時点でシステムは稼働していて、ソースコードを変更するとその変更がシステムに反映される想定です。 `.env.example` の内容に従っていれば、以下のURLが稼働しています。

- http://localhost:3000 サーバーサイドのシステム（通常のWebアクセスおよびAPI提供）
- http://localhost:8080 フロントエンドのシステム（Vue3開発用）

## 明示的に終了
VSCodeを閉じるとDockerの環境も終了するはずですが、もしも終了していない様子であれば、ホスト側のターミナルから以下のコマンドを使いましょう。

```
$ docker-compose down
```

## 学習を開始するにあたって

### ログインユーザーの確認
ログインユーザーは大抵のシステム開発同様にSeedで作成しています。
https://github.com/CircleAround/laravel-boilerplate/blob/base-php8-laravel9-node18-vue3/database/seeders/UserSeeder.php

以下のような内容になっています。最初から実装されているユーザー管理画面に入れるのはroleが1に設定されているadminだけなので、最初の動作確認にこのユーザーを利用すると良いでしょう。

```php
\App\Models\User::factory()->create([
    'name' => 'admin',
    'email' => 'admin@example.com',
    'password' => bcrypt('password'),
    'role' => 1,
]);

\App\Models\User::factory()->create([
    'name' => 'user1',
    'email' => 'user1@example.com',
    'password' => bcrypt('password'),
]);

\App\Models\User::factory()->create([
    'name' => 'user2',
    'email' => 'user2@example.com',
    'password' => bcrypt('password'),
]);
```

### 既存コードの確認
実際に開発を始める前に、既に実装されているユーザー管理（ `/admin/users` ）のコードを見ておくと、スムーズに進められるでしょう。特に以下の内容は役に立つはずです。

#### Admin/UserController
https://github.com/CircleAround/laravel-boilerplate/blob/base-php8-laravel9-node18-vue3/app/Http/Controllers/Admin/UserController.php

#### routes/web.php
https://github.com/CircleAround/laravel-boilerplate/blob/d4f58da587166a22ec06b9f5c814c7247780097b/routes/web.php#L30-L35

### ログについて

### ログの出力場所や確認方法
システムのアクセスログやSQL発行ログは `storage/logs/laravel.log` に出力されます。開発時にはログを見る機会が多いので、以下のコマンドを実行して開きっぱなしのターミナルを準備しておくとエラー対応などがしやすいでしょう（`tail` コマンドに `-f` オプションをつけておくと、テキストに何か書き込まれると自動的に追記してくれます）。

```
sail@3d84e5412bb8:/var/www/html$ tail -f storage/logs/laravel.log
```

### Laravel内で自分でログを出す方法

以下のように `Log` を利用して自分でログ出力をすることができます。デバッグ時には動作中の値が見たいと思うので参考にしてください。

```
use Illuminate\Support\Facades\Log;

// 省略

Log::debug("### UserController#index ###"); // この内容は `storage/logs/laravel.log` のログに出ます。
```

