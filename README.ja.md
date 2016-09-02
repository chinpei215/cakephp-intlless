# Intlless plugin for CakePHP

Intlless プラグインは intl 拡張モジュールなしでアプリケーションを*それなりに*動作させるためのプラグインです。

他の言語で読む: [English](README.md), **Japanese**

## インストール方法

このプラグインをインストールする方法は少し変わっています。

他の CakePHP プラグインと同様に [composer](http://getcomposer.org) を使って、お使いの CakePHP アプリケーションにインストールすることもできますが、
composer を実行する環境に intl 拡張モジュールが読み込まれていない場合、 CakePHP 自体に composer でのインストールを拒絶されてしまいます。

このため、通常は別の方法でインストールすることになります。

----
### Zip ファイルでのインストール
ダウンロードした zip ファイルを解答して、 **Intlless** という名前で plugins ディレクトリに設置してください。

### Git でのインストール
[git](https://git-scm.com/) でインストールを行う場合、 plugins ディレクトリ内で以下のコマンドを実行してください。

```
git clone https://github.com/chinpei215/cakephp-intlless.git Intlless
```
----

プラグインの設置が終わったら、 **config/bootstrap.php** で読み込みますが、これも一般的なプラグインとは異なり、ファイルの前の方で読み込むことが望ましいです。
なぜなら、まだ `Cake\I18n` 名前空間のクラスが最初に呼び出されるよりも前に、これらを上書きしなければならないからです。通常は **config/app.php** を読み込んだ直後が最適です。

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
Intlless プラグインでは `Cake\I18n` 名前空間のクラスを上書きするための初期処理を実行する必要があり、
また、 composer からインストールしていないため、 CakePHP のプラグイン自動読込機能に頼る必要があるのです。

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

次に composer の **vendor/autoload.php** を読み込んでいる場所の**直前**に、 **plugins/Intlless/src/functions.php** を読み込む命令を入れてください。
`__()` などのメッセージ関数が intl 拡張モジュールに依存しており、これらを上書きしなければならないからです。

**vendor/autoload.php** を読み込んでいる位置は、お使いの CakePHP のバージョンによって異なります。

----
### CakePHP >= 3.3

CakePHP 3.3 以上のバージョンでは、以下の三つのファイルにそれぞれ記述されています。

1. **config/index.php**
2. **bin/cake.php**
3. **tests/bootstrap.php**

それぞれのファイルに以下の命令を追加してください。

```php
// この行を追加してください
require dirname(__DIR__) . '/plugins/Intlless/src/functions.php';

require dirname(__DIR__) . '/vendor/autoload.php';
```

### CakePHP &lt; 3.3

CakePHP 3.3 未満のバージョンでは、 **config/bootstra.php** に記述されています。

```php
// この行を追加してください
require ROOT . '/plugins/Intlless/src/functions.php';

require ROOT . DS . 'vendor' . DS . 'autoload.php';
```
----

これで インストールは完了です。 intl 拡張モジュールなしでもアプリケーションが**それなりに**動作するはずです。

## 制限

### メッセージの制限

`__()` をはじめとするメッセージ関数は、以下のような複雑な書式を解釈することができません。

```php
echo __('{0}%', 100);  // 100% を表示します

echo __('{0,number,#,###}', 100); // {0,number,#,###} を表示します
```

また、メッセージの地域化には対応していません。

### 日付時刻の制限

`Cake\I18n\Time` をはじめとする日付／時刻のクラスは、 `Cake\Chronos\Chronos` などのエイリアスになります。
`Chronos` では定義されていない `i18nFormat()` 、 `timeAgoInWords()` 、 `nice()` 、およびその他のメソッドは呼び出すことができません。
なお、 CakePHP 3.2 未満のバージョンでは `Cake\I18n\Time` は `Carbon\Carbon` のエイリアスになります。

```php
use Cake\I18n\Time;

$time = new Time('-12 hour');

echo $time->isYesterday(); // 動作します

echo $time->timeAgoInWords(); // 致命的エラーになります
```

これは `Time` ヘルパーからの呼び出しでも同様です。
また、日付時刻の書式の地域化には対応していません。

### 数値の制限

`Cake\I18n\Number` は `Intlless\Number` クラスのエイリアスになります。
`Intlless\Number` クラスは以下のメソッド**のみ**を提供する小さなクラスです。

- `precision()`
- `toReadableSize()`
- `toPercentage()`
- `format()`

上記以外のメソッドを利用することはできません。
```php
use Cake\I18n\Number;

echo Number::format(1.2345, 3); // 1.234 を出力します

echo Number::currency(1000); // 致命的エラーになります
```

これは `Number` ヘルパーからの呼び出しでも同様です。
また、数値の書式の地域化には対応していません。

### その他の制限

- その他の `Cake\I18n` 名前空間のクラスは使用することができません。
- `Cake\Utility\Text::transliterate()` など、 intl 拡張モジュールのライブラリを直接使うメソッドは使用することができません。
