(function ($) {

  'use strict';

  // Toggle mobile navigation
  jQuery('.navbar__mobile-menu__toggle').click(function () {
    jQuery(this).parent().toggleClass('is-open');
  });

})(jQuery);


