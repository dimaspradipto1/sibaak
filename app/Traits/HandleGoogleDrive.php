<?php

namespace App\Traits;

use Google\Client as GoogleClient;
use Google\Service\Drive as GoogleDrive;
use Google\Service\Drive\Permission;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

trait HandleGoogleDrive
{
    /**
     * Get Google Drive Service.
     */
    private function driveService(): GoogleDrive
    {
        $client = new GoogleClient();
        $client->setClientId(env('GOOGLE_DRIVE_CLIENT_ID'));
        $client->setClientSecret(env('GOOGLE_DRIVE_CLIENT_SECRET'));

        $refreshToken = env('GOOGLE_DRIVE_REFRESH_TOKEN');
        if (!$refreshToken) {
            throw new \Exception('Refresh token tidak ditemukan di .env');
        }

        $client->fetchAccessTokenWithRefreshToken($refreshToken);
        return new GoogleDrive($client);
    }

    /**
     * Set permission: anyone with link (reader).
     */
    private function makeDriveFilePublic(string $fileId): void
    {
        $service = $this->driveService();
        $permission = new Permission([
            'type' => 'anyone',
            'role' => 'reader',
        ]);

        $service->permissions->create($fileId, $permission, [
            'fields' => 'id',
            'supportsAllDrives' => true,
        ]);
    }

    /**
     * Delete file from Google Drive.
     */
    private function deleteDriveFile(?string $url): void
    {
        if (!$url) return;

        $fileId = $this->extractDriveFileId($url);

        if ($fileId) {
            try {
                $service = $this->driveService();
                $service->files->delete($fileId, [
                    'supportsAllDrives' => true,
                ]);
            } catch (\Throwable $e) {
                Log::error('Google Drive Delete Error: ' . $e->getMessage());
            }
        }
    }

    /**
     * Extract File ID from Google Drive URL.
     */
    private function extractDriveFileId(?string $url): ?string
    {
        if (!$url) return null;

        // Pattern for https://drive.google.com/file/d/FILE_ID/view
        if (preg_match('/\/d\/([a-zA-Z0-9_-]+)/', $url, $matches)) {
            return $matches[1];
        }

        return null;
    }
}
