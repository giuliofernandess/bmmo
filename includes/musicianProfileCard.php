<main class="flex-fill d-flex align-items-center justify-content-center">
    <div class="container">
      <div class="card shadow mx-auto my-5 profile-summary-card">
        <div class="row g-0">
          <!-- Imagem -->
          <div class="col-md-4 text-center bg-secondary">
            <img src="<?= BASE_URL ?>uploads/musicians-images/<?= $profileImage ?>" class="img-fluid rounded-start h-100 object-fit-cover"
              alt="Imagem de <?= $musicianName ?>">
          </div>
          <div class="col-md-8">
            <div class="card-body">
              <h4 class="card-title fs-2 fw-bold mb-3 ps-3 text-primary"><?= $musicianName; ?></h4>
              <ul class="list-group list-group-flush">
                <li class="list-group-item"><strong>Instrumento:</strong>
                  <?= $instrumentName; ?></li>
                <li class="list-group-item"><strong>Grupo:</strong> <?= $groupName; ?>
                </li>
                <li class="list-group-item"><strong>Data de Nascimento:</strong>
                  <?= $dateOfBirth; ?></li>
                <li class="list-group-item"><strong>Telefone:</strong>
                  <?= $musicianContact; ?></li>
                <li class="list-group-item"><strong>Nome do responsável:</strong>
                  <?= $responsibleName; ?></li>
                <li class="list-group-item"><strong>Contato do responsável:</strong>
                  <?= $responsibleContact; ?></li>
                <li class="list-group-item"><strong>Bairro:</strong>
                  <?= $neighborhood; ?></li>
                <li class="list-group-item"><strong>Instituição:</strong>
                  <?= $institution; ?></li>
              </ul>