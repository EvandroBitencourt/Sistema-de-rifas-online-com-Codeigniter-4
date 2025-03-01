<div class="container">
    <?php if (session()->has('success')) : ?>
        <div class="alert alert-success" role="alert">
            <?php echo session('success'); ?>
        </div>
    <?php endif; ?>

    <?php if (session()->has('info')) : ?>
        <div class="alert alert-info" role="alert">
            <?php echo session('info'); ?>
        </div>
    <?php endif; ?>

    <?php if (session()->has('danger')) : ?>
        <div class="alert alert-danger" role="alert">
            <?php echo session('danger'); ?>
        </div>
    <?php endif; ?>

    
    <?php if (session()->has('error')) : ?>
        <div class="alert alert-danger" role="alert">
            <?php echo session('error'); ?>
        </div>
    <?php endif; ?>
</div>
