<?php require APPROOT . '/views/inc/header.php'; ?>
<?php print_r($data); ?>
<a href="<?php echo URLROOT; ?>/posts/" class="btn btn-light"><i class="fa fa-backward"></i> Back</a>
<div class="card card-body bg-light mt-5">
  <h2>Edit Product</h2>
  <p>Create a post with this form</p>
  <form action="<?php echo URLROOT; ?>/products/edit/<?php echo $data['product_id']; ?>" method="post">
    <div class="form-group">
      <label for="product_name">Name</label>
      <input type="text" name="product_name" class="form-control form-control-lg <?php echo (!empty($data['title_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['product_name']; ?>">
      <span class="invalid-feedback"><?php echo $data['name_err']; ?></span>
    </div>
    <div class="form-group">
      <label for="product_price">Price</label>
      <input type="text" name="product_price" class="form-control form-control-lg <?php echo (!empty($data['price_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['product_price']; ?>">
      <span class="invalid-feedback"><?php echo $data['price_err']; ?></span>
    </div>
    <div class="form-group">
      <label for="body">Description</label>
      <textarea name="product_description" class="form-control form-control-lg <?php echo (!empty($data['description_err'])) ? 'is-invalid' : ''; ?>"><?php echo $data['product_description']; ?></textarea>
      <span class="invalid-feedback"><?php echo $data['description_err']; ?></span>
    </div>
    <input type="submit" class="btn btn-success" value="Submit">
  </form>
</div>


<?php require APPROOT . '/views/inc/footer.php'; ?>