# Apricot Framework
Apricot is a PHP mini-framework for quickly creating simple applications.

## Installation

We recommend using Composer to create a new Apricot project as follows:

```
composer create-project y2sunlight/apricot your-project --dev
```

Alternatively, you can create it manually as follows:

```
git clone https://github.com/y2sunlight/apricot your-project
cd your-project
composer install --dev
```

Then please copy `.env.sample` to `.env`.

<br>

##### Use as a library

Of course, you can also use Apricot as a library as follows:

```
composer require y2sunlight/apricot
```

## Quick Start

After creating a new Apricot project, you can try it out right away.

Start PHP's Built-in web server in your project folder.

```
php -S localhost:8888
```

Please access the following URL in your browser.

* http://localhost:8888/public/

The Apricot login page will appear. Please log in. Initial account is `root`, no password.

## Documentation

_Currently under construction_

## License

The Apricot Framework is licensed under the MIT license. See [License File](LICENSE) for more information.
