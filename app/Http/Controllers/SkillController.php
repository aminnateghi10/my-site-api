<?php

namespace App\Http\Controllers;

use App\Models\Skill;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class SkillController extends Controller
{
    /**
     * index
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $skills = Skill::all();

        return response()->json([
            'data' => $skills
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
            'percent' => ['nullable'],
            'title' => ['required', 'string'],
            'meta' => ['nullable', 'array']
        ]);

        $skill = Skill::create($request->only(['percent', 'title', 'meta']));

        return response()->json([
            'data' => $skill
        ]);
    }

    /**
     *
     * update
     *
     * @param int $skill
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function update(int $skill, Request $request): JsonResponse
    {
        $this->validate($request, [
            'percent' => ['nullable'],
            'title' => ['required', 'string'],
            'meta' => ['nullable', 'array']
        ]);

        $status = Skill::whereId($skill)->update($request->only(['percent', 'title', 'meta']));

        return response()->json([
            'status' => $status
        ]);
    }

    /**
     *
     * delete
     *
     * @param int $skill
     * @return JsonResponse
     */
    public function delete(int $skill): JsonResponse
    {
        $status = Skill::whereId($skill)->delete();

        return response()->json([
            'status' => $status
        ]);
    }
}
