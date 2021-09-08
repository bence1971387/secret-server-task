<?= $this->extend('/templates/default') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
  <div class="row mx-auto col-md-5">
    <h1 class="mt-5 mb-5">Secret server task</h1>
    <form action=<?= base_url('/secret') ?> method="POST">
      <div class="form-group">
        <?php if (isset($errors)) : ?>
          <div class="text-danger">
            <?= $errors->listErrors() ?>
          </div>
        <?php endif; ?>
        <label for="secret"></label>
        <input type="text" class="form-control" name="secret" id="secret" placeholder="Secret">
        <small id="secret" class="form-text text-muted">This text will be saved as a secret.</small>
      </div>
      <div class="form-group">
        <label for="expireAfterViews"></label>
        <input type="number" class="form-control" name="expireAfterViews" id="expireAfterViews" aria-describedby="helpId" placeholder="Expire after views">
        <small id="expireAfterViews" class="form-text text-muted">The secret won't be available after the given number of views. It must be greater than 0.</small>
      </div>
      <div class="form-group">
        <label for="expireAfter"></label>
        <input type="number" class="form-control" name="expireAfter" id="expireAfter" aria-describedby="helpId" placeholder="Expire after minutes">
        <small id="expireAfter" class="form-text text-muted">The secret won't be available after the given time. The value is provided in minutes. 0 means never expires</small>
      </div>
      <div class="form-group pt-4">
        <button name="submit" type="submit" class="btn btn-primary">Submit</button>
      </div>
    </form>
  </div>
</div>
<?= $this->endSection() ?>