<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Service;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ClientController extends Controller
{
    /**
     * index
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $clients = Client::all();

        return response()->json([
            'data' => $clients
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
            'name' => ['required'],
            'job' => ['required', 'string'],
            'body' => ['nullable', 'string'],
            'file' => ['required', 'image'],
            'meta' => ['nullable', 'array']
        ]);

        $file = $request->file('file');
        $name = time() . '.' . $file->getClientOriginalExtension();

        $file = $request->file('file')->move('images', $name);
        $request->merge(['img' => $file->getPathname()]);

        $clients = Client::create($request->only(['name', 'job', 'body', 'meta', 'img']));

        return response()->json([
            'data' => $clients
        ]);
    }

    /**
     *
     * update
     *
     * @param int $client
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function update(int $client, Request $request): JsonResponse
    {
        $this->validate($request, [
            'name' => ['required'],
            'job' => ['required', 'string'],
            'body' => ['nullable', 'string'],
            'file' => ['required', 'image'],
            'meta' => ['nullable', 'array']
        ]);

        $client = Client::find($client);

        $request->merge(['img' => $client->img]);

        if ($file = $request->file('file')) {
            $name = time() . '.' . $file->getClientOriginalExtension();

            $file = $request->file('file')->move('images', $name);

            $request->merge(['img' => $file->getPathname()]);
        }

        $client = $client->update($request->only(['name', 'job', 'body', 'meta', 'img']));


        return response()->json([
            'data' => $client
        ]);
    }

    /**
     *
     * delete
     *
     * @param int $client
     * @return JsonResponse
     */
    public function delete(int $client): JsonResponse
    {
        $status = Client::find($client);

        return response()->json([
            'status' => $status
        ]);
    }
}
