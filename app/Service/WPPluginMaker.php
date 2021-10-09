<?php

namespace App\Service;

use Symfony\Component\Filesystem\Exception\IOExceptionInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;

class WPPluginMaker
{
    /**
     * @var Finder
     */
    protected $finder;
    /**
     * @var Filesystem
     */
    protected $fileSystem;

    public function __construct()
    {
        $this->finder = new Finder();
        $this->fileSystem = new Filesystem();
    }

    public function createNewPluginFromWpPluginSkeleton(string $pluginName, string $author, string $version): \Generator
    {
        $pluginSlug = $this->slugify($pluginName);

        $newPluginLocation = __DIR__.'/../../'.$pluginSlug.'/';

        try {
            if (!$this->fileSystem->exists($newPluginLocation))
            {
                $this->fileSystem->mkdir($newPluginLocation, 0775);
            }else{
                yield "Error creating directory at location ". $newPluginLocation.' Directory already exists.';
            }
        } catch (IOExceptionInterface $exception) {
            yield $exception->getMessage();
        }

        $this->finder->notPath('vendor');
        $this->finder->files()->in(__DIR__ . '/../../wp-plugin-skeleton');

        if ($this->finder->hasResults()) {

            $this->createIgnoredFiles($newPluginLocation);

            foreach ($this->finder as $file) {
                $fileNameWithExtension = $file->getRelativePathname();
                $fileContent = $file->getContents();
                $newFileContent = $this->replaceContent($pluginName, $fileContent, $author);

                if($fileNameWithExtension === 'wp-plugin-skeleton.php'){
                    $newFileContent = preg_replace("%[0-9.]+[0-9.]+[0-9]%i", $version, $newFileContent);
                }

                $newFileNameWithExtension = str_replace('wp-plugin-skeleton', $pluginSlug, $fileNameWithExtension);
                $this->fileSystem->dumpFile($newPluginLocation.$newFileNameWithExtension, $newFileContent);
                yield $newFileNameWithExtension;
            }
        }

    }

    /**
     * @param string $pluginName
     * @param string $fileContent
     * @param string $author
     * @return string
     */
    private function replaceContent(string $pluginName, string $fileContent, string $author): string
    {
        $fileContent = str_replace( 'Anka Bajurin Stiskalov <anka@q.agency>', $author, $fileContent);
        $fileContent = str_replace( 'Wp Plugin Skeleton', $pluginName, $fileContent);
        $fileContent = str_replace( 'Wp_Plugin_Skeleton', $this->slugify($pluginName, '_', 'ucwords'), $fileContent);
        $fileContent = str_replace( 'wp_plugin_skeleton', $this->slugify($pluginName, '_'), $fileContent);
        $fileContent = str_replace( 'wp-plugin-skeleton', $this->slugify($pluginName), $fileContent);
        return str_replace( 'WP_PLUGIN_SKELETON', $this->slugify($pluginName, '_', 'strtoupper'), $fileContent);
    }

    /**
     * Slugify string.
     *
     * @param string $text String to slugify.
     * @param string $replacement
     * @param string $type
     * @return string
     */
    private function slugify(string $text, string $replacement = '-', string $type = 'strtolower'): string
    {
        switch ($type) {
            case 'ucwords':
                $text = ucwords($text);
                break;
            case 'strtoupper':
                $text = strtoupper($text);
                break;
            default:
                $text = strtolower($text);
                break;
        }

        $text = preg_replace('~[^\\pL\d]+~u', $replacement, $text);

        $text = trim($text, $replacement);

        if (function_exists('iconv')) {
            $text = iconv('UTF-8', 'ASCII//TRANSLIT', $text);
        }

        return preg_replace('~[^-\w]+~', '', $text);
    }

    /**
     * @param string $newPluginLocation
     */
    private function createIgnoredFiles(string $newPluginLocation ): void
    {
        $this->fileSystem->dumpFile($newPluginLocation.'.gitignore', '/vendor');
        $this->fileSystem->dumpFile($newPluginLocation.'.deployignore', '# /vendor');
    }
}