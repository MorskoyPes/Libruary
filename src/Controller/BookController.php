<?php 
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Book;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class BookController extends AbstractController
{
	/**
	 * @Route("/form", name="form")
	 */
	public function testAction(Request $request)
	{
		$form = $this->createForm('App\Form\FormCreate');

		$form->handleRequest($request);

		$formData = $form->getData();

		if (!empty($formData)) {
			$product = new Book();
			$product->setName($formData["name"]);
	        $product->setYear($formData["year"]);
	        $product->setAuthor($formData["author"]);

			$entityManager = $this->getDoctrine()->getManager();
			$entityManager->persist($product);
			$entityManager->flush();
		}

		return $this->render('form.html.twig', array(
			'form' => $form->createView()
		));
	}
/**
 * @Route("/product", name="product_show")
 */
	public function show()
	{
	  $repository = $this->getDoctrine()->getRepository(Book::class);
	  $products = $repository->findAll();

	    if (!$products) {
	        throw $this->createNotFoundException(
	            'No book found for id '
	        );
	    }
	    return $this->render('show.html.twig', ['products' => $products]);
	}
	/**
	 * @Route("/product/edit/{id}")
	 */
	public function update($id, Request $request)
	{
		$form = $this->createForm('App\Form\FormCreate');

		$form->handleRequest($request);

		$entityManager = $this->getDoctrine()->getManager();
	    $product = $entityManager->getRepository(Book::class)->find($id);

		$formData = $form->getData();

		if (empty($formData)){
			$form->setData(array(
			"name" => $product->getName(), 
			"year" => $product->getYear(), 
			"author" => $product->getAuthor()));
		}

		if (!empty($formData)) {
			$product->setName($formData["name"]);
	        $product->setYear($formData["year"]);
	        $product->setAuthor($formData["author"]);
			$entityManager->flush();
		}
			
	    if (!$product) {
	        throw $this->createNotFoundException(
	            'No product found for id '.$id
	        );
	    }
	     return $this->render('form.html.twig', array(
		 	'form' => $form->createView()
		 ));
	}
}

 ?>