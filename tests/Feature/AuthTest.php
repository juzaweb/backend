<?php

namespace Tadcms\Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthTest extends TestCase
{
    use RefreshDatabase;
    
    public function testLogin() {
        $this->withoutMiddleware();
        
        $response = $this->postJson(route('auth.login.handle'), [
            'email' => 'austyn.littel@example.net',
            'password' => 123456,
        ]);
        
        $response->assertJson([
            'status' => false,
        ]);
    }
}