<?php

namespace Tests\Feature\Resources\Views\Layouts;

use App\View\Components\BlogLayout;
use Illuminate\View\View;
use Tests\TestCase;

class BlogBladeTest extends TestCase
{
    /**
     * It renders the blog layout view.
     */
    public function test_it_renders_the_blog_layout_view()
    {
        $view = $this->component(BlogLayout::class)->render();

        $this->assertInstanceOf(View::class, $view);
        $this->assertEquals('layouts.blog', $view->name());
    }
}
