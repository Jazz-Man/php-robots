<?php

namespace JazzMan\Robots;

use Closure;
use JazzMan\Traits\SingletonTrait;

class Robots implements RobotsInterface {

    use SingletonTrait;

    /**
     * The lines of for the robots.txt.
     */
    protected array $linear = [];

    public function __construct() {}

    /**
     * Perform a callback for each batch agent.
     *
     * @return \JazzMan\Robots\RobotsInterface
     */
    public function each( callable|Closure $closure ): RobotsInterface {
        if ( $closure instanceof Closure ) {
            $closure( $this );
        }

        return $this;
    }

    /**
     * Add a comment to the robots.txt.
     *
     * @return \JazzMan\Robots\RobotsInterface
     *
     * @throws \JazzMan\Robots\RobotsException
     */
    public function comment( string ...$comment ): RobotsInterface {
        $this->addLines( $comment, '# ' );

        return $this;
    }

    /**
     * Add a Host to the robots.txt.
     */
    public function host( string $host ): RobotsInterface {
        $this->addLine( "Host: {$host}" );

        return $this;
    }

    /**
     * Add a disallow rule to the robots.txt.
     *
     * @param string[] $directories
     *
     * @throws \JazzMan\Robots\RobotsException
     */
    public function disallow( string ...$directories ): RobotsInterface {
        $this->addRuleLine( $directories, 'Disallow' );

        return $this;
    }

    /**
     * Add a allow rule to the robots.txt.
     *
     * @throws \JazzMan\Robots\RobotsException
     */
    public function allow( string ...$directories ): RobotsInterface {
        $this->addRuleLine( $directories, 'Allow' );

        return $this;
    }

    /**
     * Add a User-agent to the robots.txt.
     */
    public function userAgent( string $userAgent ): RobotsInterface {
        $this->addLine( "User-agent: {$userAgent}" );

        return $this;
    }

    /**
     * Add a Sitemap to the robots.txt.
     *
     * @throws \JazzMan\Robots\RobotsException
     */
    public function sitemap( array|string $sitemap ): RobotsInterface {
        if ( \is_array( $sitemap ) ) {
            $this->addLines( $sitemap, 'Sitemap: ' );
        } else {
            $this->addLine( 'Sitemap: '.$sitemap );
        }

        return $this;
    }

    /**
     * Adding a separator to the robots.txt.
     */
    public function spacer( int $num = 1 ): RobotsInterface {
        for ( $i = 0; $i <= $num; ++$i ) {
            $this->addLine( null );
        }

        return $this;
    }

    /**
     *  Creates a file with the selected data.
     *
     * @throws RobotsException
     */
    public function create( ?string $path = 'robots.txt' ): void {
        if ( empty( $this->linear ) ) {
            throw new RobotsException( 'There were errors while creating robots.txt' );
        }

        if ( file_exists( $path ) ) {
            unlink( $path );
        }
        file_put_contents( $path, implode( PHP_EOL, $this->linear ) );
    }

    /**
     * Output of generated data to the robots.txt.
     */
    public function render(): string {
        return implode( PHP_EOL, $this->linear );
    }

    /**
     * Adding a new rule to the robots.txt.
     *
     * @throws \JazzMan\Robots\RobotsException
     */
    protected function addRuleLine( array|string $directories, string $rule ): void {
        $this->isEmpty( $directories );

        foreach ( (array) $directories as $directory ) {
            $this->addLine( "{$rule}: {$directory}" );
        }
    }

    /**
     * Adding a new line to the robots.txt.
     */
    protected function addLine( ?string $line ): void {
        $this->linear[] = $line;
    }

    /**
     * Adding multiple rows to the robots.txt.
     *
     * @throws \JazzMan\Robots\RobotsException
     */
    protected function addLines( array|string $lines, ?string $prefix = null ): void {
        $this->isEmpty( $lines );

        foreach ( (array) $lines as $line ) {
            if ( null !== $prefix ) {
                $this->addLine( $prefix.$line );
            } else {
                $this->addLine( $line );
            }
        }
    }

    /**
     * Checking the data for existence.
     *
     * @param null $var
     *
     * @throws RobotsException
     */
    protected function isEmpty( $var = null ): void {
        if ( empty( $var ) ) {
            throw new RobotsException( 'The parameter must not be empty' );
        }
    }
}
