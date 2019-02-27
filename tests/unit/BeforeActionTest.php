<?php 

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Http\Message\ResponseInterface;
use Zend\Diactoros\ServerRequestFactory;
use Zend\Diactoros\ServerRequest;
use Zend\Diactoros\ResponseFactory;
use ViloveulMiddlewareSample;

class BeforeActionTest extends \Codeception\Test\Unit
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
            if ($request->getUri()->getPath() === '/foo') {
                return ResponseFactory::createResponse(500);
            } else {
                return ResponseFactory::createResponse(200);
            }
        };
        $collection = new Viloveul\Middleware\Collection();
        $collection->add(function (ServerRequestInterface $request, RequestHandlerInterface $next) : ResponseInterface {
            // overwrite request
            $request = new ServerRequest([], [], '/foo');
            // so action will retrieve new request
            return $next($request);
        });
        $stack = new Viloveul\Middleware\Stack($controller, $collection);
        $response = $stack->handle(ServerRequestFactory::fromGlobals());
        $this->tester->assertInstanceOf(ResponseInterface::class, $response);
        $this->tester->assertEquals(500, $response->getStatusCode());
    }

    public function testObjectMiddleware()
    {
        $controller = function(ServerRequestInterface $request) {
            if ($request->getUri()->getPath() === '/bar') {
                return ResponseFactory::createResponse(500);
            } else {
                return ResponseFactory::createResponse(200);
            }
        };
        $collection = new Viloveul\Middleware\Collection();
        $collection->add(new ViloveulMiddlewareSample\BeforeAction());
        $stack = new Viloveul\Middleware\Stack($controller, $collection);
        $response = $stack->handle(ServerRequestFactory::fromGlobals());
        $this->tester->assertInstanceOf(ResponseInterface::class, $response);
        $this->tester->assertEquals(500, $response->getStatusCode());
    }
}