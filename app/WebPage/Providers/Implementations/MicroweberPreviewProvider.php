<?php

namespace App\WebPage\Providers\Implementations;

use App\WebPage\Types\EnvType;
use Exception;
use Illuminate\Support\Facades\Config;
use Screen\Capture;
use App\WebPage\Providers\PreviewProvider;
use Screen\Exceptions\PhantomJsException;

class MicroweberPreviewProvider implements PreviewProvider
{

    /**
     * @throws PhantomJsException
     * @throws Exception
     */
    function providePreviewImage(string $url): string
    {
        $imageName = time() . '.jpg';

        $screenCapture = new Capture($url);

        $screenCapture->setClipWidth(1440);
        $screenCapture->setClipHeight(800);

        $envType = Config::get("env.envType");

        if ($envType == EnvType::PROD->value){
            $screenCapture->setBinPath(resource_path());
        }

        $screenCapture->setOptions([
            'ignore-ssl-errors' => 'yes'
        ]);

        $screenCapture->output->setLocation(storage_path());
        $screenCapture->save($imageName);

        $imageFile = storage_path() . "/" . $imageName;
        $imageData = file_get_contents($imageFile);

        $base64Data = "data:image/jpg;charset=utf8;base64," . base64_encode($imageData);

        unlink($imageFile);
        $screenCapture->jobs->clean();

        return $base64Data;
    }
}
