<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use RuntimeException;

class SupabaseStorageService
{
    private string $supabaseUrl;

    private string $serviceRoleKey;

    /**
     * @throws RuntimeException
     */
    public function __construct()
    {
        $this->supabaseUrl = rtrim(config('services.supabase.url', ''), '/');
        $this->serviceRoleKey = config('services.supabase.service_role_key', '');

        if (empty($this->supabaseUrl) || empty($this->serviceRoleKey)) {
            throw new RuntimeException('Supabase credentials are not configured. Please set SUPABASE_URL and SUPABASE_SERVICE_ROLE_KEY in your .env file.');
        }
    }

    /**
     * Upload a file to Supabase Storage and return its public URL.
     *
     * @param  UploadedFile  $file  The uploaded file instance
     * @param  string  $bucket  The target bucket name (e.g. 'dresses', 'payments')
     * @param  string|null  $folder  Optional subfolder within the bucket
     * @return string The public URL of the uploaded file
     *
     * @throws RuntimeException
     */
    public function upload(UploadedFile $file, string $bucket, ?string $folder = null): string
    {
        $extension = $file->getClientOriginalExtension();
        $filename = Str::uuid()->toString().'.'.$extension;
        $path = $folder ? "{$folder}/{$filename}" : $filename;

        $endpoint = "{$this->supabaseUrl}/storage/v1/object/{$bucket}/{$path}";

        $response = Http::withHeaders([
            'Authorization' => "Bearer {$this->serviceRoleKey}",
            'Content-Type' => $file->getMimeType(),
            'x-upsert' => 'false',
        ])->withBody(
            file_get_contents($file->getRealPath()),
            $file->getMimeType()
        )->post($endpoint);

        if ($response->failed()) {
            throw new RuntimeException(
                'Failed to upload file to Supabase Storage: '.$response->body()
            );
        }

        return $this->getPublicUrl($bucket, $path);
    }

    /**
     * Delete a file from Supabase Storage by its public URL.
     *
     * @param  string  $publicUrl  The full public URL of the file to delete
     */
    public function delete(string $publicUrl): void
    {
        // URL format: {supabaseUrl}/storage/v1/object/public/{bucket}/{path}
        $prefix = "{$this->supabaseUrl}/storage/v1/object/public/";
        if (! str_starts_with($publicUrl, $prefix)) {
            return; // Not a Supabase URL, skip silently
        }

        $bucketAndPath = substr($publicUrl, strlen($prefix));
        [$bucket, $path] = array_pad(explode('/', $bucketAndPath, 2), 2, '');

        $endpoint = "{$this->supabaseUrl}/storage/v1/object/{$bucket}/{$path}";

        Http::withHeaders([
            'Authorization' => "Bearer {$this->serviceRoleKey}",
        ])->delete($endpoint);
    }

    /**
     * Build the public URL for a file in a Supabase Storage bucket.
     */
    public function getPublicUrl(string $bucket, string $path): string
    {
        return "{$this->supabaseUrl}/storage/v1/object/public/{$bucket}/{$path}";
    }
}
