(function ($, Drupal) {
  Drupal.behaviors.acmeFootball = {
    attach: function (context, settings) {
      // instantiate masonry grid
      let $grid = $('.block-acme-football .football-grid').masonry({
        // options
        itemSelector: '.team',
        columnWidth: '.team-sizer',
        percentPosition: true,
        gutter: 10,
        fitWidth: true
      });
      let $teams = $grid.find('.team');
      let $filters = jQuery('.block-acme-football .football-filters');
      // layout Masonry after each image loads
      $grid.imagesLoaded().progress( function() {
        $grid.masonry('layout');
      });
      jQuery( window ).resize(function() {
        $grid.masonry('layout');
      });
      $filters.find('select').once('acmeFootballFilter').each( function() {
        let $this = jQuery(this);
        $this.on('change', function() {
          console.log('fired change event');
          let selectedValue = jQuery(this).find('option:selected').val();
          console.log(selectedValue)
          if(selectedValue !=='') {
            $this.siblings().find("option").eq(0).prop("selected", true);
            $teams.hide();
            $grid.find('.team.' + selectedValue).show();
            $grid.masonry('layout');
          } else {
            $teams.show();
            $grid.masonry('layout');
          }
        });

      });


      // $('input.myCustomBehavior', context).once('myCustomBehavior').each(function () {
      //   // Apply the myCustomBehaviour effect to the elements only once.
      // });
    }
  };
})(jQuery, Drupal);
