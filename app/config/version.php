<?php

$container->setParameter('version', exec('git rev-parse --short HEAD'));
