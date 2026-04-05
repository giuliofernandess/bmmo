<?php

if (!function_exists('postValue')) {
	function postValue(string $key, string $type = 'string')
	{
		if (!isset($_POST[$key]) || $_POST[$key] === '') {
			return null;
		}

		return $type === 'int'
			? (int) $_POST[$key]
			: trim((string) $_POST[$key]);
	}
}

if (!function_exists('postValueAny')) {
	function postValueAny(array $keys, string $type = 'string')
	{
		foreach ($keys as $key) {
			$value = postValue($key, $type);
			if ($value !== null) {
				return $value;
			}
		}

		return null;
	}
}

if (!function_exists('redirectWithMessage')) {
	function redirectWithMessage(string $type, string $message, string $redirect): void
	{
		Message::set($type, $message);
		header('Location: ' . $redirect);
		exit;
	}
}

if (!function_exists('redirectTo')) {
	function redirectTo(string $redirect): void
	{
		header('Location: ' . $redirect);
		exit;
	}
}

if (!function_exists('isEmptyRequiredValue')) {
	function isEmptyRequiredValue($value): bool
	{
		if ($value === null) {
			return true;
		}

		if (is_string($value)) {
			return trim($value) === '';
		}

		if (is_array($value)) {
			return count($value) === 0;
		}

		return false;
	}
}

if (!function_exists('findMissingRequiredFields')) {
	function findMissingRequiredFields(array $fields): array
	{
		$missing = [];

		foreach ($fields as $label => $value) {
			if (is_int($label)) {
				$label = (string) $value;
			}

			if (isEmptyRequiredValue($value)) {
				$missing[] = (string) $label;
			}
		}

		return $missing;
	}
}

if (!function_exists('validateRequiredFields')) {
	function validateRequiredFields(array $fields, string $redirect, ?string $prefixMessage = null): void
	{
		$missingFields = findMissingRequiredFields($fields);

		if (count($missingFields) === 0) {
			return;
		}

		$message = $prefixMessage ?? 'Preencha os campos obrigatórios';

		redirectWithMessage('error', $message, $redirect);
	}
}

if (!function_exists('rotateImageByExif')) {
	function rotateImageByExif($image, string $filePath)
	{
		if (!function_exists('exif_read_data')) {
			return $image;
		}

		$exif = exif_read_data($filePath);
		if (!$exif || !isset($exif['Orientation'])) {
			return $image;
		}

		$orientation = (int) $exif['Orientation'];

		switch ($orientation) {
			case 3:
				$image = imagerotate($image, 180, 0);
				break;
			case 6:
				$image = imagerotate($image, -90, 0);
				break;
			case 8:
				$image = imagerotate($image, 90, 0);
				break;
		}

		return $image;
	}
}

if (!function_exists('handleProfileImageUpload')) {
	function handleProfileImageUpload(
		array $file,
		string $redirect,
		?string $currentImage = null,
		string $uploadSubDir = 'musicians-images',
		string $filePrefix = 'profile_',
		array $allowedExtensions = ['jpg', 'jpeg', 'png'],
		int $maxFileSize = 5242880,
		int $jpegQuality = 85
	): ?string
	{
		if (!isset($file['error']) || $file['error'] !== UPLOAD_ERR_OK) {
			return $currentImage;
		}

		$fileTmpPath = $file['tmp_name'] ?? '';
		$fileName = $file['name'] ?? '';
		$fileSize = (int) ($file['size'] ?? 0);
		$fileExtension = strtolower(pathinfo((string) $fileName, PATHINFO_EXTENSION));

		if (!in_array($fileExtension, $allowedExtensions, true)) {
			redirectWithMessage('error', 'Extensão de arquivo inválida. Permitido apenas jpg, jpeg, png.', $redirect);
		}

		if ($fileSize > $maxFileSize) {
			redirectWithMessage('error', 'Arquivo muito grande. Máximo permitido: 5MB.', $redirect);
		}

		// Carregar imagem original
		$image = null;
		switch ($fileExtension) {
			case 'jpg':
			case 'jpeg':
				$image = imagecreatefromjpeg($fileTmpPath);
				break;
			case 'png':
				$image = imagecreatefrompng($fileTmpPath);
				break;
		}

		if (!$image) {
			redirectWithMessage('error', 'Não foi possível processar a imagem.', $redirect);
		}

		// Corrigir orientação EXIF
		$image = rotateImageByExif($image, $fileTmpPath);

		$uploadDir = BASE_PATH . 'uploads/' . trim($uploadSubDir, '/') . '/';

		if (!is_dir($uploadDir)) {
			mkdir($uploadDir, 0755, true);
		}

		// Salvar sempre como JPEG
		$newFileName = uniqid($filePrefix, true) . '.jpg';
		$destPath = $uploadDir . $newFileName;

		if (!imagejpeg($image, $destPath, $jpegQuality)) {
			redirectWithMessage('error', 'Erro ao processar a imagem.', $redirect);
		}

		if ($currentImage) {
			$oldFile = basename($currentImage);
			if (file_exists($uploadDir . $oldFile)) {
				unlink($uploadDir . $oldFile);
			}
		}

		return $newFileName;
	}
}
