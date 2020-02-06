<?php

namespace App\Http\Controllers;

use App\ApiModel1;
use App\Http\Requests\ApiModel1StoreRequest;
use App\Repositories\ApiModel1RepositoryInterface;

class ApiModel1Controller extends Controller
{
    private $repo;

    /**
     * Constructor.
     *
     * @param App\Repositories\ApiModel1RepositoryInterface
     */
    public function __construct(ApiModel1RepositoryInterface $repo)
    {
        $this->repo = $repo;
        $this->middleware('auth.api', ['except' => ['index', 'show']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(): \Illuminate\Http\JsonResponse
    {
        $al = $this->repo->all();
        return response()->json($al, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param App\Http\Requests\ApiModel1StoreRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ApiModel1StoreRequest $request): \Illuminate\Http\JsonResponse
    {
        $this->repo->save($request);
        return response()->json(null, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show(int $id): \Illuminate\Http\JsonResponse
    {
        $r = $this->repo->get($id);
        return response()->json($r, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param App\Http\Requests\ApiModel1StoreRequest  $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(ApiModel1StoreRequest $request, int $id): \Illuminate\Http\JsonResponse
    {
        $this->repo->update($id, $request);
        return response()->json(null, 204);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id): \Illuminate\Http\JsonResponse
    {
        $this->repo->delete($id);
        return response()->json(null, 204);
    }
}
