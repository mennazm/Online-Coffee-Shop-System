<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>User</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
	   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous"/>
    

  </head>

  <body>
    <main class="admin-orders">
      <section class="main-padding">
        <div class="container">
          <h1>Orders</h1>
          <!-- ! table one  -->
          <table class="table">
            <thead class="thead-light">
              <tr>
                <th scope="col">Order Date</th>
                <th scope="col">Name</th>
                <th scope="col">Room</th>
                <th scope="col">Ext</th>
                <th scope="col">Action</th>
              </tr>
            </thead>
            <tbody>
              <!-- ! first order -->
              <tr class="order">
                <td>
                  <span>2019/03/10 10.30 AM</span>
                  <button class="toggle-details btn btn-link"><i class="fas fa-plus-square"></i></button>

                </td>
                <td>Fatma Alzahraa</td>
                <td>102</td>
                <td>1020</td>
                <td>deliver</td>
              </tr>
             <tr class="order-details" style="display: none;">
                <td colspan="5">
                  <div class="row">
                    <!-- each-item -->
                    <div class="col-sm-2">
                      <div class="each-order">
                        <img
                        src="../admin/assests/images/cake.jpg"
                          class="w-100"
                          width="100"
                          height="100"
                          alt=""
                        />
                        <h5>tea</h5>
                        <input type="text" name="tea" value="15" hidden />
                        <span>15 LE</span>
                        <span>2</span>
                      </div>
                    </div>
                    <!-- each-item -->
                    <div class="col-sm-2">
                      <div class="each-order">
                        <img
                        src="../admin/assests/images/cake.jpg"
                          class="w-100"
                          width="100"
                          height="100"
                          alt=""
                        />
                        <h5>tea</h5>
                        <input type="text" name="tea" value="15" hidden />
                        <span>15 LE</span>
                        <span>3</span>
                      </div>
                    </div>
                    <!-- each-item -->
                    <div class="col-sm-2">
                      <div class="each-order">
                        <img
                        src="../admin/assests/images/cake.jpg"
                          class="w-100"
                          width="100"
                          height="100"
                          alt=""
                        />
                        <h5>tea</h5>
                        <input type="text" name="tea" value="15" hidden />
                        <span>15 LE</span>
                        <span>5</span>
                      </div>
                    </div>
                    <!-- each-item -->
                    <div class="col-sm-2">
                      <div class="each-order">
                        <img
                          src="../admin/assests/images/cake.jpg"
                          class="w-100"
                          width="100"
                          height="100"
                          alt=""
                        />
                        <h5>tea</h5>
                        <input type="text" name="tea" value="15" hidden />
                        <span>15 LE</span>
                        <span>1</span>
                      </div>
                    </div>
                    <!-- Display total price -->
                     <div class='total-price d-flex justify-content-evenly'>
                     <h3>Total</h3>
                    <!-- Calculate total price here -->
                     <h3>EGP</h3>
                     </div>
                  </div>
                </td>
              </tr>
              <!-- ! ./first order -->

              <!-- ! second order -->
              <tr class="order">
                <td>
                  <span>2019/03/10 10.30 AM</span>
                  <button class="toggle-details btn btn-link"><i class="fas fa-plus-square"></i></button>
                </td>
                <td>Maghfera Hassan</td>
                <td>102</td>
                <td>3040</td>
                <td>deliver</td>
              </tr>
              <tr class="order-details" style="display: none;">
                <td colspan="5">
                  <div class="row">
                    <!-- each-item -->
                    <div class="col-sm-2">
                      <div class="each-order">
                        <img
                        src="../admin/assests/images/cake.jpg"
                          class="w-100"
                          width="100"
                          height="100"
                          alt=""
                        />
                        <h5>tea</h5>
                        <input type="text" name="tea" value="15" hidden />
                        <span>15 LE</span>
                        <span>2</span>
                      </div>
                    </div>
                    <!-- each-item -->
                    <div class="col-sm-2">
                      <div class="each-order">
                        <img
                        src="../admin/assests/images/delicious-donuts.jpg"
                          class="w-100"
                          width="100"
                          height="100"
                          alt=""
                        />
                        <h5>tea</h5>
                        <input type="text" name="tea" value="15" hidden />
                        <span>15 LE</span>
                        <span>3</span>
                      </div>
                    </div>
                    <!-- each-item -->
                    <div class="col-sm-2">
                      <div class="each-order">
                        <img
                        src="../admin/assests/images/cake.jpg"
                          class="w-100"
                          width="100"
                          height="100"
                          alt=""
                        />
                        <h5>tea</h5>
                        <input type="text" name="tea" value="15" hidden />
                        <span>15 LE</span>
                        <span>5</span>
                      </div>
                    </div>
                    <!-- each-item -->
                    <div class="col-sm-2">
                      <div class="each-order">
                        <img
                        src="../admin/assests/images/cake.jpg"
                          class="w-100"
                          width="100"
                          height="100"
                          alt=""
                        />
                        <h5>tea</h5>
                        <input type="text" name="tea" value="15" hidden />
                        <span>15 LE</span>
                        <span>1</span>
                      </div>
                    </div>
                    <!-- order-total-price -->
                    <div class="col-sm-4 order-total-price">
                      <p>Total: EGP <span>34</span></p>
                    </div>
                  </div>
                </td>
              </tr>
              <!-- ! ./second order -->
            </tbody>
          </table>
        </div>
      </section>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script>
      document.addEventListener("DOMContentLoaded", function() {
          var toggleButtons = document.querySelectorAll('.toggle-details');
          toggleButtons.forEach(function(button) {
              button.addEventListener('click', function() {
                  var icon = button.querySelector('i');
                  var detailsRow = button.closest('tr').nextElementSibling;
                  if (icon.classList.contains('fa-plus-square')) {
                      icon.classList.remove('fa-plus-square');
                      icon.classList.add('fa-minus-square');
                      detailsRow.style.display = 'table-row';
                  } else {
                      icon.classList.remove('fa-minus-square');
                      icon.classList.add('fa-plus-square');
                      detailsRow.style.display = 'none';
                  }
              });
          });
      });
      
      </script>
  </body>
</html>
