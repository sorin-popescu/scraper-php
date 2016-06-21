<?php

namespace Test\AppBundle\Service;


use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\DomCrawler\Crawler as CrawlerClient;

class CrawlerTest extends KernelTestCase
{
    private $content;

    public function setUp()
    {
        $this->content = $this->getHtml();

        parent::setUp();
    }

    public function testGetElements()
    {
        $kernel = $this->createKernel();
        $kernel->boot();

        $crawlerService = $kernel->getContainer()->get('crawler.service');

        $h1 = $crawlerService->getElement($this->content,'h1',['_text'])[0];
        $h2 = $crawlerService->getElement($this->content,'h2',['_text'])[0];
        $p = $crawlerService->getElement($this->content,'p',['_text'])[0];

        $this->assertSame('This is a test website.', $h1);
        $this->assertSame('This is a second title of the test website', $h2);
        $this->assertSame('This is a paragraph.', $p);
    }

    private function getHtml()
    {
        return <<<HTML
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Test Website</title>
</head>

<body>
        <h1>This is a test website.</h1>
        <h2>This is a second title of the test website</h2>
        <p>This is a paragraph.</p>
    
</body>
</html>
HTML;
    }
}