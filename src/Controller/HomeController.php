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

class HomeController extends AbstractController {

     /**
     * @Route("/", name="index")
     */
    
    public function index(Request $request) : Response
    {   
        $data = [];
        $fetcher = new Logger("channel");
        $fetcher->info("new message here ");
        $time = date('H:i:s');
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

    public function send_request($next_page) {
        
        $httpClient = HttpClient::create();
        $response = $httpClient->request('GET', 'https://newsapi.org/v2/top-headlines?page='.$next_page.'&country=us&category=general&apiKey=d60756acb1ff49248d829c1635cca29e');

        $statusCode = $response->getStatusCode();
       

        if ($statusCode == 200) {

            print("status ".$statusCode);
            $content = $response->getContent();
            $content = json_decode($content);
            $articles = $content->articles;
            return $articles;
        }

        return NULL;
    }

}


?>