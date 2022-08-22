<div class="container">
  <h2>Members List</h2>

  <!-- Display status message -->
  <?php if (!empty($success_msg)) { ?>
    <div class="col-xs-12">
      <div class="alert alert-success"><?php echo $success_msg; ?></div>
    </div>
  <?php } ?>
  <?php if (!empty($error_msg)) { ?>
    <div class="col-xs-12">
      <div class="alert alert-danger"><?php echo $error_msg; ?></div>
    </div>
  <?php } ?>

  <div class="row">
    <!-- Import link -->
    <div class="col-md-12 head">
      <div class="float-right">
        <a href="javascript:void(0);" class="btn btn-success" onclick="formToggle('importFrm');"><i class="plus"></i> Import</a>
      </div>
    </div>

    <!-- File upload form -->
    <div class="col-md-12" id="importFrm" style="display: none;">
      <form action="<?php echo base_url('anggota/import'); ?>" method="post" enctype="multipart/form-data">
        <input type="file" name="file" />
        <input type="submit" class="btn btn-primary" name="importSubmit" value="IMPORT">
      </form>
    </div>

  </div>
</div>

<script>
  function formToggle(ID) {
    var element = document.getElementById(ID);
    if (element.style.display === "none") {
      element.style.display = "block";
    } else {
      element.style.display = "none";
    }
  }
</script>