function tblbuildercsvpagination(id,row_num){
		var req_num_row=row_num;

		var $tr=jQuery('#csvtable'+id+' tr:not(:first-child)');

		var total_num_row=$tr.length;
		var num_pages=0;
		if(total_num_row % req_num_row ==0){
			num_pages=total_num_row / req_num_row;
		}
		if(total_num_row % req_num_row >=1){
			num_pages=total_num_row / req_num_row;
			num_pages++;
			num_pages=Math.floor(num_pages++);
		}
		for(var i=1; i<=num_pages; i++){
			jQuery('#csvpagination'+id).append("<a href='#' class='btn'>"+i+"</a>");
		}
		$tr.each(function(i){
			jQuery(this).hide();
			if(i+1 <= req_num_row){
				$tr.eq(i).show();
			}

		});
		jQuery('#csvpagination'+id+' a').click(function(e){
        jQuery('#csvpagination'+id+' a').removeClass('active');
        jQuery(this).addClass('active');
			e.preventDefault();
			$tr.hide();
			var page=jQuery(this).text();
			var temp=page-1;
			var start=temp*req_num_row;
			//alert(start);

			for(var i=0; i< req_num_row; i++){

				$tr.eq(start+i).show();

			}
		});
  jQuery('#csvpagination'+id+' a:first').addClass('active');
}
function lookuptable(id,row_num) {
  // Declare variables
 var input, filter, table, tr, td, i,j;
  input = document.getElementById("csvlookup"+id);
  filter = input.value.toUpperCase();
  table = document.getElementById("csvtable"+id);
  tr = table.getElementsByTagName("tr");

  // Loop through all table rows, and hide those who don't match the search query
  if(filter.length!=0)
  {
  for (i = 1; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td") ;
    for(j=0 ; j<td.length ; j++)
    {
      let tdata = td[j] ;
      if (tdata) {
        if (tdata.innerHTML.toUpperCase().indexOf(filter) > -1) {
          tr[i].style.display = "";
          break ;
        } else {
          tr[i].style.display = "none";
        }
      }
     jQuery("#csvpagination"+id+" a").remove(".btn");
    }
  }
  }
  else
  {
  jQuery("#csvpagination"+id+" a").remove(".btn");
  tblbuildercsvpagination(id,row_num);
  }
}
jQuery(document).ready(function() {
jQuery('.tblbuildercsv').each(function(){
var csv_id=jQuery(this).data('name');
var csv_rows=jQuery(this).data('rows');
var textalign=jQuery(this).data('textalign');
var headerbg=jQuery(this).data('headerbg');
var headercolor=jQuery(this).data('headercolor');
var pagebg=jQuery(this).data('pagebg');
var pagecolor=jQuery(this).data('pagecolor');
var pageactive=jQuery(this).data('pageactive');
var pagehoverbg=jQuery(this).data('pagehoverbg');
var pagehovercolor=jQuery(this).data('pagehovercolor');
var pagealign=jQuery(this).data('pagealign');
tblbuildercsvpagination(csv_id,csv_rows);
jQuery('#csvtable'+csv_id+' td').css('text-align',textalign);
jQuery('#csvtable'+csv_id+' tr').first().find('td').css('background',headerbg);
jQuery('#csvtable'+csv_id+' tr').first().find('td').css('color',headercolor);
jQuery('#csvpagination'+csv_id+' a:not(.active)').css('background',pagebg);
jQuery('#csvpagination'+csv_id+' a').css('color',pagecolor);
jQuery('#csvpagination'+csv_id+' a.active').css('background',pageactive);
jQuery('#csvpagination'+csv_id).css('text-align',pagealign);
jQuery('#csvpagination'+csv_id+' a').hover(function(e)
{
 jQuery(this).css('background',pagehoverbg);
jQuery(this).css('color',pagehovercolor);
},function(e){
jQuery(this).css('background',jQuery(this).hasClass('active')?pageactive:pagebg);
jQuery(this).css('color',pagecolor);
});
var active=jQuery('#csvpagination'+csv_id+' a.active');
jQuery('#csvpagination'+csv_id+' a').on('click',function(e){
 jQuery('#csvpagination'+csv_id+' a:not(.active)').css('background',pagebg);
 jQuery('#csvpagination'+csv_id+' a:not(.active)').css('color',pagecolor);
 jQuery('#csvpagination'+csv_id+' a.active').css('background',pageactive);
});


});
});