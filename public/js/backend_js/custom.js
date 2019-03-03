
$(function(){
    
      $('.textarea_editor').wysihtml5();

   var dataSrc = [];

   var table = $('#data_table').DataTable({
      'initComplete': function(){
         var api = this.api();

         // Populate a dataset for autocomplete functionality
         // using data from first, second and third columns
         api.cells('tr', [0, 1, 2]).every(function(){
            // Get cell data as plain text
            var data = $('<div>').html(this.data()).text();           
            if(dataSrc.indexOf(data) === -1){ dataSrc.push(data); }
         });
         
         // Sort dataset alphabetically
         dataSrc.sort();
        
         $('.dataTables_filter input[type="search"]', api.table().container())
            .typeahead({
               source: dataSrc,
               afterSelect: function(value){
                  api.search(value).draw();
               }
            }
         );
      }
   });
});