<footer class="footer pt-5">
      <div class="container-fluid">
        <div class="row align-items-center justify-content-lg-between">
         
          <!-- <div class="col-lg-12">
            <ul class="nav nav-footer justify-content-center justify-content-lg-end">
              <li class="nav-item">
                <a href="https://www.creative-tim.com" class="nav-link text-muted" target="_blank">About Us</a>
              </li>
              <li class="nav-item">
                <a href="https://www.creative-tim.com" class="nav-link text-muted" target="_blank">Contact Us</a>
              </li>
              <li class="nav-item">
                <a href="https://www.creative-tim.com" class="nav-link text-muted" target="_blank">Services</a>
              </li>
             
            </ul>
          </div> -->
        </div>
      </div>
    </footer>

    </main>
   
    <script src="assests/js/jquery-3.7.1.min.js"></script>
    <script src="assests/js/bootstrap.bundle.min.js"> </script>
    <script src="assests/js/perfect-scrollbar.min.js"></script>
   <script src="assests/js/smooth-scrollbar.min.js"></script>
   <script src="assests/js/custom.js"></script>
  <!-- Alertify js -->
  <script src="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>
  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

  <script>
<?php if(isset($_SESSION['message'])){ ?>
    alertify.set('notifier','position', 'bottom-right');
    <?php if($_SESSION['message_type'] == 'success'){ ?>
        alertify.success('<?= $_SESSION['message']; ?>');
    <?php } elseif($_SESSION['message_type'] == 'error'){ ?>
        alertify.error('<?= $_SESSION['message']; ?>');
    <?php } ?>
<?php } ?>

<?php
// Unset the session message variables after displaying them
unset($_SESSION['message']);
unset($_SESSION['message_type']);
?>
</script>


</body>
</html>