<?php

namespace Drupal\products\Plugin\rest\resource;

use Drupal\rest\Plugin\ResourceBase;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Drupal\views\Views;
use Drupal\Component\Serialization\Json;


/**
 * Provides a product listings resource.
 *
 * @RestResource(
 *   id = "product_listings",
 *   label = @Translation("Product Listings"),
 *   uri_paths = {
 *     "canonical" = "/api/v1/productListings"
 *   }
 * )
 */
class ProductListings extends ResourceBase {

  /**
   * Rest resource for product listings.
   *
   * @param \Symfony\Component\HttpFoundation\Request $request
   *   Rest resource query parameters.
   *
   * @return \Drupal\rest\ResourceResponse
   *   Json response.
   */
  public function get(Request $request) {
    $view = Views::getView('product_listing');
    $view->setDisplay('rest_export_products_listing');
    $view->execute();
    $view_result = \Drupal::service('renderer')->renderRoot($view->render());
    $view_results = JSON::decode($view_result->jsonSerialize(), TRUE);
    $view_results = JSON::encode($view_results, TRUE);

    return new JsonResponse($view_results, 200, [], TRUE);
  }
}
