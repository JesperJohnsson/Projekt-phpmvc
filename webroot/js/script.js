jQuery(document).ready(function() {
  jQuery("time.timeago").timeago();
});

jQuery('.toggler:not(.active)').next('div').hide();

jQuery('.toggler').click(function() {

    if ( jQuery(this).hasClass('active') ) {
        jQuery('.active').toggleClass('active').next('div').hide("fast");
    }

    else {
        jQuery('.active').toggleClass('active').next('div').hide();
        jQuery(this).toggleClass("active").next().slideToggle("fast");

    }
});

function myFunction(myValue){
  document.getElementById("currentValue").innerHTML = myValue;
}
