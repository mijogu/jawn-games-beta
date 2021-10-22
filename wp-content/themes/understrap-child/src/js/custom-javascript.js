// Add your custom JS here.
jQuery(function($) {
    // New Game form
    $('.acf-form').on('change', '.players-input input[type="checkbox"]', function(){
        var checkbox = this;
        var is_checked = $(checkbox).prop('checked');
        var val = $(checkbox).val();
        var id = $(checkbox).attr('id');

        console.log(($(this).text()).trim() + " " + val + " " + id);

        var $others = $('input[type="checkbox"][value="'+val+'"]:not(#'+id+')');

        // if($(this).is(":checked")) {
        if(is_checked) {
            // console.log('it\'s checked!');
            $.each($others, function(key, input) {
                $(input).prop('disabled', 'true');
                $(input).parent().addClass('disabled');
            });
        } else {
            // console.log('not checked');
            $.each($others, function(key, input) {
                $(input).removeAttr('disabled');
                $(input).parent().removeClass('disabled');
            });
        }
      });
});