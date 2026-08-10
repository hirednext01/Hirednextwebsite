<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\HTTP\ResponseInterface;

class UploadController extends BaseApiController
{
    public function index()
    {
        try {
            // Handle preflight OPTIONS request
            if ($this->request->getMethod() === 'options') {
                return $this->response->setStatusCode(200);
            }
            
            $file = $this->request->getFile('file');
            
            if (!$file || !$file->isValid()) {
                return $this->errorResponse('No file uploaded or invalid file', 400);
            }

            // Validate file type
            $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
            if (!in_array($file->getClientMimeType(), $allowedTypes)) {
                return $this->errorResponse('Invalid file type. Only JPG, PNG, GIF, and WebP are allowed.', 400);
            }

            // Validate file size (5MB max)
            $maxSize = 5 * 1024 * 1024; // 5MB in bytes
            if ($file->getSize() > $maxSize) {
                return $this->errorResponse('File size too large. Maximum size is 5MB.', 400);
            }

            // Generate unique filename
            $newName = $file->getRandomName();
            
            // Create upload directory if it doesn't exist
            $uploadPath = FCPATH . 'uploads/images/';
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }

            // Move file to uploads directory
            if (!$file->move($uploadPath, $newName)) {
                return $this->errorResponse('Failed to save file', 500);
            }

            // Generate public URL
            $fileUrl = base_url('uploads/images/' . $newName);

            $data = [
                'filename' => $newName,
                'original_name' => $file->getClientName(),
                'url' => $fileUrl,
                'size' => $file->getSize(),
                'mime_type' => $file->getClientMimeType(),
                'uploaded_at' => date('Y-m-d H:i:s')
            ];

            return $this->successResponse($data, 'File uploaded successfully');

        } catch (\Exception $e) {
            return $this->errorResponse('Upload failed: ' . $e->getMessage(), 500);
        }
    }

    public function delete($filename = null)
    {
        try {
            if (!$filename) {
                return $this->errorResponse('Filename is required', 400);
            }

            $filePath = FCPATH . 'uploads/images/' . $filename;
            
            if (!file_exists($filePath)) {
                return $this->errorResponse('File not found', 404);
            }

            if (unlink($filePath)) {
                return $this->successResponse([], 'File deleted successfully');
            } else {
                return $this->errorResponse('Failed to delete file', 500);
            }

        } catch (\Exception $e) {
            return $this->errorResponse('Delete failed: ' . $e->getMessage(), 500);
        }
    }
}
