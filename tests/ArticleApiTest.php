<?php
use PHPUnit\Framework\TestCase;

class ArticleApiTest extends TestCase
{
    public function testGetArticlesBySlugUsesSanitizedInput()
    {
        $mockDb = new class {
            public $escapedInput;
            public $queryString;
            public function escape_string($string) {
                $this->escapedInput = $string;
                return 'safe_' . $string;
            }
            public function query($sql) {
                $this->queryString = $sql;
                return new class {
                    public function fetch_assoc() { return null; }
                };
            }
        };

        $api = new ArticleAPI();

        $ref = new ReflectionClass($api);
        $propDb = $ref->getProperty('db');
        $propDb->setAccessible(true);
        $propDb->setValue($api, $mockDb);

        $propConfig = $ref->getProperty('config');
        $propConfig->setAccessible(true);
        $propConfig->setValue($api, (object)['dbprefix' => 'jos_']);

        $api->getArticlesBySlug('example');

        $this->assertEquals('example', $mockDb->escapedInput);
        $this->assertSame(
            "SELECT * FROM jos_content WHERE alias = 'safe_example'",
            $mockDb->queryString
        );
    }
}
