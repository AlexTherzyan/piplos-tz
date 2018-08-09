<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 07.08.2018
 * Time: 19:03
 */

namespace App\Controller;


use App\Entity\Category;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Products;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Controller\HomeController;
use \RedBeanPHP\R as R;




class CategoryController extends AbstractController
{


    /**
     * @Route("/cat-{category_slug}", name="category")
     *
     */
    public function index($category_slug)
    {


        R::setup('mysql:host=localhost;dbname=pilpos-tz',
            'root', '');
        $productFromCategory = R::getAll("SELECT * FROM category
     JOIN products ON products.category_id = category.id AND category.alias = '$category_slug'");
        R::close();


        return $this->render("category.html.twig", [
            'title' => ucwords(str_replace('', ' ', $category_slug)),
            'products' => $productFromCategory,
            'categories' => CategoryController::getAllCategories()

        ]);
    }




    public function getAllCategories() :array {

        $em = $this->getDoctrine()->getManager();
        $categories = $em->getRepository('App\Entity\Category')
            ->findAll();

        return  $categories;

    }



}