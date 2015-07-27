var $J = jQuery.noConflict();

$J(document).ajaxComplete(function() {
    $J('#widgets-right .cc-color-field, .inactive-sidebar .cc-color-field').wpColorPicker();
});

$J(document).ready(function(){
    $J('#widgets-right .cc-color-field, .inactive-sidebar .cc-color-field').wpColorPicker();
});

