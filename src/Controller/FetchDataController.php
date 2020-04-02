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


class FetchDataController extends AbstractController {

    /**
     * @Route("/fetchData" , name="fetch")
     */
    public function fetch() : Response {

        if (isDataLoading()) {
            return new Response("InProgress", Response::HTTP_OK);  
        }

        $next_page = 1;
        $httpClient = HttpClient::create();
        $categories = ["general", "business", "entertainment","health","science","sports","technology"];
        // loop through the categories array and fetch for each category 

        $response = $httpClient->request('GET', 'https://newsapi.org/v2/top-headlines?page='.$next_page.'&country=us&category=general&apiKey=d60756acb1ff49248d829c1635cca29e');

        $statusCode = $response->getStatusCode();
       

        if ($statusCode == 200) {

            print("status ".$statusCode);
            $content = $response->getContent();
            $content = json_decode($content);
            $articles = $content->articles;
            $totalResults = $content->totalResults;
            $pages = ceil($totalResults/20);
            
            
        

            for($i=2;$i<=$pages;$i++) {
                $content = sendRequest($i);
                $content = json_decode($content);
                $articles = $content->articles;

            }

            return new Response("OK", Response::HTTP_OK);
        }
        else {
            return new Response('Data not available', Response::HTTP_NOT_FOUND);
        }
    }

    public function saveByCategory($articles , $category) {
        $len = count($articles);
        for($i=0;$i<$len;$i++) {
            // then call the mysql db to store the data 
        }
    }

    /**
     * @Route("/checkLoadingStatus", name="loading")
     */

     public function checkLoadingStatus() {
        // check the mysql table to load new status , because sending requests for new data
        // would make the fetching procedure freeze or override
        
     }

     public function isDataLoading() {
         // load from database either true or false
         return true;
     }

    public function sendRequest($next_page) {
        $httpClient = HttpClient::create();
        $response = $httpClient->request('GET', 'https://newsapi.org/v2/top-headlines?page='.$next_page.'&country=us&category=general&apiKey=d60756acb1ff49248d829c1635cca29e');

        return $response->getContent();

    }
}



?>