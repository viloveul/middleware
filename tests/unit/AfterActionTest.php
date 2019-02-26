<?php 

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Http\Message\ResponseInterface;
use Zend\Diactoros\ServerRequestFactory;
use Zend\Diactoros\ServerRequest;
use Zend\Diactoros\ResponseFactory;
use ViloveulMiddlewareSample;

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
        $middlewares = [
            function (ServerRequestInterface $request, RequestHandlerInterface $next) : ResponseInterface {
                $response = $next($request);
                return $response->withStatus(404);
            }
        ];
        $stack = new Viloveul\Middleware\Stack($controller, $middlewares);
        $response = $stack->handle(ServerRequestFactory::fromGlobals());
        $this->tester->assertInstanceOf(ResponseInterface::class, $response);
        $this->tester->assertEquals(404, $response->getStatusCode());
    }

    public function testObjectMiddleware()
    {
        $controller = function(ServerRequestInterface $request) {
            return ResponseFactory::createResponse(200);
        };
        $middlewares = [
            new ViloveulMiddlewareSample\AfterAction()
        ];
        $stack = new Viloveul\Middleware\Stack($controller, $middlewares);
        $response = $stack->handle(ServerRequestFactory::fromGlobals());
        $this->tester->assertInstanceOf(ResponseInterface::class, $response);
        $this->tester->assertEquals(404, $response->getStatusCode());
    }
}