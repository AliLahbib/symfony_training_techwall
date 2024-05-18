<?php
namespace App\TwigExtensions;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class MyCostumTwigExtension extends AbstractExtension{

    public function getFilters()
    {
        return [
            new TwigFilter('defaultImage', [$this, 'defaultImage']),
        ];
    }
    public function defaultImage(string $pathhhh):string
 {
    if (strlen(trim($pathhhh))==0)
        return 'payment.jpg';
    return $pathhhh;
 }


}