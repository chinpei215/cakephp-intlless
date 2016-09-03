[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.txt)

# Intlless plugin for CakePHP

Intlless プラグインは intl 拡張モジュールなしでアプリケーションを*それなりに*動作させるための CakePHP 3.x 用のプラグインです。

他の言語で読む: [English](README.md), **日本語**

## CakePHP3 のインストール

もしも intl 拡張モジュールをインストールできていない場合、 CakePHP3 自体のインストールができなくて困っているかもしれません。
zip からインストールする方法と、設定を変更して [composer](http://getcomposer.org) からインストールする方法があります。

### zip ファイルでのインストール

任意の [CakePHP のリリース](https://github.com/cakephp/cakephp/releases) (cakephp-3-x-y.zip) をダウンロードして解凍してください。
設置後は、tmp とそのサブディレクトリ、および logs ディレクトリの [パーミションを適切な値に設定](http://book.cakephp.org/3.0/ja/installation.html#id7) してください。

### composer でのインストール

以下のコマンドを実行して ext-intl が入っていることにしてしまいます。

```
composer config --global platform.ext-intl 0.0.0
```

このコマンドを実行した後は、 create-project を実行することができるようになります。

```
composer create-project --prefer-dist cakephp/app my_app_name
```
----

## Intlless プラグインのインストール

CakePHP3 をインストールしたら、次に Intlless プラグインをインストールします。

### zip ファイルでのインストール

任意の [Intlless プラグインのリリース](https://github.com/chinpei215/cakephp-intlless/releases) (Source code) をダウンロードしてください。
解凍後、 **Intlless** という名前での **plugins** ディレクトリに設置してください。

### git でのインストール

[git](https://git-scm.com/) でインストールを行う場合、 **plugins** ディレクトリ内で以下のコマンドを実行してください。

```
git clone https://github.com/chinpei215/cakephp-intlless.git Intlless
```

### composer でのインストール

まだ実行していなければ、以下のコマンドを実行してください。

```
composer config --global platform.ext-intl 0.0.0
```

実行後、以下のコマンドでインストールを行ってください。

```
composer require --prefer-dist chinpei215/cakephp-intlless
```

----

## Intlless プラグインのセットアップ

プラグインの設置が終わったら、 **config/bootstrap.php** で読み込みますが、なるべくファイルの前の方で読み込むことが望ましいです。
なぜなら、まだ `Cake\I18n` 名前空間のクラスが最初に呼び出されるよりも前に、これらを置き換えなければならないからです。通常は **config/app.php** を読み込んだ直後が最適です。

```php
try {
    Configure::config('default', new PhpConfig());
    Configure::load('app', 'default', false);
} catch (\Exception $e) {
    exit($e->getMessage() . "\n");
}

//Configure::load('app_local', 'default');

// この辺りで呼び出すのが最適です
Plugin::load('Intlless', ['bootstrap' => true, 'autoload' => true]);
```

上記の例で `bootstrap` オプションと `autoload` オプションにそれぞれ真を渡していることに注意してください。
Intlless プラグインでは `Cake\I18n` 名前空間のクラスを置き換えるための初期処理を実行する必要があり、
また、プラグインを zip からインストールした場合、CakePHP 自体のプラグイン自動読込機能に頼る必要があります。

もしも、プラグインを composer からインストールした場合であっても `bootstrap` オプションには必ず真を渡してください。

さらに、いくつかの個所を手動で書き換える必要があります。
まず、 **config/bootstrap.php** の中で intl 拡張モジュールの有無をチェックしてエラーを投げている場所を探してコメントアウトしてください。

```php
if (!extension_loaded('intl')) {
    // この命令をコメントアウトしてください
    // trigger_error('You must enable the intl extension to use CakePHP.', E_USER_ERROR);
}
```

もしも、 **config/bootstrap.php** の中に `useLocaleParser()` の呼び出しが含まれていたら、それもコメントアウトしてください。
Intlless プラグインはこの機能をサポートしません。

```php
// これらの命令もコメントアウトしてください
// Type::build('date')->useLocaleParser();
// Type::build('datetime')->useLocaleParser();

// このように書かれている場合は、useLocaleParser() の呼び出しだけをコメントアウトしてください。
Type::build('time')
    ->useImmutable()
    /*->useLocaleParser()*/;
```

次に composer の **vendor/autoload.php** を読み込んでいる場所の*直前*に、**plugins/Intlless/src/functions.php** を読み込む命令を入れてください。 `__()` などのメッセージ関数が intl 拡張モジュールに依存しており、これらも置き換えなければならないからです。

プラグインを composer でインストールした場合は、設置場所が変わりますので、代わりに **vendor/chinpei215/cakephp-intlless/src/functions.php** を読み込んでください。

**vendor/autoload.php** を読み込んでいる位置は、お使いの CakePHP のバージョンによって異なります。

----

### CakePHP &gt;= 3.3

CakePHP 3.3 以上のバージョンでは、以下の三つのファイルにそれぞれ記述されています。

1. **webroot/index.php**
2. **bin/cake.php**
3. **tests/bootstrap.php**

それぞれのファイルに以下の命令を追加してください。

```php
require dirname(__DIR__) . '/plugins/Intlless/src/functions.php';

require dirname(__DIR__) . '/vendor/autoload.php';
```

### CakePHP &lt; 3.3

CakePHP 3.3 未満のバージョンでは、 **config/bootstrap.php** に記述されています。

```php
require ROOT . '/plugins/Intlless/src/functions.php'; // この行を追加してください

require ROOT . DS . 'vendor' . DS . 'autoload.php';
```

----

これで インストールは完了です。 intl 拡張モジュールなしでもアプリケーションが*それなりに*動作するはずです。

## 制限

### メッセージの制限

`__()` をはじめとするメッセージ関数は、複雑な書式を解釈することができません。

```php
echo __('{0}%', 100);  // 100% を表示します

echo __('{0,number,#,###}', 100); // {0,number,#,###} を表示します
```

また、メッセージの地域化には対応していません。

### 日付時刻の制限

`Cake\I18n\Time` をはじめとする日付／時刻のクラスは、 [Chronos](http://book.cakephp.org/3.0/ja/chronos.html) などのエイリアスになります。
`Chronos` では定義されていない `i18nFormat()` 、 `timeAgoInWords()` 、 `nice()` 、およびその他のメソッドは呼び出すことができません。

```php
use Cake\I18n\Time;

$time = new Time('-12 hour');

echo $time->isYesterday(); // 動作します

echo $time->timeAgoInWords(); // 致命的エラーになります
```

これは `Time` ヘルパーからの呼び出しでも同様です。また、日付時刻の書式の地域化には対応していません。

なお、 CakePHP 3.2 未満のバージョンでは `Cake\I18n\Time` は代わりに [Carbon](http://carbon.nesbot.com/) のエイリアスになります。

### 数値の制限

`Cake\I18n\Number` は `Intlless\Number` クラスのエイリアスになります。
`Intlless\Number` クラスは以下のメソッド*のみ*を提供する小さなクラスです。

- `precision()`
- `toReadableSize()`
- `toPercentage()`
- `format()`
- `formatDelta()` (0.2.0 で追加)

上記以外のメソッドを利用することはできません。

```php
use Cake\I18n\Number;

echo Number::precision(1.2345, 3); // 1.234 を出力します

echo Number::currency(1000); // 致命的エラーになります
```

これは `Number` ヘルパーからの呼び出しでも同様です。また、数値の書式の地域化には対応していません。

### その他の制限

- その他の `Cake\I18n` 名前空間のクラスは使用することができません。
- `Cake\Utility\Text::transliterate()` など、 intl 拡張モジュールを直接使うメソッドは使用することができません。
