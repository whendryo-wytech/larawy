<?php

namespace App\Support\Zip;


use Illuminate\Support\Facades\File;
use RuntimeException;
use ZipArchive;

class Zip
{
    public function extract($zipPath, $destination, bool $deleteZip = true): void
    {
        $originalZipArchive = $zipPath;

        $queue = [$zipPath];

        if (!File::exists($destination)) {
            if (!mkdir($destination, 0777, true) && !is_dir($destination)) {
                throw new RuntimeException(sprintf('Directory "%s" was not created', $destination));
            }
        }

        while ($queue) {
            $currentZip = array_shift($queue);
            $zip = new ZipArchive;

            if ($zip->open($currentZip) !== true) {
                $targetDir = escapeshellarg($destination);
                $zipFile = escapeshellarg($currentZip);
                exec("unzip -o -qq $zipFile -d $targetDir", $output, $returnCode);

                if ($returnCode !== 0) {
                    throw new RuntimeException("Erro ao descompactar via unzip: código $returnCode");
                }

                throw new RuntimeException(sprintf('Error on open "%s"', $currentZip));
            }

            for ($i = 0; $i < $zip->numFiles; $i++) {
                $entry = $zip->getNameIndex($i);

                if (str_ends_with($entry, '/')) {
                    continue; // Ignora diretórios
                }

                $stream = $zip->getStream($entry);
                if (!$stream) {
                    continue; // Não conseguiu abrir o stream
                }

                $filename = basename($entry);
                $uniqueName = $this->generateUniqueFilename($destination, $filename);
                $destPath = $destination.'/'.$uniqueName;

                $outStream = fopen($destPath, 'wb');
                if ($outStream) {
                    stream_copy_to_stream($stream, $outStream); // Lida com arquivos grandes
                    fclose($outStream);
                }

                fclose($stream);

                // Adiciona .zip à fila para extração posterior
                if (strtolower(pathinfo($uniqueName, PATHINFO_EXTENSION)) === 'zip') {
                    $queue[] = $destPath;
                }
            }

            $zip->close();

            if (($deleteZip) && ($originalZipArchive !== $currentZip)) {
                File::delete($currentZip);
            }
        }
    }

    private function generateUniqueFilename($dir, $filename): string
    {
        $path = $dir.'/'.$filename;

        if (!file_exists($path)) {
            return $filename;
        }

        $info = pathinfo($filename);
        $base = $info['filename'];
        $ext = isset($info['extension']) ? '.'.$info['extension'] : '';
        $i = 1;

        do {
            $newFilename = $base.'_'.$i.$ext;
            $path = $dir.'/'.$newFilename;
            $i++;
        } while (file_exists($path));

        return $newFilename;
    }

    public function compact(array $filesToZip, string $file): ?string
    {
        $zipFilePath = $file;
        $zip = new ZipArchive;

        if (!File::exists(dirname($file))) {
            File::makeDirectory(dirname($file));
        }

        if ($zip->open($zipFilePath, ZipArchive::CREATE | ZipArchive::OVERWRITE) === true) {
            if (count($filesToZip) === 0) {
                $zip->addFromString('Nenhum arquivo encontrado', '');
                $zip->close();
                return $file;
            }

            foreach ($filesToZip as $filePath) {
                if (file_exists($filePath)) {
                    $zip->addFile($filePath, basename($filePath));
                }
            }
            $zip->close();
        }

        if (!file_exists($file)) {
            return null;
        }

        return $file;
    }
}
