
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
