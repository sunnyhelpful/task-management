<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\TaskRequest;
use App\Http\Resources\TaskResource;
use Illuminate\Http\Request;
use App\Models\Task;
use Symfony\Component\HttpFoundation\Response;

class TaskController extends ApiController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $tasks = Task::orderBy('id', 'desc')->get();
            return $this->respondOk([
                'status' => true,
                'message' => trans('messages.data_retrieved_successfully'),
                'data' => TaskResource::collection($tasks),
            ]);
        } catch (\Exception $e) {
            \Log::info($e->getMessage().' '.$e->getFile().' '.$e->getCode());
            return $this->respondWithError(trans('messages.error_message'))->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

     /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TaskRequest $request)
    {
        try {
            $validated = $request->validated();
            $task = Task::create($validated);
    
            return $this->respondCreated([
                'status' => true,
                'message' => trans('messages.record_created_successfully'),
                'data' => new TaskResource($task),
            ]);
        } catch (\Exception $e) {
            \Log::info($e->getMessage().' '.$e->getFile().' '.$e->getCode());
            return $this->respondWithError(trans('messages.error_message'))->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $task = Task::where('uuid', $id)->firstOrFail();
            if (!$task) {
                return $this->respondWithError(trans('messages.no_record_found'))->setStatusCode(Response::HTTP_NOT_FOUND);
            }
            return $this->respondOk([
                'status' => true,
                'message' => trans('messages.data_retrieved_successfully'),
                'data' => new TaskResource($task),
            ]);
        } catch (\Exception $e) {
            \Log::info($e->getMessage().' '.$e->getFile().' '.$e->getCode());
            return $this->respondWithError(trans('messages.error_message'))->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TaskRequest $request, string $id)
    {
    try {
        $task = Task::where('uuid', $id)->firstOrFail();
        if (!$task) {
            return $this->respondWithError(trans('messages.no_record_found'))->setStatusCode(Response::HTTP_NOT_FOUND);
        }

        $validated = $request->validated();
        $task->update($validated);

        return $this->respondOk([
            'status' => true,
            'message' => trans('messages.record_updated_successfully'),
            'data' => new TaskResource($task),
        ]);
    } catch (\Exception $e) {
        return $this->respondWithError(trans('messages.error_message'))->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
    }
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $task = Task::where('uuid', $id)->firstOrFail();
            $task->delete();

            return $this->respondOk([
                'status' => true,
                'message' => trans('messages.record_deleted_successfully'),
            ]);
        } catch (\Exception $e) {
            return $this->respondWithError(trans('messages.error_message'))->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
