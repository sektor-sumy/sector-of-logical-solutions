<?php

namespace AppBundle\Controller\Api;

use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\View\View;
use AppBundle\Entity\User;
use Nelmio\ApiDocBundle\Annotation\Model;
use Nelmio\ApiDocBundle\Annotation\Security;
use Swagger\Annotations as SWG;
use FOS\RestBundle\Controller\Annotations\Route;



class UserController extends FOSRestController
{
    /**
     * Get all users.
     *
     * Get users.
     *
     * @Rest\Get("/user")
     * @SWG\Response(
     *     response=200,
     *     description="Returns users",
     *     @SWG\Schema(
     *         type="array",
     *         @SWG\Items(
     *             type="object",
     *             @SWG\Property(property="id", type="integer"),
     *             @SWG\Property(property="email", type="string")
     *         )
     *     )
     * )
     * @SWG\Response(
     *     response=404,
     *     description="there are no users exist"
     * )
     * @SWG\Tag(name="User")
     * @param string $slug
     * @return JsonResponse
     */
    public function getAction()
    {
        $restresult = $this->getDoctrine()->getRepository('AppBundle:User')->findAll();
        if ($restresult === null) {
            return new View("there are no users exist", Response::HTTP_NOT_FOUND);
        }
        return $restresult;
    }
    /**
     * Get user by id.
     *
     * Get user.
     *
     * @Rest\Get("/user/{id}")
     * @SWG\Response(
     *     response=200,
     *     description="Return user by id",
     *     @SWG\Schema(
     *         type="array",
     *         @SWG\Items(
     *             type="object",
     *             @SWG\Property(property="id", type="integer"),
     *             @SWG\Property(property="email", type="string")
     *         )
     *     )
     * )
     * @SWG\Response(
     *     response=404,
     *     description="there are no users exist"
     * )
     * @SWG\Tag(name="User")
     * @param string $id
     * @return JsonResponse
     */
    public function idAction($id)
    {
        $singleresult = $this->getDoctrine()->getRepository('AppBundle:User')->find($id);
        if ($singleresult === null) {
            return new View("user not found", Response::HTTP_NOT_FOUND);
        }
        return $singleresult;
    }

    /**
     * add user???
     *
     * Get user.
     *
     * @Rest\Post("/user")
     * @SWG\Response(
     *     response=200,
     *     description="Return user by id",
     *     @SWG\Schema(
     *         type="array",
     *         @SWG\Items(
     *             type="object",
     *             @SWG\Property(property="id", type="integer"),
     *             @SWG\Property(property="email", type="string")
     *         )
     *     )
     * )
     * @SWG\Response(
     *     response=404,
     *     description="there are no users exist"
     * )
     * @SWG\Tag(name="User")
     * @param string $id
     * @return JsonResponse
     */
     public function postAction(Request $request)
     {
         $data = new User;
         $name = $request->get('name');

         if(empty($name) || empty($role))
         {
             return new View("NULL VALUES ARE NOT ALLOWED", Response::HTTP_NOT_ACCEPTABLE);
         }

         $data->setUsername($name);

         $em = $this->getDoctrine()->getManager();
         $em->persist($data);
         $em->flush();

         return new View("User Added Successfully", Response::HTTP_OK);
     }
}
