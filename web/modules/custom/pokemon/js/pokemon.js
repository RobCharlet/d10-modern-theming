(function($, Drupal) {
  Drupal.behaviors.pokemonListAjax = {
    attach: function(context, settings) {
      once('pokemonListAjax', '#pokemon-list-wrapper > nav > ul > li > a', context).forEach(function(element) {
        $(element).click(function(event) {
          event.preventDefault();
          const $href = $(this).attr('href');
          const $wrapper = $('#pokemon-list-wrapper');
          const $overlay = $('#pokemon-loading-overlay');

          $overlay.show();
          $wrapper.fadeOut('100', function() {
            $.ajax({
              url: $href,
              type: 'GET',
              dataType: 'json',
              success: function (response) {
                if (response[0].data) {
                  $wrapper.html(response[0].data);
                  // Reattach the Drupal behavior of the new loaded content.
                  // If not reattached, pokemonListAjax will not be applied on
                  // the links.
                  // $wrapper.get(0) gives the html of the jQuery element.
                  Drupal.attachBehaviors($wrapper.get(0));
                  $wrapper.fadeIn('100');
                  $overlay.hide();
                }
              }
            });
          });

        });
      });
    }
  }
})(jQuery, Drupal);
