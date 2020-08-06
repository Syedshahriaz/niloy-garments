<h2>Niloy Garments</h2>
Dear {{$task->username}}: <br>
Your task has {{$day_left}} days left to complete <br>
Please complete the task in due date <br>
Task Details <br>

<table>
    <tr>
        <td>Project: </td>
        <td>{{$task->project_name}}</td>
    </tr>
    <tr>
        <td>Task: </td>
        <td>{{$task->title}}</td>
    </tr>
    <tr>
        <td>Original Due Date: </td>
        <td>{{date('l, F d, Y', strtotime($task->original_delivery_date))}}</td>
    </tr>
    <tr>
        <td>Username: </td>
        <td>{{$task->username}}</td>
    </tr>
    <tr>
        <td>User ID: </td>
        <td>{{$task->unique_id}}</td>
    </tr>
</table>
