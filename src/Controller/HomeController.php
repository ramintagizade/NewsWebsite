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
        $data = [];
        $this->getAllDates();
        return $this->render('index.html.twig', ["news" => $data]);
    }

    /**
     * @Route("/business", name="business")
     */
    public function business(Request $request) : Response {

        $data = [];
        return $this->render('business.html.twig', ["news" => $data]);
    }

    /**
     * @Route("/entertainment" , name="entertainment")
     */
    public function entertainment(Request $request) : Response {
        $data = [];
        return $this->render('entertainment.html.twig', ["news" => $data]);
    }

    /**
     * @Route("/health" , name = "health")
     */
    public function health(Request $request) : Response {
        $data = [];
        return $this->render("health.html.twig", ["news" => $data]);
    }

    /**
     * @Route("/science", name = "science")
     */
    public function science(Request $request) : Response {
        $data = [];
        return $this->render("science.html.twig", ["news" => $data]);
    }

    /**
     * @Route("/sports", name = "sports")
     */
    public function sports(Request $request) : Response {
        $data = [];
        return $this->render("sports.html.twig", ["news" => $data]);
    }

    /**
     * @Route("/technology", name = "technology")
     */
    public function technology(Request $request) : Response {
        $data = [];
        return $this->render("technology.html.twig", ["news" => $data]);
    }

    /**
     * @Route("/page/{next_page}" , name="page" )
     */
    public function page($next_page) {
        
        $data = $this->send_request($next_page);
        return $this->render("index.html.twig", ["news" => $data]);
    }

    public function sortDates() {
        // this is just an example 
        $arr = array('2011-01-02', '2011-02-01', '2011-03-02', '2011-02-04', '2011-01-07');    
        
        usort($arr, function ($a, $b) {
            return strtotime($a) - strtotime($b);
        });
        print_r($arr);
    }

    public function getAllDates() {
        $this->entityManager = $this->getDoctrine()->getManager();
        $dateRepository = $this->entityManager->getRepository(Dates::class);
        $dates = $dateRepository->findAllDates();
        //echo implode(', ', $dates);
        print_r($dates);
        return $dates;
    }
    



}


?>