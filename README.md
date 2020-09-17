# Apricot Framework
Apricot is a PHP lightweight framework for quickly creating simple web applications.

## Installation

We recommend using Composer to create a new Apricot project as follows:

```
composer create-project y2sunlight/apricot your-project-name --dev
```

Alternatively, you can create it manually as follows:

```
git clone https://github.com/y2sunlight/apricot your-project-name
cd your-project-name
composer install --dev
```

Then copy `.env.sample` to `.env`.

```
cd your-project-name
cp .env.sample .env
```

## Quick Start

After creating a new Apricot project, you can try it out right away.

Start PHP's built-in web server in your project folder.

```
php -S localhost:8888 -t public
```

And access the following URL.

* http://localhost:8888/

Your Apricot project "login page" will appear. Then log in. The default account id is `root`, no password is set.

<br>

## Use as a library

To use Apricot as a library, do the following:

```
composer require y2sunlight/apricot
```

When using it as a library, it's recommended to use the [Apricot skeleton](https://github.com/y2sunlight/apricot-skeleton).


## Documentation

The Apricot documentation can be found on the GitHub Wiki: [Apricot-Document](https://github.com/y2sunlight/apricot/wiki/Apricot-Document)

## License

The Apricot framework is licensed under the MIT license. See [License File](LICENSE) for more information.
