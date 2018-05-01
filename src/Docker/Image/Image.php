<?php /** @noinspection PhpUnusedPrivateFieldInspection */

namespace Docker\Image;

use Curl\Curl;
use Error;
use Exception;

class Image
{
    const TYPE = 'images';

    const BASE_URL = '/'.self::TYPE;

    private static $header = ['content-type' => 'application/json;charset=utf-8'];

    private static $base_url;

    private static $curl;

    /**
     * @var array
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
     * @see          https://docs.docker.com/engine/api/v1.37/#operation/ImageSearch
     */
    private static $filters_array_search = [
        'is-automated',
        'is-official',
        'stars',
    ];

    /**
     * @var array
     * @see          https://docs.docker.com/engine/api/v1.37/#operation/ImagePrune
     */
    private static $filters_array_prune = [
        'dangling',
        'until',
        'label',
    ];

    public function __construct(Curl $curl, $docker_host)
    {
        self::$base_url = $docker_host.self::BASE_URL;
        self::$curl = $curl;
    }

    /**
     * @param string $type
     * @param array  $filters
     *
     * @return string
     * @throws Exception
     */
    private function resolveFilters(string $type, array $filters)
    {
        $filters_array_defined = 'filters_array_'.$type;

        $filters_array = [];

        try {
            $filters_array_defined = self::$$filters_array_defined;
        } catch (Error | Exception $e) {
            throw new Exception($e->getMessage(), $e->getCode());
        }

        foreach ($filters as $k => $v) {
            if (!in_array($k, $filters_array_defined)) {
                throw new Exception($filters, 500);
            }

            if (is_array($v)) {
                $filters_array["$k"] = $v;
                continue;
            }

            $filters_array["$k"] = [$v];
        }

        return json_encode($filters_array);
    }

    /**
     * @param bool       $all
     * @param array|null $filters
     * @param bool       $digests
     *
     * @return mixed
     * @throws Exception
     */
    public function list(bool $all = false, array $filters = null, bool $digests = false)
    {
        $filters_array = [];

        if ($filters) {
            $filters_array = [
                'filters' => $this->resolveFilters(__FUNCTION__, $filters)
            ];
        }

        $data = [
            'all' => $all,
            'digests' => $digests
        ];

        $data = array_merge($data, $filters_array);

        $url = self::$base_url.'/json?'.http_build_query($data);

        return self::$curl->get($url);
    }

    /**
     * @param string      $gitAddress
     * @param string      $tag
     * @param string      $dockerfile
     * @param array       $other
     * @param string|null $auth
     *
     * @return mixed
     */
    public function build(string $gitAddress,
                          string $tag,
                          string $dockerfile = 'Dockerfile',
                          array $other = [],
                          string $auth = null)
    {
        $data = [
            'dockerfile' => $dockerfile,
            't' => $tag,
            'remote' => $gitAddress,
        ];

        $data = array_merge($data, $other);

        $url = self::$base_url.'/build?'.http_build_query($data);

        $header = [];

        $header['Content-type'] = "application/x-tar";

        if ($auth) {
            $header['X-Registry-Config'] = $auth;
        }

        return self::$curl->post($url, null, $header);
    }

    /**
     * @return mixed
     */
    public function deleteBuildCache()
    {
        $url = self::$base_url.'/build/prune';

        return self::$curl->post($url);
    }

    /**
     * @param array  $queryParameters
     * @param string $request
     * @param string $auth
     *
     * @return mixed
     */
    private function create(array $queryParameters, string $request = null, string $auth = null)
    {
        $url = self::$base_url.'/create?'.http_build_query($queryParameters);
        $header = [];
        if ($auth) {
            $header ['X-Registry-Auth'] = $auth;
        }
        var_dump($url);
        return self::$curl->post($url, $request, $header);
    }

    /**
     * 如果 tag 为空，则拉取所有标签，所以必须指定名称
     * 额外增加 $force 参数，拉取前首先判断是否已存在。
     *
     * @param string      $image
     * @param string      $tag
     * @param bool        $force
     * @param string|null $auth
     * @param string|null $platform
     *
     * @return mixed
     * @throws Exception
     */
    public function pull(string $image, string $tag = 'latest', bool $force = false, string $auth = null, string $platform = null)
    {
        $json = $this->list(1, ["reference" => "$image:$tag"]);

        if (false === $force and $json) {
            return "Already Exists";
        }

        $data = [
            'fromImage' => $image,
            'tag' => $tag,
            'platform' => $platform
        ];

        return $this->create($data, null, $auth);
    }

    /**
     * @param string      $fromSrc
     * @param string|null $repo
     * @param string|null $auth
     * @param string|null $platform
     * @param string|null $request
     *
     * @return mixed
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
            'platform' => $platform
        ];

        if ($fromSrc === '-') {
            $request === null or die("$request error");
        }

        return $this->create($data, $request, $auth);
    }

    /**
     * @param string $name
     *
     * @return mixed
     */
    public function inspect(string $name)
    {
        $url = self::$base_url.'/'.$name.'/json';

        return self::$curl->get($url);
    }

    /**
     * @param string $name
     *
     * @return mixed
     */
    public function history(string $name)
    {
        $url = self::$base_url.'/'.$name.'/history';

        return self::$curl->get($url);
    }

    /**
     * @param string $name
     * @param string $tag
     * @param string $auth
     *
     * @return mixed
     */
    public function push(string $name, string $tag = 'latest', string $auth)
    {
        $url = self::$base_url.'/'.$name.'/push?'.http_build_query(['tag' => $tag]);

        $header = [];

        if ($auth) {
            $header ['X-Registry-Auth'] = [$auth];
        }

        return self::$curl->post($url, null, $header);
    }

    /**
     * @param string $name
     * @param string $repo
     * @param string $tag
     *
     * @return mixed
     */
    public function tag(string $name, string $repo, string $tag)
    {
        $data = [
            'repo' => $repo,
            'tag' => $tag
        ];

        $url = self::$base_url.'/'.$name.'/tag?'.http_build_query($data);

        return self::$curl->post($url);
    }

    /**
     * @param string $name
     * @param bool   $force
     * @param bool   $noprune
     *
     * @return mixed
     */
    public function remove(string $name, bool $force = false, bool $noprune = false)
    {
        $data = [
            'force' => $force,
            'noprune' => $noprune
        ];

        $url = self::$base_url.'/'.$name.'?'.http_build_query($data);

        return self::$curl->delete($url);
    }

    /**
     * @param string   $term
     * @param int|null $limit
     * @param array    $filters
     *
     * @return mixed
     * @throws Exception
     */
    public function search(string $term, int $limit = null, array $filters = [])
    {
        $filters_array = [];

        if ($filters) {
            $filters_array = [
                'filters' => $this->resolveFilters(__FUNCTION__, $filters)
            ];
        }

        $data = [
            'term' => $term,
            'limit' => $limit,
            'filters' => $filters
        ];

        $data = array_merge($data, $filters_array);

        $url = self::$base_url.'/search?'.http_build_query($data);

        return self::$curl->get($url);
    }

    /**
     * @param string $container
     * @param string $repo
     * @param string $tag
     * @param string $comment
     * @param string $author
     * @param bool   $pause
     * @param string $changes
     * @param array  $request_body
     *
     * @return mixed
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
            'changes' => $changes
        ];

        $url = self::$base_url.'/commit?'.http_build_query($data);

        $request = json_encode($request_body);

        return self::$curl->post($url, $request, self::$header);
    }

    /**
     * @param string $name
     *
     * @return mixed
     */
    public function export(string $name)
    {
        $url = self::$base_url.'/'.$name.'/get';

        return self::$curl->get($url);
    }

    /**
     * @param array $names
     *
     * @return mixed
     */
    public function exports(array $names)
    {
        $url = self::$base_url.'/get?'.http_build_query(['names' => $names]);

        return self::$curl->get($url);
    }

    /**
     * @param bool   $quiet
     * @param string $tar
     *
     * @return mixed
     */
    public function load(bool $quiet = false, string $tar)
    {
        $url = self::$base_url.'/load?'.http_build_query(['quiet' => $quiet]);

        return self::$curl->post($url, null, $tar);
    }

    /**
     * @param array $filters
     *
     * @return mixed
     * @throws Exception
     */
    public function prune(array $filters = [])
    {
        $url = self::$base_url.'/prune';

        if ($filters) {
            $filters_array = [
                'filters' => $this->resolveFilters(__FUNCTION__, $filters)
            ];
            $url = $url.'?'.http_build_query($filters_array);
        }

        return self::$curl->post($url);
    }

    /**
     * @param string $name
     * @param bool   $force
     * @param bool   $noprune
     *
     * @return mixed
     */
    public function delete(string $name, bool $force, bool $noprune)
    {
        $url = self::$base_url.'/'.$name;

        $url = $url.'?'.http_build_query([
                    'force' => $force,
                    'noprune' => $noprune,
                ]
            );

        return self::$curl->delete($url);
    }
}
