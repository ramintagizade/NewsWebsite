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
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\News;
use Symfony\Component\Validator\Constraints\DateTime;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;

class FetchDataController extends AbstractController {
    /**
     * @Route("/fetchData" , name="fetch")
     */
    public function fetch() : Response {

        $logger = new Logger("FetchData");
        
        if ($this->isDataLoading()) {
            return new Response("InProgress", Response::HTTP_OK);  
        }

        $logger->info("received a request");

        $next_page = 1;
        $httpClient = HttpClient::create();
        $categories = ["general", "business", "entertainment","health","science","sports","technology"];
        // loop through the categories array and fetch for each category 
        print ("sending request ..." ); 
        $response = $httpClient->request('GET', 'https://newsapi.org/v2/top-headlines?page='.$next_page.'&country=us&category=general&apiKey=d60756acb1ff49248d829c1635cca29e');

        $statusCode = $response->getStatusCode();
       

        if ($statusCode == 200) {

            print("status ".$statusCode);
            $content = $response->getContent();
            $content = json_decode($content);
            $articles = $content->articles;
            $totalResults = $content->totalResults;
            $pages = ceil($totalResults/20);

            $len = count($articles);

            
    
            //id, title, description, url, urlToImage, publishedAt

            for($i=0;$i<$len;$i++) {
                $news = new News();
                $title = $articles[$i]->title;
                $description = $articles[$i]->description;
                $url = $articles[$i]->url;
                $urlToImage = $articles[$i]->urlToImage;
                $publishedAt = new \DateTime($articles[$i]->publishedAt);
                
                if ($title == NULL || $description == NULL || $url == NULL || $urlToImage==NULL || $publishedAt==NULL) {
                    continue;
                }

                $news->setTitle($title);
                $news->setDescription($description);
                $news->setUrl($url);
                $news->setUrlToImage($urlToImage);
                $news->setPublishedAt($publishedAt);
                $news->setCategory($categories[0]);
                $manager = $this->getDoctrine()->getManager();
                try {
                    $manager->persist($news);
                    $manager->flush();
                }
                catch (UniqueConstraintViolationException  $e){
                    $manager = $this->getDoctrine()->resetManager();
                    $logger->error($e);
                }
            }
            // $title, $publishedAt, $category
            $this->entityManager = $this->getDoctrine()->getManager();
            $newsRepository = $this->entityManager->getRepository(News::class);
            $news = $newsRepository->findByTitleDateCategory("title", "2020-04-02", "general");
            $logger->info($news);
            for($i=2;$i<=$pages;$i++) {
                $content = $this->sendRequest($i);
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
         return false;
     }

    public function sendRequest($next_page) {
        $httpClient = HttpClient::create();
        $response = $httpClient->request('GET', 'https://newsapi.org/v2/top-headlines?page='.$next_page.'&country=us&category=general&apiKey=d60756acb1ff49248d829c1635cca29e');

        return $response->getContent();

    }
}



?>