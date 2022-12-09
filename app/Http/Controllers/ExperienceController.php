<?php

namespace App\Http\Controllers;

use App\Models\Experience;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ExperienceController extends Controller
{
    /**
     * index
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $experiences = Experience::all();

        return response()->json([
            'data' => $experiences
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
            'type' => ['required'],
            'title' => ['required', 'string'],
            'body' => ['nullable'],
            'start' => ['required'],
            'end' => ['nullable'],
            'meta' => ['nullable', 'array']
        ]);

        $experiences = Experience::create($request->only(['type', 'title', 'body', 'start', 'end', 'meta']));

        return response()->json([
            'data' => $experiences
        ]);
    }

    /**
     *
     * update
     *
     * @param int $experience
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function update(int $experience, Request $request): JsonResponse
    {
        $this->validate($request, [
            'type' => ['required'],
            'title' => ['required', 'string'],
            'body' => ['nullable'],
            'start' => ['required'],
            'end' => ['nullable'],
            'meta' => ['nullable', 'array']
        ]);

        $status = Experience::whereId($experience)->update($request->only(['type', 'title', 'body', 'start', 'end', 'meta']));

        return response()->json([
            'status' => Experience::find($experience)
        ]);
    }

    /**
     *
     * delete
     *
     * @param int $experience
     * @return JsonResponse
     */
    public function delete(int $experience): JsonResponse
    {
        $status = Experience::whereId($experience)->delete();

        return response()->json([
            'status' => $status
        ]);
    }
}
