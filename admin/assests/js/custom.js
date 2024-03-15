$(document).ready(function() {
   $('.delete_product_btn').click(function (e) { 
    e.preventDefault();
    var id = $(this).val();
    

    swal({
        title: "Are you sure?",
        text: "Once deleted, you will not be able to recover!",
        icon: "warning",
        buttons: true,
        dangerMode: true,
      })
      .then((willDelete) => {
        if (willDelete) {
         $.ajax({
            method: "POST",
            url: "delete_product.php",
            data: {
                'product_id':id,
                'delete_product_btn':true

            },
          
            success: function (response) {
                location.reload();
            }
         });
        } else {
          swal("Your imaginary file is safe!");
        }
      });
   });
}
)

