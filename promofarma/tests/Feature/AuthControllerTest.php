<?php

namespace Tests\Feature;


use Tests\TestCase;

class AuthControllerTest extends TestCase
{

    public function testSignUpUserRequiresNameAndEmailAndPassword()
    {
        $this->json('POST', 'api/auth/signup')
            ->assertStatus(422)
            ->assertJson([
                'message' => 'The given data was invalid.',
                'errors' =>
                    array (
                        'name' =>
                            array (
                                0 => 'The name field is required.',
                            ),
                        'email' =>
                            array (
                                0 => 'The email field is required.',
                            ),
                        'password' =>
                            array (
                                0 => 'The password field is required.',
                            ),
                    ),
            ]);
    }

    public function testSignUpNewUser()
    {
        $response = $this->json('POST',
            '/api/auth/signup',
            [
                'name' => 'Batman',
                'email' => 'brucewayne@iam.com',
                'password' => 'barcueva'
            ]);

        $response
            ->assertStatus(201)
            ->assertJson([
                'data' => 'Successfully created user',
            ]);
    }

    public function testCreateNewUserWhichAlreadyExist() {

        $response = $this->json('POST',
            '/api/auth/signup',
            [
                'name' => 'Batman',
                'email' => 'brucewayne@iam.com',
                'password' => 'barcueva'
            ]);

        $response
            ->assertStatus(422)
            ->assertJson([
                'message' => 'The given data was invalid.',
                'errors' =>
                    array (
                        'email' =>
                            array (
                                0 => 'The email has already been taken.',
                            ),
                    ),
            ]);
    }
}
