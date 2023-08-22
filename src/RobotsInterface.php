<?php

namespace JazzMan\Robots;

use Closure;

interface RobotsInterface {

    /**
         * Add a comment to the robots.txt.
         */
    public function comment( string ...$comment ): self;

    /**
     * Add a Host to the robots.txt.
     */
    public function host( string $host ): self;

    /**
     * Add a disallow rule to the robots.txt.
     *
     * @param string|array $directories
     */
    public function disallow( string ...$directories ): self;

    /**
     * Add a allow rule to the robots.txt.
     */
    public function allow( string ...$directories ): self;

    /**
     * Add a User-agent to the robots.txt.
     */
    public function userAgent( string $userAgent ): self;

    /**
     * Add a Sitemap to the robots.txt.
     */
    public function sitemap( array|string $sitemap ): self;

    /**
     * Adding a separator to the robots.txt.
     */
    public function spacer( int $num = 1 ): self;

    /**
     * Perform a callback for each batch agent.
     *
     * @throws RobotsException
     */
    public function each( callable|Closure $closure ): self;

    /**
     *  Creates a file with the selected data.
     *
     * @throws RobotsException
     */
    public function create( ?string $path = 'robots.txt' ): void;

    /**
     * Output of generated data to the robots.txt.
     */
    public function render(): string;
}
