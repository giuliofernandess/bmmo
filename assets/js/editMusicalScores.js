document.addEventListener("DOMContentLoaded", () => {
    document
        .querySelectorAll(".delete-instrument-file-button")
        .forEach((button) => {
            button.addEventListener("click", () => {
                const musicalScoreId = Number(button.dataset.musicId);
                const instrumentId = Number(button.dataset.instrumentId);
                const voiceOff = button.dataset.voiceOff === "1";

                deleteInstrumentFile(musicalScoreId, instrumentId, voiceOff);
            });
        });

    const deleteScoreButton = document.querySelector(
        ".delete-musical-score-button",
    );
    if (deleteScoreButton) {
        deleteScoreButton.addEventListener("click", () => {
            deleteMusicalScore(Number(deleteScoreButton.dataset.musicId));
        });
    }
});

function submitPost(url, fields) {
    const form = document.createElement("form");
    form.method = "POST";
    form.action = url;

    Object.entries(fields).forEach(([key, value]) => {
        const input = document.createElement("input");
        input.type = "hidden";
        input.name = key;
        input.value = String(value);
        form.appendChild(input);
    });

    document.body.appendChild(form);
    form.submit();
}

function deleteInstrumentFile(musicalScoreId, instrumentId, voiceOff) {
    if (!confirmAction("Deseja excluir este arquivo?")) {
        return;
    }

    submitPost(
        "<?= BASE_URL ?>pages/admin/musical-scores/actions/deleteinstrument.php",
        {
            musical_score_id: musicalScoreId,
            instrument_id: instrumentId,
            voice_off: voiceOff ? "1" : "0",
        },
    );
}

function deleteMusicalScore(musicalScoreId) {
    if (!confirmAction("Deseja excluir esta partitura?")) {
        return;
    }

    submitPost("<?= BASE_URL ?>pages/admin/musical-scores/actions/delete.php", {
        musical_score_id: musicalScoreId,
    });
}
