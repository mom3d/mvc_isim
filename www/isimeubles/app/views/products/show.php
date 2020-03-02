<?php require APPROOT . '/views/inc/header.php'; ?>

<a href="<?php echo URLROOT; ?>/products/" class="btn btn-light"><i class="fa fa-backward"></i> Back</a>
<h1>

    <?php echo $data['product']->product_name; ?>
</h1>
<div class="bg-secondary text-white p-2 mb-3">
    Added By <?php echo $data['admin']->admin_login; ?>
</div>
<p>
    <?php echo $data['product']->product_description; ?>
</p>
<?php if ($data['product']->admin_id == $_SESSION['admin_id']) : ?>
    <hr>
    <a href="<?php echo URLROOT; ?>/products/edit/<?php echo $data['product']->product_id; ?>" class="btn btn-dark">Edit</a>
    <form class="pull-right" action="<?php echo URLROOT; ?>/products/delete/<?php echo $data['product']->product_id; ?>" method="post">
        <input type="submit" value="Delete" class="btn btn-danger">
    </form>
<?php endif; ?>


<?php require APPROOT . '/views/inc/footer.php'; ?>