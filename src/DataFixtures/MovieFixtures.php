<?php

namespace App\DataFixtures;

use App\Entity\Movie;
use App\Repository\GenreRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use League\Csv\Reader;
use League\Csv\Statement;

class MovieFixtures extends Fixture implements DependentFixtureInterface
{
    /**
     * @var GenreRepository
     */
    private $genreRepository;

    public function __construct(GenreRepository $genreRepository)
    {
        $this->genreRepository = $genreRepository;
    }

    public function load(ObjectManager $manager)
    {
        $reader = Reader::createFromPath('%kernel.root_dir%/../storage/movies.csv');
        $reader->setHeaderOffset(0);
        $stmt = Statement::create()->limit(100);
        $results = $stmt->process($reader)->getRecords();


//        foreach ($results as $offset => $row) {
//
//            $movie = new Movie();
//            $movie->setTitle($row['title']);
//
//            $getAllGenres = $this->getAllGenres($row['genres']);
//
//            foreach ($getAllGenres as $genre) {
//                $movie->addGenre($genre);
//            }
//
//            $manager->persist($movie);
//            $manager->flush();
//
//        }



    }

    private function getAllGenres($genres): array
    {
        $genres = explode('|', $genres);

        $genresObjects = [];

        foreach ($genres as $g) {
            if(null !== $genre = $this->genreRepository->findOneBy(['name' => $g])) {
                $genresObjects[] = $genre;
            }
        }

        return $genresObjects;


    }

    /**
     * This method must return an array of fixtures classes
     * on which the implementing class depends on
     *
     * @return class-string[]
     */
    public function getDependencies()
    {
        return [
            GenreFixtures::class
        ];
    }
}
