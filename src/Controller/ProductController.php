<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 07.08.2018
 * Time: 19:03
 */

namespace App\Controller;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use \RedBeanPHP\R as R;
use App\Controller\HomeController;


class ProductController extends AbstractController
{







    /**
     * @Route("/{product_slug}.html")
     *
     */
    public function index($product_slug)
    {

        R::setup('mysql:host=localhost;dbname=pilpos-tz',
            'root', '');

        $product = R::getAll("SELECT * FROM products WHERE alias = '$product_slug'");




        return $this->render("product.html.twig",[
            'title' => ucwords(str_replace('', ' ', $product_slug)),
            'product' => $product,
            'categories' => ProductController::getAllCategories()
        ]);
    }





    public function getAllCategories() :array {

        $em = $this->getDoctrine()->getManager();
        $categories = $em->getRepository('App\Entity\Category')
            ->findAll();

        return  $categories;

    }
}






























