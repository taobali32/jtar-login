<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://hyperf.wiki
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */
namespace App\Traits;

use App\Exception\FastException;
use App\Exception\HttpErrorHandleException;
use Hyperf\Redis\Redis;
use Hyperf\Utils\ApplicationContext;

trait Look
{
    /**
     * redis key.
     * @var string
     */
    protected $prefix = 'look';

    /**
     * @var float 锁超时时间
     */
    protected $lockTime = 3;

    /**
     * 尝试获取锁 并执行对应操作.
     * @param int|string $id 锁ID
     * @param \Closure $closure 获取锁后需要执行的代码
     * @param int $times 尝试获取次数 <= 1 和 1 一致
     * @param int $ms 获取失败后的等待时间 毫秒
     * @param bool $runAgain 当首次争抢锁失败后，是否执行代码
     */
    public function try($id, \Closure $closure, int $times = 20, int $ms = 500, $runAgain = true)
    {
        $result = null;

        $runFirst = true;
        $tryCount = 0;

        $redis = ApplicationContext::getContainer()->get(Redis::class);

        beginning:
        $tryCount++;
        if ($redis->set($this->getCacheKey($id), '1', ['NX', 'PX' => $this->lockTime * 1000]) !== true) {
            if ($tryCount < $times) {
                $runFirst = false;
                $this->wait($ms);
                goto beginning;
            }

            throw new HttpErrorHandleException('请求超时');
        }

        if ($runFirst || $runAgain) {
            try {
                $result = $closure();
            } finally {
                $this->del($id);
            }
        }

        return $result;
    }

    /**
     * 主动删除锁
     * @param int|string $id
     */
    public function del($id)
    {
        $redis = ApplicationContext::getContainer()->get(Redis::class);

        return $redis->del($this->getCacheKey($id));
    }

    protected function getCacheKey($parentId): string
    {
        if (empty($this->prefix)) {
            throw new \Exception('锁值不存在');
        }

        return $this->prefix . $parentId;
    }

    protected function wait(int $ms): void
    {
        if ($ms > 0) {
            usleep($ms * 1000);
        }
    }


    public function lock(String $str, $value = '',$msg = '')
    {
        $redis = ApplicationContext::getContainer()->get(Redis::class);

        $result = $redis->get($str);

        if ($result) throw new FastException(empty($msg) ? '操作太快了!' : $msg);

        $value = ($value == '') ? $str : $value;

        $redis->set($str,$value,['nx','ex' => $this->lockTime]);
    }
}
