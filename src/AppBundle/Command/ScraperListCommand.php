<?php

namespace AppBundle\Command;


use AppBundle\Service\ClientHttp as Client;
use AppBundle\Service\Product as ProductService;
use AppBundle\Entity\Product as ProductEntity;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Exception\InvalidArgumentException;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use AppBundle\Service\Crawler;

class ScraperListCommand extends Command
{
    /**
     * @var Client
     */
    private $client;

    private $crawler;

    private $productService;

    /**
     * ScraperListCommand constructor.
     * @param ProductService $productService
     * @param Client $client
     * @param Crawler $crawler
     */
    public function __construct(ProductService $productService, Client $client, Crawler $crawler)
    {
        $this->client = $client;
        $this->crawler = $crawler;
        $this->productService = $productService;
        parent::__construct();
    }

    const COMMAND_NAME = "get:list";

    protected function configure()
    {
        $this
            ->setName(self::COMMAND_NAME)
            ->setDescription('Scraps given URL')
            ->addArgument(
                'url',
                null,
                InputOption::VALUE_REQUIRED,
                null
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $url = $input->getArgument('url');

        if (filter_var($url, FILTER_VALIDATE_URL) === false) {
            throw new InvalidArgumentException();
        }

        $productContent = $this->client->getContent($url, false);

        $productLinks = $this->crawler->getElement($productContent['body'], '.productInfoWrapper h3 a', ['href']);

        foreach ($productLinks as $link) {

            $productContent = $this->client->getContent($link, true);

            $product = $this->createProduct($productContent);

            $this->productService->addProduct($product);


        }
        $products = $this->productService->getProducts();

        $output->writeln((json_encode($products, JSON_PRETTY_PRINT)));
    }

    /**
     * @param $productContent
     * @return ProductEntity
     */
    private function createProduct($productContent)
    {
        $title = $this->crawler->getElement($productContent['body'], '.productTitleDescriptionContainer h1', ['_text'])[0];
        $price = $this->crawler->getElement($productContent['body'], '.pricePerUnit', ['_text'])[0];
        $description = $this->crawler->getElement($productContent['body'], '.productText p', ['_text'])[0];
        preg_match('!\d+(?:\.\d+)?!',trim($price), $matches);

        $product = new ProductEntity(
            trim($title),
            round($productContent['size'] / 1024, 1).'kb',
            $matches[0],
            trim($description)
        );
        return $product;
    }
}