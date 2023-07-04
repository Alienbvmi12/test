<!DOCTYPE html>
<html>
  <?php $this->getThemeElement('layout/partials/head', $__forward) ?>
  <body>

    <div class="container">
      <div class="row">
        <div class="col s12">
          <h1><small style="color: rgba(0,0,0,0.5);">Error 404</small> Notfound</h1>
          <p>Oops, looks like this page doesn't exist</p>
          <hr>
          <h5>Back to <a href="<?=base_url()?>">Homepage</a></h5>
        </div>
      </div>
    </div>

    <!-- jQuery, Bootstrap.js, jQuery plugins and Custom JS code -->
    <?php $this->getJsFooter(); ?>

    <!-- Load and execute javascript code used only in this page -->
    <script>
      $(document).ready(function(e){
        <?php $this->getJsReady(); ?>
      });
      <?php $this->getJsContent(); ?>
    </script>
  </body>
</html>