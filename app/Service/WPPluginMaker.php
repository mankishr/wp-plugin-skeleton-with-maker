<?php

namespace App\Service;

use Symfony\Component\Finder\Finder;

class WPPluginMaker

{

    protected $finder;

    public function __construct()
    {
        $this->finder = new Finder();
    }

    public function createNewPluginFromWpPluginSkeleton(): \Generator
    {
        $this->finder->notPath('vendor');
        $this->finder->files()->in(__DIR__.'/../../wp-plugin-skeleton');

        if ($this->finder->hasResults()) {
            foreach ($this->finder as $file) {
                yield $file->getRelativePathname();
            }
        }

    }
}