<?php
//

$loader = new Twig_Loader_Filesystem('templates');
$twig = new Twig_Environment($loader, array(
    'debug' => true,
    'cache' => 'tmp/cache',
    'auto_reload' => true
));
$filter = new Twig_SimpleFilter('my', function ($string) {
    return ((int)$string == 0) ? 'в работе' : 'закрыто';
});
$twig->addFilter($filter);
$filter = new Twig_SimpleFilter('my_st', function ($string) {
    switch ((int)$string) {
        case  0:
            return 'Ожидает ответа';
        case  1:
            return 'Опубликован';
        case  2:
            return 'Скрыт';

        default:
            return 'Ошибка';
    }
});
$twig->addFilter($filter);

$filter = new Twig_SimpleFilter('my_sti', function ($string) {
    switch ((int)$string) {
        case  2:
            return 'Опубликовать';
        case  1:
            return 'Скрыть';

        default:
            return 'Ошибка';
    }
});
$twig->addFilter($filter);

$twig->addExtension(new Twig_Extension_Debug());
return $twig;