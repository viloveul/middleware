# Installation
make sure your php version > 7.0
```bash
composer require viloveul/middleware
```
## HOW
```php
require __DIR__ . '/vendor/autoload.php';

$controller = function () {
	// return Psr\Http\Message\ResponseInterface
};

$middlewares = [
	'new object from Psr\Http\Server\MiddlewareInterface',
	'new object of Closure',
	function (Psr\Http\Message\ServerRequestInterface $request, Psr\Http\Server\RequestHandlerInterface $next) : Psr\Http\Message\ResponseInterface {
		// do something
		return $next->handle($request);
	}
];

$stack = new Viloveul\Middleware\Stack($controller, $middlewares);

$response = $stack->handle("object from Psr\Http\Message\ServerRequestInterface");

var_dump($response);

```
