<?php
/**
 * Copyright (C) 2020 Cape Morris Sp. z o.o. - All Rights Reserved
 */

namespace App\Controller;

use App\Query\Schedule\CurlSchedule;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @author Hubert Sosiński <h.sosinski@361.sh>
 */
class ApiController extends AbstractController
{
    /**
     * @Route("/api", methods={"GET"})
     * @param CurlSchedule $schedule
     * @return Response
     */
    public function index(CurlSchedule $schedule)
    {
        return new JsonResponse($schedule->execute());
    }
}