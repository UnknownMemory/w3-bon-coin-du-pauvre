<?php
namespace App\Service;
use App\Entity\Annonce;
use Cocur\Slugify\Slugify;

class SlugService
{
    const MAX = 999999;
    const MIN = 1;

    public function getSlug (Annonce $annonce): string
    {
        $slugify = new Slugify();
        $genrateInt = rand(self::MIN, self::MAX);
        return($slugify->slugify($annonce->getTitre() . '-'. $genrateInt));
    }

}