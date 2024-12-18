<?php

namespace Geekbrains\Application1\Application;

use Exception;
use Twig\Loader\FilesystemLoader;
use Twig\Environment;

class Render {

    private string $viewFolder = '/src/Domain/Views/';
    private FilesystemLoader $loader;
    private Environment $environment;


    public function __construct(){
        $this->loader = new FilesystemLoader($_SERVER['DOCUMENT_ROOT'] . $this->viewFolder);
        $this->environment = new Environment($this->loader, [
            //'cache' => $_SERVER['DOCUMENT_ROOT'].'/cache/', отключили кэш в папке /cache
        ]);
    }

    /*public function renderPage(string $contentTemplateName = 'page-index.tpl', array $templateVariables = []) {
        $template = $this->environment->load('main.tpl');
        
        $templateVariables['content_template_name'] = $contentTemplateName;
 
        return $template->render($templateVariables);
    }

    public static function renderExceptionPage(Exception $exception): string {
        $contentTemplateName = "error.tpl";
        $viewFolder = '/src/Domain/Views/';

        $loader = new FilesystemLoader($_SERVER['DOCUMENT_ROOT'] . $viewFolder);
        $environment = new Environment($loader, [
            'cache' => $_SERVER['DOCUMENT_ROOT'].'/cache/',
        ]);

        $template = $environment->load('main.tpl');
        
        $templateVariables['content_template_name'] = $contentTemplateName;
        $templateVariables['error_message'] = $exception->getMessage();
 
        return $template->render($templateVariables);
    }*/

    private function renderTemplate(string $templateName, array $templateVariables): string {
        $template = $this->environment->load('main.tpl');
        $templateVariables['content_template_name'] = $templateName;
        return $template->render($templateVariables);
    }

    /*Метод renderTemplate принимает имя шаблона и массив переменных, а затем рендерит шаблон main.tpl с предоставленными переменными.Методы renderPage и renderExceptionPage теперь просто вызывают метод renderTemplate с соответствующими параметрами.Это улучшение позволяет избежать дублирования кода и сделать его более поддерживаемым.*/
    
    public function renderPage(string $contentTemplateName = 'page-index.tpl', array $templateVariables = []): string {
        //return $this->renderTemplate($contentTemplateName, $templateVariables);
        $template = $this->environment->load('main.tpl');
        
        $templateVariables['content_template_name'] = $contentTemplateName;
        return $template->render($templateVariables);
    }
    
    public static function renderExceptionPage(Exception $exception): string {
        $contentTemplateName = "error.tpl";
        $templateVariables = ['error_message' => $exception->getMessage()];
        $loader = new FilesystemLoader($_SERVER['DOCUMENT_ROOT'] . '/src/Domain/Views/');
        $environment = new Environment($loader, [
            'cache' => $_SERVER['DOCUMENT_ROOT'].'/cache/',
        ]);
        $renderer = new self();
        $renderer->environment = $environment;
        return $renderer->renderTemplate($contentTemplateName, $templateVariables);
    }
}