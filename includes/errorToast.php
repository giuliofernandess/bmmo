<?php if ($message = Message::get('error')) { ?>
    <div class="app-toast-container app-toast-error" role="alert" aria-live="assertive" aria-atomic="true">
      <div class="app-toast-card">
        <div class="app-toast-icon" aria-hidden="true">
          <i class="bi bi-exclamation-triangle-fill"></i>
        </div>

        <div class="app-toast-content">
          <strong class="app-toast-title">Erro</strong>
          <p class="app-toast-message mb-0"><?= htmlspecialchars($message); ?></p>
        </div>

        <button type="button" class="app-toast-close" aria-label="Fechar">
          <i class="bi bi-x-lg"></i>
        </button>
      </div>
    </div>

    <?php Message::clear('error'); ?>
   
    <!-- Remove toast em 5 segundos -->
    <script src="<?= BASE_URL ?>assets/js/removeToast.js?v=<?= filemtime(BASE_PATH . 'assets/js/removeToast.js') ?>"></script>
  <?php } ?>