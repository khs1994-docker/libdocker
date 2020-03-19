<?php

/** @noinspection PhpUnusedPrivateFieldInspection */

declare(strict_types=1);

namespace Docker\Image;

use Curl\Curl;
use Exception;

/**
 * Image.
 *
 * @see https://docs.docker.com/engine/api/v1.37/#tag/Image
 */
class Client
{
    const TYPE = 'images';

    const BASE_URL = '/'.self::TYPE;

    private static $header = ['content-type' => 'application/json;charset=utf-8'];

    private static $docker_host;

    private static $base_url;

    private static $curl;

    /**
     * @var array
     *
     * @see https://docs.docker.com/engine/api/v1.37/#operation/ImageList
     */
    private static $filters_array_list = [
        'before',
        'dangling',
        'label',
        'reference',
        'since',
    ];

    /**
     * @var array
     *
     * @see          https://docs.docker.com/engine/api/v1.37/#operation/ImageSearch
     */
    private static $filters_array_search = [
        'is-automated',
        'is-official',
        'stars',
    ];

    /**
     * @var array
     *
     * @see          https://docs.docker.com/engine/api/v1.37/#operation/ImagePrune
     */
    private static $filters_array_prune = [
        'dangling',
        'until',
        'label',
    ];

    public function __construct(Curl $curl, $docker_host)
    {
        self::$docker_host = $docker_host;
        self::$base_url = $docker_host.self::BASE_URL;
        self::$curl = $curl;
    }

    /**
     * @return string
     *
     * @throws Exception
     */
    private function resolveFilters(string $type, array $filters)
    {
        $filters_array_defined = 'filters_array_'.$type;

        $filters_array = [];

        try {
            $filters_array_defined = self::$$filters_array_defined;
        } catch (\Throwable $e) {
            throw new Exception($e->getMessage(), $e->getCode());
        }

        foreach ($filters as $k => $v) {
            if (!\in_array($k, $filters_array_defined, true)) {
                throw new Exception($filters, 500);
            }

            if (\is_array($v)) {
                $filters_array["$k"] = $v;

                continue;
            }

            $filters_array["$k"] = [$v];
        }

        return json_encode($filters_array);
    }

    /**
     * @param array|null $filters
     *
     * before=(<image-name>[:<tag>], <image id> or <image@digest>)
     * dangling=true
     * label=key or label="key=value" of an image label
     * reference=(<image-name>[:<tag>])
     * since=(<image-name>[:<tag>], <image id> or <image@digest>)
     *
     * @return mixed 200
     *
     * @throws Exception
     */
    public function list(bool $all = false, array $filters = null, bool $digests = false)
    {
        $filters_array = [];

        if ($filters) {
            $filters_array = [
                'filters' => $this->resolveFilters(__FUNCTION__, $filters),
            ];
        }

        $data = [
            'all' => $all,
            'digests' => $digests,
        ];

        $data = array_merge($data, $filters_array);

        $url = self::$base_url.'/json?'.http_build_query($data);

        return self::$curl->get($url);
    }

    /**
     * @param string      $gitAddress
     * @param string      $tag         name:tag
     * @param array       $buildargs   ['a'=>'b']
     * @param array       $labels      ['a'=>'b']
     * @param string|null $networkmode bridge, host, none, and container:<name|id>
     * @param string      $platform    os[/arch[/variant]]
     * @param string      $request
     *
     * @return mixed 200
     *
     * @throws Exception
     */
    public function build(?string $gitAddress,
                          ?string $auth,
                          string $tag,
                          ?int $shmsize,
                          string $dockerfile = 'Dockerfile',
                          string $extrahosts = null,
                          bool $q = false,
                          bool $nocache = false,
                          string $cachefrom = null,
                          string $pull = null,
                          bool $rm = true,
                          bool $forcerm = false,
                          array $buildargs = null,
                          bool $squash = false,
                          array $labels = null,
                          string $networkmode = null,
                          string $platform = null,
                          ?string $request = null)
    {
        $data = [
            'dockerfile' => $dockerfile,
            't' => $tag,
            'extrahosts' => $extrahosts,
            'remote' => $gitAddress,
            'q' => $q,
            'nocache' => $nocache,
            'cachefrom' => $cachefrom,
            'pull' => $pull,
            'rm' => $rm,
            'forcerm' => $forcerm,
            'buildargs' => json_encode($buildargs),
            'shmsize' => $shmsize,
            'squash' => $squash,
            'labels' => json_encode($labels),
            'networkmode' => $networkmode,
            'platform' => $platform,
        ];

        $url = self::$docker_host.'/build?'.http_build_query(array_filter($data));

        $header = [];

        if ($request) {
            $header['Content-type'] = 'application/x-tar';
        }

        if ($auth) {
            $header['X-Registry-Config'] = $auth;
        }

        return self::$curl->post($url, null, $header);
    }

    /**
     * @return mixed 200
     *
     * @throws Exception
     */
    public function deleteBuildCache()
    {
        $url = self::$docker_host.'/build/prune';

        return self::$curl->post($url);
    }

    /**
     * @param string $request
     * @param string $auth
     *
     * @return mixed 200
     *
     * @throws Exception
     */
    private function create(array $queryParameters, string $request = null, string $auth = null)
    {
        $url = self::$base_url.'/create?'.http_build_query($queryParameters);

        $header = [];

        if ($auth) {
            $header['X-Registry-Auth'] = $auth;
        }

        return self::$curl->post($url, $request, $header);
    }

    /**
     * @param $image
     * @param $tag   当 $image 不包含 tag 时的默认值
     *
     * @return array
     */
    public function parseImage(string $image, string $tag = 'latest')
    {
        $image_array = explode(':', $image);

        $pull_tag = $tag;
        $pull_image = $image;

        if (1 === \count($image_array)) {
            return [$image, $tag];
        }

        // 取最后一位为 tag,删除 tag,得到 image
        $tag = array_pop($image_array);
        $image = implode(':', $image_array);

        if (preg_match('#/#', $tag)) {
            // tag 包含 /
            // 说明是一个包含端口号的 url 并且不包含 tag ,取默认值即可
            $tag = $pull_tag;
            $image = $pull_image;
        }

        return [$image, $tag];
    }

    /**
     * 如果 tag 为空，则拉取所有标签，所以必须指定名称
     * 额外增加 $force 参数，拉取前首先判断是否已存在。
     *
     * @param string|null $platform os[/arch[/variant]]
     *
     * @return mixed 200
     *
     * @throws Exception
     */
    public function pull(string $image, string $tag = 'latest', bool $force = false, string $auth = null, string $platform = null)
    {
        list($image, $tag) = $this->parseImage($image, $tag);

        $json = $this->list(true, ['reference' => "$image:$tag"]);

        if (false === $force and json_decode($json)) {
            return "$image:$tag".' Already Exists';
        }

        $data = [
            'fromImage' => $image,
            'tag' => $tag,
            'platform' => $platform,
        ];

        return $this->create($data, null, $auth);
    }

    /**
     * @return mixed 200
     *
     * @throws Exception
     */
    public function import(string $fromSrc,
                           string $repo = null,
                           string $auth = null,
                           string $platform = null,
                           string $request = null)
    {
        $data = [
            'fromSrc' => $fromSrc,
            'repo' => $repo,
            'platform' => $platform,
        ];

        if ('-' === $fromSrc) {
            null === $request or die("$request error");
        }

        return $this->create($data, $request, $auth);
    }

    /**
     * @return mixed 200
     *
     * @throws Exception
     */
    public function inspect(string $name)
    {
        $url = self::$base_url.'/'.$name.'/json';

        return self::$curl->get($url);
    }

    /**
     * @return mixed 200
     *
     * @throws Exception
     */
    public function history(string $name)
    {
        $url = self::$base_url.'/'.$name.'/history';

        return self::$curl->get($url);
    }

    /**
     * @param string $auth
     *
     * @return mixed 200
     *
     * @throws Exception
     */
    public function push(string $image, string $tag = 'latest', string $auth = null)
    {
        list($image, $tag) = $this->parseImage($image, $tag);

        $url = self::$base_url.'/'.$image.'/push?'.http_build_query(['tag' => $tag]);

        $header = [];

        if ($auth) {
            $header['X-Registry-Auth'] = $auth;
        }

        echo self::$curl->post($url, null, $header);

        var_dump(self::$curl->getRequestHeaders());
    }

    /**
     * @return mixed 201
     *
     * @throws Exception
     */
    public function tag(string $name, string $repo, string $tag = 'latest')
    {
        $data = [
            'repo' => $repo,
            'tag' => $tag,
        ];

        $url = self::$base_url.'/'.$name.'/tag?'.http_build_query($data);

        return self::$curl->post($url);
    }

    /**
     * @return mixed 200
     *
     * @throws Exception
     */
    public function remove(string $name, bool $force = false, bool $noprune = false)
    {
        $data = [
            'force' => $force,
            'noprune' => $noprune,
        ];

        $url = self::$base_url.'/'.$name.'?'.http_build_query($data);

        return self::$curl->delete($url);
    }

    /**
     * @param array $filters
     *
     * is-automated=(true|false)
     * is-official=(true|false)
     * stars=<number> Matches images that has at least 'number' stars
     *
     * @return mixed 200
     *
     * @throws Exception
     */
    public function search(string $term, int $limit = null, array $filters = [])
    {
        $filters_array = [];

        if ($filters) {
            $filters_array = [
                'filters' => $this->resolveFilters(__FUNCTION__, $filters),
            ];
        }

        $data = [
            'term' => $term,
            'limit' => $limit,
            'filters' => $filters,
        ];

        $data = array_merge($data, $filters_array);

        $url = self::$base_url.'/search?'.http_build_query($data);

        return self::$curl->get($url);
    }

    /**
     * @return mixed 200
     *
     * @throws Exception
     */
    public function prune(array $filters = [])
    {
        $url = self::$base_url.'/prune';

        if ($filters) {
            $filters_array = [
                'filters' => $this->resolveFilters(__FUNCTION__, $filters),
            ];
            $url = $url.'?'.http_build_query($filters_array);
        }

        return self::$curl->post($url);
    }

    /**
     * Create a new image from a container.
     *
     * @return mixed 201
     *
     * @throws Exception
     *
     * @see https://docs.docker.com/engine/api/v1.37/#operation/ImageCommit
     */
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
            'changes' => $changes,
        ];

        $url = self::$docker_host.'/commit?'.http_build_query($data);

        $request = json_encode($request_body);

        return self::$curl->post($url, $request, self::$header);
    }

    /**
     * Get a tarball containing all images and metadata for a repository.
     *
     * @return mixed 200
     *
     * @throws Exception
     */
    public function export(string $name)
    {
        $url = self::$base_url.'/'.$name.'/get';

        return self::$curl->get($url);
    }

    /**
     * Get a tarball containing all images and metadata for several image repositories.
     *
     * @return mixed 200
     *
     * @throws Exception
     */
    public function exports(array $names)
    {
        $url = self::$base_url.'/get?'.http_build_query(['names' => $names]);

        return self::$curl->get($url);
    }

    /**
     * Load a set of images and tags into a repository.
     *
     * @return mixed 200
     *
     * @throws Exception
     */
    public function load(string $tar, bool $quiet = false)
    {
        $url = self::$base_url.'/load?'.http_build_query(['quiet' => $quiet]);

        return self::$curl->post($url, $tar);
    }
}
