<?php

namespace App\Controller;

use App\Database\FichierManager;
use App\File\UploadService;
use Doctrine\DBAL\Connection;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\UploadedFileInterface;

class HomeController extends AbstractController
{
    public function homepage(
        ResponseInterface $response,
        ServerRequestInterface $request,
        UploadService $uploadService,
        FichierManager $fichierManager
        
    ){
        // Récupérer les fichiers envoyés:
        $listeFichiers = $request->getUploadedFiles();

        // Si le formulaire est envoyé
        if (isset($listeFichiers['fichier'])) {
            /** @var UploadedFileInterface $fichier */
            $fichier = $listeFichiers['fichier'];

            // // Générer un nom de fichier unique:
            // // horodatage + chaine de caractères aléatoires + extension
            // $filename = date('YmdHis');
            // $filename .= bin2hex(random_bytes(8));
            // $filename .='.' . pathinfo($fichier->getClientFilename(), PATHINFO_EXTENSION);

            // Récupérer le nouveau nom du fichier
            $nouveauNom = $uploadService->saveFile($fichier);

            // Enregistrer les infos du fichier en de données
            
                // méthode insert()
                // $connection->insert('fichier', [
                //     'nom' => $nouveauNom,
                //     'nom_original' => $fichier->getClientFilename(),
                // ]);

                // // méthode executeStatement()
                // $connection->executeStatement('INSERT INTO fichier (nom, nom_original) VALUES (:nom, :nom_original)', [
                //     'nom' => $nouveauNom,
                //     'nom_original' => $fichier->getClientFilename(),
                // ]);

                // // méthode prepare() (style PDO)
                // $query = $connection->prepare('INSERT INTO fichier (nom, nom_original) VALUES (:nom, :nom_original)');
                // $query->bindValue('nom', $nouveauNom);
                // $query->bindValue('nom_original', $fichier->getClientFilename());
                // $query->execute();

                // // Query Builder
                // $queryBuilder = $connection->createQueryBuilder();
                // $queryBuilder
                //     ->insert('fichier')
                //     ->values([
                //         'nom' => $nouveauNom,
                //         'nom_original' => $fichier->getClientFilename(),
                //     ])
                //     ;
                // $queryBuilder->execute();
                //             $connection->executeStatement('INSERT INTO fichier (nom, nom_original')
                            ;
            // Afficher un message à l'utilisateur
            
            // Construire le chemin de destination du fichier:
            // chemin vers le dossier /files/ + nouveau nom de fichier
            // $path = __DIR__ . '/../../files/' . $fichier;


            // Déplacer le fichier remplacé l.35
            // $fichier->moveTo($path);
            // Enregistrer les infos du fichier en base de données
            $fichier = $fichierManager->createFichier($nouveauNom, $fichier->getClientFilename());

            // Redirection vers la page de Succès
            return $this->redirect('success', [
                'id' => $fichier->getId(),
            ]);
        }

        return $this->template($response, 'home.html.twig');
    }

    /** Vérifier que l'identifiant (argument $id) correspond à un fichier existant
     * Si ce n'est pass le cas, rediriger vers une route qui affiche un message d'erreur
     */
    public function success(ResponseInterface $response,Connection $connection, int $id, FichierManager $fichierManager)
    {

        // On efface donc toute cette partie puisque que l'on a créée une classe fichierManager (copie la récupération de donnée) jusqu' var_dump et je rajoute $fichier = $fichierManager->getByµId($id); 
        // Requête SQL
        // $query = $connection->prepare('SELECT * FROM fichier WHERE id = :id ');
        // $query->bindValue('id', $id);
        // $result = $query->execute();
        
        // Récupérer le fichier dans la BDD
        $fichier = $fichierManager -> getById($id);
        $fileName = $fichier->getNomOriginal();

        // // Tableau associatif contenant les données du fichier, ou false si aucun resultat
        // $fichier = $result->fetchAssociative();
        $fichier = $fichierManager->getById($id);
        if($fichier === null) {
            return $this->redirect('file-error');
        }

        return $this->template($response, 'success.html.twig', [
            'fichier' => $fichier
        ]);
        /**
         * On enlève ceci
         * var_dump($fichier);
         * die;
         */
    }

    public function fileError(ResponseInterface $response)
    {
        return $this->template($response, 'file_error.html.twig');   
    }

    public function download(ResponseInterface $response, int $id, Connection $connection, FichierManager $fichierManager)
    {
        $response->getBody()->write(sprintf('Identifiant: %d', $id));
        return $response;
    }
}
