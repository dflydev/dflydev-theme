<?php

$data = json_decode(file_get_contents(__DIR__.'/../composer.json'), true);
if (!isset($data['provide'])) {
   $data['provide'] = array();
}
$data['provide']['dflydev/psr0-resource-locator-implementation'] = '1.0.0-alpha';
file_put_contents(__DIR__.'/composer.json', json_encode($data));
