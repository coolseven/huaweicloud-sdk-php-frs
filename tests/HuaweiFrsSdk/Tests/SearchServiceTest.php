<?php
/**
 * PROJECT: huawei-frs-sdk
 * FILENAME: SearchServiceTest.php
 * HOMEPAGE: https://github.com/coolseven/huaweicloud-sdk-php-frs
 */

namespace HuaweiFrsSdk\Tests;


use HuaweiFrsSdk\Client\Param\AuthInfo;
use HuaweiFrsSdk\Client\FrsClient;
use PHPUnit_Framework_TestCase;

class SearchServiceTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var string
     */
    private $ak;
    /**
     * @var string
     */
    private $sk;
    /**
     * @var string
     */
    private $endpoint;

    /**
     * @var AuthInfo
     */
    private $authInfo;
    /**
     * @var string
     */
    private $projectId;
    /**
     * @var string
     */
    private $faceSetName;
    /**
     * @var string
     */
    private $faceId;

    public function setUp()
    {
        require_once __DIR__.'/../../bootstrap.php';

        $this->ak = getenv('HUAWEI_FRS_AK') ;
        $this->sk = getenv('HUAWEI_FRS_SK') ;
        $this->endpoint = getenv('HUAWEI_FRS_ENDPOINT') ;

        $this->authInfo = new AuthInfo($this->endpoint,$this->ak,$this->sk);

        $this->projectId = getenv('HUAWEI_FRS_PROJECT_ID');
        $this->faceSetName = getenv('HUAWEI_FRS_FACE_SET_NAME');
        $this->faceId = getenv('HUAWEI_FRS_SEARCH_FACE_ID');
    }

    public function testSearchByImageBase64(): void
    {
        $imageBase64 = base64_encode(file_get_contents(__DIR__.'/images/donald_trump.jpeg'));

        $frsClient = new FrsClient($this->authInfo,$this->projectId);

        $response = $frsClient->getSearchService()->searchFaceByBase64($this->faceSetName,$imageBase64,100);

        $this->assertEquals(200,$response->getStatusCode());
    }

    public function testSearchByFaceId(): void
    {
        $frsClient = new FrsClient($this->authInfo,$this->projectId);
        $response = $frsClient->getSearchService()->searchFaceByFaceId($this->faceSetName,$this->faceId,1000,0.99);

        $this->assertEquals(200,$response->getStatusCode());
    }
}