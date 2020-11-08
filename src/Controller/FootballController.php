<?php

namespace Drupal\acme_football\Controller;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Component\Serialization\Json;
use Drupal\Core\Cache\CacheBackendInterface;
use Drupal\Component\Utility;
use GuzzleHttp\Client;

/**
 * Class FootballController.
 */
class FootballController extends ControllerBase {


  /**
   * Gets football grid.
   *
   * @param string $api_key
   *   The API Key.
   * @param string $api_endpoint
   *   The API endpoint URL.
   *
   * @return array $grid
   *   An associative array of teams.
   * @throws \GuzzleHttp\Exception\GuzzleException
   */
  public function getFootballGrid($api_key, $api_endpoint) {
    $utility = new \Drupal\Component\Utility\Html();
    $client = new \GuzzleHttp\Client;
    $grid = [];

    if ($cache = \Drupal::cache()->get('acme_football_grid')) {
      \Drupal::logger('acme_football_grid')->notice('used cached data');
      $team_data = $cache->data;
    } else {
      $request = $client->request('GET', $api_endpoint . '?api_key=' . $api_key);
      if ($request->getStatusCode() === 200) {
        \Drupal::logger('acme_football_grid')->notice('fetched new data from ' . $api_endpoint);
        $team_data_response = $request->getBody();
        $team_data = Json::decode($team_data_response);
        \Drupal::cache()->set('acme_football_grid', $team_data, CacheBackendInterface::CACHE_PERMANENT);
      }
    }
        // populate the grid
    if (isset($team_data['results']['data']['team'])) {
      $grid['content'] = $team_data['results']['data']['team'];
      // build the filters
      $grid['filters']['conference'] = [];
      $grid['filters']['division'] = [];
      foreach ($grid['content'] as $k => $team) {
        // conference filter
        $conference_slug = $utility::cleanCssIdentifier($team['conference']);
        $grid['content'][$k]['conference_slug'] = $conference_slug;
        $grid['filters']['conference'][$conference_slug] = $team['conference'];
        // division filter
        $division_slug = $utility::cleanCssIdentifier($team['division'] . ' division');
        $grid['content'][$k]['division_slug'] = $division_slug;
        $grid['filters']['division'][$division_slug] = $team['division'];
      }
    }



    return $grid;

  }

}
