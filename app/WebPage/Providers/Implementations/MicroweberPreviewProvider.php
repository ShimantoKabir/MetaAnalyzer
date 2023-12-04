<?php

namespace App\WebPage\Providers\Implementations;

use Screen\Capture;
use App\WebPage\Providers\PreviewProvider;

class MicroweberPreviewProvider implements PreviewProvider
{

  function providePreviewImage(string $url): string
  {
    $imageName = time() . '.jpg';

    $screenCapture = new Capture($url);

    $screenCapture->setWidth(1200);
    $screenCapture->setHeight(800);

    $screenCapture->output->setLocation(public_path());
    $screenCapture->save($imageName);

    $imageFile = public_path() . "\\" . $imageName;
    $imageData = file_get_contents($imageFile);

    $base64Data = "data:image/jpg;charset=utf8;base64," . base64_encode($imageData);

    unlink($imageFile);

    return $base64Data;
  }
}
