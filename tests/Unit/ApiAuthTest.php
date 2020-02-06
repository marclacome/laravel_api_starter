<?php
namespace Tests\Unit\Auth;

use App\User;
use Tests\Unit\TestBase\EnvironmentCheckedTestCase;

class ApiAuthTest extends EnvironmentCheckedTestCase
{
    private $root = "/api/auth/";
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
        \Artisan::call('passport:install');
    }

    /**
     * testRegisterSuccess
     *
     * @return void
     */
    public function testRegisterSuccess()
    {
        $newuser = ["name" => "marc", "email" => "email@test.com", "password" => "12345678", "password_confirmation" => "12345678"];
        $response = $this->withHeaders(['Content-Type' => 'application/json', 'Accept' => 'application/json'])->json("POST", $this->root . "register", $newuser);
        $response->assertStatus(200);
        $this->assertIsObject($response->getData());
        $this->assertEquals(["registered" => "OK"], (array) $response->getData());
    }

    /**
     * testRegisterFail
     *
     * @return void
     */
    public function testRegisterFail()
    {
        $data = ["name" => "username", "email" => "email@test.com"];
        factory(User::class)->create($data);
        $newuser = ["name" => "marc", "email" => "email@test.com", "password" => "12345678", "password_confirmation" => "12345678"];
        $response = $this->withHeaders(['Content-Type' => 'application/json', 'Accept' => 'application/json'])->json("POST", $this->root . "register", $newuser);
        $response->assertStatus(422);
        $this->assertIsObject($response->getData());
        $this->assertEquals(["That email address is already in use"], (array) $response->getData()->errors[0]);
    }

    /**
     * testLoginSuccess
     *
     * @return void
     */
    public function testLoginSuccess()
    {
        $data = ["name" => "username", "email" => "email@test.com"];
        $user = ["email" => "email@test.com", "password" => "password"];
        factory(User::class)->create($data);
        $response = $this->withHeaders(['Content-Type' => 'application/json', 'Accept' => 'application/json'])->json("POST", $this->root . 'login', $user);

        $response->assertStatus(200);
        $this->assertIsObject($response->getData());
        $this->assertEquals(["logged_on" => "OK"], (array) $response->getData());
        $response->assertCookie("_token");
    }

    /**
     * testLoginFail
     *
     * @return void
     */
    public function testLoginFail()
    {
        $data = ["name" => "username", "email" => "email@test.com"];
        $user = ["email" => "email@test.com", "password" => "xxxxxxxx"];
        factory(User::class)->create($data);
        $response = $this->withHeaders(['Content-Type' => 'application/json', 'Accept' => 'application/json'])->json("POST", $this->root . 'login', $user);
        $response->assertStatus(422);
        $this->assertIsObject($response->getData());
        $this->assertEquals(["These credentials do not match our records."], (array) $response->getData()->errors[0]);
    }

    /**
     * testLogOff
     *
     * @return void
     */
    public function testLogOff()
    {
        $data = ["name" => "username", "email" => "email@test.com"];
        $user = ["email" => "email@test.com", "password" => "password"];
        factory(User::class)->create($data);
        $response = $this->withHeaders(['Content-Type' => 'application/json', 'Accept' => 'application/json'])->json("POST", $this->root . 'login', $user);
        $response->assertStatus(200);
        $token = ["_token" => explode(";", str_replace("_token=", "", $response->headers->getCookies()[0]))[0]];

        $token = ["_token" => $response->headers->getCookies()[0]->getValue()];
        $headers = $this->transformHeadersToServerVars(['Content-Type' => 'application/json', 'Accept' => 'application/json']);
        $response = $this->call("POST", $this->root . 'logout', [], $token, [], $headers);

        $response->assertStatus(200);
        $this->assertEquals(["logged_out" => "OK"], (array) $response->getData());
        $token = ["_token" => explode(";", str_replace("_token=", "", $response->headers->getCookies()[0]))[0]];
        $this->assertEquals($token['_token'], "deleted");
    }
}
