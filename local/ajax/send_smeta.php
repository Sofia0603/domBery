<?php
namespace DigitalPlans;

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
require_once $_SERVER["DOCUMENT_ROOT"]."/local/classes/General.php";

class formHandler {
    public function main() {
        General::autoload();

        // Получаем данные формы
        $formData = $_POST['form'] ?? [];
        $name = $_POST['name'] ?? '';
        $phone = $_POST['phone'] ?? '';
        $message = $_POST['message'] ?? '';

        // Создаём лид в CRM через ваш класс B24
        $leadResult = B24::createLead($formData, $name, $phone, $message);

        if ($leadResult) {
            // Если есть PDF (например, путь формируется на основе ID лида)
            $pdfFile = $_SERVER["DOCUMENT_ROOT"]."/upload/smeta_".$leadResult.".pdf";
            $pdfLink = file_exists($pdfFile) ? "/upload/smeta_".$leadResult.".pdf" : null;

            echo json_encode([
                'success' => true,
                'pdf_link' => $pdfLink
            ]);
        } else {
            // Если лид не создался
            echo json_encode(['success' => false]);
        }

        General::autoload(1);
    }
}

$formHandler = new formHandler();
$formHandler->main();
