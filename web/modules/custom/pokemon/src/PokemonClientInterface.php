<?php

namespace Drupal\pokemon;

/**
 * Interface PokemonClientInterface.
 */
interface PokemonClientInterface {

  /**
   * Get pokemons data.
   *
   * @param int $offset
   *   The request offset.
   * @param int $limit
   *   The request limit.
   *
   * @return array
   *   The pokemons data.
   */
  public function getPokemonData($offset, $limit);

  /**
   * Get pokemon details data.
   *
   * @param string $pokemonName
   *   The pokemon name.
   *
   * @return array
   *   The pokemon data.
   */
  public function getPokemonDetails($pokemonName);

}
