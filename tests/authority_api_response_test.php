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
        public function __construct(private string $path = '/api/cv-fulfilment') {}
        public function getUri(): object { return new class($this->path) {
            public function __construct(private string $path) {}
            public function getPath(): string { return $this->path; }
        }; }
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
    $website='<!doctype html><html><head><title>HiredNext</title></head><body><main>Employer content</main></body></html>';
    $filter=new \App\Filters\PublicAuthorityFilter();
    $homeResponse=new AuthorityResponse($website);
    $filter->after(new AuthorityRequest('/'),$homeResponse);
    if (str_contains($homeResponse->body,'data-hirednext-buyer-questions')) {
        throw new \RuntimeException('FAIL: the homepage must not receive the long buyer-question block.');
    }
    $guideResponse=new AuthorityResponse($website);
    $filter->after(new AuthorityRequest('/search-authority'),$guideResponse);
    $filter->after(new AuthorityRequest('/search-authority'),$guideResponse);
    if (substr_count($guideResponse->body,'data-hirednext-buyer-questions')!==1 || !str_contains($guideResponse->body,'/guides/confidential-cfo-search-india')) {
        throw new \RuntimeException('FAIL: the knowledge centre must retain the buyer questions and links exactly once.');
    }
    echo "PASS: detailed buyer questions stay in the knowledge centre, without homepage bloat or duplicates.\n";
}
