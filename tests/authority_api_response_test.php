<?php
declare(strict_types=1);
namespace CodeIgniter\HTTP { interface RequestInterface {} interface ResponseInterface {} }
namespace CodeIgniter\Filters { interface FilterInterface {} }
namespace {
    function esc(string $s,string $context='html'): string { return htmlspecialchars($s,ENT_QUOTES,'UTF-8'); }
    function base_url(string $s=''): string { return 'https://hirednext.net/'.$s; }
    require __DIR__.'/../app/Filters/PublicAuthorityFilter.php';
    require __DIR__.'/../app/Filters/HumanAuthorityLinksFilter.php';
    class AuthorityRequest implements \CodeIgniter\HTTP\RequestInterface {
        public function getUri(): object { return new class { public function getPath(): string { return '/api/cv-fulfilment'; } }; }
    }
    class AuthorityResponse implements \CodeIgniter\HTTP\ResponseInterface {
        public function __construct(public string $body) {}
        public function getBody(): string { return $this->body; }
        public function setBody(string $body): void { $this->body=$body; }
    }
    $html='<!doctype html><html><head><title>Email</title></head><body>Candidate message</body></html>';
    $json=json_encode(['ok'=>true,'result'=>['outbound'=>['html'=>$html]]],JSON_UNESCAPED_SLASHES|JSON_THROW_ON_ERROR);
    foreach ([new \App\Filters\PublicAuthorityFilter(),new \App\Filters\HumanAuthorityLinksFilter()] as $filter) {
        $response=new AuthorityResponse($json); $filter->after(new AuthorityRequest(),$response);
        if ($response->body!==$json || !json_decode($response->body,true)) { throw new \RuntimeException('FAIL: API JSON containing an email must remain byte-identical.'); }
    }
    $response=new AuthorityResponse($html); (new \App\Filters\PublicAuthorityFilter())->after(new AuthorityRequest(),$response);
    if (!str_contains($response->body,'data-hirednext-ai-referral')) { throw new \RuntimeException('FAIL: full website HTML must retain existing discovery behavior.'); }
    echo "PASS: email HTML inside API JSON is preserved; website discovery still works.\n";
}
