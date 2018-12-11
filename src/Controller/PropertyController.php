<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Property;
use App\Repository\PropertyRepository;


class PropertyController extends AbstractController{

    /**
     *  @var PropertyRepository
     */
    
     private $repository;

    public function __construct(PropertyRepository $repository)
    {
        $this->repository = $repository;
    }
    
    
    /**
     * @Route("/biens", name="property.index")
     * @return Response
     */

    public function index(): Response
    {
        $property = $this->repository->findAllVisible();
        dump($property);

       /* $property=new Property();
        $property->setTitle('Mon premier bien')
                ->setPrice(200000)
                ->setRooms(4)
                ->setBedrooms(3)
                ->setDescription('Une petite description')
                ->setSurface(60)
                ->setFloor(4)
                ->setHeat(1)
                ->setCity('Montpellier')
                ->setAdress('15 Boulevard Gambetta')
                ->setPostalCode('34000');
        $em=$this->getDoctrine()->getManager();
        $em->persist($property);
        $em->flush(); */
                

        return $this->render('property/index.html.twig', ['current_menu'=>'properties']);
    }

     /**
     * @Route("/biens/{slug}-{id}", name="property.show", requirements={"slug": "[a-z0-9\-]*"})
     * @param Property $property
     * @return Response
     */

    public function show(Property $property, string $slug): Response
    {
        if($property->getSlug() !== $slug){
            return $this->redirectToRoute('property.show', [
                'id' => $property->getId(),
                'slug' => $property->getSlug()
            ], 301);
        }
          return $this->render('property/show.html.twig', [ 'property' => $property, 'current_menu' => 'properties']);
    }
}