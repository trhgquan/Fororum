<form class="navbar-form navbar-left" action="<?php echo e(url('/f/search')); ?>" method="POST">
    <div class="form-group">
         <div class="input-group">
             <input type="text" class="form-control" name="keyword" placeholder="keyword" required>
             <span class="input-group-btn">
                 <button type="submit" class="btn btn-default">tìm</button>
             </span>
         </div>
     </div>

    <?php echo csrf_field(); ?>
</form>
