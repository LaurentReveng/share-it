<?php

// src/File/UploadService.php
namespace App\File;

use Psr\Http\Message\UploadedFileInterface;

/**
 * Service en charge de l'enregistrement de fichiers 
 */
class UploadService
{
    /** @var string chemin vers le dossier où enregistrer les fichiers */
    public const FILES_DIR = __DIR__ . '/../../files';
    /**
     * Enregistrer un fichier
     * 
     * @param UploadedFileInterface $file le fichier chargé à enregistrer
     * @return string le nouveau nom du fichier
     */
    public function saveFile(UploadedFileInterface $file): ?string
    {
        $filename = $this->generateFilename($file);
        //  // Générer un nom de fichier unique:
        //     // horodatage + chaine de caractères aléatoires + extension
        //     $filename = date('YmdHis');
        //     $filename .= bin2hex(random_bytes(8));
        //     $filename .='.' . pathinfo($file->getClientFilename(), PATHINFO_EXTENSION);

            // Construire le chemin de destination du fichier:
            // chemin vers le dossier /files/ + nouveau nom de fichier
            $path = self::FILES_DIR . '/' . $filename;

            // Déplacer le fichier
            $file->moveTo($path);
            return $filename;
    }

    /**
     * 
     * @param UploadedFileInterface $file le fichier chargé à enregistrer
     * @return string le nouveau nom du fichier
     */
    private function generateFilename(UploadedFileInterface $file): string
    {
        /**
         * Ecrire le code de generateFilename()
         * Utiliser la méthode generateFilename()dans la méthode saveFile()
         * Ajouter un argument UploadService dans le Home Controller et utiliser saveFile()
         */
        // Générer un nom de fichier unique:
            // horodatage + chaine de caractères aléatoires + extension
            $filename = date('YmdHis');
            $filename .= bin2hex(random_bytes(8));
            $filename .='.' . pathinfo($file->getClientFilename(), PATHINFO_EXTENSION);
            return $filename;
    }   
}