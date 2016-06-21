<?php

namespace Test\AppBundle\Command;


use Doctrine\Common\Proxy\Exception\InvalidArgumentException;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Tester\CommandTester;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use AppBundle\Command\ScraperListCommand;

class ScraperListCommandTest extends KernelTestCase
{
    public function testExecute()
    {
        $expected = [
            'results' => [
                0 => [
                    'title' => "Sainsbury's Apricot Ripe & Ready x5",
                    'size' => "38.3kb",
                    'unit_price' => "3.50",
                    'description' => "Apricots"
                ],
                1 => [
                    'title' => "Sainsbury's Avocado Ripe & Ready XL Loose 300g",
                    'size' => "38.7kb",
                    'unit_price' => "1.50",
                    'description' => "Avocados",
                ],
                2 => [
                    'title' => "Sainsbury's Avocado, Ripe & Ready x2",
                    'size' => "43.4kb",
                    'unit_price' => "1.80",
                    'description' => "Avocados"
                ],
                3 => [
                    'title' => "Sainsbury's Avocados, Ripe & Ready x4",
                    'size' => "38.7kb",
                    'unit_price' => "3.20",
                    'description' => "Avocados"
                ],
                4 => [
                    'title' => "Sainsbury's Conference Pears, Ripe & Ready x4 (minimum)",
                    'size' => "38.5kb",
                    'unit_price' => "1.50",
                    'description' => "Conference"
                ],
                5 => [
                    'title' => "Sainsbury's Golden Kiwi x4",
                    'size' => "38.6kb",
                    'unit_price' => "1.80",
                    'description' => "Gold Kiwi"
                ],
                6 => [
                    'title' => "Sainsbury's Kiwi Fruit, Ripe & Ready x4",
                    'size' => "39kb",
                    'unit_price' => "1.80",
                    'description' => "Kiwi"
                ]
            ]
        ];
        $kernel = $this->createKernel();
        $kernel->boot();

        $productService = $kernel->getContainer()->get('product.service');
        $clientHttp = $kernel->getContainer()->get('guzzle.client');
        $crawlerService = $kernel->getContainer()->get('crawler.service');

        // mock the Kernel or create one depending on your needs
        $application = new Application($kernel);
        $application->add(new ScraperListCommand($productService, $clientHttp, $crawlerService));

        $command = $application->find('get:list');
        $commandTester = new CommandTester($command);
        $commandTester->execute(
            array(
                'url' => 'http://hiring-tests.s3-website-eu-west-1.amazonaws.com/2015_Developer_Scrape/5_products.html',
            )
        );


        $this->assertEquals($expected, json_decode($commandTester->getDisplay(), true));

    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testInvalidUrlExecute()
    {

        $kernel = $this->createKernel();
        $kernel->boot();

        $productService = $kernel->getContainer()->get('product.service');
        $clientHttp = $kernel->getContainer()->get('guzzle.client');
        $crawlerService = $kernel->getContainer()->get('crawler.service');

        // mock the Kernel or create one depending on your needs
        $application = new Application($kernel);
        $application->add(new ScraperListCommand($productService, $clientHttp, $crawlerService));

        $command = $application->find('get:list');
        $commandTester = new CommandTester($command);
        $commandTester->execute(
            array(
                'url' => 'hiring-tests.s3-website-eu-west-1.amazonaws.com/2015_Developer_Scrape/5_products.html',
            )
        );
    }
}