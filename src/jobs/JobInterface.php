<?php

namespace graychen\yii2\queue\backend\jobs;

Interface JobInterface
{
    public function getName();
    public function getCatalog();
    public function getDescription();

}
