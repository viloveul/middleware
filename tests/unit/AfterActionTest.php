<?php 

use Zend\Diactoros\ServerRequest;
use Zend\Diactoros\ResponseFactory;
use Psr\Http\Message\ResponseInterface;
use Zend\Diactoros\ServerRequestFactory;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class AfterActionTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;
    
    protected function _before()
    {
    }

    protected function _after()
    {
    }

    // tests
    public function testClosureMiddleware()
    {
        $controller = function(ServerRequestInterface $request) {
            return ResponseFactory::createResponse(200);
        };
        $collection = new Viloveul\Middleware\Collection();
        $collection->add(function (ServerRequestInterface $request, RequestHandlerInterface $next) : ResponseInterface {
            $response = $next($request);
            return $response->withStatus(404);
        });
        $stack = new Viloveul\Middleware\Stack($controller, $collection);
        $response = $stack->handle(ServerRequestFactory::fromGlobals());
        $this->tester->assertInstanceOf(ResponseInterface::class, $response);
        $this->tester->assertEquals(404, $response->getStatusCode());
    }

    public function testObjectMiddleware()
    {
        $controller = function(ServerRequestInterface $request) {
            return ResponseFactory::createResponse(200);
        };
        $collection = new Viloveul\Middleware\Collection();
        $collection->add(new ViloveulMiddlewareSample\AfterAction());
        $stack = new Viloveul\Middleware\Stack($controller, $collection);
        $response = $stack->handle(ServerRequestFactory::fromGlobals());
        $this->tester->assertInstanceOf(ResponseInterface::class, $response);
        $this->tester->assertEquals(404, $response->getStatusCode());
    }
}