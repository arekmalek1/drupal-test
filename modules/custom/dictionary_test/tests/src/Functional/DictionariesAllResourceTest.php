<?php

declare(strict_types=1);

namespace Drupal\Tests\dictionary_test\Functional;

use Coduo\PHPMatcher\PHPUnit\PHPMatcherAssertions;
use Drupal\Core\Url;
use Drupal\Tests\rest\Functional\BasicAuthResourceTestTrait;
use Drupal\Tests\rest\Functional\ResourceTestBase;
use Symfony\Component\HttpFoundation\Response;

class DictionariesAllResourceTest extends ResourceTestBase
{
    use BasicAuthResourceTestTrait;
	use DictionaryEntityTrait;
	use PHPMatcherAssertions;

    private const URL = '/dictionary_rest_api/dictionaries-all?_format=json';

    protected $defaultTheme = 'stark';
    protected static $auth = 'basic_auth';
    protected static $resourceConfigId = 'dictionary_resource';
    protected static $modules = [
        'basic_auth',
        'dictionary_test',
    ];
	
	protected function setUpAuthorization($method)
	{
		switch ($method) {
			case 'GET':
				$this->grantPermissionsToTestedRole(['restful get dictionary_resource']);
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
			'restful get dictionary_resource',
			$response->getBody()->getContents()
		);
	}

    public function testGetAllDictionaries(): void
    {
        $this->initAuthentication();
        $this->setUpAuthorization('GET');

		$this->loadDefaultData();

        $url = Url::fromUserInput(self::URL);
        $request_options = $this->getAuthenticationRequestOptions('GET');
        $response = $this->request('GET', $url, $request_options);

		$responseAsArray = (array) json_decode($response->getBody()->getContents(), true);
		$this->assertCount(3, $responseAsArray);

		$this->assertMatchesPattern($this->expectedResponse(), $responseAsArray);

    }
	
	private function expectedResponse(): array
	{
		return [
			'bundle1' => [
				[
					'id' => '@string@',
					'type' => 'bundle1',
					'title' => '@string@',
					'word' => 'słowo 1',
					'createdAt' => '@integer@',
				],
				[
					'id' => '@string@',
					'type' => 'bundle1',
					'title' => '@string@',
					'word' => 'słowo 2',
					'createdAt' => '@integer@',
				]
			],
			'bundle2' => [
				[
					'id' => '@string@',
					'type' => 'bundle2',
					'title' => '@string@',
					'word' => 'słowo 3',
					'createdAt' => '@integer@',
				],
				[
					'id' => '@string@',
					'type' => 'bundle2',
					'title' => '@string@',
					'word' => 'słowo 4',
					'createdAt' => '@integer@',
				]
			],
			'bundle3' => [
				[
					'id' => '@string@',
					'type' => 'bundle3',
					'title' => '@string@',
					'word' => 'słowo 5',
					'createdAt' => '@integer@',
				],
			]
		];
	}
}
