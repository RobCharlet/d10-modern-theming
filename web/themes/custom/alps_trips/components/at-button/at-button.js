(function(Drupal, once) {
  Drupal.behaviors.at_button = {
    attach: function attach(context) {
      once('at-button', '.at-button', context).forEach(
        (item) => {
          item.addEventListener(
            'click',
            function(event) {
              event.preventDefault();
              alert('hello world');
            }
          )
        }
      )
    },
  };
})(Drupal, once);
