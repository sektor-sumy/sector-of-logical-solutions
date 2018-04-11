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

/**
 * Class UserController
 */
class UserController extends FOSRestController
{
    /**
     * Get all users.
     *
     * Get users.
     *
     * @Rest\Get("/user")
     *
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
     *
     * @return \AppBundle\Entity\Page[]|User[]|array|View
     */
    public function getAction()
    {
        $restResult = $this->getDoctrine()->getRepository(User::class)->findAll();

        if (null === $restResult) {
            return new View("there are no users exist", Response::HTTP_NOT_FOUND);
        }

        return $restResult;
    }

    /**
     * Get user by id.
     *
     * Get user.
     *
     * @Rest\Get("/user/{id}")
     *
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
     *
     * @param string $id
     *
     * @return User|View|null|object
     */
    public function idAction($id)
    {
        $singleResult = $this->getDoctrine()->getRepository(User::class)->find($id);

        if (null === $singleResult) {
            return new View("user not found", Response::HTTP_NOT_FOUND);
        }

        return $singleResult;
    }

    /**
     * add user???
     *
     * Get user.
     *
     * @Rest\Post("/user")
     *
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
     *
     * @param Request $request
     *
     * @return View
     */
    public function postAction(Request $request)
    {
        $user = new User();
        $name = $request->get('name');

        if ((empty($name)) || (empty($role))) {
            return new View("NULL VALUES ARE NOT ALLOWED", Response::HTTP_NOT_ACCEPTABLE);
        }

        $user->setUsername($name);

        $em = $this->getDoctrine()->getManager();
        $em->persist($user);
        $em->flush();

        return new View("User Added Successfully", Response::HTTP_OK);
    }
}
