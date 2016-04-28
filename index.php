<?php
/**
 * @author: Viskov Sergey
 * @date  : 4/27/16
 * @time  : 10:29 AM
 */

    use LTDBeget\vim\Options;
    use LTDBeget\vim\Vim;
    
    require(__DIR__ . '/vendor/autoload.php');

    $vim = new Vim(
        (new Options())->setDiffMode(true)->setReadonlyMode(true)
    );
    $vim->addFileContent('a.txt', 'some text')->addFileContent('b.txt', 'some text2')->execute();


    $vim = new Vim;
    $vim->addFileContent('a.txt', 'some text')->execute();
    $vim->getContent('a.txt');
