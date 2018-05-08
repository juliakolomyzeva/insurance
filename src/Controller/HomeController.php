<?php
/**
 * Created by PhpStorm.
 * User: jumu
 * Date: 09.03.18
 * Time: 17:45
 */
namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Asset\Package;
use Symfony\Component\Asset\VersionStrategy\EmptyVersionStrategy;

class HomeController extends Controller
{
    /**
     * @Route("/", name="start")
     */
    public function startAction()
    {
        $package = new Package(new EmptyVersionStrategy());
      //  echo $package->getUrl('/Schutz.jpg');
        return $this->render('content/startPage.html.twig');
    }
}