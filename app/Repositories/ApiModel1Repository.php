<?php

namespace App\Repositories;

use App\ApiModel1;
use App\Http\Requests\ApiModel1StoreRequest;
use App\Repositories\ApiModel1RepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ApiModel1Repository implements ApiModel1RepositoryInterface
{

    /**
     * Get's an ApiModel1 by ID
     *
     * @param int $id;
     * @return ApiModel1;
     */

    public function get(int $id): ApiModel1
    {
        try
        {
            $m = ApiModel1::findOrFail($id);
            return $m;
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            throw new \Illuminate\Database\Eloquent\ModelNotFoundException("Cannot find a ApiModel1 with id " . $id, 404);
        }
    }

    /**
     * all
     *
     * @return object
     */
    public function all(): object
    {
        return ApiModel1::paginate(3);
    }

    /**
     * update
     *
     * @param  int $id
     * @param  ApiModel1StoreRequest $post_data
     *
     * @return ApiModel1
     */
    public function update(int $id, ApiModel1StoreRequest $post_data): ApiModel1
    {
        try {
            $c = ApiModel1::findOrFail($id);
            $c->setAttributes($post_data->all());
            $c->update();
            return $c;
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            throw new \Illuminate\Database\Eloquent\ModelNotFoundException("Cannot find a ApiModel1 with id " . $id, 404);
        }
    }

    /**
     * delete
     *
     * @param  int $id
     *
     * @return void
     */
    public function delete(int $id): void
    {
        try {
            ApiModel1::findOrFail($id);
            ApiModel1::destroy($id);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            throw new \Illuminate\Database\Eloquent\ModelNotFoundException("Cannot find a ApiModel1 with id " . $id, 404);
        }
    }

    /**
     * save
     *
     * @param  ApiModel1StoreRequest $post_data
     *
     * @return void
     */
    public function save(ApiModel1StoreRequest $post_data): void
    {
        $v = $post_data->validated();
        $c = new ApiModel1();
        $c->setAttributes($post_data);
        $c->save();
    }
}
