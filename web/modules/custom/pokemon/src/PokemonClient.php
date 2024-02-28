<?php

namespace Drupal\pokemon;

use GuzzleHttp\ClientInterface;

/**
 * Class Pokemon.
 */
class PokemonClient implements PokemonClientInterface
{
  /**
   * @var \GuzzleHttp\ClientInterface
   */
  protected ClientInterface $httpClient;

  /**
   * Constructs a new PokemonClient object.
   *
   * @param \GuzzleHttp\ClientInterface $httpClient
   */
  public function __construct(ClientInterface $httpClient)
  {
    $this->httpClient = $httpClient;
  }

  /**
   * {@inheritdoc}
   */
  public function getPokemonData($limit = null, $offset = null)
  {
    //TODO: implements logger

    try {
      $response = $this->httpClient->request(
        'GET',
        'https://pokeapi.co/api/v2/pokemon',
        [
          'query' => [
            'offset' => $offset,
            'limit'  => $limit,
          ],
        ]
      );

      if ($response->getStatusCode() != 200) {
        return [];
      }

      $data = json_decode($response->getBody(), true);

      /*$results  = $data->results;
      $pokemons = [];

      if ($results) {
        foreach ($results as $pokemon) {
          $pokemons[] = [
            'name' => $pokemon->name,
          ];
        }
      }*/

      return $data;
    } catch (e) {
      return [];
    }
  }

  /**
   * {@inheritdoc}
   */
  public function getPokemonDetails($pokemonName)
  {
    $request = $this->httpClient->request(
      'GET',
      'https://pokeapi.co/api/v2/pokemon/' . $pokemonName
    );

    if ($request->getStatusCode() != 200) {
      return [];
    }

    $result = json_decode($request->getBody()->getContents());

    $pokemon = [
      'name'            => $result->name,
      'base_experience' => $result->base_experience,
      'height'          => $result->height,
      'weight'          => $result->weight,
    ];

    return $pokemon;
  }

}
