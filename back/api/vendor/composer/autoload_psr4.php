<?php

// autoload_psr4.php @generated by Composer

$vendorDir = dirname(dirname(__FILE__));
$baseDir = dirname($vendorDir);

return array(
    'Slim\\' => array($vendorDir . '/slim/slim/Slim'),
    'Psr\\Http\\Message\\' => array($vendorDir . '/psr/http-message/src'),
    'Plug\\Framework\\DBAL\\QueryBuilder\\' => array($baseDir . '/src/DBAL/QueryBuilder'),
    'Plug\\Framework\\DBAL\\Connection\\' => array($baseDir . '/src/DBAL/Connection'),
    'Interop\\Container\\' => array($vendorDir . '/container-interop/container-interop/src/Interop/Container'),
    'FastRoute\\' => array($vendorDir . '/nikic/fast-route/src'),
    'Examsys\\Api\\Request\\' => array($baseDir . '/src'),
    'Examsys\\Api\\Orm\\' => array($baseDir . '/src'),
    'Examsys\\Api\\DB\\' => array($baseDir . '/src'),
    'Examsys\\Api\\' => array($baseDir . '/src'),
);
