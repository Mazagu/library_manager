<?php 

namespace App\Command;

use App\Repository\BookRepository;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CountBooksCommand extends Command
{
    protected static $defaultName = 'app:count-books';
    protected static $defaultDescription = 'Counts all books in the library.';
    private $bookRepository;

    public function __construct(BookRepository $bookRepository)
    {
        $this->bookRepository = $bookRepository;

        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $totalCopies = $this->bookRepository->countBookCopies();
        $output->writeln([
            'Library Manager',
            '===============',
            'Total books: ' . $totalCopies,
        ]);
        return 1;
    }
}