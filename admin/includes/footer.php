

    </main>
   
    <script src="assests/js/jquery-3.7.1.min.js"></script>
    <script src="assests/js/bootstrap.bundle.min.js"> </script>
    <script src="assests/js/perfect-scrollbar.min.js"></script>
   <script src="assests/js/smooth-scrollbar.min.js"></script>

  <!-- Alertify js -->
  <script src="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- Include SweetAlert library -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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