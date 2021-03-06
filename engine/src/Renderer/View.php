<?php

/**
 * This file is part of Battleground package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Serafim\Bic\Renderer;

use SDL\SDLNativeApiAutocomplete;
use Serafim\Bic\Lifecycle\Lifecycle;
use SDL\SDL;

/**
 * Class View
 *
 * @method void load()
 */
abstract class View implements ViewInterface
{
    /**
     * @var SDL|SDLNativeApiAutocomplete
     */
    protected SDL $sdl;

    /**
     * @var Lifecycle
     */
    protected Lifecycle $game;

    /**
     * View constructor.
     *
     * @param Lifecycle $game
     */
    public function __construct(Lifecycle $game)
    {
        $this->sdl = SDL::getInstance();
        $this->game = $game;

        if (\method_exists($this, 'load')) {
            $game->app->call(\Closure::fromCallable([$this, 'load']));
        }
    }

    /**
     * @param string $pathname
     * @return Texture
     */
    protected function texture(string $pathname): Texture
    {
        if (! \is_file($pathname)) {
            $pathname = $this->game->app->resourcesPath($pathname);
        }

        return Texture::fromPathname($this->game->renderer, $pathname);
    }

    /**
     * @param string $path
     * @return string
     */
    protected function resources(string $path): string
    {
        return $this->game->app->resourcesPath($path);
    }
}
