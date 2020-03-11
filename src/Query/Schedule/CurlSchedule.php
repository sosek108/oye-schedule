<?php

namespace App\Query\Schedule;

use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\HttpClient\HttpClient;

class CurlSchedule
{
    const VACUNA_URL = 'http://vacuna.casadeoye.pl/grafik_iframe/';
    /**
     * @var \Symfony\Contracts\HttpClient\HttpClientInterface
     */
    private $client;

    /**
     * CurlSchedule constructor.
     */
    public function __construct()
    {
        $this->client = HttpClient::create();
    }

    public function execute()
    {
        $response = $this->client->request('GET', self::VACUNA_URL);

        $content = $response->getContent();

        $crawler = new Crawler($content);

        $response = [];
        /** @var \DOMElement $day */
        foreach ($crawler->filter('.dzien') as $day) {
            $class = $day->attributes->getNamedItem('class')->nodeValue;
            preg_match('/\d/', $class, $match);
            $dayName = $match[0];

            $roomNodes = $day->lastChild->childNodes;
            $rooms = [];
            $dayCourses = [];
            /** @var \DOMElement $roomNode */
            foreach ($roomNodes as $roomNode) {
                if ($roomNode->nodeName === '#text') {
                    continue;
                }
                $roomName = '';
                $courses = [];
                /** @var \DOMElement $courseNode */
                foreach ($roomNode->childNodes as $courseNode) {
                    if ($courseNode->nodeName === '#text') {
                        continue;
                    }
                    $class = $courseNode->attributes->getNamedItem('class');

                    if (strpos($class->nodeValue, 'sala') !== false) {
                        $roomName = $courseNode->nodeValue;
                    } else {

                        $course = [];
                        $course['room'] = $roomName;
                        /** @var \DOMElement $paramNode */
                        foreach ($courseNode->childNodes as $paramNode) {
                            if ($paramNode->nodeName === '#text') {
                                continue;
                            }
                            $class = $paramNode->attributes->getNamedItem('class')->nodeValue;
                            if (strpos($class, 'godzina') !== false) {
                                $course['hour'] = $paramNode->nodeValue;
                            }
                            if (strpos($class, 'typ') !== false) {
                                $course['name'] = $paramNode->nodeValue;
                            }
                            if (strpos($class, 'poziom') !== false) {
                                $course['level'] = $paramNode->nodeValue;
                            }
                            if (strpos($class, 'ktore_zajecia') !== false) {
                                preg_match('/\d+/', $paramNode->nodeValue, $match);
                                $course['classesCount'] = $match[0];
                            }
                            if (strpos($class, 'start_kursu') !== false) {
                                $course['courseStart'] = $paramNode->nodeValue;
                            }
                            if (strpos($class, 'instruktor') !== false) {
                                $course['trainer'] = $paramNode->nodeValue;
                            }
                        }

                        $courses[] = $course;
                    }
                }

                $dayCourses = array_merge($dayCourses, $courses);
            }

            $response[$dayName] = $dayCourses;
        }
        return $response;
    }
}