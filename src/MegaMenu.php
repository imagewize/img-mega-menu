<?php

namespace Imagewize\ImgMegaMenu;

use Roots\Acorn\Application;

class MegaMenu
{
    /**
     * The application instance.
     *
     * @var \Roots\Acorn\Application
     */
    protected $app;

    /**
     * Create a new MegaMenu instance.
     *
     * @param  \Roots\Acorn\Application  $app
     * @return void
     */
    public function __construct(Application $app)
    {
        $this->app = $app;
    }
}
