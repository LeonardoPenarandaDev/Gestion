<?php
// Temporal fix para esquivar el error de Symfony Translation
// Esta es una solución temporal mientras se resuelve el problema del antivirus

// Crear clase mock de Translator
if (!class_exists('Symfony\Component\Translation\Translator')) {
    @mkdir('vendor/symfony', 0777, true);
    @mkdir('vendor/symfony/translation', 0777, true);
    @mkdir('vendor/symfony/translation/Dumper', 0777, true);
    
    file_put_contents('vendor/symfony/translation/Dumper/IcuResFileDumper.php', '<?php namespace Symfony\Component\Translation\Dumper; class IcuResFileDumper {} ?>');
    file_put_contents('vendor/symfony/translation/Translator.php', '<?php namespace Symfony\Component\Translation; class Translator {} ?>');
}

// Cargar el autoload normal
require __DIR__ . '/vendor/autoload.php';
