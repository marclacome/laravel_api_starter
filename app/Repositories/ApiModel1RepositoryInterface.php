<?php

namespace App\Repositories;

use App\ApiModel1;
use App\Http\Requests\ApiModel1StoreRequest;

interface ApiModel1RepositoryInterface
{
    /**
     * Get's a ApiModel1 by ID
     *
     * @param int $id;
     * @return ApiModel1;
     */
    public function get(int $id): ApiModel1;

    /**
     * Get's all ApiModel1s.
     *
     * @return object
     */
    public function all(): object;

    /**
     * Deletes a ApiModel1.
     *
     * @param int;
     * @return void;
     *
     */
    public function delete(int $id): void;

    /**
     * Updates a ApiModel1.
     *
     * @param int $id
     * @param ApiModel1StoreRequest $post_data
     * @return ApiModel1;
     */
    public function update(int $ApiModel1_id, ApiModel1StoreRequest $post_data): ApiModel1;

    /**
     * Saves a ApiModel1.
     * @param ApiModel1_id int
     * @param ApiModel1StoreRequest
     * @return void;
     */
    public function save(ApiModel1StoreRequest $post_data): void;

}
