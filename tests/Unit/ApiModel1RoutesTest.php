<?php

namespace Tests\Unit;

use App\ApiModel1;
use Tests\Unit\TestBase\EnvironmentCheckedTestCase;

class ApiModel1RoutesTest extends EnvironmentCheckedTestCase
{
    private $root = "/api/api-models/";

    private $user;

    /**
     * setUp
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        \Artisan::call('migrate');
        $this->user = factory(\App\User::class)->create();
    }

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testIndex()
    {
        \Artisan::call('db:seed');
        $items = ApiModel1::all();
        $response = $this->withHeaders(['Content-Type' => 'application/json', 'Accept' => 'application/json'])->json("GET", $this->root);
        $response->assertStatus(200);
        $this->assertIsArray($response->getData()->data);
    }

    /**
     * testShow
     *
     * @return void
     */
    public function testShow()
    {
        \Artisan::call('db:seed');
        $item = ApiModel1::all()[0];

        $response = $this->withHeaders(['Content-Type' => 'application/json', 'Accept' => 'application/json'])->json("GET", $this->root . $item->id);
        $response->assertStatus(200);
        $this->assertIsObject($response->getData());
        $this->assertEquals($item->getAttributes(), (array) $response->getData());
    }

    /**
     * testStore
     *
     * @return void
     */
    public function testStore()
    {
        $newitem = ["fname" => "marc", "lname" => "lacome", "email" => "email@test.com", "town" => "London"];
        $response = $this->actingAs($this->user, 'api')->withHeaders(['Content-Type' => 'application/json', 'Accept' => 'application/json'])->json("POST", $this->root, $newitem);
        $response->assertStatus(200);
    }

    /**
     * testUpdate
     *
     * @return void
     */
    public function testUpdate()
    {
        \Artisan::call('db:seed');
        $item = ApiModel1::all()[0];
        $response = $this->actingAs($this->user, 'api')->put($this->root . $item->id, $item->toArray());
        $response->assertStatus(204);
    }

    /**
     * testDestroy
     *
     * @return void
     */
    public function testDestroy()
    {
        \Artisan::call('db:seed');
        $item = ApiModel1::all()[0];
        $response = $this->actingAs($this->user, 'api')->delete($this->root . $item->id);
        $response->assertStatus(204);

    }

    /**
     * testBadUrl
     *
     * @return void
     */
    public function testBadUrl()
    {
        $response = $this->get($this->root . 'a/b');
        $response->assertStatus(404);
    }

    /**
     * testInvalidShow
     *
     * @return void
     */
    public function testInvalidShow()
    {
        $response = $this->withHeaders(["Content-Type" => "application/json", 'Accept' => 'application/json'])->json("GET", $this->root . 'a');
        $response->assertStatus(400);
    }
}
