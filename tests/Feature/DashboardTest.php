<?php

namespace Tadcms\Tests\Feature;

use Tests\TestCase;

class DashboardTest extends TestCase
{
    public function testIndex() {
        $this->withoutMiddleware();
        $response = $this->get(route('admin.dashboard'));
        $response->assertSuccessful();
        //$response->dump();
    }
}