<?php

namespace Drupal\products\Plugin\rest\resource;

use Drupal\rest\Plugin\ResourceBase;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Drupal\Component\Serialization\Json;
use Drupal\node\Entity\Node;


/**
 * Provides Product Delete.
 *
 * @RestResource(
 *   id = "product_delete",
 *   label = @Translation("Product Delete"),
 *   uri_paths = {
 *     "canonical" = "/api/v1/ProductsDeleteListings/{id}"
 *   }
 * )
 */


class ProductsDeleteListings extends ResourceBase {

  /**
   * Rest resource for product Details.
   *
   * @param \Symfony\Component\HttpFoundation\Request $request
   *   Rest resource query parameters.
   *
   * @return \Drupal\rest\ResourceResponse
   *   Json response.
   */
  public function delete(Request $request, $id) {
    try {
      $node = Node::load($id);
      $node->delete();
    }
    catch(Exception $e) {
      return new JsonResponse('error', 400);
    }


    return new JsonResponse('Node deleted', 200);
  }


}
