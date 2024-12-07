
<?php if(isset($_SESSION['alert'])): ?>
    <div class="container">
   
    <div class="alert <?= $_SESSION['alert']['type'] ?? 'alert-success' ?> alert-dismissible fade show" role="alert">
        <?php 
            echo $_SESSION['alert']['message'];
            unset($_SESSION['alert']);
        ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
        
    </div>
<?php endif ?>