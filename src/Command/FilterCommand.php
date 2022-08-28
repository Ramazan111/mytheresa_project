<?php

namespace App\Command;

use App\Controller\ProductController;
use App\Controller\ProductsController;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'load:products',
    description: 'Used to filter products by {category}',
)]
class FilterCommand extends Command
{
    private $product;

    public function __construct(ProductController $product)
    {
        $this->product = $product;

        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $saved = $this->product->createProduct();

        $io->success($saved);

        return Command::SUCCESS;
    }
}
