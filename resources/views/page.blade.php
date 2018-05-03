<!doctype html>
<html lang="en">
  <head>

    <title>Product creation/view</title>
    <!-- Required meta tags -->
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">

  </head>
  <body>

    @include('templates.navbar')

    <center>
      <h4>Submit products on `public/products.json`</h4>
    </center>
    <div class='container '>

      <form id="productForm">
        <div class="form-group">
          <label for="productName">Product name</label>
          <input type="text" required  class="form-control" id="productName" placeholder="Enter product name">
        </div>

        <div class="form-group">
        <label for="quantity">Quantity in stock</label>
        <input type="number" required class="form-control" id="quantity" placeholder="Enter quantity">
        </div>

        <div class="form-group">
        <label for="price">Price per item</label>
        <input type="number" required class="form-control" id="price" placeholder="Enter price">
        </div>


        <button type="submit" class="btn btn-primary submitProduct">Submit</button>
      </form>

      <hr>

      <p><h1>Submitted Product List</h1></p>
      <table class="table">
        <thead class="thead-dark">
          <tr>
            <th scope="col">Product ID</th>
            <th scope="col">Product name</th>
            <th scope="col">Quantity in stock</th>
            <th scope="col">Price per item</th>
            <th scope="col">Datetime submitted</th>
            <th scope="col">Total value</th>

          </tr>
        </thead>
        <tbody id="tproducts">
          @foreach($products as $product)
          <tr>
            <th scope="row">{{$product->productId}}</th>
            <td>{{$product->productName}}</td>
            <td>{{$product->quantity}}</td>
            <td>${{$product->price}}</td>
            <td>{{$product->datetime}}</td>
            <td>${{$product->quantity*$product->price}}</td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>





    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T" crossorigin="anonymous"></script>
    <script
    src="https://code.jquery.com/jquery-3.3.1.min.js"
    integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
    crossorigin="anonymous"></script>
    <script>

      $(document).ready(function(){
        var token = $('meta[name="csrf-token"]').attr('content');
          $('#productForm').on('submit', function(e){
            e.preventDefault();
            $.ajax({
              url: '/create-product',
              type: 'POST',
              data: {_token:token, product_name: $('#productName').val(), quantity:$('#quantity').val(), price:$('#price').val()},
              dataType: 'JSON',
              success: function (data) {
                // We add the data on the table
              $('#tproducts').append(`
                  <tr>
                    <th scope="row">${data.productId}</th>
                    <td>${data.productName}</td>
                    <td>${data.quantity}</td>
                    <td>$${data.price}</td>
                    <td>${data.datetime}</td>
                    <td>$${data.quantity*data.price}</td>
                  </tr>
                `);

                // Now we clear the form fields
                $('#productName').val('');
                $('#quantity').val('');
                $('#price').val('');
              }
            });

          });
      });
    </script>
  </body>
</html>
