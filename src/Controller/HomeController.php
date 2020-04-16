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
use App\Service\DataFetcher;
use App\Entity\News;
use App\Entity\Dates;

class HomeController extends AbstractController {

     /**
     * @Route("/", name="index")
     */
    public function index(Request $request) : Response
    {   
        $page = $request->query->get("page");
        $page = intval($page);
        
        $data = [];
        $this->getAllDates();
        $this->getAllNewsByCategoryAndDate("general", "2020-04-06");
        return $this->render('index.html.twig', ["news" => $data]);
    }

    /**
     * @Route("/business", name="business")
     */
    public function business(Request $request) : Response {
        $page = $request->query->get("page");
        $page = intval($page);

        $data = [];
        return $this->render('business.html.twig', ["news" => $data]);
    }

    /**
     * @Route("/entertainment" , name="entertainment")
     */
    public function entertainment(Request $request) : Response {
        $page = $request->query->get("page");
        $page = intval($page);

        $data = [];
        return $this->render('entertainment.html.twig', ["news" => $data]);
    }

    /**
     * @Route("/health" , name = "health")
     */
    public function health(Request $request) : Response {
        $page = $request->query->get("page");
        $page = intval($page);

        $data = [];
        return $this->render("health.html.twig", ["news" => $data]);
    }

    /**
     * @Route("/science", name = "science")
     */
    public function science(Request $request) : Response {
        $page = $request->query->get("page");
        $page = intval($page);

        $data = [];
        return $this->render("science.html.twig", ["news" => $data]);
    }

    /**
     * @Route("/sports", name = "sports")
     */
    public function sports(Request $request) : Response {
        $page = $request->query->get("page");
        $page = intval($page);

        $data = [];
        return $this->render("sports.html.twig", ["news" => $data]);
    }

    /**
     * @Route("/technology", name = "technology")
     */
    public function technology(Request $request) : Response {
        $page = $request->query->get("page");
        $page = intval($page);

        $data = [];
        return $this->render("technology.html.twig", ["news" => $data]);
    }

    public function sortStrArray($arr) {

        usort($arr, function ($a, $b) {
            return strtotime($a) - strtotime($b);
        });
        
        return $arr;
    }

}


?>