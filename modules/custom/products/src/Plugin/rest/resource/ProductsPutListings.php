<?php

namespace Drupal\products\Plugin\rest\resource;

use Drupal\rest\Plugin\ResourceBase;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Drupal\Component\Serialization\Json;
use Drupal\node\Entity\Node;


/**
 * Provides Product Put.
 *
 * @RestResource(
 *   id = "products_put",
 *   label = @Translation("Products Put"),
 *   uri_paths = {
 *     "canonical" = "/api/v1/ProductsPutListings/{id}"
 *   }
 * )
 */


class ProductsPutListings extends ResourceBase {

  /**
   * Rest resource for product Details.
   *
   * @param \Symfony\Component\HttpFoundation\Request $request
   *   Rest resource query parameters.
   *
   * @return \Drupal\rest\ResourceResponse
   *   Json response.
   */
  public function put(Request $request, $id) {
    $data = Json::decode($request->getContent());
    $node = Node::load($id);
    $node->title = $data['title']['value'];
    $node->save();

    return new JsonResponse('Node Updated', 200);
  }


}
