<?php

declare(strict_types=1);

namespace Drupal\Tests\dictionary_test\Functional;

use Drupal\Core\Url;
use Drupal\Tests\rest\Functional\BasicAuthResourceTestTrait;
use Drupal\Tests\rest\Functional\ResourceTestBase;
use Symfony\Component\HttpFoundation\Response;

class DictionariesResourceTest extends ResourceTestBase
{
    use BasicAuthResourceTestTrait;
	use DictionaryEntityTrait;

    private const URL = '/dictionary_rest_api/dictionaries?_format=json';

    protected $defaultTheme = 'stark';
    protected static $auth = 'basic_auth';
    protected static $resourceConfigId = 'dictionary_resource_dictionaries';
    protected static $modules = [
        'basic_auth',
        'dictionary_test',
	    'field'
    ];
	
	protected function setUpAuthorization($method)
	{
		switch ($method) {
			case 'GET':
				$this->grantPermissionsToTestedRole(['restful get dictionary_resource_dictionaries']);
				break;
			default:
				throw new \UnexpectedValueException();
		}
	}

    public function setUp(): void
    {
        parent::setUp();

        $this->provisionResource([static::$format], [static::$auth]);
    }

	public function testGetDictionariesWhenUnauthorized(): void
	{
		$this->initAuthentication();
		$this->setUpAuthorization('GET');

		$url = Url::fromUserInput(self::URL);
		$response = $this->request('GET', $url, []);

		$this->assertSame(Response::HTTP_UNAUTHORIZED, $response->getStatusCode());
		$this->assertEquals(
			json_encode(['message' => 'No authentication credentials provided.']),
			$response->getBody()->getContents()
		);
	}

	public function testGetDictionariesWhenNoPermissions(): void
	{
		$this->initAuthentication();

		$url = Url::fromUserInput(self::URL);
		$request_options = $this->getAuthenticationRequestOptions('GET');
		$response = $this->request('GET', $url, $request_options);

		$this->assertSame(Response::HTTP_FORBIDDEN, $response->getStatusCode());
		$this->assertStringContainsString(
			'restful get dictionary_resource_dictionaries',
			$response->getBody()->getContents()
		);
	}

    public function testGetDictionariesWhenResponseIsEmpty(): void
    {
        $this->initAuthentication();
        $this->setUpAuthorization('GET');

        $url = Url::fromUserInput(self::URL);
        $request_options = $this->getAuthenticationRequestOptions('GET');
        $response = $this->request('GET', $url, $request_options);
	
	    $this->assertSame(Response::HTTP_OK, $response->getStatusCode());
        $this->assertEquals(json_encode(['dictionaries' => []]), $response->getBody()->getContents());
    }

    public function testGetDictionariesWhenResponseIsNotEmpty(): void
    {
        $this->initAuthentication();
        $this->setUpAuthorization('GET');
		
	    $this->loadDefaultData();
		
        $url = Url::fromUserInput(self::URL);
        $request_options = $this->getAuthenticationRequestOptions('GET');
        $response = $this->request('GET', $url, $request_options);
	
	    $this->assertSame(Response::HTTP_OK, $response->getStatusCode());
        $expected = json_encode(['dictionaries' => ['bundle1', 'bundle2', 'bundle3']]);
        $this->assertEquals($expected, $response->getBody()->getContents());
    }
}
