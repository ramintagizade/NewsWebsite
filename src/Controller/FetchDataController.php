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
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\News;
use App\Entity\Dates;
use Symfony\Component\Validator\Constraints\DateTime;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use App\Service\DateFormatFunction;

class FetchDataController extends AbstractController {
    
    private $log;
    
    public function __construct() {
        $this->log = new Logger("FetchDataController");
    }

    /**
     * @Route("/fetchData" , name="fetch")
     */
    public function fetch() {
        
        $current_date  = new \DateTime();
        $current_date = DATE_FORMAT($current_date, 'Y-m-d');

        if ($this->isDateExists($current_date)) {
            return new Response('Data exists', Response::HTTP_NOT_FOUND);
        }
    
        $categories = ["general", "business", "entertainment","health","science","sports","technology"];
        $have_read = FALSE;
        foreach($categories as $category) {
            $httpClient = HttpClient::create();
            $next_page = 1;
            $response = $httpClient->request('GET', 'https://newsapi.org/v2/top-headlines?page='.$next_page.'&country=us&category='.$category.'&apiKey=d60756acb1ff49248d829c1635cca29e');
            $statusCode = $response->getStatusCode();
            if ($statusCode == 200) {
                $have_read = TRUE;
                $content = $response->getContent();
                $content = json_decode($content);
                $articles = $content->articles;
                $totalResults = $content->totalResults;
                $pages = ceil($totalResults/20);

                $this->saveByCategory($articles, $category);
                $this->entityManager = $this->getDoctrine()->getManager();
                $newsRepository = $this->entityManager->getRepository(News::class);
                //$news = $newsRepository->findByTitleDateCategory("title", "2020-04-02", "general");
                
                /* cut this data of , as we need first page of every news
                for($i=2;$i<=$pages;$i++) {
                    $content = $this->sendRequest($i,$category);
                    $content = json_decode($content);
                    $articles = $content->articles;
                    $this->saveByCategory($articles, $category);
                }
                */
            }
           
        }

        if($have_read) {
            return new Response("OK", Response::HTTP_OK);
        }
        else {
            return new Response('Data not available', Response::HTTP_NOT_FOUND);
        }
            
    }

    public function isDateExists(string $date) {
       
        $this->entityManager = $this->getDoctrine()->getManager();
        $dateRepository = $this->entityManager->getRepository(Dates::class);
        $exists = $dateRepository->findDate($date);

        return $exists;
    }

    public function saveDate($date) {
        $manager = $this->getDoctrine()->getManager();
        $new_date = new Dates();
        $new_date->setDate($date);

        try {
            $manager->persist($new_date);
            $manager->flush();
        }
        catch (UniqueConstraintViolationException  $e){
            $manager = $this->getDoctrine()->resetManager();
        }
        catch (\DBALException $e) {
            
        } catch (\PDOException $e) {
           
        } catch (\ORMException $e) {
            
        } catch (\Exception $e) {
            
        }

    }

    public function saveByCategory($articles , $category) {
        $len = count($articles);
        $manager = $this->getDoctrine()->getManager();
        $save_dates = array();
        for($i=0;$i<$len;$i++) {
            $news = new News();
            $title = $articles[$i]->title;
            $description = $articles[$i]->description;
            $url = $articles[$i]->url;
            $urlToImage = $articles[$i]->urlToImage;
            $publishedAt = new \DateTime($articles[$i]->publishedAt);
            $new_date = $publishedAt->format("Y-m-d");
            $publishedAt = new \DateTime($new_date);
            if ($urlToImage == NULL) {
                $urlToImage = "static/image.png";
            }
            if ($title == NULL || $description == NULL || $url == NULL || $publishedAt==NULL) {
                continue;
            }

            $news->setTitle($title);
            $news->setDescription($description);
            $news->setUrl($url);
            $news->setUrlToImage($urlToImage);
            $news->setPublishedAt($publishedAt);
            $news->setCategory($category);
            
            if(!in_array($new_date, $save_dates)) {
                array_push($save_dates, $new_date);
            }
            try {
                $manager->persist($news);
            }
            catch (UniqueConstraintViolationException  $e){
                $this->log->info($e);
                $manager = $this->getDoctrine()->resetManager();
            }
            catch (\DBALException $e) {
                $this->log->info($e);
                $manager = $this->getDoctrine()->resetManager();
            } catch (\PDOException $e) {
                $this->log->info($e);
                $manager = $this->getDoctrine()->resetManager();
            } catch (\ORMException $e) {
                $this->log->info($e);
                $manager = $this->getDoctrine()->resetManager();
            } catch (\Exception $e) {
                $this->log->info($e);
                $manager = $this->getDoctrine()->resetManager();
            }
        }
        try {
           $manager->flush();
           $manager->clear();
        }
        catch (UniqueConstraintViolationException  $e){
            $this->log->info($e);
            $manager = $this->getDoctrine()->resetManager();
        }
        catch (\DBALException $e) {
            $this->log->info($e);
            $manager = $this->getDoctrine()->resetManager();    
        } catch (\PDOException $e) {
            $this->log->info($e);
            $manager = $this->getDoctrine()->resetManager();
        } catch (\ORMException $e) {
            $this->log->info($e);
            $manager = $this->getDoctrine()->resetManager();
        } catch (\Exception $e) {
            $this->log->info($e);
            $manager = $this->getDoctrine()->resetManager();
        }
        
        usort($save_dates, function ($a, $b) {
            return strtotime($a) - strtotime($b);
        });

        $len = count($save_dates);
        for($i=0;$i<$len;$i++) {
            if(!$this->isDateExists($save_dates[$i]))
               $this->saveDate($save_dates[$i]);
        }
    }

    public function sendRequest($next_page, $category) {
        $httpClient = HttpClient::create();
        $response = $httpClient->request('GET', 'https://newsapi.org/v2/top-headlines?page='.$next_page.'&country=us&category='.$category.'&apiKey=d60756acb1ff49248d829c1635cca29e');

        return $response->getContent();

    }
}



?>
