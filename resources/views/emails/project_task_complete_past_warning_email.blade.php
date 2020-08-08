Dear {{$task->username}}, <br>
Your Project {{$task->project_name}} {{$task->title}} due date is on {{date('d F', strtotime($task->original_delivery_date))}}.<br>
Please visit <a href="www.vujadetec.com">www.vujadetec.com</a> to get more information about our product & services.
