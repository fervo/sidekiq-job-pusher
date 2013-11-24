<?php

namespace SidekiqJobPusher;

class MessageSerialiser
{
    function serialise($workerClass, $args = array(), $retry = false, $queue = 'default')
    {
        return json_encode(array(
            'jid'   => $this->getId(),
            'class' => $workerClass,
            'args'  => $args,
            'retry' => $retry,
            'queue' => $queue,
        ));
    }

    function getId()
    {
        return substr(md5(uniqid(mt_rand())), 0, 12);
    }
}
