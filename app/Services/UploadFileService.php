<?php 

class UploadFileService 
{
    static public function uploadNewsImage(array $files): ?string
    {
        if (!isset($files['file']) || $files['file']['error'] !== UPLOAD_ERR_OK) {
            return null;
        }

        $file = $files['file'];

        $allowedMimeTypes = [
            'image/jpeg',
            'image/png',
            'image/gif',
            'image/webp'
        ];

        $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mimeType = finfo_file($finfo, $file['tmp_name']);

        if (!in_array($mimeType, $allowedMimeTypes)) {
            throw new Exception("Arquivo inválido. Apenas imagens são permitidas.");
        }

        // Valida extensão
        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

        if (!in_array($ext, $allowedExtensions)) {
            throw new Exception("Extensão não permitida.");
        }

        $maxSize = 5 * 1024 * 1024;
        if ($file['size'] > $maxSize) {
            throw new Exception("Arquivo muito grande. Máximo 5MB.");
        }

        $name = uniqid() . "." . $ext;

        $destination = BASE_PATH . "uploads/news-images/" . $name;

        if (!move_uploaded_file($file['tmp_name'], $destination)) {
            throw new Exception("Erro ao mover o arquivo.");
        }

        return $name;
    }
}
