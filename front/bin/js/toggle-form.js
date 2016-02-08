/**
* Toggle the state of the login page
*
* @author Samuel Adeshina <samueladeshina73@gmail.com>
* @since 4/2/2016
*/

$('.toggle').click(function(){
  $(this).children('i').toggleClass('fa-pencil');
  $('.form').animate({
    height: "toggle",
    'padding-top': 'toggle',
    'padding-bottom': 'toggle',
    opacity: "toggle"
  }, "slow");
});