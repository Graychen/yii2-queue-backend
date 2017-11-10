<?php

namespace graychen\yii2\queue\backend\jobs;

interface JobInterface
{
    public function getName();
    public function getCatalog();
    public function getDescription();
}
