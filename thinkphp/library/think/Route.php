<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

namespace think;

use think\exception\HttpException;

class Route
{
    // 路由规则
    private static $rules = [
        'get'     => [],
        'post'    => [],
        'put'     => [],
        'delete'  => [],
        'patch'   => [],
        'head'    => [],
        'options' => [],
        '*'       => [],
        'alias'   => [],
        'domain'  => [],
        'pattern' => [],
        'name'    => [],
    ];

    // REST璺敱鎿嶄綔鏂规硶瀹氫箟
    private static $rest = [
        'index'  => ['get', '', 'index'],
        'create' => ['get', '/create', 'create'],
        'edit'   => ['get', '/:id/edit', 'edit'],
        'read'   => ['get', '/:id', 'read'],
        'save'   => ['post', '', 'save'],
        'update' => ['put', '/:id', 'update'],
        'delete' => ['delete', '/:id', 'delete'],
    ];

    // 涓嶅悓璇锋眰绫诲瀷鐨勬柟娉曞墠缂�
    private static $methodPrefix = [
        'get'    => 'get',
        'post'   => 'post',
        'put'    => 'put',
        'delete' => 'delete',
        'patch'  => 'patch',
    ];

    // 瀛愬煙鍚�
    private static $subDomain = '';
    // 鍩熷悕缁戝畾
    private static $bind = [];
    // 褰撳墠鍒嗙粍淇℃伅
    private static $group = [];
    // 褰撳墠瀛愬煙鍚嶇粦瀹�
    private static $domainBind;
    private static $domainRule;
    // 褰撳墠鍩熷悕
    private static $domain;
    // 褰撳墠璺敱鎵ц杩囩▼涓殑鍙傛暟
    private static $option = [];

    /**
     * 娉ㄥ唽鍙橀噺瑙勫垯
     * @access public
     * @param string|array $name 鍙橀噺鍚�
     * @param string       $rule 鍙橀噺瑙勫垯
     * @return void
     */
    public static function pattern($name = null, $rule = '')
    {
        if (is_array($name)) {
            self::$rules['pattern'] = array_merge(self::$rules['pattern'], $name);
        } else {
            self::$rules['pattern'][$name] = $rule;
        }
    }

    /**
     * 娉ㄥ唽瀛愬煙鍚嶉儴缃茶鍒�
     * @access public
     * @param string|array $domain  瀛愬煙鍚�
     * @param mixed        $rule    璺敱瑙勫垯
     * @param array        $option  璺敱鍙傛暟
     * @param array        $pattern 鍙橀噺瑙勫垯
     * @return void
     */
    public static function domain($domain, $rule = '', $option = [], $pattern = [])
    {
        if (is_array($domain)) {
            foreach ($domain as $key => $item) {
                self::domain($key, $item, $option, $pattern);
            }
        } elseif ($rule instanceof \Closure) {
            // 鎵ц闂寘
            self::setDomain($domain);
            call_user_func_array($rule, []);
            self::setDomain(null);
        } elseif (is_array($rule)) {
            self::setDomain($domain);
            self::group('', function () use ($rule) {
                // 鍔ㄦ�佹敞鍐屽煙鍚嶇殑璺敱瑙勫垯
                self::registerRules($rule);
            }, $option, $pattern);
            self::setDomain(null);
        } else {
            self::$rules['domain'][$domain]['[bind]'] = [$rule, $option, $pattern];
        }
    }

    private static function setDomain($domain)
    {
        self::$domain = $domain;
    }

    /**
     * 璁剧疆璺敱缁戝畾
     * @access public
     * @param mixed  $bind 缁戝畾淇℃伅
     * @param string $type 缁戝畾绫诲瀷 榛樿涓簃odule 鏀寔 namespace class controller
     * @return mixed
     */
    public static function bind($bind, $type = 'module')
    {
        self::$bind = ['type' => $type, $type => $bind];
    }

    /**
     * 璁剧疆鎴栬�呰幏鍙栬矾鐢辨爣璇�
     * @access public
     * @param string|array $name  璺敱鍛藉悕鏍囪瘑 鏁扮粍琛ㄧず鎵归噺璁剧疆
     * @param array        $value 璺敱鍦板潃鍙婂彉閲忎俊鎭�
     * @return array
     */
    public static function name($name = '', $value = null)
    {
        if (is_array($name)) {
            return self::$rules['name'] = $name;
        } elseif ('' === $name) {
            return self::$rules['name'];
        } elseif (!is_null($value)) {
            self::$rules['name'][strtolower($name)][] = $value;
        } else {
            $name = strtolower($name);
            return isset(self::$rules['name'][$name]) ? self::$rules['name'][$name] : null;
        }
    }

    /**
     * 璇诲彇璺敱缁戝畾
     * @access public
     * @param string $type 缁戝畾绫诲瀷
     * @return mixed
     */
    public static function getBind($type)
    {
        return isset(self::$bind[$type]) ? self::$bind[$type] : null;
    }

    /**
     * 瀵煎叆閰嶇疆鏂囦欢鐨勮矾鐢辫鍒�
     * @access public
     * @param array  $rule 璺敱瑙勫垯
     * @param string $type 璇锋眰绫诲瀷
     * @return void
     */
    public static function import(array $rule, $type = '*')
    {
        // 妫�鏌ュ煙鍚嶉儴缃�
        if (isset($rule['__domain__'])) {
            self::domain($rule['__domain__']);
            unset($rule['__domain__']);
        }

        // 妫�鏌ュ彉閲忚鍒�
        if (isset($rule['__pattern__'])) {
            self::pattern($rule['__pattern__']);
            unset($rule['__pattern__']);
        }

        // 妫�鏌ヨ矾鐢卞埆鍚�
        if (isset($rule['__alias__'])) {
            self::alias($rule['__alias__']);
            unset($rule['__alias__']);
        }

        // 妫�鏌ヨ祫婧愯矾鐢�
        if (isset($rule['__rest__'])) {
            self::resource($rule['__rest__']);
            unset($rule['__rest__']);
        }

        self::registerRules($rule, strtolower($type));
    }

    // 鎵归噺娉ㄥ唽璺敱
    protected static function registerRules($rules, $type = '*')
    {
        foreach ($rules as $key => $val) {
            if (is_numeric($key)) {
                $key = array_shift($val);
            }
            if (empty($val)) {
                continue;
            }
            if (is_string($key) && 0 === strpos($key, '[')) {
                $key = substr($key, 1, -1);
                self::group($key, $val);
            } elseif (is_array($val)) {
                self::setRule($key, $val[0], $type, $val[1], isset($val[2]) ? $val[2] : []);
            } else {
                self::setRule($key, $val, $type);
            }
        }
    }

    /**
     * 娉ㄥ唽璺敱瑙勫垯
     * @access public
     * @param string|array $rule    璺敱瑙勫垯
     * @param string       $route   璺敱鍦板潃
     * @param string       $type    璇锋眰绫诲瀷
     * @param array        $option  璺敱鍙傛暟
     * @param array        $pattern 鍙橀噺瑙勫垯
     * @return void
     */
    public static function rule($rule, $route = '', $type = '*', $option = [], $pattern = [])
    {
        $group = self::getGroup('name');

        if (!is_null($group)) {
            // 璺敱鍒嗙粍
            $option  = array_merge(self::getGroup('option'), $option);
            $pattern = array_merge(self::getGroup('pattern'), $pattern);
        }

        $type = strtolower($type);

        if (strpos($type, '|')) {
            $option['method'] = $type;
            $type             = '*';
        }
        if (is_array($rule) && empty($route)) {
            foreach ($rule as $key => $val) {
                if (is_numeric($key)) {
                    $key = array_shift($val);
                }
                if (is_array($val)) {
                    $route    = $val[0];
                    $option1  = array_merge($option, $val[1]);
                    $pattern1 = array_merge($pattern, isset($val[2]) ? $val[2] : []);
                } else {
                    $option1  = null;
                    $pattern1 = null;
                    $route    = $val;
                }
                self::setRule($key, $route, $type, !is_null($option1) ? $option1 : $option, !is_null($pattern1) ? $pattern1 : $pattern, $group);
            }
        } else {
            self::setRule($rule, $route, $type, $option, $pattern, $group);
        }

    }

    /**
     * 璁剧疆璺敱瑙勫垯
     * @access public
     * @param string|array $rule    璺敱瑙勫垯
     * @param string       $route   璺敱鍦板潃
     * @param string       $type    璇锋眰绫诲瀷
     * @param array        $option  璺敱鍙傛暟
     * @param array        $pattern 鍙橀噺瑙勫垯
     * @param string       $group   鎵�灞炲垎缁�
     * @return void
     */
    protected static function setRule($rule, $route, $type = '*', $option = [], $pattern = [], $group = '')
    {
        if (is_array($rule)) {
            $name = $rule[0];
            $rule = $rule[1];
        } elseif (is_string($route)) {
            $name = $route;
        }
        if (!isset($option['complete_match'])) {
            if (Config::get('route_complete_match')) {
                $option['complete_match'] = true;
            } elseif ('$' == substr($rule, -1, 1)) {
                // 鏄惁瀹屾暣鍖归厤
                $option['complete_match'] = true;
            }
        } elseif (empty($option['complete_match']) && '$' == substr($rule, -1, 1)) {
            // 鏄惁瀹屾暣鍖归厤
            $option['complete_match'] = true;
        }

        if ('$' == substr($rule, -1, 1)) {
            $rule = substr($rule, 0, -1);
        }

        if ('/' != $rule || $group) {
            $rule = trim($rule, '/');
        }
        $vars = self::parseVar($rule);
        if (isset($name)) {
            $key    = $group ? $group . ($rule ? '/' . $rule : '') : $rule;
            $suffix = isset($option['ext']) ? $option['ext'] : null;
            self::name($name, [$key, $vars, self::$domain, $suffix]);
        }
        if (isset($option['modular'])) {
            $route = $option['modular'] . '/' . $route;
        }
        if ($group) {
            if ('*' != $type) {
                $option['method'] = $type;
            }
            if (self::$domain) {
                self::$rules['domain'][self::$domain]['*'][$group]['rule'][] = ['rule' => $rule, 'route' => $route, 'var' => $vars, 'option' => $option, 'pattern' => $pattern];
            } else {
                self::$rules['*'][$group]['rule'][] = ['rule' => $rule, 'route' => $route, 'var' => $vars, 'option' => $option, 'pattern' => $pattern];
            }
        } else {
            if ('*' != $type && isset(self::$rules['*'][$rule])) {
                unset(self::$rules['*'][$rule]);
            }
            if (self::$domain) {
                self::$rules['domain'][self::$domain][$type][$rule] = ['rule' => $rule, 'route' => $route, 'var' => $vars, 'option' => $option, 'pattern' => $pattern];
            } else {
                self::$rules[$type][$rule] = ['rule' => $rule, 'route' => $route, 'var' => $vars, 'option' => $option, 'pattern' => $pattern];
            }
            if ('*' == $type) {
                // 娉ㄥ唽璺敱蹇嵎鏂瑰紡
                foreach (['get', 'post', 'put', 'delete', 'patch', 'head', 'options'] as $method) {
                    if (self::$domain && !isset(self::$rules['domain'][self::$domain][$method][$rule])) {
                        self::$rules['domain'][self::$domain][$method][$rule] = true;
                    } elseif (!self::$domain && !isset(self::$rules[$method][$rule])) {
                        self::$rules[$method][$rule] = true;
                    }
                }
            }
        }
    }

    /**
     * 璁剧疆褰撳墠鎵ц鐨勫弬鏁颁俊鎭�
     * @access public
     * @param array $options 鍙傛暟淇℃伅
     * @return mixed
     */
    protected static function setOption($options = [])
    {
        self::$option[] = $options;
    }

    /**
     * 鑾峰彇褰撳墠鎵ц鐨勬墍鏈夊弬鏁颁俊鎭�
     * @access public
     * @return array
     */
    public static function getOption()
    {
        return self::$option;
    }

    /**
     * 鑾峰彇褰撳墠鐨勫垎缁勪俊鎭�
     * @access public
     * @param string $type 鍒嗙粍淇℃伅鍚嶇О name option pattern
     * @return mixed
     */
    public static function getGroup($type)
    {
        if (isset(self::$group[$type])) {
            return self::$group[$type];
        } else {
            return 'name' == $type ? null : [];
        }
    }

    /**
     * 璁剧疆褰撳墠鐨勮矾鐢卞垎缁�
     * @access public
     * @param string $name    鍒嗙粍鍚嶇О
     * @param array  $option  鍒嗙粍璺敱鍙傛暟
     * @param array  $pattern 鍒嗙粍鍙橀噺瑙勫垯
     * @return void
     */
    public static function setGroup($name, $option = [], $pattern = [])
    {
        self::$group['name']    = $name;
        self::$group['option']  = $option ?: [];
        self::$group['pattern'] = $pattern ?: [];
    }

    /**
     * 娉ㄥ唽璺敱鍒嗙粍
     * @access public
     * @param string|array   $name    鍒嗙粍鍚嶇О鎴栬�呭弬鏁�
     * @param array|\Closure $routes  璺敱鍦板潃
     * @param array          $option  璺敱鍙傛暟
     * @param array          $pattern 鍙橀噺瑙勫垯
     * @return void
     */
    public static function group($name, $routes, $option = [], $pattern = [])
    {
        if (is_array($name)) {
            $option = $name;
            $name   = isset($option['name']) ? $option['name'] : '';
        }
        // 鍒嗙粍
        $currentGroup = self::getGroup('name');
        if ($currentGroup) {
            $name = $currentGroup . ($name ? '/' . ltrim($name, '/') : '');
        }
        if (!empty($name)) {
            if ($routes instanceof \Closure) {
                $currentOption  = self::getGroup('option');
                $currentPattern = self::getGroup('pattern');
                self::setGroup($name, array_merge($currentOption, $option), array_merge($currentPattern, $pattern));
                call_user_func_array($routes, []);
                self::setGroup($currentGroup, $currentOption, $currentPattern);
                if ($currentGroup != $name) {
                    self::$rules['*'][$name]['route']   = '';
                    self::$rules['*'][$name]['var']     = self::parseVar($name);
                    self::$rules['*'][$name]['option']  = $option;
                    self::$rules['*'][$name]['pattern'] = $pattern;
                }
            } else {
                $item          = [];
                $completeMatch = Config::get('route_complete_match');
                foreach ($routes as $key => $val) {
                    if (is_numeric($key)) {
                        $key = array_shift($val);
                    }
                    if (is_array($val)) {
                        $route    = $val[0];
                        $option1  = array_merge($option, isset($val[1]) ? $val[1] : []);
                        $pattern1 = array_merge($pattern, isset($val[2]) ? $val[2] : []);
                    } else {
                        $route = $val;
                    }

                    $options  = isset($option1) ? $option1 : $option;
                    $patterns = isset($pattern1) ? $pattern1 : $pattern;
                    if ('$' == substr($key, -1, 1)) {
                        // 鏄惁瀹屾暣鍖归厤
                        $options['complete_match'] = true;
                        $key                       = substr($key, 0, -1);
                    } elseif ($completeMatch) {
                        $options['complete_match'] = true;
                    }
                    $key    = trim($key, '/');
                    $vars   = self::parseVar($key);
                    $item[] = ['rule' => $key, 'route' => $route, 'var' => $vars, 'option' => $options, 'pattern' => $patterns];
                    // 璁剧疆璺敱鏍囪瘑
                    $suffix = isset($options['ext']) ? $options['ext'] : null;
                    self::name($route, [$name . ($key ? '/' . $key : ''), $vars, self::$domain, $suffix]);
                }
                self::$rules['*'][$name] = ['rule' => $item, 'route' => '', 'var' => [], 'option' => $option, 'pattern' => $pattern];
            }

            foreach (['get', 'post', 'put', 'delete', 'patch', 'head', 'options'] as $method) {
                if (!isset(self::$rules[$method][$name])) {
                    self::$rules[$method][$name] = true;
                } elseif (is_array(self::$rules[$method][$name])) {
                    self::$rules[$method][$name] = array_merge(self::$rules['*'][$name], self::$rules[$method][$name]);
                }
            }

        } elseif ($routes instanceof \Closure) {
            // 闂寘娉ㄥ唽
            $currentOption  = self::getGroup('option');
            $currentPattern = self::getGroup('pattern');
            self::setGroup('', array_merge($currentOption, $option), array_merge($currentPattern, $pattern));
            call_user_func_array($routes, []);
            self::setGroup($currentGroup, $currentOption, $currentPattern);
        } else {
            // 鎵归噺娉ㄥ唽璺敱
            self::rule($routes, '', '*', $option, $pattern);
        }
    }

    /**
     * 娉ㄥ唽璺敱
     * @access public
     * @param string|array $rule    璺敱瑙勫垯
     * @param string       $route   璺敱鍦板潃
     * @param array        $option  璺敱鍙傛暟
     * @param array        $pattern 鍙橀噺瑙勫垯
     * @return void
     */
    public static function any($rule, $route = '', $option = [], $pattern = [])
    {
        self::rule($rule, $route, '*', $option, $pattern);
    }

    /**
     * 娉ㄥ唽GET璺敱
     * @access public
     * @param string|array $rule    璺敱瑙勫垯
     * @param string       $route   璺敱鍦板潃
     * @param array        $option  璺敱鍙傛暟
     * @param array        $pattern 鍙橀噺瑙勫垯
     * @return void
     */
    public static function get($rule, $route = '', $option = [], $pattern = [])
    {
        self::rule($rule, $route, 'GET', $option, $pattern);
    }

    /**
     * 娉ㄥ唽POST璺敱
     * @access public
     * @param string|array $rule    璺敱瑙勫垯
     * @param string       $route   璺敱鍦板潃
     * @param array        $option  璺敱鍙傛暟
     * @param array        $pattern 鍙橀噺瑙勫垯
     * @return void
     */
    public static function post($rule, $route = '', $option = [], $pattern = [])
    {
        self::rule($rule, $route, 'POST', $option, $pattern);
    }

    /**
     * 娉ㄥ唽PUT璺敱
     * @access public
     * @param string|array $rule    璺敱瑙勫垯
     * @param string       $route   璺敱鍦板潃
     * @param array        $option  璺敱鍙傛暟
     * @param array        $pattern 鍙橀噺瑙勫垯
     * @return void
     */
    public static function put($rule, $route = '', $option = [], $pattern = [])
    {
        self::rule($rule, $route, 'PUT', $option, $pattern);
    }

    /**
     * 娉ㄥ唽DELETE璺敱
     * @access public
     * @param string|array $rule    璺敱瑙勫垯
     * @param string       $route   璺敱鍦板潃
     * @param array        $option  璺敱鍙傛暟
     * @param array        $pattern 鍙橀噺瑙勫垯
     * @return void
     */
    public static function delete($rule, $route = '', $option = [], $pattern = [])
    {
        self::rule($rule, $route, 'DELETE', $option, $pattern);
    }

    /**
     * 娉ㄥ唽PATCH璺敱
     * @access public
     * @param string|array $rule    璺敱瑙勫垯
     * @param string       $route   璺敱鍦板潃
     * @param array        $option  璺敱鍙傛暟
     * @param array        $pattern 鍙橀噺瑙勫垯
     * @return void
     */
    public static function patch($rule, $route = '', $option = [], $pattern = [])
    {
        self::rule($rule, $route, 'PATCH', $option, $pattern);
    }

    /**
     * 娉ㄥ唽璧勬簮璺敱
     * @access public
     * @param string|array $rule    璺敱瑙勫垯
     * @param string       $route   璺敱鍦板潃
     * @param array        $option  璺敱鍙傛暟
     * @param array        $pattern 鍙橀噺瑙勫垯
     * @return void
     */
    public static function resource($rule, $route = '', $option = [], $pattern = [])
    {
        if (is_array($rule)) {
            foreach ($rule as $key => $val) {
                if (is_array($val)) {
                    list($val, $option, $pattern) = array_pad($val, 3, []);
                }
                self::resource($key, $val, $option, $pattern);
            }
        } else {
            if (strpos($rule, '.')) {
                // 娉ㄥ唽宓屽璧勬簮璺敱
                $array = explode('.', $rule);
                $last  = array_pop($array);
                $item  = [];
                foreach ($array as $val) {
                    $item[] = $val . '/:' . (isset($option['var'][$val]) ? $option['var'][$val] : $val . '_id');
                }
                $rule = implode('/', $item) . '/' . $last;
            }
            // 娉ㄥ唽璧勬簮璺敱
            foreach (self::$rest as $key => $val) {
                if ((isset($option['only']) && !in_array($key, $option['only']))
                    || (isset($option['except']) && in_array($key, $option['except']))) {
                    continue;
                }
                if (isset($last) && strpos($val[1], ':id') && isset($option['var'][$last])) {
                    $val[1] = str_replace(':id', ':' . $option['var'][$last], $val[1]);
                } elseif (strpos($val[1], ':id') && isset($option['var'][$rule])) {
                    $val[1] = str_replace(':id', ':' . $option['var'][$rule], $val[1]);
                }
                $item           = ltrim($rule . $val[1], '/');
                $option['rest'] = $key;
                self::rule($item . '$', $route . '/' . $val[2], $val[0], $option, $pattern);
            }
        }
    }

    /**
     * 娉ㄥ唽鎺у埗鍣ㄨ矾鐢� 鎿嶄綔鏂规硶瀵瑰簲涓嶅悓鐨勮姹傚悗缂�
     * @access public
     * @param string $rule    璺敱瑙勫垯
     * @param string $route   璺敱鍦板潃
     * @param array  $option  璺敱鍙傛暟
     * @param array  $pattern 鍙橀噺瑙勫垯
     * @return void
     */
    public static function controller($rule, $route = '', $option = [], $pattern = [])
    {
        foreach (self::$methodPrefix as $type => $val) {
            self::$type($rule . '/:action', $route . '/' . $val . ':action', $option, $pattern);
        }
    }

    /**
     * 娉ㄥ唽鍒悕璺敱
     * @access public
     * @param string|array $rule   璺敱鍒悕
     * @param string       $route  璺敱鍦板潃
     * @param array        $option 璺敱鍙傛暟
     * @return void
     */
    public static function alias($rule = null, $route = '', $option = [])
    {
        if (is_array($rule)) {
            self::$rules['alias'] = array_merge(self::$rules['alias'], $rule);
        } else {
            self::$rules['alias'][$rule] = $option ? [$route, $option] : $route;
        }
    }

    /**
     * 璁剧疆涓嶅悓璇锋眰绫诲瀷涓嬮潰鐨勬柟娉曞墠缂�
     * @access public
     * @param string $method 璇锋眰绫诲瀷
     * @param string $prefix 绫诲瀷鍓嶇紑
     * @return void
     */
    public static function setMethodPrefix($method, $prefix = '')
    {
        if (is_array($method)) {
            self::$methodPrefix = array_merge(self::$methodPrefix, array_change_key_case($method));
        } else {
            self::$methodPrefix[strtolower($method)] = $prefix;
        }
    }

    /**
     * rest鏂规硶瀹氫箟鍜屼慨鏀�
     * @access public
     * @param string|array $name     鏂规硶鍚嶇О
     * @param array|bool   $resource 璧勬簮
     * @return void
     */
    public static function rest($name, $resource = [])
    {
        if (is_array($name)) {
            self::$rest = $resource ? $name : array_merge(self::$rest, $name);
        } else {
            self::$rest[$name] = $resource;
        }
    }

    /**
     * 娉ㄥ唽鏈尮閰嶈矾鐢辫鍒欏悗鐨勫鐞�
     * @access public
     * @param string $route  璺敱鍦板潃
     * @param string $method 璇锋眰绫诲瀷
     * @param array  $option 璺敱鍙傛暟
     * @return void
     */
    public static function miss($route, $method = '*', $option = [])
    {
        self::rule('__miss__', $route, $method, $option, []);
    }

    /**
     * 娉ㄥ唽涓�涓嚜鍔ㄨВ鏋愮殑URL璺敱
     * @access public
     * @param string $route 璺敱鍦板潃
     * @return void
     */
    public static function auto($route)
    {
        self::rule('__auto__', $route, '*', [], []);
    }

    /**
     * 鑾峰彇鎴栬�呮壒閲忚缃矾鐢卞畾涔�
     * @access public
     * @param mixed $rules 璇锋眰绫诲瀷鎴栬�呰矾鐢卞畾涔夋暟缁�
     * @return array
     */
    public static function rules($rules = '')
    {
        if (is_array($rules)) {
            self::$rules = $rules;
        } elseif ($rules) {
            return true === $rules ? self::$rules : self::$rules[strtolower($rules)];
        } else {
            $rules = self::$rules;
            unset($rules['pattern'], $rules['alias'], $rules['domain'], $rules['name']);
            return $rules;
        }
    }

    /**
     * 妫�娴嬪瓙鍩熷悕閮ㄧ讲
     * @access public
     * @param Request $request      Request璇锋眰瀵硅薄
     * @param array   $currentRules 褰撳墠璺敱瑙勫垯
     * @param string  $method       璇锋眰绫诲瀷
     * @return void
     */
    public static function checkDomain($request, &$currentRules, $method = 'get')
    {
        // 鍩熷悕瑙勫垯
        $rules = self::$rules['domain'];
        // 寮�鍚瓙鍩熷悕閮ㄧ讲 鏀寔浜岀骇鍜屼笁绾у煙鍚�
        if (!empty($rules)) {
            $host = $request->host(true);
            if (isset($rules[$host])) {
                // 瀹屾暣鍩熷悕鎴栬�匢P閰嶇疆
                $item = $rules[$host];
            } else {
                $rootDomain = Config::get('url_domain_root');
                if ($rootDomain) {
                    // 閰嶇疆鍩熷悕鏍� 渚嬪 thinkphp.cn 163.com.cn 濡傛灉鏄浗瀹剁骇鍩熷悕 com.cn net.cn 涔嬬被鐨勫煙鍚嶉渶瑕侀厤缃�
                    $domain = explode('.', rtrim(stristr($host, $rootDomain, true), '.'));
                } else {
                    $domain = explode('.', $host, -2);
                }
                // 瀛愬煙鍚嶉厤缃�
                if (!empty($domain)) {
                    // 褰撳墠瀛愬煙鍚�
                    $subDomain       = implode('.', $domain);
                    self::$subDomain = $subDomain;
                    $domain2         = array_pop($domain);
                    if ($domain) {
                        // 瀛樺湪涓夌骇鍩熷悕
                        $domain3 = array_pop($domain);
                    }
                    if ($subDomain && isset($rules[$subDomain])) {
                        // 瀛愬煙鍚嶉厤缃�
                        $item = $rules[$subDomain];
                    } elseif (isset($rules['*.' . $domain2]) && !empty($domain3)) {
                        // 娉涗笁绾у煙鍚�
                        $item      = $rules['*.' . $domain2];
                        $panDomain = $domain3;
                    } elseif (isset($rules['*']) && !empty($domain2)) {
                        // 娉涗簩绾у煙鍚�
                        if ('www' != $domain2) {
                            $item      = $rules['*'];
                            $panDomain = $domain2;
                        }
                    }
                }
            }
            if (!empty($item)) {
                if (isset($panDomain)) {
                    // 淇濆瓨褰撳墠娉涘煙鍚�
                    $request->route(['__domain__' => $panDomain]);
                }
                if (isset($item['[bind]'])) {
                    // 瑙ｆ瀽瀛愬煙鍚嶉儴缃茶鍒�
                    list($rule, $option, $pattern) = $item['[bind]'];
                    if (!empty($option['https']) && !$request->isSsl()) {
                        // https妫�娴�
                        throw new HttpException(404, 'must use https request:' . $host);
                    }

                    if (strpos($rule, '?')) {
                        // 浼犲叆鍏跺畠鍙傛暟
                        $array  = parse_url($rule);
                        $result = $array['path'];
                        parse_str($array['query'], $params);
                        if (isset($panDomain)) {
                            $pos = array_search('*', $params);
                            if (false !== $pos) {
                                // 娉涘煙鍚嶄綔涓哄弬鏁�
                                $params[$pos] = $panDomain;
                            }
                        }
                        $_GET = array_merge($_GET, $params);
                    } else {
                        $result = $rule;
                    }

                    if (0 === strpos($result, '\\')) {
                        // 缁戝畾鍒板懡鍚嶇┖闂� 渚嬪 \app\index\behavior
                        self::$bind = ['type' => 'namespace', 'namespace' => $result];
                    } elseif (0 === strpos($result, '@')) {
                        // 缁戝畾鍒扮被 渚嬪 @app\index\controller\User
                        self::$bind = ['type' => 'class', 'class' => substr($result, 1)];
                    } else {
                        // 缁戝畾鍒版ā鍧�/鎺у埗鍣� 渚嬪 index/user
                        self::$bind = ['type' => 'module', 'module' => $result];
                    }
                    self::$domainBind = true;
                } else {
                    self::$domainRule = $item;
                    $currentRules     = isset($item[$method]) ? $item[$method] : $item['*'];
                }
            }
        }
    }

    /**
     * 妫�娴婾RL璺敱
     * @access public
     * @param Request $request     Request璇锋眰瀵硅薄
     * @param string  $url         URL鍦板潃
     * @param string  $depr        URL鍒嗛殧绗�
     * @param bool    $checkDomain 鏄惁妫�娴嬪煙鍚嶈鍒�
     * @return false|array
     */
    public static function check($request, $url, $depr = '/', $checkDomain = false)
    {
        //妫�鏌ヨВ鏋愮紦瀛�
        if (!App::$debug && Config::get('route_check_cache')) {
            $key = self::getCheckCacheKey($request);
            if (Cache::has($key)) {
                list($rule, $route, $pathinfo, $option, $matches) = Cache::get($key);
                return self::parseRule($rule, $route, $pathinfo, $option, $matches, true);
            }
        }

        // 鍒嗛殧绗︽浛鎹� 纭繚璺敱瀹氫箟浣跨敤缁熶竴鐨勫垎闅旂
        $url = str_replace($depr, '|', $url);

        if (isset(self::$rules['alias'][$url]) || isset(self::$rules['alias'][strstr($url, '|', true)])) {
            // 妫�娴嬭矾鐢卞埆鍚�
            $result = self::checkRouteAlias($request, $url, $depr);
            if (false !== $result) {
                return $result;
            }
        }
        $method = strtolower($request->method());
        // 鑾峰彇褰撳墠璇锋眰绫诲瀷鐨勮矾鐢辫鍒�
        $rules = isset(self::$rules[$method]) ? self::$rules[$method] : [];
        // 妫�娴嬪煙鍚嶉儴缃�
        if ($checkDomain) {
            self::checkDomain($request, $rules, $method);
        }
        // 妫�娴婾RL缁戝畾
        $return = self::checkUrlBind($url, $rules, $depr);
        if (false !== $return) {
            return $return;
        }
        if ('|' != $url) {
            $url = rtrim($url, '|');
        }
        $item = str_replace('|', '/', $url);
        if (isset($rules[$item])) {
            // 闈欐�佽矾鐢辫鍒欐娴�
            $rule = $rules[$item];
            if (true === $rule) {
                $rule = self::getRouteExpress($item);
            }
            if (!empty($rule['route']) && self::checkOption($rule['option'], $request)) {
                self::setOption($rule['option']);
                return self::parseRule($item, $rule['route'], $url, $rule['option']);
            }
        }

        // 璺敱瑙勫垯妫�娴�
        if (!empty($rules)) {
            return self::checkRoute($request, $rules, $url, $depr);
        }
        return false;
    }

    private static function getRouteExpress($key)
    {
        return self::$domainRule ? self::$domainRule['*'][$key] : self::$rules['*'][$key];
    }

    /**
     * 妫�娴嬭矾鐢辫鍒�
     * @access private
     * @param Request $request
     * @param array   $rules   璺敱瑙勫垯
     * @param string  $url     URL鍦板潃
     * @param string  $depr    URL鍒嗗壊绗�
     * @param string  $group   璺敱鍒嗙粍鍚�
     * @param array   $options 璺敱鍙傛暟锛堝垎缁勶級
     * @return mixed
     */
    private static function checkRoute($request, $rules, $url, $depr = '/', $group = '', $options = [])
    {
        foreach ($rules as $key => $item) {
            if (true === $item) {
                $item = self::getRouteExpress($key);
            }
            if (!isset($item['rule'])) {
                continue;
            }
            $rule    = $item['rule'];
            $route   = $item['route'];
            $vars    = $item['var'];
            $option  = $item['option'];
            $pattern = $item['pattern'];

            // 妫�鏌ュ弬鏁版湁鏁堟��
            if (!self::checkOption($option, $request)) {
                continue;
            }

            if (isset($option['ext'])) {
                // 璺敱ext鍙傛暟 浼樺厛浜庣郴缁熼厤缃殑URL浼潤鎬佸悗缂�鍙傛暟
                $url = preg_replace('/\.' . $request->ext() . '$/i', '', $url);
            }

            if (is_array($rule)) {
                // 鍒嗙粍璺敱
                $pos = strpos(str_replace('<', ':', $key), ':');
                if (false !== $pos) {
                    $str = substr($key, 0, $pos);
                } else {
                    $str = $key;
                }
                if (is_string($str) && $str && 0 !== stripos(str_replace('|', '/', $url), $str)) {
                    continue;
                }
                self::setOption($option);
                $result = self::checkRoute($request, $rule, $url, $depr, $key, $option);
                if (false !== $result) {
                    return $result;
                }
            } elseif ($route) {
                if ('__miss__' == $rule || '__auto__' == $rule) {
                    // 鎸囧畾鐗规畩璺敱
                    $var    = trim($rule, '__');
                    ${$var} = $item;
                    continue;
                }
                if ($group) {
                    $rule = $group . ($rule ? '/' . ltrim($rule, '/') : '');
                }

                self::setOption($option);
                if (isset($options['bind_model']) && isset($option['bind_model'])) {
                    $option['bind_model'] = array_merge($options['bind_model'], $option['bind_model']);
                }
                $result = self::checkRule($rule, $route, $url, $pattern, $option, $depr);
                if (false !== $result) {
                    return $result;
                }
            }
        }
        if (isset($auto)) {
            // 鑷姩瑙ｆ瀽URL鍦板潃
            return self::parseUrl($auto['route'] . '/' . $url, $depr);
        } elseif (isset($miss)) {
            // 鏈尮閰嶆墍鏈夎矾鐢辩殑璺敱瑙勫垯澶勭悊
            return self::parseRule('', $miss['route'], $url, $miss['option']);
        }
        return false;
    }

    /**
     * 妫�娴嬭矾鐢卞埆鍚�
     * @access private
     * @param Request $request
     * @param string  $url  URL鍦板潃
     * @param string  $depr URL鍒嗛殧绗�
     * @return mixed
     */
    private static function checkRouteAlias($request, $url, $depr)
    {
        $array = explode('|', $url);
        $alias = array_shift($array);
        $item  = self::$rules['alias'][$alias];

        if (is_array($item)) {
            list($rule, $option) = $item;
            $action              = $array[0];
            if (isset($option['allow']) && !in_array($action, explode(',', $option['allow']))) {
                // 鍏佽鎿嶄綔
                return false;
            } elseif (isset($option['except']) && in_array($action, explode(',', $option['except']))) {
                // 鎺掗櫎鎿嶄綔
                return false;
            }
            if (isset($option['method'][$action])) {
                $option['method'] = $option['method'][$action];
            }
        } else {
            $rule = $item;
        }
        $bind = implode('|', $array);
        // 鍙傛暟鏈夋晥鎬ф鏌�
        if (isset($option) && !self::checkOption($option, $request)) {
            // 璺敱涓嶅尮閰�
            return false;
        } elseif (0 === strpos($rule, '\\')) {
            // 璺敱鍒扮被
            return self::bindToClass($bind, substr($rule, 1), $depr);
        } elseif (0 === strpos($rule, '@')) {
            // 璺敱鍒版帶鍒跺櫒绫�
            return self::bindToController($bind, substr($rule, 1), $depr);
        } else {
            // 璺敱鍒版ā鍧�/鎺у埗鍣�
            return self::bindToModule($bind, $rule, $depr);
        }
    }

    /**
     * 妫�娴婾RL缁戝畾
     * @access private
     * @param string $url   URL鍦板潃
     * @param array  $rules 璺敱瑙勫垯
     * @param string $depr  URL鍒嗛殧绗�
     * @return mixed
     */
    private static function checkUrlBind(&$url, &$rules, $depr = '/')
    {
        if (!empty(self::$bind)) {
            $type = self::$bind['type'];
            $bind = self::$bind[$type];
            // 璁板綍缁戝畾淇℃伅
            App::$debug && Log::record('[ BIND ] ' . var_export($bind, true), 'info');
            // 濡傛灉鏈塙RL缁戝畾 鍒欒繘琛岀粦瀹氭娴�
            switch ($type) {
                case 'class':
                    // 缁戝畾鍒扮被
                    return self::bindToClass($url, $bind, $depr);
                case 'controller':
                    // 缁戝畾鍒版帶鍒跺櫒绫�
                    return self::bindToController($url, $bind, $depr);
                case 'namespace':
                    // 缁戝畾鍒板懡鍚嶇┖闂�
                    return self::bindToNamespace($url, $bind, $depr);
            }
        }
        return false;
    }

    /**
     * 缁戝畾鍒扮被
     * @access public
     * @param string $url   URL鍦板潃
     * @param string $class 绫诲悕锛堝甫鍛藉悕绌洪棿锛�
     * @param string $depr  URL鍒嗛殧绗�
     * @return array
     */
    public static function bindToClass($url, $class, $depr = '/')
    {
        $url    = str_replace($depr, '|', $url);
        $array  = explode('|', $url, 2);
        $action = !empty($array[0]) ? $array[0] : Config::get('default_action');
        if (!empty($array[1])) {
            self::parseUrlParams($array[1]);
        }
        return ['type' => 'method', 'method' => [$class, $action], 'var' => []];
    }

    /**
     * 缁戝畾鍒板懡鍚嶇┖闂�
     * @access public
     * @param string $url       URL鍦板潃
     * @param string $namespace 鍛藉悕绌洪棿
     * @param string $depr      URL鍒嗛殧绗�
     * @return array
     */
    public static function bindToNamespace($url, $namespace, $depr = '/')
    {
        $url    = str_replace($depr, '|', $url);
        $array  = explode('|', $url, 3);
        $class  = !empty($array[0]) ? $array[0] : Config::get('default_controller');
        $method = !empty($array[1]) ? $array[1] : Config::get('default_action');
        if (!empty($array[2])) {
            self::parseUrlParams($array[2]);
        }
        return ['type' => 'method', 'method' => [$namespace . '\\' . Loader::parseName($class, 1), $method], 'var' => []];
    }

    /**
     * 缁戝畾鍒版帶鍒跺櫒绫�
     * @access public
     * @param string $url        URL鍦板潃
     * @param string $controller 鎺у埗鍣ㄥ悕 锛堟敮鎸佸甫妯″潡鍚� index/user 锛�
     * @param string $depr       URL鍒嗛殧绗�
     * @return array
     */
    public static function bindToController($url, $controller, $depr = '/')
    {
        $url    = str_replace($depr, '|', $url);
        $array  = explode('|', $url, 2);
        $action = !empty($array[0]) ? $array[0] : Config::get('default_action');
        if (!empty($array[1])) {
            self::parseUrlParams($array[1]);
        }
        return ['type' => 'controller', 'controller' => $controller . '/' . $action, 'var' => []];
    }

    /**
     * 缁戝畾鍒版ā鍧�/鎺у埗鍣�
     * @access public
     * @param string $url        URL鍦板潃
     * @param string $controller 鎺у埗鍣ㄧ被鍚嶏紙甯﹀懡鍚嶇┖闂达級
     * @param string $depr       URL鍒嗛殧绗�
     * @return array
     */
    public static function bindToModule($url, $controller, $depr = '/')
    {
        $url    = str_replace($depr, '|', $url);
        $array  = explode('|', $url, 2);
        $action = !empty($array[0]) ? $array[0] : Config::get('default_action');
        if (!empty($array[1])) {
            self::parseUrlParams($array[1]);
        }
        return ['type' => 'module', 'module' => $controller . '/' . $action];
    }

    /**
     * 璺敱鍙傛暟鏈夋晥鎬ф鏌�
     * @access private
     * @param array   $option  璺敱鍙傛暟
     * @param Request $request Request瀵硅薄
     * @return bool
     */
    private static function checkOption($option, $request)
    {
        if ((isset($option['method']) && is_string($option['method']) && false === stripos($option['method'], $request->method()))
            || (isset($option['ajax']) && $option['ajax'] && !$request->isAjax()) // Ajax妫�娴�
             || (isset($option['ajax']) && !$option['ajax'] && $request->isAjax()) // 闈濧jax妫�娴�
             || (isset($option['pjax']) && $option['pjax'] && !$request->isPjax()) // Pjax妫�娴�
             || (isset($option['pjax']) && !$option['pjax'] && $request->isPjax()) // 闈濸jax妫�娴�
             || (isset($option['ext']) && false === stripos('|' . $option['ext'] . '|', '|' . $request->ext() . '|')) // 浼潤鎬佸悗缂�妫�娴�
             || (isset($option['deny_ext']) && false !== stripos('|' . $option['deny_ext'] . '|', '|' . $request->ext() . '|'))
            || (isset($option['domain']) && !in_array($option['domain'], [$_SERVER['HTTP_HOST'], self::$subDomain])) // 鍩熷悕妫�娴�
             || (isset($option['https']) && $option['https'] && !$request->isSsl()) // https妫�娴�
             || (isset($option['https']) && !$option['https'] && $request->isSsl()) // https妫�娴�
             || (!empty($option['before_behavior']) && false === Hook::exec($option['before_behavior'])) // 琛屼负妫�娴�
             || (!empty($option['callback']) && is_callable($option['callback']) && false === call_user_func($option['callback'])) // 鑷畾涔夋娴�
        ) {
            return false;
        }
        return true;
    }

    /**
     * 妫�娴嬭矾鐢辫鍒�
     * @access private
     * @param string $rule    璺敱瑙勫垯
     * @param string $route   璺敱鍦板潃
     * @param string $url     URL鍦板潃
     * @param array  $pattern 鍙橀噺瑙勫垯
     * @param array  $option  璺敱鍙傛暟
     * @param string $depr    URL鍒嗛殧绗︼紙鍏ㄥ眬锛�
     * @return array|false
     */
    private static function checkRule($rule, $route, $url, $pattern, $option, $depr)
    {
        // 妫�鏌ュ畬鏁磋鍒欏畾涔�
        if (isset($pattern['__url__']) && !preg_match(0 === strpos($pattern['__url__'], '/') ? $pattern['__url__'] : '/^' . $pattern['__url__'] . '/', str_replace('|', $depr, $url))) {
            return false;
        }
        // 妫�鏌ヨ矾鐢辩殑鍙傛暟鍒嗛殧绗�
        if (isset($option['param_depr'])) {
            $url = str_replace(['|', $option['param_depr']], [$depr, '|'], $url);
        }

        $len1 = substr_count($url, '|');
        $len2 = substr_count($rule, '/');
        // 澶氫綑鍙傛暟鏄惁鍚堝苟
        $merge = !empty($option['merge_extra_vars']);
        if ($merge && $len1 > $len2) {
            $url = str_replace('|', $depr, $url);
            $url = implode('|', explode($depr, $url, $len2 + 1));
        }

        if ($len1 >= $len2 || strpos($rule, '[')) {
            if (!empty($option['complete_match'])) {
                // 瀹屾暣鍖归厤
                if (!$merge && $len1 != $len2 && (false === strpos($rule, '[') || $len1 > $len2 || $len1 < $len2 - substr_count($rule, '['))) {
                    return false;
                }
            }
            $pattern = array_merge(self::$rules['pattern'], $pattern);
            if (false !== $match = self::match($url, $rule, $pattern)) {
                // 鍖归厤鍒拌矾鐢辫鍒�
                return self::parseRule($rule, $route, $url, $option, $match);
            }
        }
        return false;
    }

    /**
     * 瑙ｆ瀽妯″潡鐨刄RL鍦板潃 [妯″潡/鎺у埗鍣�/鎿嶄綔?]鍙傛暟1=鍊�1&鍙傛暟2=鍊�2...
     * @access public
     * @param string $url        URL鍦板潃
     * @param string $depr       URL鍒嗛殧绗�
     * @param bool   $autoSearch 鏄惁鑷姩娣卞害鎼滅储鎺у埗鍣�
     * @return array
     */
    public static function parseUrl($url, $depr = '/', $autoSearch = false)
    {

        if (isset(self::$bind['module'])) {
            $bind = str_replace('/', $depr, self::$bind['module']);
            // 濡傛灉鏈夋ā鍧�/鎺у埗鍣ㄧ粦瀹�
            $url = $bind . ('.' != substr($bind, -1) ? $depr : '') . ltrim($url, $depr);
        }
        $url              = str_replace($depr, '|', $url);
        list($path, $var) = self::parseUrlPath($url);
        $route            = [null, null, null];
        if (isset($path)) {
            // 瑙ｆ瀽妯″潡
            $module = Config::get('app_multi_module') ? array_shift($path) : null;
            if ($autoSearch) {
                // 鑷姩鎼滅储鎺у埗鍣�
                $dir    = APP_PATH . ($module ? $module . DS : '') . Config::get('url_controller_layer');
                $suffix = App::$suffix || Config::get('controller_suffix') ? ucfirst(Config::get('url_controller_layer')) : '';
                $item   = [];
                $find   = false;
                foreach ($path as $val) {
                    $item[] = $val;
                    $file   = $dir . DS . str_replace('.', DS, $val) . $suffix . EXT;
                    $file   = pathinfo($file, PATHINFO_DIRNAME) . DS . Loader::parseName(pathinfo($file, PATHINFO_FILENAME), 1) . EXT;
                    if (is_file($file)) {
                        $find = true;
                        break;
                    } else {
                        $dir .= DS . Loader::parseName($val);
                    }
                }
                if ($find) {
                    $controller = implode('.', $item);
                    $path       = array_slice($path, count($item));
                } else {
                    $controller = array_shift($path);
                }
            } else {
                // 瑙ｆ瀽鎺у埗鍣�
                $controller = !empty($path) ? array_shift($path) : null;
            }
            // 瑙ｆ瀽鎿嶄綔
            $action = !empty($path) ? array_shift($path) : null;
            // 瑙ｆ瀽棰濆鍙傛暟
            self::parseUrlParams(empty($path) ? '' : implode('|', $path));
            // 灏佽璺敱
            $route = [$module, $controller, $action];
            // 妫�鏌ュ湴鍧�鏄惁琚畾涔夎繃璺敱
            $name  = strtolower($module . '/' . Loader::parseName($controller, 1) . '/' . $action);
            $name2 = '';
            if (empty($module) || isset($bind) && $module == $bind) {
                $name2 = strtolower(Loader::parseName($controller, 1) . '/' . $action);
            }

            if (isset(self::$rules['name'][$name]) || isset(self::$rules['name'][$name2])) {
                throw new HttpException(404, 'invalid request:' . str_replace('|', $depr, $url));
            }
        }
        return ['type' => 'module', 'module' => $route];
    }

    /**
     * 瑙ｆ瀽URL鐨刾athinfo鍙傛暟鍜屽彉閲�
     * @access private
     * @param string $url URL鍦板潃
     * @return array
     */
    private static function parseUrlPath($url)
    {
        // 鍒嗛殧绗︽浛鎹� 纭繚璺敱瀹氫箟浣跨敤缁熶竴鐨勫垎闅旂
        $url = str_replace('|', '/', $url);
        $url = trim($url, '/');
        $var = [];
        if (false !== strpos($url, '?')) {
            // [妯″潡/鎺у埗鍣�/鎿嶄綔?]鍙傛暟1=鍊�1&鍙傛暟2=鍊�2...
            $info = parse_url($url);
            $path = explode('/', $info['path']);
            parse_str($info['query'], $var);
        } elseif (strpos($url, '/')) {
            // [妯″潡/鎺у埗鍣�/鎿嶄綔]
            $path = explode('/', $url);
        } else {
            $path = [$url];
        }
        return [$path, $var];
    }

    /**
     * 妫�娴婾RL鍜岃鍒欒矾鐢辨槸鍚﹀尮閰�
     * @access private
     * @param string $url     URL鍦板潃
     * @param string $rule    璺敱瑙勫垯
     * @param array  $pattern 鍙橀噺瑙勫垯
     * @return array|false
     */
    private static function match($url, $rule, $pattern)
    {
        $m2 = explode('/', $rule);
        $m1 = explode('|', $url);

        $var = [];
        foreach ($m2 as $key => $val) {
            // val涓畾涔変簡澶氫釜鍙橀噺 <id><name>
            if (false !== strpos($val, '<') && preg_match_all('/<(\w+(\??))>/', $val, $matches)) {
                $value   = [];
                $replace = [];
                foreach ($matches[1] as $name) {
                    if (strpos($name, '?')) {
                        $name      = substr($name, 0, -1);
                        $replace[] = '(' . (isset($pattern[$name]) ? $pattern[$name] : '\w+') . ')?';
                    } else {
                        $replace[] = '(' . (isset($pattern[$name]) ? $pattern[$name] : '\w+') . ')';
                    }
                    $value[] = $name;
                }
                $val = str_replace($matches[0], $replace, $val);
                if (preg_match('/^' . $val . '$/', isset($m1[$key]) ? $m1[$key] : '', $match)) {
                    array_shift($match);
                    foreach ($value as $k => $name) {
                        if (isset($match[$k])) {
                            $var[$name] = $match[$k];
                        }
                    }
                    continue;
                } else {
                    return false;
                }
            }

            if (0 === strpos($val, '[:')) {
                // 鍙�夊弬鏁�
                $val      = substr($val, 1, -1);
                $optional = true;
            } else {
                $optional = false;
            }
            if (0 === strpos($val, ':')) {
                // URL鍙橀噺
                $name = substr($val, 1);
                if (!$optional && !isset($m1[$key])) {
                    return false;
                }
                if (isset($m1[$key]) && isset($pattern[$name])) {
                    // 妫�鏌ュ彉閲忚鍒�
                    if ($pattern[$name] instanceof \Closure) {
                        $result = call_user_func_array($pattern[$name], [$m1[$key]]);
                        if (false === $result) {
                            return false;
                        }
                    } elseif (!preg_match(0 === strpos($pattern[$name], '/') ? $pattern[$name] : '/^' . $pattern[$name] . '$/', $m1[$key])) {
                        return false;
                    }
                }
                $var[$name] = isset($m1[$key]) ? $m1[$key] : '';
            } elseif (!isset($m1[$key]) || 0 !== strcasecmp($val, $m1[$key])) {
                return false;
            }
        }
        // 鎴愬姛鍖归厤鍚庤繑鍥濽RL涓殑鍔ㄦ�佸彉閲忔暟缁�
        return $var;
    }

    /**
     * 瑙ｆ瀽瑙勫垯璺敱
     * @access private
     * @param string $rule      璺敱瑙勫垯
     * @param string $route     璺敱鍦板潃
     * @param string $pathinfo  URL鍦板潃
     * @param array  $option    璺敱鍙傛暟
     * @param array  $matches   鍖归厤鐨勫彉閲�
     * @param bool   $fromCache 閫氳繃缂撳瓨瑙ｆ瀽
     * @return array
     */
    private static function parseRule($rule, $route, $pathinfo, $option = [], $matches = [], $fromCache = false)
    {
        $request = Request::instance();

        //淇濆瓨瑙ｆ瀽缂撳瓨
        if (Config::get('route_check_cache') && !$fromCache) {
            try {
                $key = self::getCheckCacheKey($request);
                Cache::tag('route_check')->set($key, [$rule, $route, $pathinfo, $option, $matches]);
            } catch (\Exception $e) {

            }
        }

        // 瑙ｆ瀽璺敱瑙勫垯
        if ($rule) {
            $rule = explode('/', $rule);
            // 鑾峰彇URL鍦板潃涓殑鍙傛暟
            $paths = explode('|', $pathinfo);
            foreach ($rule as $item) {
                $fun = '';
                if (0 === strpos($item, '[:')) {
                    $item = substr($item, 1, -1);
                }
                if (0 === strpos($item, ':')) {
                    $var           = substr($item, 1);
                    $matches[$var] = array_shift($paths);
                } else {
                    // 杩囨护URL涓殑闈欐�佸彉閲�
                    array_shift($paths);
                }
            }
        } else {
            $paths = explode('|', $pathinfo);
        }

        // 鑾峰彇璺敱鍦板潃瑙勫垯
        if (is_string($route) && isset($option['prefix'])) {
            // 璺敱鍦板潃鍓嶇紑
            $route = $option['prefix'] . $route;
        }
        // 鏇挎崲璺敱鍦板潃涓殑鍙橀噺
        if (is_string($route) && !empty($matches)) {
            foreach ($matches as $key => $val) {
                if (false !== strpos($route, ':' . $key)) {
                    $route = str_replace(':' . $key, $val, $route);
                }
            }
        }

        // 缁戝畾妯″瀷鏁版嵁
        if (isset($option['bind_model'])) {
            $bind = [];
            foreach ($option['bind_model'] as $key => $val) {
                if ($val instanceof \Closure) {
                    $result = call_user_func_array($val, [$matches]);
                } else {
                    if (is_array($val)) {
                        $fields    = explode('&', $val[1]);
                        $model     = $val[0];
                        $exception = isset($val[2]) ? $val[2] : true;
                    } else {
                        $fields    = ['id'];
                        $model     = $val;
                        $exception = true;
                    }
                    $where = [];
                    $match = true;
                    foreach ($fields as $field) {
                        if (!isset($matches[$field])) {
                            $match = false;
                            break;
                        } else {
                            $where[$field] = $matches[$field];
                        }
                    }
                    if ($match) {
                        $query  = strpos($model, '\\') ? $model::where($where) : Loader::model($model)->where($where);
                        $result = $query->failException($exception)->find();
                    }
                }
                if (!empty($result)) {
                    $bind[$key] = $result;
                }
            }
            $request->bind($bind);
        }

        if (!empty($option['response'])) {
            Hook::add('response_send', $option['response']);
        }

        // 瑙ｆ瀽棰濆鍙傛暟
        self::parseUrlParams(empty($paths) ? '' : implode('|', $paths), $matches);
        // 璁板綍鍖归厤鐨勮矾鐢变俊鎭�
        $request->routeInfo(['rule' => $rule, 'route' => $route, 'option' => $option, 'var' => $matches]);

        // 妫�娴嬭矾鐢盿fter琛屼负
        if (!empty($option['after_behavior'])) {
            if ($option['after_behavior'] instanceof \Closure) {
                $result = call_user_func_array($option['after_behavior'], []);
            } else {
                foreach ((array) $option['after_behavior'] as $behavior) {
                    $result = Hook::exec($behavior, '');
                    if (!is_null($result)) {
                        break;
                    }
                }
            }
            // 璺敱瑙勫垯閲嶅畾鍚�
            if ($result instanceof Response) {
                return ['type' => 'response', 'response' => $result];
            } elseif (is_array($result)) {
                return $result;
            }
        }

        if ($route instanceof \Closure) {
            // 鎵ц闂寘
            $result = ['type' => 'function', 'function' => $route];
        } elseif (0 === strpos($route, '/') || strpos($route, '://')) {
            // 璺敱鍒伴噸瀹氬悜鍦板潃
            $result = ['type' => 'redirect', 'url' => $route, 'status' => isset($option['status']) ? $option['status'] : 301];
        } elseif (false !== strpos($route, '\\')) {
            // 璺敱鍒版柟娉�
            list($path, $var) = self::parseUrlPath($route);
            $route            = str_replace('/', '@', implode('/', $path));
            $method           = strpos($route, '@') ? explode('@', $route) : $route;
            $result           = ['type' => 'method', 'method' => $method, 'var' => $var];
        } elseif (0 === strpos($route, '@')) {
            // 璺敱鍒版帶鍒跺櫒
            $route             = substr($route, 1);
            list($route, $var) = self::parseUrlPath($route);
            $result            = ['type' => 'controller', 'controller' => implode('/', $route), 'var' => $var];
            $request->action(array_pop($route));
            $request->controller($route ? array_pop($route) : Config::get('default_controller'));
            $request->module($route ? array_pop($route) : Config::get('default_module'));
            App::$modulePath = APP_PATH . (Config::get('app_multi_module') ? $request->module() . DS : '');
        } else {
            // 璺敱鍒版ā鍧�/鎺у埗鍣�/鎿嶄綔
            $result = self::parseModule($route, isset($option['convert']) ? $option['convert'] : false);
        }
        // 寮�鍚姹傜紦瀛�
        if ($request->isGet() && isset($option['cache'])) {
            $cache = $option['cache'];
            if (is_array($cache)) {
                list($key, $expire, $tag) = array_pad($cache, 3, null);
            } else {
                $key    = str_replace('|', '/', $pathinfo);
                $expire = $cache;
                $tag    = null;
            }
            $request->cache($key, $expire, $tag);
        }
        return $result;
    }

    /**
     * 瑙ｆ瀽URL鍦板潃涓� 妯″潡/鎺у埗鍣�/鎿嶄綔
     * @access private
     * @param string $url     URL鍦板潃
     * @param bool   $convert 鏄惁鑷姩杞崲URL鍦板潃
     * @return array
     */
    private static function parseModule($url, $convert = false)
    {
        list($path, $var) = self::parseUrlPath($url);
        $action           = array_pop($path);
        $controller       = !empty($path) ? array_pop($path) : null;
        $module           = Config::get('app_multi_module') && !empty($path) ? array_pop($path) : null;
        $method           = Request::instance()->method();
        if (Config::get('use_action_prefix') && !empty(self::$methodPrefix[$method])) {
            // 鎿嶄綔鏂规硶鍓嶇紑鏀寔
            $action = 0 !== strpos($action, self::$methodPrefix[$method]) ? self::$methodPrefix[$method] . $action : $action;
        }
        // 璁剧疆褰撳墠璇锋眰鐨勮矾鐢卞彉閲�
        Request::instance()->route($var);
        // 璺敱鍒版ā鍧�/鎺у埗鍣�/鎿嶄綔
        return ['type' => 'module', 'module' => [$module, $controller, $action], 'convert' => $convert];
    }

    /**
     * 瑙ｆ瀽URL鍦板潃涓殑鍙傛暟Request瀵硅薄
     * @access private
     * @param string $url 璺敱瑙勫垯
     * @param array  $var 鍙橀噺
     * @return void
     */
    private static function parseUrlParams($url, &$var = [])
    {
        if ($url) {
            if (Config::get('url_param_type')) {
                $var += explode('|', $url);
            } else {
                preg_replace_callback('/(\w+)\|([^\|]+)/', function ($match) use (&$var) {
                    $var[$match[1]] = strip_tags($match[2]);
                }, $url);
            }
        }
        // 璁剧疆褰撳墠璇锋眰鐨勫弬鏁�
        Request::instance()->route($var);
    }

    // 鍒嗘瀽璺敱瑙勫垯涓殑鍙橀噺
    private static function parseVar($rule)
    {
        // 鎻愬彇璺敱瑙勫垯涓殑鍙橀噺
        $var = [];
        foreach (explode('/', $rule) as $val) {
            $optional = false;
            if (false !== strpos($val, '<') && preg_match_all('/<(\w+(\??))>/', $val, $matches)) {
                foreach ($matches[1] as $name) {
                    if (strpos($name, '?')) {
                        $name     = substr($name, 0, -1);
                        $optional = true;
                    } else {
                        $optional = false;
                    }
                    $var[$name] = $optional ? 2 : 1;
                }
            }

            if (0 === strpos($val, '[:')) {
                // 鍙�夊弬鏁�
                $optional = true;
                $val      = substr($val, 1, -1);
            }
            if (0 === strpos($val, ':')) {
                // URL鍙橀噺
                $name       = substr($val, 1);
                $var[$name] = $optional ? 2 : 1;
            }
        }
        return $var;
    }

    /**
     * 鑾峰彇璺敱瑙ｆ瀽缂撳瓨鐨刱ey
     * @param Request $request
     * @return string
     */
    private static function getCheckCacheKey(Request $request)
    {
        static $key;

        if (empty($key)) {
            if ($callback = Config::get('route_check_cache_key')) {
                $key = call_user_func($callback, $request);
            } else {
                $key = "{$request->host(true)}|{$request->method()}|{$request->path()}";
            }
        }

        return $key;
    }
}
