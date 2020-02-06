<?php

namespace Tests\Unit;

use App\ApiModel1;
use App\Repositories\ApiModel1Repository;
use Tests\Unit\TestBase\EnvironmentCheckedTestCase;

class ApiModel1RepositoryTest extends EnvironmentCheckedTestCase
{

    /**
     * setUp
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        \Artisan::call('migrate');
    }

    /**
     * testAll
     *
     * @return void
     */
    public function testAll()
    {
        $data = ['fname' => 'fn', "lname" => "ln", "email" => "mail", "town" => "town"];
        factory(ApiModel1::class)->create($data);
        $m = new ApiModel1Repository();
        $repo_data = $m->all()->first()->toArray();

        foreach ($data as $key => $value) {
            $this->assertArrayHasKey($key, $repo_data);
            $this->assertSame($value, $repo_data[$key]);
        }
    }

    /**
     * testGet
     *
     * @return void
     */
    public function testGet()
    {
        $data = ['fname' => 'fn', "lname" => "ln", "email" => "mail", "town" => "town"];
        factory(ApiModel1::class)->create($data);
        $m = new ApiModel1Repository();
        $id = ApiModel1::all()->first()->id;
        $repo_data = $m->get($id)->toArray();
        foreach ($data as $key => $value) {
            $this->assertArrayHasKey($key, $repo_data);
            $this->assertSame($value, $repo_data[$key]);
        }
    }

    /**
     * testSave
     *
     * @return void
     */
    public function testSave()
    {
        $m = new ApiModel1Repository();
        $data = ['fname' => 'fn', "lname" => "ln", "email" => "smail@mymail.com", "town" => "atown"];
        $request = new \App\Http\Requests\ApiModel1StoreRequest($data);
        $request->setContainer($this->app);
        $request->validateResolved();
        $request->merge($data);

        $m->save($request);

        $repo_data = ApiModel1::all()->first();
        foreach ($data as $key => $value) {
            $this->assertArrayHasKey($key, $repo_data);
            $this->assertSame($value, $repo_data[$key]);
        }
    }

    /**
     * testDelete
     *
     * @return void
     */
    public function testDelete()
    {
        $data = ['fname' => 'fn', "lname" => "ln", "email" => "mail", "town" => "town"];
        factory(ApiModel1::class)->create($data);
        $m = new ApiModel1Repository();
        $id = ApiModel1::all()->first()->id;
        $m->delete($id);
        $repo_data = ApiModel1::find($id);
        $this->assertSame($repo_data, null);
    }

    /**
     * testUpdate
     *
     * @return void
     */
    public function testUpdate()
    {
        $data = ['fname' => 'fn', "lname" => "ln", "email" => "mail", "town" => "town"];
        factory(ApiModel1::class)->create($data);
        $id = ApiModel1::all()->first()->id;
        $m = new ApiModel1Repository();
        $updated = collect($data)->map(function ($item) {
            return 'updated_' . $item;
        });
        $request = new \App\Http\Requests\ApiModel1StoreRequest($updated->all());
        $m->update($id, $request);
        $repo_data = ApiModel1::find($id);
        foreach ($updated->all() as $key => $value) {
            $this->assertArrayHasKey($key, $repo_data);
            $this->assertSame($value, $repo_data[$key]);
        }
    }

    /**
     * testSaveFailsInvalidEmail
     *
     * @return void
     */
    public function testSaveFailsInvalidEmail()
    {
        $m = new ApiModel1Repository();
        $data = ['fname' => 'fn', "lname" => "ln", "email" => "smail", "town" => "atown"];
        $request = new \App\Http\Requests\ApiModel1StoreRequest($data);
        $request->setContainer($this->app);
        try {
            $request->validateResolved();
            $request->merge($data);
        } catch (\Illuminate\Validation\ValidationException $e) {
            $this->assertSame($e->errors()[0][0], "The email address is not valid");
        }
    }

    /**
     * testSaveDuplicateEmailSameID
     *
     * @return void
     */
    public function testSaveDuplicateEmailSameID()
    {
        $data = ['id' => 1, 'fname' => 'fn', "lname" => "ln", "email" => "test@mail.com", "town" => "atown"];
        factory(ApiModel1::class)->create($data);

        $m = new ApiModel1Repository();
        $request = new \App\Http\Requests\ApiModel1StoreRequest($data);
        $request->setContainer($this->app);
        $exceptionThrown = false;
        try {
            $request->validateResolved();
            $request->merge($data);
        } catch (\Illuminate\Validation\ValidationException $e) {
            $exceptionThrown = true;
        }
        $this->assertFalse($exceptionThrown);
    }

}
