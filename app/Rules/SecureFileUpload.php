<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Http\UploadedFile;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;


class SecureFileUpload implements ValidationRule
{
    protected $allowedTypes;
    protected $maxSizeKB;

    public function __construct($allowedTypes = ['jpg', 'jpeg', 'png', 'pdf', 'doc', 'docx'], $maxSizeKB = 5120)
    {
        $this->allowedTypes = $allowedTypes;
        $this->maxSizeKB = $maxSizeKB;
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!$value instanceof UploadedFile) {
            $fail('The ' . $attribute . ' must be a valid uploaded file.');
            return;
        }

        // Check file size
        if ($value->getSize() > ($this->maxSizeKB * 1024)) {
            $fail('The ' . $attribute . ' may not be greater than ' . $this->maxSizeKB . ' kilobytes.');
            return;
        }

        // Check file extension
        $extension = strtolower($value->getClientOriginalExtension());
        if (!in_array($extension, $this->allowedTypes)) {
            $fail('The ' . $attribute . ' must be a file of type: ' . implode(', ', $this->allowedTypes) . '.');
            return;
        }

        // Validate file content based on extension
        $isValid = $this->validateFileContent($value, $extension);
        if (!$isValid) {
            $fail('The ' . $attribute . ' file content does not match its extension. Invalid file detected.');
            return;
        }

        // Additional security checks for images
        if (in_array($extension, ['jpg', 'jpeg', 'png', 'gif'])) {
            $this->validateImageSecurity($value, $fail);
        }
    }

    /**
     * Validate file content based on its extension
     */
    private function validateFileContent(UploadedFile $file, string $extension): bool
    {
        $mimeType = $file->getMimeType();
        $originalName = $file->getClientOriginalName();

        // Map extensions to expected MIME types
        $mimeTypes = [
            'jpg' => ['image/jpeg'],
            'jpeg' => ['image/jpeg'],
            'png' => ['image/png'],
            'gif' => ['image/gif'],
            'pdf' => ['application/pdf'],
            'doc' => ['application/msword', 'application/vnd.ms-word'],
            'docx' => ['application/vnd.openxmlformats-officedocument.wordprocessingml.document']
        ];

        if (isset($mimeTypes[$extension])) {
            if (!in_array($mimeType, $mimeTypes[$extension])) {
                return false;
            }
        }

        // Additional check: try to detect if the file is actually what it claims to be
        switch ($extension) {
            case 'pdf':
                // Check if PDF header is present
                $handle = fopen($file->getPathname(), 'rb');
                $header = fread($handle, 4);
                fclose($handle);
                if ($header !== '%PDF') {
                    return false;
                }
                break;

            case 'jpg':
            case 'jpeg':
                // Check JPEG header
                $handle = fopen($file->getPathname(), 'rb');
                $header = fread($handle, 2);
                fclose($handle);
                if ($header !== chr(0xFF) . chr(0xD8)) {
                    return false;
                }
                break;

            case 'png':
                // Check PNG header
                $handle = fopen($file->getPathname(), 'rb');
                $header = fread($handle, 8);
                fclose($handle);
                $expectedHeader = "\x89PNG\x0D\x0A\x1A\x0A";
                if ($header !== $expectedHeader) {
                    return false;
                }
                break;
        }

        return true;
    }

    /**
     * Validate image security by processing it with Intervention Image
     */
    private function validateImageSecurity(UploadedFile $file, Closure $fail): bool
    {
        try {
            $manager = new ImageManager(new Driver());

            $image = $manager->read($file->getPathname());

            if (!$image) {
                $fail('The image file is corrupted or invalid.');
                return false;
            }

            $width = $image->width();
            $height = $image->height();

            // Proteksi decompression bomb
            if ($width > 10000 || $height > 10000) {
                $fail('The image dimensions are too large.');
                return false;
            }

            return true;
        } catch (\Throwable $e) {
            $fail('The image file contains malicious content or is invalid.');
            return false;
        }
    }
}
