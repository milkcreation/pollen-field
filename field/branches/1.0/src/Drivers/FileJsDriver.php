<?php

declare(strict_types=1);

namespace Pollen\Field\Drivers;

use League\Flysystem\FilesystemException;
use Pollen\Http\JsonResponse;
use Pollen\Http\ResponseInterface;
use Pollen\Support\Proxy\StorageProxy;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Pollen\Field\FieldDriver;

class FileJsDriver extends FieldDriver implements FileJsDriverInterface
{
    use StorageProxy;

    /**
     * @inheritDoc
     */
    public function defaultParams(): array
    {
        return array_merge(
            parent::defaultParams(),
            [
                /**
                 *
                 */
                'container' => [],
                /**
                 * @var string $dirname Chemin absolu vers le répertoire de stockage des fichiers téléchargés.
                 */
                'dirname'   => PUBLIC_PATH,
                /**
                 * @var bool $multiple Activation du chargement de fichiers multiple.
                 */
                'multiple'  => true,
                /**
                 * @var array $params Liste des paramètres complémentaires passées à la requête Xhr de téléchargement.
                 */
                'params'    => [],
                /**
                 * @var array uploader Liste des paramètres de configuration du pilote JS de téléchargement.
                 */
                'uploader'  => [
                    'driver' => 'dropzone',
                ],
            ]
        );
    }

    /**
     * @inheritDoc
     */
    public function parseDropzone(): FileJsDriverInterface
    {
        $this->set(
            'uploader',
            array_merge(
                [
                    'createImageThumbnails' => false,
                    'maxFiles'              => $this->get('multiple') ? null : 1,
                    'params'                => array_merge(
                        $this->get('params', []),
                        [
                            '_dir' => $this->get('dirname'),
                        ]
                    ),
                    'timeout'               => 0,
                    'url'                   => $this->getXhrUrl(),
                ],
                $this->get('uploader', [])
            )
        );

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function render(): string
    {
        $this->set('attrs.data-control', 'file-js');

        $this->set(
            'container.attrs.class',
            sprintf(
                $this->get('container.attrs.class') ?: '%s',
                'FieldFileJs-container'
            )
        );
        $this->set('container.attrs.data-control', 'file-js.container');

        $uploader = $this->pull('uploader.driver', 'dropzone');
        if ($uploader === 'dropzone') {
            $this->parseDropzone();
        }
        $this->set('attrs.data-options', [$uploader => $this->pull('uploader', [])]);

        return parent::render();
    }

    /**
     * @inheritDoc
     */
    public function xhrResponse(...$args): ResponseInterface
    {
        $disk = $this->storage()->createLocalFilesystem($this->httpRequest()->input('_dir'));

        foreach ($this->httpRequest()->files as $f) {
            /** @var UploadedFile $f */
            try {
                $disk->write($f->getClientOriginalName(), file_get_contents($f->getPathname()));
            } catch (FilesystemException $e) {
                unset($e);
            }
        }

        return new JsonResponse([
            'success' => true,
        ]);
    }

    /**
     * @inheritDoc
     */
    public function viewDirectory(): string
    {
        return $this->field()->resources('/views/file-js');
    }
}