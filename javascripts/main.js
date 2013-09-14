jQuery(document).ready(function($) {
  $.get('http://demo.webmasterpanel.net/surum.php', function(data) {
    $("#surum").html(data);
  });
});