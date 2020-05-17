<?php

namespace App\Controller;

use App\Entity\Movie;
use App\Form\MovieType;
use App\Helpers\Pagination\Paginator;
use App\Repository\MovieRepository;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use FOS\RestBundle\Controller\Annotations\View;


class MovieController extends AbstractFOSRestController
{

    private $entityManager;

    private $paginator;

    private $movieRepository;

    private $validator;

    public function __construct(MovieRepository $movieRepository , EntityManagerInterface $entityManager, Paginator $paginator, ValidatorInterface $validator)
    {
        $this->movieRepository = $movieRepository;
        $this->entityManager = $entityManager;
        $this->paginator = $paginator;
        $this->validator = $validator;
    }

    public function getMoviesAction(Request $request)
    {
        $movies = $this->movieRepository->findWithGenreQuery();

        $formatedMovies = $movies;

        // foreach ($movies as $movie) {
        //     $formatedMovies[] = [
        //         'id' => $movie->getId(),
        //         'title' => $movie->getTitle(),
        //         'genres' => $movie->getGenre(),
        //         'ratings' => $movie->getRatings()
        //     ];
        // }

        $data = $this->paginator->paginate(
            $formatedMovies,
            $request->query->getInt('page', 1)
        );


        return $this->view($data, Response::HTTP_OK);
    }

    public function postMovieAction(Request $request)
    {
//        $validator
        $form = $this->createForm(MovieType::class, new Movie());

        $form->submit($request->request->all());

        if(!$form->isValid()) {
            return $this->view($form);
        }

        $this->entityManager->persist($form->getData());
        $this->entityManager->flush();

        return $this->view(['status' => 'true'], Response::HTTP_CREATED);
    }

    public function getMovieAction(Movie $movie) {
        return $this->view($movie, Response::HTTP_OK);
    }

    public function putMovieAction(Request $request,$movie)
    {

        if (!$movie) {
            throw new NotFoundHttpException();
        }

        $form = $this->createForm(MovieType::class, $movie);

        $form->submit($request->request->all());

        if (!$form->isValid()) {
            return $this->view($form);
        }

        $this->entityManager->flush();

        return $this->view(null, Response::HTTP_NO_CONTENT);
    }


    public function patchMovieAction(Request $request, $movie)
    {

        $form = $this->createForm(MovieType::class, $movie);

        $form->submit($request->request->all(), false);

        if (!$form->isValid()) {
            return $this->view($form);
        }

        $this->entityManager->flush();

        return $this->view(null, Response::HTTP_NO_CONTENT);
    }

    public function deleteMovieAction($movie)
    {
        $this->entityManager->remove($movie);
        $this->entityManager->flush();

        return $this->view(null, Response::HTTP_NO_CONTENTF);
    }


}
