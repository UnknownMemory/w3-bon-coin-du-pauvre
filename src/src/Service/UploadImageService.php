<?php

/* ORIGINAL POUR UNE IMAGE */

// /* Gestion de l'image */
// $images = $form['images']->getData();
// /* On définir l'endroid ou l'on veut placer les images */
// $destination = $this->getParameter('kernel.project_dir') . '/public/assets/img/upload';
// /* on rename les images un id unique -suivi du nom du site ainsi que de l'extension */
// $fileName = uniqid() . '-le-bon-coin-du-pauvre.' . $images->guessExtension();
// /* On déplace le fichier dans la destination */
// $images->move($destination, $fileName);
// /* On utilise la méthode setImage pour enregistrer le nom de l'image dans BDD (ici sous forme de tableau) */
// $annonce->setImages([$fileName]);

/* ORIGINAL POUR PLUSIEURS IMAGES */

/* 
            foreach ($images as $f) {
                $fileName =  uniqid() . '-le-bon-coin-du-pauvre' . '.' . $f->guessExtension();
                $destination = $this->getParameter('kernel.project_dir') . '/public/assets/img/upload';
                $f->move($destination, $fileName);

                $arrayImage[] = $fileName;
                $annonce->setImages([$arrayImage]);
            };
 */



namespace App\Service;


use Symfony\Component\HttpFoundation\File\Exception\FileException;

class UploadImageService
{

    private string $projectDir;
    public array $arrayImage;
    public string $nameOfFile;

    public function __construct(string $projectDir)
    {
        $this->projectDir = $projectDir;
    }


    public function upload(array $files, string $nameOfFile, string $path)
    {
        /*     dd($files); */
        foreach ($files as $f) {
            $fileName =  uniqid() . $nameOfFile . '.' . $f->guessExtension();
            $destination = $this->projectDir . $path;
            $f->move($destination, $fileName);
            $arrayImage[] = $fileName;
        };

        return $arrayImage;
    }
}
