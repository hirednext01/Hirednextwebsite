<?php

namespace App\Controllers\Api;

class UploadApi extends BaseApiController
{
    public function upload()
    {
        try {
            $file = $this->request->getFile('file');
            
            if (!$file || !$file->isValid()) {
                return $this->errorResponse('No file uploaded or invalid file', 400);
            }

            // Validate file type
            $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
            if (!in_array($file->getMimeType(), $allowedTypes)) {
                return $this->errorResponse('Invalid file type. Only images are allowed.', 400);
            }

            // Validate file size (5MB max)
            if ($file->getSize() > 5 * 1024 * 1024) {
                return $this->errorResponse('File too large. Maximum size is 5MB.', 400);
            }

            // Generate unique filename
            $newName = $file->getRandomName();
            
            // Move file to uploads directory
            $uploadPath = FCPATH . 'uploads/';
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }
            
            $file->move($uploadPath, $newName);
            
            return $this->successResponse([
                'filename' => $newName,
                'original_name' => $file->getClientName(),
                'size' => $file->getSize(),
                'mime_type' => $file->getMimeType(),
                'url' => base_url('uploads/' . $newName)
            ], 'File uploaded successfully');
            
        } catch (\Exception $e) {
            return $this->errorResponse('Upload failed: ' . $e->getMessage(), 500);
        }
    }

    public function delete()
    {
        try {
            $data = $this->request->getJSON(true);
            $filename = $data['filename'] ?? null;
            
            if (!$filename) {
                return $this->errorResponse('Filename is required', 400);
            }

            $filePath = FCPATH . 'uploads/' . $filename;
            
            if (file_exists($filePath)) {
                unlink($filePath);
                return $this->successResponse(null, 'File deleted successfully');
            } else {
                return $this->errorResponse('File not found', 404);
            }
            
        } catch (\Exception $e) {
            return $this->errorResponse('Delete failed: ' . $e->getMessage(), 500);
        }
    }
}
