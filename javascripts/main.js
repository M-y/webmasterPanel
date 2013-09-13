jQuery(document).ready(function($) {
  $.get('https://raw.github.com/M-y/webmasterPanel/stabil/VERSION', function(data) {
    $("#surum").html(data);
  });
});