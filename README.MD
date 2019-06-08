<p align="center">
<a href="https://travis-ci.com/viloveul/middleware">
<img src="https://travis-ci.com/viloveul/middleware.svg" alt="Build Status">
</a>
<a href="https://packagist.org/packages/viloveul/middleware">
<img src="https://poser.pugx.org/viloveul/middleware/d/total.svg" alt="Total Downloads">
</a>
<a href="https://packagist.org/packages/viloveul/middleware">
<img src="https://poser.pugx.org/viloveul/middleware/v/stable.svg" alt="Latest Stable Version">
</a>
</p>

# Installation

make sure your php version > 7.0

```bash
composer require viloveul/middleware
```

## HOW

```php
require __DIR__ . '/vendor/autoload.php';

$collection = new Viloveul\Middleware\Collection();

$controller = function () {
	// return Psr\Http\Message\ResponseInterface
};

$collection->add('new object from Psr\Http\Server\MiddlewareInterface');
$collection->add('new object of Closure');
$collection->add(function (Psr\Http\Message\ServerRequestInterface $request, Psr\Http\Server\RequestHandlerInterface $next) : Psr\Http\Message\ResponseInterface {
		// do something
		return $next->handle($request);
	}
);

$stack = new Viloveul\Middleware\Stack($controller, $collection);

$response = $stack->handle("object from Psr\Http\Message\ServerRequestInterface");

var_dump($response);

```
