## herokuにphpのプロジェクトをデプロイする

* composer.json
* package.json
* bower.json

これらをサポートするPHPのbuildpackがあった。

```
heroku config:set BUILDPACK_URL=https://github.com/CHH/heroku-buildpack-php
```

## composer.json

composer.jsonが置いてあると自動的に読んでくれるらしい

```composer.json
  "extra": {
    "heroku": {
      "document-root": "htdocs",
      "index-document": "index.php"
    }
  }
```

こんな感じで書いておくとhtdocs/index.phpを実行してくれる。

## slim

普通に使える。

```composer.json
  "require": {
    "slim/slim": "2.*",
  },
```

```htdocs/index.php
define('ROOT_DIR', dirname(__DIR__));

require ROOT_DIR.'/vendor/composer/autoload.php';
```

## smarty

このbuildpackにはsvnが入っていないので、gitのリポジトリを使う。

https://github.com/noiselabs/smarty

```composer.json
  "require": {
    "playmedia/smarty": "3.*",
  },
```

アプリケーションのルートディレクトリ以下のtmpにしか書き込み権限が無いらしいので、テンプレートのコンパイル結果はここに生成するようにする。

## package.json

npmではbowerだけ入ればとりあえず十分。

```package.json
  "dependencies": {
    "bower": "~1.3.2"
  },
  "scripts": {
    "postinstall": "./node_modules/bower/bin/bower install"
  }
```

これでいける。`devDependencies`ではなく`dependencies`にしないとherokuの環境でインストールされない。

## bower

`bower install`はデフォルトで`./bower_components`に入れるので、bower.jsonの他に.bowerrcを置いてインストールするディレクトリを変えてあげる。

```.bowerrc
{
  "directory": "htdocs/public/bower_components"
}
```

<ins>結局この方法は使わず htdocs/public/bower_components/bootstrap/dist から bower_components/bootstrap/dist へのシンボリックリンクを置くことにした。</ins>

## mysql

以下のコマンドを打つとherokuのアドオンとしてMySQLが使えるようになる

```
heroku addons:add cleardb
```

（これをするためにクレカ入力する必要あり）

configでMySQLの接続情報が取得できる。

```
heroku config | grep CLEARDB_DATABASE_URL
CLEARDB_DATABASE_URL: mysql://b1****:11****@us-cdbr-east-05.cleardb.net/heroku_2a****?reconnect=true
```


