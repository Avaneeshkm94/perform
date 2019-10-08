<?php

namespace Drupal\products\Plugin\rest\resource;

use Drupal\rest\Plugin\ResourceBase;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Drupal\views\Views;
use Drupal\Component\Serialization\Json;
use Drupal\node\Entity\Node;
use Drupal\file\Entity\File;


/**
 * Provides Product Details.
 *
 * @RestResource(
 *   id = "product_details",
 *   label = @Translation("Product Details"),
 *   uri_paths = {
 *     "canonical" = "/api/v1/ProductDetails",
 *     "https://www.drupal.org/link-relations/create" = "/api/v1/ProductDetails"
 *   }
 * )
 */


class ProductDetails extends ResourceBase {

  /**
   * Rest resource for product Details.
   *
   * @param \Symfony\Component\HttpFoundation\Request $request
   *   Rest resource query parameters.
   *
   * @return \Drupal\rest\ResourceResponse
   *   Json response.
   */
  public function post(array $data) {

    $market = $this->get_market_id($data['market']);
    if (!$market) {
      return new JsonResponse('Market not exist', 422);
    }
    $node = Node::create([
      'type'        => 'products',
      'title'       => $data['title'],
      'field_subtitle' => $data['subTitle'],
      'body' => $data['body'],
      'field_markets' => [
        'target_id' => $market
      ]
    ]);
    $node->save();

    return new JsonResponse('Node created', 200);
  }

  public function get_market_id($name) {
    $query = \Drupal::database()->select('taxonomy_term_field_data', 't');
    $query->condition('t.name', $name, '=');
    $query->fields('t', ['tid']);
    $result = $query->execute()->fetchField();
    if (empty($result)) {
      return FALSE;
    }

    return $result;
  }

}
