<?php

declare(strict_types=1);

namespace Drupal\Tests\dictionary_test\Functional;

use Coduo\PHPMatcher\PHPUnit\PHPMatcherAssertions;
use Drupal\Core\Url;
use Drupal\Tests\rest\Functional\BasicAuthResourceTestTrait;
use Drupal\Tests\rest\Functional\ResourceTestBase;
use Symfony\Component\HttpFoundation\Response;

class DictionaryResourceTest extends ResourceTestBase
{
    use BasicAuthResourceTestTrait;
	use DictionaryEntityTrait;
	use PHPMatcherAssertions;

    private const URL = '/dictionary_rest_api/%s?_format=json';

    protected $defaultTheme = 'stark';
    protected static $auth = 'basic_auth';
    protected static $resourceConfigId = 'dictionary_resource_type';
    protected static $modules = [
        'basic_auth',
        'dictionary_test',
    ];
	
	protected function setUpAuthorization($method)
	{
		switch ($method) {
			case 'GET':
				$this->grantPermissionsToTestedRole(['restful get dictionary_resource_type']);
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

		$url = Url::fromUserInput(sprintf(self::URL, 'slo1'));
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

		$url = Url::fromUserInput(sprintf(self::URL, 'slo1'));
		$request_options = $this->getAuthenticationRequestOptions('GET');
		$response = $this->request('GET', $url, $request_options);

		$this->assertSame(Response::HTTP_FORBIDDEN, $response->getStatusCode());
		$this->assertStringContainsString(
			'restful get dictionary_resource_type',
			$response->getBody()->getContents()
		);
	}

    public function testGetDictionaries(): void
    {
        $this->initAuthentication();
        $this->setUpAuthorization('GET');
		
		$this->loadDefaultData();

        $url = Url::fromUserInput(sprintf(self::URL, 'bundle1'));
        $request_options = $this->getAuthenticationRequestOptions('GET');
        $response = $this->request('GET', $url, $request_options);
	
	    $this->assertSame(Response::HTTP_OK, $response->getStatusCode());
		$responseAsArray = (array) json_decode($response->getBody()->getContents(), true);
		
		$this->assertCount(2, $responseAsArray['data']);

		$this->assertSame('bundle1', $responseAsArray['data'][0]['type']);
	    $this->assertSame('słowo 1', $responseAsArray['data'][0]['word']);
	    
	    $this->assertSame('bundle1', $responseAsArray['data'][1]['type']);
	    $this->assertSame('słowo 2', $responseAsArray['data'][1]['word']);
	
	    $this->assertMatchesPattern([
		    'data' => '@array@.repeat(\'{
                "id": "@string@",
                "type": "@string@",
                "title": "@string@",
                "word": "@string@",
                "createdAt": "@integer@"
            }\')'
	    ], $responseAsArray);
    }
}
