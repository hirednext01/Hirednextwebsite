<?php
declare(strict_types=1);
namespace App\Services\Cv\Automation;

final class CvFulfilmentStore
{
    private string $directory;
    public function __construct(?string $directory = null)
    {
        // Hostinger serves ROOTPATH/public and ROOTPATH through rewrites. Keep
        // capabilities, source documents and journals outside both web roots.
        $this->directory = $directory ?? dirname(rtrim(ROOTPATH, DIRECTORY_SEPARATOR)) . '/hirednext-cv-automation';
        if (!is_dir($this->directory) && !mkdir($this->directory,0700,true) && !is_dir($this->directory)) { throw new \RuntimeException('private_store_unavailable'); }
        chmod($this->directory,0700);
    }
    public function locked(callable $callback)
    {
        $handle=fopen($this->directory.'/operations.lock','c');
        if (!$handle || !flock($handle,LOCK_EX|LOCK_NB)) { if ($handle) { fclose($handle); } throw new \DomainException('busy_retry'); }
        try { return $callback($this); } finally { flock($handle,LOCK_UN); fclose($handle); }
    }
    public function read(string $key): array
    {
        $path=$this->path($key);
        if (!is_file($path)) { return []; }
        $data=json_decode((string)file_get_contents($path),true,64,JSON_THROW_ON_ERROR);
        if (!is_array($data)) { throw new \RuntimeException('invalid_private_state'); }
        return $data;
    }
    public function write(string $key,array $data): void
    {
        $this->put($key,json_encode($data,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES|JSON_THROW_ON_ERROR));
    }
    public function put(string $key,string $bytes): string
    {
        $path=$this->path($key); $temp=tempnam($this->directory,'pending-');
        if (!$temp) { throw new \RuntimeException('private_store_unavailable'); }
        try {
            chmod($temp,0600);
            if (file_put_contents($temp,$bytes)!==strlen($bytes) || !rename($temp,$path)) { throw new \RuntimeException('private_store_write_failed'); }
        } finally { if (is_file($temp)) { unlink($temp); } }
        return $path;
    }
    public function secret(): string
    {
        $path=$this->directory.'/access.key'; $handle=fopen($path,'c+b');
        if (!$handle || !flock($handle,LOCK_EX)) { throw new \RuntimeException('private_key_unavailable'); }
        try {
            chmod($path,0600); $key=stream_get_contents($handle);
            if ($key==='') { $key=random_bytes(32); if (fwrite($handle,$key)!==32 || !fflush($handle)) { throw new \RuntimeException('private_key_write_failed'); } }
            if (strlen((string)$key)!==32) { throw new \RuntimeException('private_key_invalid'); }
            return $key;
        } finally { flock($handle,LOCK_UN); fclose($handle); }
    }
    private function path(string $key): string { return $this->directory.'/'.hash('sha256',$key).'.data'; }
}
