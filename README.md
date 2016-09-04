[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.txt)

# Intlless plugin for CakePHP

Intlless plugin is a plugin for CakePHP 3.x, which allows your application to work *relatively* well without intl extension.

Read this in other languages: **English**, [日本語](README.ja.md)

## Installing CakePHP3

If you don't have intl installed, you might have trouble installing CakePHP3 itself.
You can install it with zip file, or with [composer](http://getcomposer.org) by changing configuration.

### Installing with zip file

Download a [release of CakePHP](https://github.com/cakephp/cakephp/releases) (cakephp-3-x-y.zip), and extract it.
Set suitable permissions on your **logs** directory, **tmp** directory and its subdirectories.

### Installing with composer

Execute the following command to pretend you have intl extension.

```
composer config --global platform.ext-intl 0.0.0
```

After that, you can execute `create-project`.

```
composer create-project --prefer-dist cakephp/app my_app_name
```
----

## Installing Intlless plugin

After installing CakePHP3, let's install Intlless plugin.

### Installing with zip file

Download a [release of Intlless plugin](https://github.com/chinpei215/cakephp-intlless/releases) (Source code).
After extracting it, put it into your **plugins** directory, as "**Intlless**".

### Installing with git

If you want to install with [git](https://git-scm.com/), execute the following command in your **plugins** directory.

```
git clone https://github.com/chinpei215/cakephp-intlless.git Intlless
```

### Installing with composer

Execute the following command if you have not done it yet.

```
composer config --global platform.ext-intl 0.0.0
```

After that, you can install the plugin by the following command.

```
composer require --prefer-dist chinpei215/cakephp-intlless
```

----

## Setting up Intlless plugin

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
and if you have installed it with zip, it is necessary to use the  autoloading feature of CakePHP.

Even if you have installed it with composer, make sure to set the `bootstrap` option to true.

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

`Cake\I18n\Time` will be an alias of `Intlless\Time`.
`Intlless\Time` is a sub-class of `Cake\Chronos\MutableDateTime` contained in [Chronos](http://book.cakephp.org/3.0/ja/chronos.html), with different constructor.
So you cannot call any methods not defined in the parent class, such as `i18nFormat()`, `timeAgoInWords()`, `nice()` and so on.

```php
use Cake\I18n\Time;

$time = new Time('-12 hour');

echo $time->isYesterday(); // Works

echo $time->timeAgoInWords(); // Throws a fatal error
```

The same can be said about `Time` helper. In addition, they don't support any localization features.

`Cake\I18n\FrozenTime` will be an alias of `Intlless\FrozenTime`.
`Intlless\FrozenTime` is a sub-class of `Cake\Chronos\Chronos` with different constructor.
So you cannot call any methods not defined in the parent class as well.

`Cake\I18n\Date` and `Cake\I18n\FrozenDate` will be an alias of `Cake\Chronos\MutableDate` and `Cake\Chronos\Date`, respectively.

Note that, CakePHP earlier than version 3.2, `Cake\Chronos\MutableTime` will be an alias of [Carbon](http://carbon.nesbot.com/) instead.
`Cake\I18n\FrozenTime` will be undeclared.

### Limitation of number functions

`Cake\I18n\Number` will be an alias of `Intlless\Number`.
`Intlless\Number` is a small class that provides the following methods *only*.

- `precision()`
- `toReadableSize()`
- `toPercentage()`
- `format()`
- `formatDelta()` (added in 0.2.0)

You cannot call any other methods not listed in the above.

```php
use Cake\I18n\Number;

echo Number::precision(1.2345, 3); // Prints 1.234

echo Number::currency(1000); // Throws a fatal error
```

The same can be said about `Number` helper. In addition, they don't support any localization features.

### Other limitations

- You cannot use any other `Cake\I18n`-namespaced classes.
- You cannot use `Cake\ORM\Behavior\TranslateBehavior` class.
- You cannot use any functions using intl extension under the hood, such as `Cake\Utility\Text::transliterate()`.
