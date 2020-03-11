<?php
/**
 * Copyright (C) 2020 Cape Morris Sp. z o.o. - All Rights Reserved
 */


namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @author Hubert Sosiński <h.sosinski@361.sh>
 */
class IndexController extends AbstractController
{
    /**
     * @Route("/")
     */
    public function index()
    {
        return $this->render('base.html.twig');
    }
}