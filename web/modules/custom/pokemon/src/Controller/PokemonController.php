<?php

namespace Drupal\pokemon\Controller;

use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\HtmlCommand;
use Drupal\Core\Ajax\ReplaceCommand;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Pager\PagerManagerInterface;
use Drupal\Core\Pager\PagerParametersInterface;
use Drupal\Core\Render\Renderer;
use Drupal\pokemon\PokemonClient;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class PokemonController.
 */
class PokemonController extends ControllerBase
{
  /**
   * The number of pokemons to display per page.
   */
  const POKEMON_PER_PAGE = 20;

  /**
   * @var PokemonClient
   *  The pokemon client object.
   */
  protected PokemonClient $pokemonClient;

  /**
   * @var PagerManagerInterface
   *  The Drupal pager.
   */
  protected PagerManagerInterface $pagerManager;

  /**
   * @var PagerManagerInterface
   *  The Drupal pager informations.
   */
  protected PagerParametersInterface $pagerParameters;

  protected Renderer $renderer;

  /**
   * PokemonController constructor.
   *
   * @param \Drupal\pokemon\PokemonClient $pokemonClient
   */
  public function __construct(
    PokemonClient $pokemonClient,
    PagerManagerInterface $pagerManager,
    PagerParametersInterface $pagerParameters,
    Renderer $renderer

  ) {
    $this->pokemonClient   = $pokemonClient;
    $this->pagerManager    = $pagerManager;
    $this->pagerParameters = $pagerParameters;
    $this->renderer        = $renderer;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container)
  {
    return new static(
      $container->get('pokemon_client'),
      $container->get('pager.manager'),
      $container->get('pager.parameters'),
      $container->get('renderer'),
    );
  }

  /**
   * Pokemons route callback.
   */
  public function showPokemons(Request $request)
  {
    //TODO: implements drupal settings

    // Pager implementation.
    // Get the current pager page.
    $currentPage = $this->pagerParameters->findPage();
    $offset      = self::POKEMON_PER_PAGE * $currentPage;
    $pokemons    = $this->pokemonClient->getPokemonData(self::POKEMON_PER_PAGE, $offset);
    $totalItems  = $pokemons['count'];
    $this->pagerManager->createPager($totalItems, self::POKEMON_PER_PAGE);

    $listBuild = [
      '#theme'    => 'pokemon_pokemon_list',
      '#pokemons' => $pokemons,
      # Inject the pager in the template.
      '#pager'    => [
        '#type' => 'pager',
      ],
      '#cache'    => [
        # 3 Hours.
        'max-age' => 10800,
      ],
      '#attached' => [
        'library' => [
          'pokemon/base',
        ],
      ],
    ];

    $countBuild = [
      '#theme'    => 'pokemon_pokemon_count',
      '#count'    => $totalItems,
      '#cache'    => [
        'max-age' => 10800,
      ],
      '#attached' => [
        'library' => [
          'pokemon/base',
        ],
      ],
    ];

    //AJAX handling
    if ($request->isXmlHttpRequest()) {
      $html     = $this->renderer->renderRoot($listBuild);
      $response = new AjaxResponse();
      $command  = new HtmlCommand('#pokemon-list-wrapper', $html);
      $response->addCommand($command);

      return $response;
    }

    return [
      'count' => $countBuild,
      'list'  => $listBuild,
    ];
  }

  /**
   * Pokemon detail route callback.
   */
  public function showPokemonDetails($name)
  {
    $pokemon = $this->pokemonClient->getPokemonDetails($name);

    return [
      '#theme'    => 'pokemon_pokemon_details',
      '#pokemon'  => $pokemon,
      '#cache'    => [
        'max-age'  => 10800,
        'tags'     => ['pokemon:' . $name],
        'contexts' => ['url.path'],
      ],
      '#attached' => [
        'library' => [
          'pokemon/base',
        ],
      ],
    ];
  }

}
