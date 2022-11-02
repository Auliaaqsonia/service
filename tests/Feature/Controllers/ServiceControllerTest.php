<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\Service;

use App\Models\ProductService;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ServiceControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();

        $this->actingAs(
            User::factory()->create(['email' => 'admin@admin.com'])
        );

        $this->seed(\Database\Seeders\PermissionsSeeder::class);

        $this->withoutExceptionHandling();
    }

    /**
     * @test
     */
    public function it_displays_index_view_with_services()
    {
        $services = Service::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('services.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.services.index')
            ->assertViewHas('services');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_service()
    {
        $response = $this->get(route('services.create'));

        $response->assertOk()->assertViewIs('app.services.create');
    }

    /**
     * @test
     */
    public function it_stores_the_service()
    {
        $data = Service::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('services.store'), $data);

        $this->assertDatabaseHas('services', $data);

        $service = Service::latest('id')->first();

        $response->assertRedirect(route('services.edit', $service));
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_service()
    {
        $service = Service::factory()->create();

        $response = $this->get(route('services.show', $service));

        $response
            ->assertOk()
            ->assertViewIs('app.services.show')
            ->assertViewHas('service');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_service()
    {
        $service = Service::factory()->create();

        $response = $this->get(route('services.edit', $service));

        $response
            ->assertOk()
            ->assertViewIs('app.services.edit')
            ->assertViewHas('service');
    }

    /**
     * @test
     */
    public function it_updates_the_service()
    {
        $service = Service::factory()->create();

        $productService = ProductService::factory()->create();
        $user = User::factory()->create();

        $data = [
            'product_id' => $productService->id,
            'user_id' => $user->id,
        ];

        $response = $this->put(route('services.update', $service), $data);

        $data['id'] = $service->id;

        $this->assertDatabaseHas('services', $data);

        $response->assertRedirect(route('services.edit', $service));
    }

    /**
     * @test
     */
    public function it_deletes_the_service()
    {
        $service = Service::factory()->create();

        $response = $this->delete(route('services.destroy', $service));

        $response->assertRedirect(route('services.index'));

        $this->assertDeleted($service);
    }
}
