<?php

namespace Tests\Unit;

use App\Http\Controllers\ApiModel1Controller;
use App\Http\Requests\ApiModel1StoreRequest;
use Tests\Unit\Mocks\ApiModel1TestRepository;
use Tests\Unit\TestBase\EnvironmentCheckedTestCase;

class ApiModel1ControllerTest extends EnvironmentCheckedTestCase
{
    private $controller;
    /**
     * setUp
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->controller = new ApiModel1Controller(new ApiModel1TestRepository());
    }

    /**
     * Test show
     *
     * @return void
     */
    public function testIndex()
    {
        $response = $this->controller->index();
        $this->assertEquals($response->status(), 200);
        $this->assertIsObject(json_decode($response->content()));
    }

    /**
     * testStore
     *
     * @return void
     */
    public function testStore()
    {
        $response = $this->controller->store(new ApiModel1StoreRequest(), 1);
        $this->assertEquals($response->status(), 200);
        $this->assertIsObject(json_decode($response->content()));
    }

    /**
     * testShow
     *
     * @return void
     */
    public function testShow()
    {
        $response = $this->controller->show(1);
        $this->assertEquals($response->status(), 200);
        $this->assertIsArray(json_decode($response->content()));
    }

    /**
     * testUpdate
     *
     * @return void
     */
    public function testUpdate()
    {
        $response = $this->controller->update(new ApiModel1StoreRequest(), 1);
        $this->assertEquals($response->status(), 204);
        $this->assertIsObject(json_decode($response->content()));
    }

    /**
     * testDestroy
     *
     * @return void
     */
    public function testDestroy()
    {
        $response = $this->controller->destroy(1);
        $this->assertEquals($response->status(), 204);
        $this->assertIsObject(json_decode($response->content()));
    }
}
