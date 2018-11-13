<?php
define("DOCROOT",$_SERVER["DOCUMENT_ROOT"]);//корневая папка
include DOCROOT.'/function.php';
//основа в индекс файле, подключаем файлик с функциями


function getRootPath($path='/'){
return DOCROOT."$path";
}  // краткий способ подключить файл, теперь можно писать
// include getRootPath("/template.php")

function renderTemplate($template,$content){//template-имя шаблона, content-контент
    ob_start();
    include getRootPath("/templates/".$template.".php");
    return ob_get_clean();
    //tamplates-папка с шаблонами и к ней клеем названия файла шаблона которое примет функция
}
function renderView($viev){
    ob_start();
    include getRootPath("/views/".$viev.".php");
    return ob_get_clean();
}
$content=renderView("content");
$result=renderTemplate("template",$content);//берем шаблон и вставляем в него вьюшку

function renderViewwithTemplate($view,$template){
    $content=renderView($view);
    return renderTemplate($template,$content);
}//тоже самое но уже в функции

//функции каждая из которой соответствует заданой странице
function mainPage(){
    echo renderTemplate($template,$content);
}
//логика загрузки
$page=@$_GET["page"];
if (empty($page)||$page=="main"){
    $logicfile="main";
    $pagefunc="main";
}

elseif ($page=="contacts"){
    $logicfile="main";
    $pagefunc="contacts";
}


// функцию указываем в файле main
function mainPage(){
    echo renderViewwithTemplate("content","template");
}
function contactPage(){
    echo renderViewwithTemplate("contacts","template");

}

//запустить весь механизм
function loadPage($logicfile,$pagefunc){
    include getRootPath("/pagelogic/".$logicfile."php");
    call_user_func($pagefunc."Page");
}//путь к файлу в папке pagelogic, вызывает функции указаные выше
//вызов ф файле индекс
loadPage($logicfile,$pagefunc);

