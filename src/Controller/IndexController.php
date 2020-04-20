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
        //echo json_encode($data[0]);

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

}


?>