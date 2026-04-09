<?php

namespace App\Services;

class Validations
{
    /**
     * Valide le formulaire de création d'un livre.
     *
     * @param array $post
     * @param array $files
     * @return array
     */
    public static function validateBookCreation(array $post, array $files = []): array
    {
        $errors = [];

        $title = trim($post['title'] ?? '');
        $author = trim($post['author'] ?? '');
        $description = trim($post['description'] ?? '');

        if ($title === '') {
            $errors[] = 'Le titre est obligatoire.';
        }

        if ($author === '') {
            $errors[] = 'L’auteur est obligatoire.';
        }

        if ($description === '') {
            $errors[] = 'La description est obligatoire.';
        }

        if (isset($files['image']) && ($files['image']['error'] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_NO_FILE) {
            $imageError = $files['image']['error'] ?? UPLOAD_ERR_NO_FILE;

            if ($imageError !== UPLOAD_ERR_OK) {
                $errors[] = 'Erreur lors de l’envoi de l’image.';
                return $errors;
            }

            $tmpName = $files['image']['tmp_name'] ?? '';
            $originalName = $files['image']['name'] ?? '';
            $extension = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));

            $allowedExtensions = ['jpg', 'jpeg', 'png', 'webp'];

            if (!in_array($extension, $allowedExtensions, true)) {
                $errors[] = 'Le format de l’image doit être jpg, jpeg, png ou webp.';
            }

            if (!empty($tmpName) && is_uploaded_file($tmpName)) {
                $maxSize = 5 * 1024 * 1024; // 5 Mo
                $fileSize = $files['image']['size'] ?? 0;

                if ($fileSize > $maxSize) {
                    $errors[] = 'L’image ne doit pas dépasser 5 Mo.';
                }
            }
        }

        return $errors;
    }
}