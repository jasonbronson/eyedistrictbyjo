


<script>
$(function() {

  $( ".btn-edit" ).click(function() {
    var sku = $(this).data("sku");
    $('.modal-edit-name').html(sku);
    var data = $(this).data("json");
    console.log(data);
    populate("form#myForm", data);
  });

  $(".btn-search").click(function() {
    event.preventDefault();
    var field = $('.search-text').val();
    window.location.href = '/admin/?search=' + field;
  });

  $(".btn-refresh").click(function() {
    event.preventDefault();
    $('.search-text').val("");
    window.location.href = '/admin/';
  });

  $(".btn-details").click(function() {
    event.preventDefault();
    
  });


  $( ".btn-save" ).click(function() {
    var formData = $('form#myForm')[0];
    var formArray = new FormData(formData);
    console.log(formArray);
    event.preventDefault();
    $.ajax({
        type:'POST',
        url: "/admin/save/",
        data: formArray,
        contentType: false, 
        processData: false, 
        error: function(output, textStatus) {
        console.log(textStatus);
        console.log(output);
        alert( "Error on saving item" );
        },
        success: function(output) { 
          console.log("success");
          console.log(output);
          save("Product Added", "Successfully saved ");
          $('#EditModal').modal('toggle');
          $('form#myForm')[0].reset();
        }
        
    });

  });

  $( ".btn-delete" ).click(function() {
    event.preventDefault();
    var id = $(this).data("id");
    
    $.ajax({
        url: "/admin/delete/",
        data: 'id='+id,
        error: function(output, textStatus) {
        console.log(textStatus);
        console.log(output);
        alert( "Error deleting item" );
        },
        success: function(output) { 
          console.log("success");
          console.log(output);
          save("Deleted", "Removed Item " + $("form#editForm input[name='sku']").val());
          
        }

    });

  });

  function populate(frm, data) {   
    $.each(data, function(key, value) {  
        var ctrl = $('[name='+key+']', frm);  
        switch(ctrl.prop("type")) { 
            case "file": case "checkbox":   
                /*ctrl.each(function() {
                    if($(this).attr('value') == value) $(this).attr("checked",value);
                });*/   
                break;
            default:
                ctrl.val(value); 
        }  
    });  
  }

  function save(title, message, time){
    $('.alertHover').show();
    $('.alert-heading').html(title);
    $('.alert-message').html(message);

    setTimeout(hideAlert, 2000);

  }

  function hideAlert(){
    $('.alertHover').hide();
  }
  
  hideAlert();
    
});
</script>


</body>

</html>