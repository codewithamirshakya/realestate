<?php

namespace Tests\Feature;

use App\Models\SiteContent;
use App\Models\User;
use App\Support\Cms;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class CmsTest extends TestCase
{
    use RefreshDatabase;

    protected function admin(): User
    {
        return User::factory()->admin()->create();
    }

    public function test_pages_fall_back_to_the_defaults_in_the_cms_config(): void
    {
        $this->get('/')
            ->assertOk()
            ->assertSee('Ready to sell, rent, or list your property?')
            ->assertSee('Lagankhel, Lalitpur');
    }

    public function test_an_admin_can_open_the_content_manager(): void
    {
        $this->actingAs($this->admin())
            ->get(route('admin.content.index'))
            ->assertOk()
            ->assertSee('Site Content')
            ->assertSee('Home page');
    }

    public function test_agents_and_buyers_cannot_reach_the_content_manager(): void
    {
        $this->actingAs(User::factory()->agent()->create())
            ->get(route('admin.content.index'))
            ->assertForbidden();

        $this->actingAs(User::factory()->buyer()->create())
            ->post(route('admin.content.inline'), ['key' => 'home.cta.button', 'value' => 'Hacked'])
            ->assertForbidden();

        $this->assertDatabaseCount('site_contents', 0);
    }

    public function test_guests_cannot_edit_content(): void
    {
        $this->post(route('admin.content.inline'), ['key' => 'home.cta.button', 'value' => 'Hacked'])
            ->assertRedirect(route('login'));

        $this->assertDatabaseCount('site_contents', 0);
    }

    public function test_saving_a_group_updates_the_public_page(): void
    {
        $this->actingAs($this->admin())
            ->post(route('admin.content.update'), [
                'values' => [
                    'home.cta.title' => 'Sell your land with us',
                    'home.hero.badge' => 'Lalitpur, Nepal',
                ],
            ])
            ->assertRedirect();

        $this->assertDatabaseHas('site_contents', [
            'key' => 'home.cta.title',
            'value' => 'Sell your land with us',
        ]);

        $this->get('/')
            ->assertOk()
            ->assertSee('Sell your land with us')
            ->assertSee('Lalitpur, Nepal');
    }

    public function test_an_empty_value_is_stored_as_null_and_falls_back_to_the_default(): void
    {
        app(Cms::class)->set('home.cta.button', 'Join now');

        $this->actingAs($this->admin())
            ->post(route('admin.content.update'), ['values' => ['home.cta.button' => '']])
            ->assertRedirect();

        $this->assertNull(SiteContent::where('key', 'home.cta.button')->value('value'));
        $this->assertSame('Get Started', app(Cms::class)->value('home.cta.button'));
    }

    public function test_inline_editing_saves_a_single_field(): void
    {
        $this->actingAs($this->admin())
            ->postJson(route('admin.content.inline'), [
                'key' => 'home.featured.title',
                'value' => 'Handpicked Homes',
            ])
            ->assertOk()
            ->assertJson(['key' => 'home.featured.title', 'value' => 'Handpicked Homes']);

        $this->assertSame('Handpicked Homes', app(Cms::class)->value('home.featured.title'));
    }

    public function test_inline_editing_rejects_unknown_and_oversized_values(): void
    {
        $this->actingAs($this->admin())
            ->postJson(route('admin.content.inline'), ['key' => 'home.not.a.key', 'value' => 'x'])
            ->assertStatus(422);

        $this->actingAs($this->admin())
            ->postJson(route('admin.content.inline'), ['key' => 'home.featured.title', 'value' => str_repeat('a', 300)])
            ->assertStatus(422);

        $this->assertDatabaseCount('site_contents', 0);
    }

    public function test_edit_mode_makes_the_home_page_editable_for_admins_only(): void
    {
        $this->get('/')->assertDontSee('data-cms-key', false);

        $admin = $this->admin();

        $this->actingAs($admin)
            ->post(route('admin.content.edit-mode'))
            ->assertRedirect()
            ->assertSessionHas(Cms::SESSION_KEY, true);

        $this->actingAs($admin)
            ->withSession([Cms::SESSION_KEY => true])
            ->get('/')
            ->assertSee('data-cms-bar', false)
            ->assertSee('data-cms-key', false)
            ->assertSee('contenteditable', false)
            ->assertSee('data-cms-image="home.hero.image"', false);
    }

    public function test_company_details_override_the_config_and_show_in_the_footer(): void
    {
        app(Cms::class)->set('company.phone', '+977-9812345678');

        $this->get('/')
            ->assertOk()
            ->assertSee('+977-9812345678');
    }

    public function test_an_admin_can_upload_and_reset_an_image_field(): void
    {
        Storage::fake('public');

        $this->actingAs($this->admin())
            ->post(route('admin.content.upload'), [
                'key' => 'home.hero.image',
                'image' => UploadedFile::fake()->image('hero.jpg', 1200, 600),
            ])
            ->assertOk();

        $path = SiteContent::where('key', 'home.hero.image')->value('value');

        $this->assertNotNull($path);
        Storage::disk('public')->assertExists($path);

        $this->actingAs($this->admin())
            ->delete(route('admin.content.destroy', ['key' => 'home.hero.image']))
            ->assertRedirect();

        Storage::disk('public')->assertMissing($path);
        $this->assertDatabaseCount('site_contents', 0);
    }
}
