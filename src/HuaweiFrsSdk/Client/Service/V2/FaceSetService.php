<?php

namespace HuaweiFrsSdk\Client\Service\V2;


use HuaweiFrsSdk\Access\FrsAccess;
use HuaweiFrsSdk\Access\HttpResponse\FaceSet\DeleteFaceSetResponse;
use HuaweiFrsSdk\Access\HttpResponse\FaceSet\CreateFaceSetResponse;
use HuaweiFrsSdk\Access\HttpResponse\FaceSet\GetFaceSetResponse;
use HuaweiFrsSdk\Access\HttpResponse\FaceSet\GetFaceSetsResponse;
use HuaweiFrsSdk\Client\Param\ExternalFieldDefinitions;
use HuaweiFrsSdk\Common\FrsPathsV2;

class FaceSetService
{
    /**
     * @var FrsAccess
     */
    private $accessService;
    /**
     * @var string
     */
    private $projectId;

    /**
     * SearchService constructor.
     *
     * @param FrsAccess $accessService
     * @param string    $projectId
     */
    public function __construct( FrsAccess $accessService, string $projectId)
    {
        $this->accessService = $accessService;
        $this->projectId = $projectId;
    }

    public function getAllFaceSets(): GetFaceSetsResponse
    {
        $uri = sprintf(FrsPathsV2::FACE_SET_GET_ALL, $this->projectId);

        $response =  $this->accessService->get($uri);

        return new GetFaceSetsResponse($response);
    }

    public function getFaceSet(string $faceSetName): GetFaceSetResponse
    {
        $uri = sprintf(FrsPathsV2::FACE_SET_GET_ONE, $this->projectId, $faceSetName);

        $response = $this->accessService->get($uri);

        return new GetFaceSetResponse($response);
    }

    public function createFaceSet(
        string $faceSetName,
        int $faceSetCapacity = 100000,
        ExternalFieldDefinitions $externalFieldDefinitions = null
    ): CreateFaceSetResponse
    {
        $uri = sprintf(FrsPathsV2::FACE_SET_CREATE, $this->projectId);

        $body['face_set_name'] = $faceSetName;
        $body['face_set_capacity'] = $faceSetCapacity;
        if (null !== $externalFieldDefinitions && count($externalFieldDefinitions->getExternalFieldDefinitions())) {
            $body['external_fields'] = $externalFieldDefinitions->getExternalFieldDefinitions();
        }

        $response = $this->accessService->post($uri,$body);

        return new CreateFaceSetResponse($response);
    }

    public function deleteFaceSet(string $faceSetName): DeleteFaceSetResponse
    {
        $uri = sprintf(FrsPathsV2::FACE_SET_DELETE, $this->projectId, $faceSetName);

        $response =  $this->accessService->delete($uri);

        return new DeleteFaceSetResponse($response);
    }

}