<?php require APPROOT . '/views/inc/header.php'; ?>
<?php flash('product_message'); ?>
<div class="row mb-3">
    <div class="col-md-6">
        <h1>Products</h1>
    </div>
    <div class="col-md-6">
        <a href="<?php echo URLROOT; ?>/products/add" class="btn btn-primary pull-right">
            <i class="fa fa-pencil"></i>Add Product
        </a>

    </div>
</div>
<?php foreach ($data['products'] as $product) : ?>
    <div class="card text-center mb-3">
        <h4 class="card-title"><?php echo $product->product_name; ?></h4>
        <div class="bg-light p-2 mb-3">
            <p class="text-success"><?php echo $product->product_price . "$"; ?> </p>
        </div>
        <p class="card-text">
            <?php echo $product->product_description; ?>
        </p>

        <a href="<?php echo URLROOT; ?>/products/show/<?php echo $product->product_id; ?>" class="btn btn-dark">Read More</a>
    </div>
<?php endforeach; ?>

<?php require APPROOT . '/views/inc/footer.php'; ?>