<?php if (isset($_SESSION['error'])): ?>
    <div class="toast-container position-fixed top-0 start-0 p-3" style="z-index: 9999;">
      <div class="toast align-items-center text-bg-danger border-0 show" role="alert">
        <div class="d-flex">
          <div class="toast-body">
            <?= htmlspecialchars($_SESSION['error']); ?>
          </div>
          <button type="button" class="btn-close btn-close-white me-2 m-auto"
            onclick="this.closest('.toast-container').remove()"></button>
        </div>
      </div>
    </div>
    <?php unset($_SESSION['error']);?>
<?php endif; ?>

<!-- Remove toast em 5 segundos -->
<script src="<?= BASE_URL ?>assets/js/removeToast.js"></script>