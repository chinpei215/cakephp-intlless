# Intlless plugin for CakePHP

Intlless plugin is a plugin for CakePHP 3.x, which allows your application to work *relatively* well without intl extension.

Read this in other languages: **English**, [日本語](README.ja.md)

## Installation

You might have to install this plugin in a bit strange way.

While you can install this plugin into your CakePHP application using [composer](http://getcomposer.org),
if you don't have intl extension, CakePHP will refuse to be installed using composer.

So normally, you would need to install it in alternative ways.

----
### Installing with Zip file
Extract the zip file you downloaded and put it into your **plugins/** directory, as "**Intlless**".

### Installing with Git
If you want to install with git, execute the following command in your **plugins/** directory.

```
git clone https://github.com/chinpei215/cakephp-intlless.git Intlless
```
----

Once you put this plugin, you need to load it in your **config/bootstrap.php**, but it would be better to do it near the front part of the file as much as possible.
Because it is necessary to replace `Cake\I18n`-namespaced classes before the original classes loaded. Normally, it is best to do it just after loading **config/app.php**.

```php
try {
    Configure::config('default', new PhpConfig());
    Configure::load('app', 'default', false);
} catch (\Exception $e) {
    exit($e->getMessage() . "\n");
}

//Configure::load('app_local', 'default');

// Here is the best place to load
Plugin::load('Intlless', ['bootstrap' => true, 'autoload' => true]);
```
Note that the `boostrap` option and the `autoload` option are set to true in the above example.
Since Intlless plugin needs to execute bootstrapping to replace `Cake\I18n`-namespaced classes,
and you didn't install it using composer, it is necessary to use the plugin autoloading feature of CakePHP.

In addition, you need to modify some code in your application.
First, find a line where an error is thrown if intl extension is not loaded, and comment it out.

```php
if (!extension_loaded('intl')) {
    // Comment out this statement
    // trigger_error('You must enable the intl extension to use CakePHP.', E_USER_ERROR);
}
```

If `useLocaleParser()` call is found in your **config/bootstrap.php**, also comment it out.
Intlless plugin doesn't support the feature.

```php
// Comment them out
// Type::build('date')->useLocaleParser();
// Type::build('datetime')->useLocaleParser();

// Comment out only useLocaleParser(), if the statement is like this
Type::build('time')
    ->useImmutable()
    /*->useLocaleParser()*/;
```

Next, *just before* including **vendor/autoload.php**  of composer, you need to include **plugins/Intlless/src/functions.php**.
Since `__()` or other messaging functions are depending on intl extension, it is also necessary to replace them.

The file is included in different places depending on the version of CakePHP you are using.

----
### CakePHP &gt;= 3.3

CakePHP greater than or equal version 3.3, the file is included in the following three files.

1. **config/index.php**
2. **bin/cake.php**
3. **tests/bootstrap.php**

Add the following statement in the each file.

```php
// Add this statement
require dirname(__DIR__) . '/plugins/Intlless/src/functions.php';

require dirname(__DIR__) . '/vendor/autoload.php';
```

### CakePHP &lt; 3.3

CakePHP earlier than version 3.3, the file is included in your **config/bootstrap.php**.

```php
// Add this statement
require ROOT . '/plugins/Intlless/src/functions.php';

require ROOT . DS . 'vendor' . DS . 'autoload.php';
```
----

Installation is end with this. You will see your application works *relatively* well without intl extension.

## Limitations

### Limitation of messaging functions

`__()` or other messaging functions cannot parse complex message formats.

```php
echo __('{0}%', 100);  // Prints 100%

echo __('{0,number,#,###}', 100); // Prints {0,number,#,###}
```

In addition, they don't support any localization features.

### Limitation of date and time functions

`Cake\I18n\Time` or other date and time classes will be a alias of [Chronos](http://book.cakephp.org/3.0/en/chronos.html) or its siblings.
You cannot call any methods not defined in `Chronos`, such as `i18nFormat()`, `timeAgoInWords()`, `nice()` and so on.

```php
use Cake\I18n\Time;

$time = new Time('-12 hour');

echo $time->isYesterday(); // Works

echo $time->timeAgoInWords(); // Throws a fatal error
```

The same can be said about `Time` helper. In addition, they don't support any localization features.

Note that, CakePHP earlier than version 3.2, `Cake\I18n\Time` will be an alias of [Carbon](http://carbon.nesbot.com/) instead.

### Limitation of number functions

`Cake\I18n\Number` will be an alias of `Intlless\Number`.
`Intlless\Number` is a small class that provides the following methods *only*.

- `precision()`
- `toReadableSize()`
- `toPercentage()`
- `format()`

You cannot call any other method not listed in the above.
```php
use Cake\I18n\Number;

echo Number::precision(1.2345, 3); // Prints 1.234

echo Number::currency(1000); // Throws a fatal error
```

The same can be said about `Number` helper. In addition, they don't support any localization features.

### Other limitations

- You cannot use any other `Cake\I18n`-namespaced claases.
- You cannot use any functions using intl extension under the hood, such as `Cake\Utility\Text::transliterate()`.
