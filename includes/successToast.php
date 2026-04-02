<?php if ($message = Message::get('success')): ?>
    <div class="app-toast-container app-toast-success" role="status" aria-live="polite" aria-atomic="true">
        <div class="app-toast-card">
            <div class="app-toast-icon" aria-hidden="true">
                <i class="bi bi-check-circle-fill"></i>
            </div>

            <div class="app-toast-content">
                <strong class="app-toast-title">Sucesso</strong>
                <p class="app-toast-message mb-0"><?= htmlspecialchars($message) ?></p>
            </div>

            <button type="button" class="app-toast-close" aria-label="Fechar"
                onclick="this.closest('.app-toast-container').remove()">
                <i class="bi bi-x-lg"></i>
            </button>
        </div>
    </div>

    <?php Message::clear('success'); ?>

    <!-- Remove toast em 5 segundos -->
    <script src="<?= BASE_URL ?>assets/js/removeToast.js?v=<?= filemtime(BASE_PATH . 'assets/js/removeToast.js') ?>"></script>
<?php endif; ?>