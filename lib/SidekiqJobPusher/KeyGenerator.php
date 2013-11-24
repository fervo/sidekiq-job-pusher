<?php

namespace SidekiqJobPusher;

class KeyGenerator
{
    function generateQueue($queue = 'default', $namespace = null)
    {
        $parts = $this->compact(array($namespace, 'queue', $queue));
        return implode(':', $parts);
    }

    public function generateSchedule($namespace = null)
    {
        $parts = $this->compact(array($namespace, 'schedule'));
        return implode(':', $parts);
    }

    private function compact($array)
    {
        return array_filter($array, 'strlen');
    }
}
