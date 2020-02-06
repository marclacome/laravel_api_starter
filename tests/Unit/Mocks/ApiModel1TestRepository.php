<?php

namespace Tests\Unit\Mocks;

use App\ApiModel1;
use App\Http\Requests\ApiModel1StoreRequest;
use App\Repositories\ApiModel1RepositoryInterface;

class ApiModel1TestRepository implements ApiModel1RepositoryInterface
{
    /**
     * Mock Get an ApiModel
     *
     * @param  mixed $id
     *
     * @return ApiModel1
     */
    public function get(int $id): ApiModel1
    {
        return new ApiModel1();
    }

    /**
     * Mock Get all ApiModel1s.
     *
     * @return object
     */
    public function all(): object
    {
        //  return new ApiModel1();
        return new \stdClass;
    }

    /**
     * Mock Deletes a ApiModel1.
     *
     * @param int;
     * @return void;
     *
     */
    public function delete(int $id): void
    {
    }

    /**
     * Mock Updates a ApiModel1.
     *
     * @param int $id
     * @param array $post_data
     * @return ApiModel1;
     */
    public function update(int $ApiModel1_id, ApiModel1StoreRequest $post_data): ApiModel1
    {
        return new ApiModel1();
    }

    /**
     * Mock Saves a ApiModel1.
     *
     * @param ApiModel1StoreRequest
     * @return void;
     */
    public function save(ApiModel1StoreRequest $post_data): void
    {

    }
}
