<?php

namespace JazzMan\Robots;

use PHPUnit\Framework\TestCase;

/**
 * @internal
 *
 * @coversNothing
 */
final class RobotsTest extends TestCase {

    public function testSitemap(): void {
        $robots = new Robots();
        $sitemap = 'sitemap.xml';
        self::assertStringNotContainsString( $sitemap, $robots->render() );
        $robots->sitemap( $sitemap );

        self::assertStringContainsString( "Sitemap: {$sitemap}", $robots->render() );
    }

    public function testHost(): void {
        $robots = new Robots();
        $host = 'www.steein.ru';
        self::assertStringNotContainsString( "Host: {$host}", $robots->render() );
        $robots->host( $host );
        self::assertStringContainsString( "Host: {$host}", $robots->render() );
    }

    public function testDisallow(): void {
        $robots = new Robots();
        $path = 'dir';

        self::assertStringNotContainsString( $path, $robots->render() );
        $robots->disallow( $path );
        self::assertStringContainsString( $path, $robots->render() );
    }

    public function testComment(): void {
        $robots = new Robots();
        $comment_1 = 'Steein comment';
        $comment_2 = 'Test comment';
        $comment_3 = 'Final test comment';

        self::assertStringNotContainsString( "# {$comment_1}", $robots->render() );
        self::assertStringNotContainsString( "# {$comment_2}", $robots->render() );
        self::assertStringNotContainsString( "# {$comment_3}", $robots->render() );

        $robots->comment( $comment_1 );
        self::assertStringContainsString( "# {$comment_1}", $robots->render() );

        $robots->comment( $comment_2 );
        self::assertStringContainsString( "# {$comment_1}", $robots->render() );
        self::assertStringContainsString( "# {$comment_2}", $robots->render() );

        $robots->comment( $comment_3 );
        self::assertStringContainsString( "# {$comment_1}", $robots->render() );
        self::assertStringContainsString( "# {$comment_2}", $robots->render() );
        self::assertStringContainsString( "# {$comment_3}", $robots->render() );
    }

    public function testSpacer(): void {
        $robots = new Robots();

        $lines = \count( preg_split( '/'.PHP_EOL.'/', $robots->render() ) );
        self::assertSame( 1, $lines ); // Starts off with at least one line.

        $robots->spacer();
        $lines = \count( preg_split( '/'.PHP_EOL.'/', $robots->render() ) );

        self::assertSame( 2, $lines );
    }
}
