<?php

namespace App\IdGenerator;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Id\AbstractIdGenerator;
use Psr\Cache\CacheItemPoolInterface;
use Symfony\Component\Lock\LockFactory;

abstract class AceIdGenerator extends AbstractIdGenerator
{
    protected string $prefix = 'ACE';

    public function __construct(
        private readonly LockFactory            $lockFactory,
        private readonly CacheItemPoolInterface $cache
    )
    {
    }

    public function generateId(EntityManagerInterface $em, ?object $entity): string
    {
        return $this->createId();
    }

    private function createId(): string
    {
        $date = date('Ymd');
        $lockKey = $this->getLockKey($this->prefix, $date);
        $cacheKey = $this->getCacheKey($this->prefix, $date);

        $lock = $this->lockFactory->createLock($lockKey);
        $lock->acquire(true);

        try {
            $item = $this->cache->getItem($cacheKey);
            $sequence = $item->isHit() ? $item->get() + 1 : 1;
            $item->set($sequence);
            $this->cache->save($item);
        } finally {
            $lock->release();
        }

        return sprintf('%s%s%06d', $this->prefix, $date, $sequence);
    }

    private function getLockKey(string $prefix, string $date): string
    {
        return sprintf('%s_%s_lock', $prefix, $date);
    }

    private function getCacheKey(string $prefix, string $date): string
    {
        return sprintf('%s_%s_sequence', $prefix, $date);
    }
}
