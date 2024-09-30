<?php
header("Content-Type: text/xml");

$xmlFile = __DIR__ . "/tasks.xml";

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (file_exists($xmlFile)) {
        readfile($xmlFile);
    } else {
        echo "<tasks></tasks>";
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = isset($_POST['title']) ? $_POST['title'] : '';

    if (!empty($title)) {
        $xml = simplexml_load_file($xmlFile);
        $newTask = $xml->addChild('task');
        $newTask->addAttribute('id', time());
        $newTask->addChild('title', htmlspecialchars($title));
        $newTask->addChild('status', 'incomplete');

        $xml->asXML($xmlFile);

        echo $xml->asXML();
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    parse_str(file_get_contents("php://input"), $deleteData);
    $taskId = isset($deleteData['id']) ? $deleteData['id'] : null;

    if ($taskId !== null) {
        $xml = simplexml_load_file($xmlFile);
        foreach ($xml->task as $task) {
            if ((string) $task['id'] === $taskId) {
                unset($task[0]);
                break;
            }
        }
        $xml->asXML($xmlFile);
        echo $xml->asXML();
    }
}

