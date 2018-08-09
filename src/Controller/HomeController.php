<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 07.08.2018
 * Time: 18:24
 */

namespace App\Controller;

use App\Entity\About;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class HomeController extends AbstractController
{


    /**
     * @Route("/")
     */
    public function index()
    {


        return $this->render("base.html.twig",[
            'categories' =>   HomeController::getAllCategories(),

        ]);

    }


    /**
     * @Route("/about", name="about")
     */
    public function about()
    {

        $post = null;

        if (isset($_POST['send']))
        {
            $post = htmlspecialchars($_POST['email']);

            $about = new About();

            $about->setEmail($_POST['email']);
            $about->setName($_POST['name']);
            $about->setPhone($_POST['phone']);
            $about->setText($_POST['text']);

            $em = $this->getDoctrine()->getManager();
            $em->persist($about);
            $em->flush();
        }




        return $this->render("about.html.twig",[
            'post' => $post,
            'categories' =>  HomeController::getAllCategories(),
        ]);
    }



    public function getAllCategories() :array {

        $em = $this->getDoctrine()->getManager();
        $categories = $em->getRepository('App\Entity\Category')
            ->findAll();

        return  $categories;

    }

}




















