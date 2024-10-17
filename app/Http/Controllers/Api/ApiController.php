<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Response as IlluminateResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 * Base API Controller.
 */
class ApiController extends Controller
{
    /**
     * Default status code.
     *
     * @var int
     */
    protected $statusCode = IlluminateResponse::HTTP_OK;

    /**
     * Get the status code.
     *
     * @return int
     */
    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    /**
     * Set the status code.
     *
     * @param int $statusCode
     * @return $this
     */
    public function setStatusCode(int $statusCode): self
    {
        $this->statusCode = $statusCode;
        return $this;
    }

    /**
     * Respond with JSON data.
     *
     * @param mixed $data
     * @param array $headers
     * @return \Illuminate\Http\JsonResponse
     */
    public function respond($data, array $headers = []): \Illuminate\Http\JsonResponse
    {
        return response()->json($data, $this->getStatusCode(), $headers);
    }

    /**
     * Respond with validation error.
     *
     * @param string $message
     * @return \Illuminate\Http\JsonResponse
     */
    public function throwValidation(string $message): \Illuminate\Http\JsonResponse
    {
        return $this->setStatusCode(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->respondWithError($message);
    }

    /**
     * Respond with created data.
     *
     * @param mixed $data
     * @return \Illuminate\Http\JsonResponse
     */
    public function respondCreated($data): \Illuminate\Http\JsonResponse
    {
        return $this->respond([
            'status_code' => Response::HTTP_CREATED,
            'data' => $data,
        ]);
    }

    /**
     * Respond with success.
     *
     * @param mixed $data
     * @return \Illuminate\Http\JsonResponse
     */
    public function respondOk($data): \Illuminate\Http\JsonResponse
    {
        return $this->respond([
            'status_code' => Response::HTTP_OK,
            'data' => $data,
        ]);
    }

    /**
     * Respond with error.
     *
     * @param string $message
     * @return \Illuminate\Http\JsonResponse
     */
    public function respondWithError(string $message): \Illuminate\Http\JsonResponse
    {
        return $this->respond([
            'status' => false,
            'status_code' => $this->getStatusCode(),
            'error' => ['message' => $message],
        ]);
    }
}
