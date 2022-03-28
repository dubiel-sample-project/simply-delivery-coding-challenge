<?php

namespace App\Controller;

use App\Entity\Item;
use App\Entity\Property;
use App\Repository\ItemRepository;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityNotFoundException;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Annotations as OA;


/**
  * Class ItemsController
  * @package App\Controller
  * @author Tom Dubiel <oconnor7777@gmail.com>
  */
class ItemsController extends AbstractFOSRestController {

    /**
     * @Rest\Get("/items")
	 * @OA\Response(
	 *     response=200,
	 *     description="Returns a list of all items",
	 *     @OA\JsonContent(
	 *        type="array",
	 *        @OA\Items(ref=@Model(type=Item::class, groups={"full"}))
	 *     )
	 * )
     * @return View
     */
    public function getItems(ItemRepository $itemRepository): View
    {
        return View::create($itemRepository->findAll(), Response::HTTP_OK);
    }

    /**
	 * @Rest\Post("/items")
	 * @param Request $request
	 * @OA\Response(
	 *     response=201,
	 *     description="Create a new item",
	 *     @OA\JsonContent(ref=@Model(type=Item::class))
	 * )
	 * @OA\Parameter(
	 *     name="name",
	 *     in="query",
	 *     description="The name of the new item",
	 *     @OA\Schema(type="string")
	 * )
	 *  @OA\Parameter(
	 *     name="price",
	 *     in="query",
	 *     description="The price of the new item",
	 *     @OA\Schema(type="decimal")
	 * )
	 * @return View
	 */
    public function postItem(Request $request, EntityManagerInterface $em): View
    {
        $item = new Item();
        $item->setName($request->get('name'));
        $item->setPrice($request->get('price'));

        $em->persist($item);
        $em->flush();

        return View::create($item, Response::HTTP_CREATED);
    }

    /**
	 * @Rest\Post("/items/{itemId}")
	 * @param Request $request
	 * @OA\Response(
	 *     response=201,
	 *     description="Create a new item property",
	 *     @OA\JsonContent(ref=@Model(type=Item::class))
	 * )
	 * @OA\Parameter(
	 *     name="itemId",
	 *     in="path",
	 *     description="The id of the item",
	 *     @OA\Schema(type="integer")
	 * )
	 * @OA\Parameter(
	 *     name="name",
	 *     in="query",
	 *     description="The name of the new property",
	 *     @OA\Schema(type="string")
	 * )
	 * @return View
	 */
    public function postItemProperty(int $itemId, Request $request, ItemRepository $itemRepository,
        EntityManagerInterface $em): View
    {
        $item = $itemRepository->findOneById($itemId);
        if(!$item)
		{
            throw new EntityNotFoundException(sprintf("Item with id %d not found!", $itemId));
		}

        $item->addProperty(new Property($request->get('name')));

        $em->flush();

        return View::create($item, Response::HTTP_CREATED);
    }

    /**
	 * @Rest\Put("/items/{itemId}")
	 * @param Request $request
	 * @OA\Response(
	 *     response=200,
	 *     description="Updates an existing item",
	 *     @OA\JsonContent(ref=@Model(type=Item::class))
	 * )
	 * @OA\Parameter(
	 *     name="itemId",
	 *     in="path",
	 *     description="The id of the item",
	 *     @OA\Schema(type="integer")
	 * )
	 * @OA\Parameter(
	 *     name="name",
	 *     in="query",
	 *     description="The new name of the item",
	 *     @OA\Schema(type="string")
	 * )
	 * @OA\Parameter(
	 *     name="name",
	 *     in="query",
	 *     description="The new price of the item",
	 *     @OA\Schema(type="decimal")
	 * )
	 * @return View
	 */
    public function putItem(int $itemId, Request $request, ItemRepository $itemRepository,
        EntityManagerInterface $em): View
    {
        $item = $itemRepository->findOneById($itemId);
        if(!$item)
		{
            throw new EntityNotFoundException(sprintf("Item with id %d not found!", $itemId));
		}

        $item->setName($request->get('name'));
		$item->setPrice($request->get('price'));

        $em->flush();

        return View::create($item, Response::HTTP_OK);
    }

    /**
	 * @Rest\Delete("/items/{itemId}")
	 * @param Request $request
	 * @OA\Response(
	 *     response=204,
	 *     description="Deletes an existing item",
	 *     @OA\JsonContent(ref=@Model(type=Item::class))
	 * )
	 * @OA\Parameter(
	 *     name="itemId",
	 *     in="path",
	 *     description="The id of the item",
	 *     @OA\Schema(type="integer")
	 * )
	 * @return View
	 */
    public function deleteItem(int $itemId, ItemRepository $itemRepository,
        EntityManagerInterface $em): View
    {
        $item = $itemRepository->findOneById($itemId);
        if(!$item)
		{
            throw new EntityNotFoundException(sprintf("Item with id %d not found!", $itemId));
		}

        $em->remove($item);
        $em->flush();

        return View::create($item, Response::HTTP_NO_CONTENT);
    }
}