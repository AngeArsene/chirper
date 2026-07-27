<?php

namespace Tests\Feature\View\Component\Pagination;

use App\Models\Chirp;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SimplePaginateTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic view test example.
     */
    public function test_it_does_not_render_links_when_there_are_no_pages(): void
    {
        User::factory(2)->hasChirps(5)->create()->fresh();

        $paginator = Chirp::simplePaginate(10);

        $contents = $this->view('simple-paginate', compact('paginator'));

        $contents->assertDontSee('Previous')->assertDontSee('Next');
    }

    public function test_it_renders_simple_pagination_links_in_the_feed_component(): void
    {
        User::factory(2)->hasChirps(6)->create()->fresh();

        $chirps = Chirp::simplePaginate(10);

        $contents = $this->view('components.feed', compact('chirps'));

        $contents->assertSee('Previous')->assertSee('Next');
    }
}
