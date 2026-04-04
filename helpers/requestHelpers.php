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

if (!function_exists('handleProfileImageUpload')) {
	function handleProfileImageUpload(
		array $file,
		string $redirect,
		?string $currentImage = null,
		string $uploadSubDir = 'musicians-images',
		string $filePrefix = 'profile_',
		array $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'],
		int $maxFileSize = 5242880
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
			redirectWithMessage('error', 'Extensão de arquivo inválida. Permitido apenas jpg, jpeg, png, gif.', $redirect);
		}

		if ($fileSize > $maxFileSize) {
			redirectWithMessage('error', 'Arquivo muito grande. Máximo permitido: 5MB.', $redirect);
		}

		$newFileName = uniqid($filePrefix, true) . '.' . $fileExtension;
		$uploadDir = BASE_PATH . 'uploads/' . trim($uploadSubDir, '/') . '/';

		if (!is_dir($uploadDir)) {
			mkdir($uploadDir, 0755, true);
		}

		$destPath = $uploadDir . $newFileName;

		if (!move_uploaded_file($fileTmpPath, $destPath)) {
			redirectWithMessage('error', 'Erro ao enviar a imagem.', $redirect);
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