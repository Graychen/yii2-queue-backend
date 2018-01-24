<?php

namespace graychen\yii2\queue\backend\models;

use Yii;
use yii\base\Model;
use yii\di\Instance;
use yii\queue\serializers\PhpSerializer;
use yii\queue\serializers\Serializer;

/**
 * Class RedisQueue
 * @package graychen\yii2\queue\backend\models
 * @property integer $total
 * @property integer $done
 * @property integer $waiting
 * @property integer $delayed
 * @property integer $reserved
 */
class RedisQueue extends Model
{
    /**
     * @see Queue::isWaiting()
     */
    const STATUS_WAITING = 1;
    /**
     * @see Queue::isReserved()
     */
    const STATUS_RESERVED = 2;
    /**
     * @see Queue::isDone()
     */
    const STATUS_DONE = 3;
    /**
     * @var Serializer|array
     */
    public $serializer = PhpSerializer::class;

    public $prefix;

    public function __construct(array $config = [])
    {
        $this->getPrefix();
        $this->serializer = Instance::ensure($this->serializer, PhpSerializer::class);
        parent::__construct($config);
    }

    public function setPrefix()
    {
        $this->prefix = Yii::$app->queue->channel;
    }


    public function getPrefix()
    {
        $this->setPrefix();
        return $this->prefix;
    }

    public function setWaiting()
    {
        $this->waiting = Yii::$app->queue->redis->llen("$this->prefix.waiting");
    }

    public function getWaiting()
    {
        $this->setWaiting();
        return $this->waiting;
    }

    public function setDelayed()
    {
        $this->delayed = Yii::$app->queue->redis->zcount("$this->prefix.delayed", '-inf', '+inf');
    }

    public function getDelayed()
    {
        $this->setDelayed();
        return $this->delayed;
    }

    public function setReserved()
    {
        $this->reserved = Yii::$app->queue->redis->zcount("$this->prefix.reserved", '-inf', '+inf');
    }

    public function getReserved()
    {
        $this->setReserved();
        return $this->reserved;
    }

    public function setTotal()
    {
        $this->total = Yii::$app->queue->redis->get("$this->prefix.message_id");
    }

    public function getTotal()
    {
        $this->setTotal();
        return $this->total;
    }

    public function setDone()
    {
        $this->done = $this->total - $this->waiting - $this->delayed - $this->reserved;
    }

    public function getDone()
    {
        $this->setDone();
        return $this->done;
    }

    public function getWorkInfo()
    {
        $workers = [];
        $data = Yii::$app->queue->redis->clientList();
        foreach (explode("\n", trim($data)) as $line) {
            $client = [];
            foreach (explode(' ', trim($line)) as $pair) {
                list($key, $value) = explode('=', $pair, 2);
                $client[$key] = $value;
            }

            if (isset($client['name']) && strpos($client['name'], Yii::$app->queue->channel . '.worker') === 0) {
                $workers[$client['name']] = $client;
            }
        }
        return $workers;
    }

    public function getWaitContent()
    {
        $waitContent = Yii::$app->queue->redis->lrange("$this->prefix.waiting", 0, 10);
        return $waitContent;
    }

    public function getReservedContent()
    {
        return Yii::$app->queue->redis->zrange("$this->prefix.reserved", 0, -1);
    }

    public function getDelayedContent()
    {
        return Yii::$app->queue->redis->zrange("$this->prefix.delayed", 0, -1);
    }

    public function getMessage($id)
    {
        $message = Yii::$app->queue->redis->hget("$this->prefix.messages", $id);
        $strMessage = ltrim($message, '300;');
        return $this->serializer->unserialize($strMessage);
    }

    public function getAttempt($id)
    {
        $attempt = Yii::$app->queue->redis->hget("$this->prefix.attempt", $id);
        $strAttempt = ltrim($attempt, '300;');
        return $this->serializer->unserialize($strAttempt);
    }


    /** 得到执行时间
     * @param $id todo
     */
    public function getExecutionTime($id)
    {
    }

    /** 得到队列的状态
     * @param $id
     * @return int
     */
    public function status($id)
    {
        if (Yii::$app->queue->redis->hexists("$this->prefix.attempts", $id)) {
            return self::STATUS_RESERVED;
        } elseif (Yii::$app->queue->redis->hexists("$this->prefix.messages", $id)) {
            return self::STATUS_WAITING;
        } else {
            return self::STATUS_DONE;
        }
    }
}
