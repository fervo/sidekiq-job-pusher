<?php

namespace SidekiqJobPusher;

use Predis\Client as PredisClient;

class Client
{
    private $redis;

    function __construct(PredisClient $redis, $namespace = null)
    {
        $this->redis = $redis;
        $this->namespace = $namespace;

        $this->keyGenerator = new KeyGenerator;
        $this->messageSerialiser = new MessageSerialiser;
    }

    function perform($workerClass, $arguments = array(), $retry = false, $queue = 'default', $at = null)
    {
        $message = $this->messageSerialiser->serialise($workerClass, $arguments, $retry, $queue);

        if ($at) {
            $key = $this->keyGenerator->generateSchedule($this->namespace);
            $this->redis->zadd($key, (double)$at, $message);
        } else {
            $key = $this->keyGenerator->generateQueue($queue, $this->namespace);
            $this->redis->lpush($key, $message);
        }
    }
}
