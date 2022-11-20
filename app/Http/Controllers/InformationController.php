<?php

namespace App\Http\Controllers;

use App\Models\Information;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class InformationController extends Controller
{
    /**
     * index
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $information = Information::pluck('value', 'key');

        return response()->json([
            'data' => $information
        ]);
    }

    /**
     *
     * store
     *
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function store(Request $request): JsonResponse
    {
        $this->validate($request, [
            'group' => ['nullable', 'string'],
            'key' => ['required', 'string'],
            'value' => ['nullable'],
            'meta' => ['nullable', 'array']
        ]);

        $info = Information::create($request->only(['group', 'key', 'value', 'meta']));

        return response()->json([
            'data' => $info
        ]);
    }

    /**
     *
     * update
     *
     * @param int $information
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function update(int $information, Request $request): JsonResponse
    {
        foreach ($request->all() as $key => $value) {
            Information::updateOrCreate([
                'key' => $key,
            ], [
                'value' => $value
            ]);
        }

        $information = Information::pluck('value', 'key');

        return response()->json([
            'data' => $information
        ]);
    }

    /**
     *
     * delete
     *
     * @param int $information
     * @return JsonResponse
     */
    public function delete(int $information): JsonResponse
    {
        $status = Information::whereId($information)->delete();

        return response()->json([
            'status' => $status
        ]);
    }
}
