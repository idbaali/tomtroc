<?php

namespace App\Services;

class FileUploader
{
    /**
     * Upload une image de livre
     */
    public static function uploadBookImage(array $file): ?string
    {
        if (($file['error'] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_OK) {
            return null;
        }

        $originalName = $file['name'] ?? '';
        $tmpName = $file['tmp_name'] ?? '';

        if ($originalName === '' || $tmpName === '') {
            return null;
        }

        $extension = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));
        $fileName = uniqid('book_', true) . '.' . $extension;

        $destination = __DIR__ . '/../../public/images/books/' . $fileName;

        if (!move_uploaded_file($tmpName, $destination)) {
            return null;
        }

        return $fileName;
    }
}