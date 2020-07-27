# Apricot Framework
Apricot is a PHP mini-framework for quickly creating simple applications.

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

<br>

##### Use as a library

Also you can use Apricot as a library as follows:

```
composer require y2sunlight/apricot
```

## Quick Start

After creating a new Apricot project, you can try it out right away.

Start PHP's built-in web server in your project folder.

```
php -S localhost:8888
```

And access the following URL.

* http://localhost:8888/public/

Your Apricot project "login page" will appear. Then log in. The default account id is `root`, no password is set.

## Documentation

_Currently under construction_

## License

The Apricot framework is licensed under the MIT license. See [License File](LICENSE) for more information.
