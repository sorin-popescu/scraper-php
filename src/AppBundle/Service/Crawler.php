<?php

namespace AppBundle\Service;


use Symfony\Component\DomCrawler\Crawler as CrawlerClient;

class Crawler
{
    private $crawler;

    public function __construct(CrawlerClient $crawler)
    {
        $this->crawler = $crawler;
    }
    
    public function getElement($content, $element, array $extract)
    {
        $crawler = new $this->crawler;
        $crawler->addContent($content);
        $elementContent = $crawler->filter($element)->extract($extract);

        return $elementContent;
    }
}