$(function() {

    // this is just a super-simple demo of JS

	var demoHeaderBox;

     var table = $("#report-table").stupidtable();
     $('th').css('cursor','pointer');
     table.on("aftertablesort", function (event, data) {
          // Reset loading message.
          var th = $(this).find("th");
          th.find(".arrow").remove();
          var dir = $.fn.stupidtable.dir;
          var arrow = data.direction === dir.ASC ? "&uarr;" : "&darr;";
          th.eq(data.column).append('<span class="arrow">' + arrow +'</span>');
        });
        
        $("#filter-input").stupid_table_search("#report-table");

    // if #javascript-ajax-button exists
    if ($('#javascript-ajax-button').length !== 0) {

        $('#javascript-ajax-button').on('click', function(){

            // send an ajax-request to this URL: current-server.com/songs/ajaxGetStats
            // "url" is defined in views/_templates/footer.php
            $.ajax(url + "list/ajaxGetStats")
                .done(function(result) {
                    // this will be executed if the ajax-call was successful
                    // here we get the feedback from the ajax-call (result) and show it in #javascript-ajax-result-box
                    $('#javascript-ajax-result-box').html(result);
                })
                .fail(function() {
                    // this will be executed if the ajax-call had failed
                })
                .always(function() {
                    // this will ALWAYS be executed, regardless if the ajax-call was success or not
                });
        });
    }

});

$.fn.stupid_table_search = function(table_selector){
        var $search_box = $(this);
        var $table = $(table_selector);
        $search_box.keyup(function(){
            var regExp = new RegExp($(this).val(), 'i');
            $table.children('tbody').children('tr').each(function(index, row){
                var allCells = $(row).find('td');
                var found = false;
                allCells.each(function(index, td){
                    if(regExp.test($(td).text())){
                        found = true;
                        return false;
                    }
                });

                if(found)
                    $(row).show();
                else 
                    $(row).hide();
            });
        });
};