<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\ProductType;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/product")
 */
class ProductController extends AbstractController
{
    /**
     * @Route("/", name="product_index", methods={"GET"})
     */
    public function index(ProductRepository $productRepository): Response
    {
        return $this->render('product/index.html.twig', [
            'products' => $productRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="product_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $product = new Product();
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

             //traitment de photo
             $photo = $form->get('photo')->getData();

             // On génère un nouveau nom de fichier
             $photoName = md5(uniqid()).'.'.$photo->guessExtension();

             // On copie le fichier dans le dossier uploads
             $photo->move(
                 $this->getParameter('images_directory'),
                 $photoName
             );

             // On crée l'image dans la base de données
             $product->setPhoto($photoName);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($product);
            $entityManager->flush();

            return $this->redirectToRoute('product_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('product/new.html.twig', [
            'product' => $product,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="product_show", methods={"GET"})
     */
    public function show(Product $product): Response
    {
        return $this->render('product/show.html.twig', [
            'product' => $product,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="product_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Product $product): Response
    {
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {


            //traitment de photo
            $photo = $form->get('photo')->getData();

            if ($photo) {
                // On supprime le fichier
                $path = $this->getParameter('images_directory').'/'. $product->getPhoto();
                if(is_file($path))
                unlink($path);

                // On génère un nouveau nom de fichier
                $photoName = md5(uniqid()).'.'.$photo->guessExtension();

                // On copie le fichier dans le dossier uploads
                $photo->move(
                    $this->getParameter('images_directory'),
                    $photoName
                );

                $product->setPhoto($photoName);
            }
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('product_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('product/edit.html.twig', [
            'product' => $product,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="product_delete", methods={"POST"})
     */
    public function delete(Request $request, Product $product): Response
    {
        if ($this->isCsrfTokenValid('delete'.$product->getId(), $request->request->get('_token'))) {

            //traitment de photo
            //On récupère le nom
            $photo = $product->getPhoto();

            if ($photo) {
                // On supprime le fichier
                $path = $this->getParameter('images_directory').'/'. $photo;
                if(is_file($path))
                unlink($path);
            }

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($product);
            $entityManager->flush();
        }

        return $this->redirectToRoute('product_index', [], Response::HTTP_SEE_OTHER);
    }
}
