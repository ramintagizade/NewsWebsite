<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpClient\HttpClient;
use Psr\Log\LoggerInterface;
use Psr\Log\AbstractLogger;
use Monolog\Logger;
use App\Entity\News;
use App\Entity\Dates;
use App\Service\HomeService;
use App\Service\BusinessService;
use App\Service\EntertainmentService;
use App\Service\HealthService;
use App\Service\ScienceService;
use App\Service\SportsService;
use App\Service\TechnologyService;
use App\Service\SearchService;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\EntityManagerInterface;

class IndexController extends AbstractController {

     /**
     * @Route("/", name="index")
     */
    public function index(Request $request) : Response
    {   
        $page = $request->query->get("page");
        $page = intval($page);
        $em = $this->getDoctrine()->getManager();
        $homeService = new HomeService($em);
        $data = $homeService->getHomeNews($page);

        return $this->render('index.html.twig', ["news" => $data]);
    }

    /**
     * @Route("/business", name="business")
     */
    public function business(Request $request) : Response {
        $page = $request->query->get("page");
        $page = intval($page);

        $em = $this->getDoctrine()->getManager();
        $businessService = new BusinessService($em);
        $data = $businessService->getBusinessNews($page);

        return $this->render('business.html.twig', ["news" => $data]);
    }

    /**
     * @Route("/entertainment" , name="entertainment")
     */
    public function entertainment(Request $request) : Response {
        $page = $request->query->get("page");
        $page = intval($page);

        $em = $this->getDoctrine()->getManager();
        $entertainmentService = new EntertainmentService($em);
        $data = $entertainmentService->getEntertainmentNews($page);
        return $this->render('entertainment.html.twig', ["news" => $data]);
    }

    /**
     * @Route("/health" , name = "health")
     */
    public function health(Request $request) : Response {
        $page = $request->query->get("page");
        $page = intval($page);

        $em = $this->getDoctrine()->getManager();
        $healthService = new HealthService($em);
        $data = $healthService->getHealthNews($page);
        return $this->render("health.html.twig", ["news" => $data]);
    }

    /**
     * @Route("/science", name = "science")
     */
    public function science(Request $request) : Response {
        $page = $request->query->get("page");
        $page = intval($page);

        $em = $this->getDoctrine()->getManager();
        $scienceService = new ScienceService($em);
        $data = $scienceService->getScienceNews($page);
        return $this->render("science.html.twig", ["news" => $data]);
    }

    /**
     * @Route("/sports", name = "sports")
     */
    public function sports(Request $request) : Response {
        $page = $request->query->get("page");
        $page = intval($page);

        $em = $this->getDoctrine()->getManager();
        $sportsService = new SportsService($em);
        $data = $sportsService->getSportsNews($page);
        return $this->render("sports.html.twig", ["news" => $data]);
    }

    /**
     * @Route("/technology", name = "technology")
     */
    public function technology(Request $request) : Response {
        $page = $request->query->get("page");
        $page = intval($page);

        $em = $this->getDoctrine()->getManager();
        $technologyService = new TechnologyService($em);
        $data = $technologyService->getTechnologyNews($page);
        return $this->render("technology.html.twig", ["news" => $data]);
    }

    /**
     * @Route("/search" , name="search")
     */
    public function search(Request $request) : Response {
        $page = $request->query->get("page");
        $page = intval($page);
        $query = $request->query->get("q");

        $em = $this->getDoctrine()->getManager();
        $searchService = new SearchService($em);
        $data = $searchService->getSearchNews($page,$query);
        return $this->render("search.html.twig", ["news" => $data]);
    }

}


?>