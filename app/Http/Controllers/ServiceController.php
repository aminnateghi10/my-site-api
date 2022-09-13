<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ServiceController extends Controller
{
    /**
     * index
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $services = Service::all();

        return response()->json([
            'data' => $services
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
       //dd($request->files);
        $this->validate($request, [
            'title' => ['required'],
            'body' => ['nullable', 'string'],
            'file' => ['required', 'image'],
            'meta' => ['nullable', 'array']
        ]);

        $file = $request->file('file');
        $name = time() . '.' . $file->getClientOriginalExtension();

        $file = $request->file('file')->move('images', $name);
        $request->merge(['image' => $file->getPathname()]);

        $service = Service::create($request->only(['title', 'body', 'meta', 'image']));

        return response()->json([
            'data' => $service
        ]);
    }

    /**
     *
     * update
     *
     * @param int $service
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function update(int $service, Request $request): JsonResponse
    {
        $this->validate($request, [
            'title' => ['required'],
            'body' => ['nullable', 'string'],
            'file' => ['required', 'image'],
            'meta' => ['nullable', 'array']
        ]);

        $service = Service::find($service);

        $request->merge(['image' => $service->image]);

        if ($file = $request->file('file')) {
            $name = time() . '.' . $file->getClientOriginalExtension();

            $file = $request->file('file')->move('images', $name);

            $request->merge(['image' => $file->getPathname()]);
        }

        $service = $service->update($request->only(['title', 'body', 'meta', 'image']));


        return response()->json([
            'data' => $service
        ]);
    }

    /**
     *
     * delete
     *
     * @param int $service
     * @return JsonResponse
     */
    public function delete(int $service): JsonResponse
    {
        $service = Service::find($service);

        $status = $service->delete();

        return response()->json([
            'status' => $status
        ]);
    }
}
