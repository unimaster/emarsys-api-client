<?php

namespace LinguaLeo\EmarsysApiClient;

use LinguaLeo\EmarsysApiClient\Client;
use LinguaLeo\EmarsysApiClient\Transport\CurlTransport;

class EmarsysTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Client
     */
    private $client;

    protected function setUp()
    {
        if (
            !defined('EMARSYS_API_USERNAME') ||
            !defined('EMARSYS_API_SECRET') ||
            !defined('EMARSYS_API_URL')
        ) {
            $this->markTestSkipped('No Emarsys credentials are specified');
        }

        $httpClient = new CurlTransport();
        $this->client = new Client($httpClient, EMARSYS_API_USERNAME, EMARSYS_API_SECRET, EMARSYS_API_URL);

        $connectionTestResponse = $this->client->getLanguages();

        if (0 !== $connectionTestResponse->getReplyCode()) {
            $this->markTestSkipped('Problem connecting to Emarsys. Check credentials in phpunit.xml.dist.');
        }
    }

    /**
     * @test
     */
    public function itShouldGetAvailableLanguages()
    {
        $response = $this->client->getLanguages();
        $expectation = ['id' => 'en', 'language' => 'english'];

        $this->assertContains($expectation, $response->getData());
    }

    /**
     * @test
     */
    public function itShouldGetAvailableFields()
    {
        $response = $this->client->getFields();
        $expectation = ['id' => 1, 'name' => 'First Name', 'application_type' => 'shorttext'];

        $this->assertContains($expectation, $response->getData());
    }
}
