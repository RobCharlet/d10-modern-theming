import '../css/tailwind.css';

/**
 * Retrieve the theme configuration setting passed
 * in the alps_trips_page_attachments_alter hook.
 */
(function(Drupal) {
  Drupal.behaviors.alps_trips = {
    attach: function(context, settings) {
      console.log(settings.alps_trips.copyright);
    }
  }
})(Drupal)
