/**
 * Grafik çizmek için gerekli js kodları
 * 
 * @bağımlılıklar
 *  jquery-1.10.2.min.js
 *  http://www.google.com/jsapi
 */

google.load("visualization", "1", {packages:["corechart"]});
google.setOnLoadCallback(drawChart);
function drawChart() {
  jQuery(document).ready(function($) {
    /**
     * Tablodan grafik
     */
    var divSay = 0;
    $(".grafik").each(function(){
      $(this).css({display: 'none'});
      
      var genislik = $(this).css('width');
      var yukseklik = $(this).css('height');
      var ID = 'grafik' + divSay;
      
      $(this).after('<div id="' + ID + '" style="width:' + genislik + ';height:' + yukseklik + '"></div>');
    
      var veriler = new Array();
    
      veriler.push(Array());
      $(this).find('th').each(function(){
	veriler[0].push( $(this).html() );
      });
      
      trSayac = 1;
      $(this).find('tr').each(function(){
	if ( $(this).find('th').length == 0 ) {
	  veriler.push(Array());
	  tdSayac = 1;
	  $(this).find('td').each(function(){
	    veriler[trSayac].push( (tdSayac == 1) ? $(this).html() : parseInt($(this).html()) );
	    tdSayac++;
	  });
	  trSayac++;
	}
      });
      console.log(veriler);
      var data = google.visualization.arrayToDataTable(veriler);
      
      var options = {
	///       title: 'Company Performance' @todo
      };
      
      var chart = new google.visualization.LineChart(document.getElementById(ID));
      chart.draw(data, options);
      
      divSay++;
    });
  
  });
  

}


