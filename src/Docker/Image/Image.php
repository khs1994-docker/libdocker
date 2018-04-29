<?php

namespace Docker;

class Image
{
    const TYPE = 'images';

    const BASE_URL = '/'.self::TYPE;

    use Request;

    public function list(bool $all = false, array $filters = null, bool $digests = false)
    {
        $filters_array = [];

        if ($filters) {
            $filters_array = $this->resolveFilters($filters);
        }

        // filters[name]=nginx

        $data = [
            'all' => $all,
            'digests' => $digests
        ];

        $data = array_merge($data, $filters_array);

        $url = self::BASE_URL.'/json?'.http_build_query($data);

        return $this->request($url);
    }

    public function build(string $gitAddress, string $tag, string $dockerfile = 'Dockerfile', array $other = [], string $auth = null)
    {
        $data = [
            'dockerfile' => $dockerfile,
            't' => $tag,
            'remote' => $gitAddress,
        ];

        $data = array_merge($data, $other);

        $url = '/build?'.http_build_query($data);

        $header = [];

        $header['Content-type'] = "application/x-tar";

        if ($auth) {
            $header['X-Registry-Config'] = $auth;
        }

        return $this->request($url, 'post', null, $header);
    }

    public function deleteBuildCache()
    {
        $url = '/build/prune';

        return $this->request($url, 'post');
    }

    private function create($queryParameters, $request, $auth)
    {
        $url = self::BASE_URL.'/create?'.http_build_query($queryParameters);
        $header = [];
        if ($auth) {
            $header ['X-Registry-Auth'] = $auth;
        }

        return $this->request($url, 'post', $request, $header);
    }

    // 如果 tag 为空，则拉取所有标签，所以必须指定名称

    public function pull(string $image, string $tag = 'latest', string $auth = null, string $platform = null)
    {
        $data = [
            'fromImage' => $image,
            'tag' => $tag,
            'platform' => $platform
        ];

        return $this->create($data, null, $auth);
    }

    public function import(string $fromSrc,
                           string $repo = null,
                           string $auth = null,
                           string $platform = null,
                           string $request = null)
    {
        $data = [
            'fromSrc' => $fromSrc,
            'repo' => $repo,
            'platform' => $platform
        ];

        if ($fromSrc === '-') {
            $request === null or die("$request error");
        }

        return $this->create($data, $request, $auth);
    }

    public function inspect(string $name)
    {
        $url = self::BASE_URL.'/'.$name.'/json';
        return $this->request($url);
    }

    public function history(string $name)
    {
        $url = self::BASE_URL.'/'.$name.'/history';
        return $this->request($url);
    }

    public function push(string $name, string $tag = 'latest', string $auth)
    {
        $url = self::BASE_URL.'/'.$name.'/push?'.http_build_query(['tag' => $tag]);

        $header = [];

        if ($auth) {
            $header ['X-Registry-Auth'] = [$auth];
        }

        return $this->request($url, 'post', null, $header);
    }

    public function tag(string $name, string $repo, string $tag)
    {
        $data = [
            'repo' => $repo,
            'tag' => $tag
        ];

        $url = self::BASE_URL.'/'.$name.'/tag?'.http_build_query($data);

        return $this->request($url, 'post');
    }

    public function remove(string $name, bool $force = false, bool $noprune = false)
    {
        $data = [
            'force' => $force,
            'noprune' => $noprune
        ];

        $url = self::BASE_URL.'/'.$name.'?'.http_build_query($data);

        return $this->request($url, 'delete');
    }

    public function search(string $term, int $limit = null, array $filters = [])
    {
        $filters_array = [];
        if ($filters) {
            $filters_array = $this->resolveFilters($filters);
        }
        $data = [
            'term' => $term,
            'limit' => $limit,
            'filters' => $filters
        ];

        $data = array_merge($data, $filters_array);

        $url = self::BASE_URL.'/search?'.http_build_query($data);

        return $this->request($url);
    }

    public function commit(string $container,
                           string $repo,
                           string $tag,
                           string $comment,
                           string $author,
                           bool $pause,
                           string $changes,
                           array $request_body)
    {
        $data = [
            'container' => $container,
            'repo' => $repo,
            'tag' => $tag,
            'comment' => $comment,
            'author' => $author,
            'pause' => $pause,
            'changes' => $changes
        ];

        $url = '/commit?'.http_build_query($data);

        $request = json_encode($request_body);

        return $this->request($url, 'post', $request, $this->header);
    }

    public function export(string $name)
    {
        $url = self::BASE_URL.'/'.$name.'/get';
        return $this->request($url);
    }

    public function exports(array $names)
    {
        $url = self::BASE_URL.'/get?'.http_build_query(['names' => $names]);

        return $this->request($url);
    }

    public function load(bool $quiet = false, string $tar)
    {
        $url = self::BASE_URL.'/load?'.http_build_query(['quiet' => $quiet]);

        return $this->request($url, 'post', $tar);
    }

    // prune

    private function delete()
    {

    }
}
