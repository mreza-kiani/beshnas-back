<?php
/**
 * Created by PhpStorm.
 * User: arash
 * Date: 10/26/16
 * Time: 12:00 PM
 */

namespace App\Http\Controllers;


use App\Models\Task;
use App\Models\TaskBoard;
use App\Models\TaskDependency;
use Davibennun\LaravelPushNotification\Facades\PushNotification;
use Symfony\Component\Process\Process;

class TestController extends Controller
{
    public function getIndex()
    {
        PushNotification::app('HinzaAutomationAndroid')
            ->to("dyx8kLPvSAQ:APA91bEHqWFebLFVC3UXjU0j09OSzMMvoxjVVL_pUf5MbZlMnoPruBUVjsIQ3USgftqjhfdy9byReTMFKUFSTLmKr6nYxTXVIMQA_3HyCs4zBO1xEhPbFz351NLsxw7NKgNtDIDK74mC")
            ->send('Hello World, i`m a push message');
    }

    public function getUpdateApplication()
    {
        $process = new Process("cd .. && composer update");
        $process->start();
        echo $process->getOutput();
        return "salam";
    }

    public function getFixFollowers(){
        foreach (Task::all() as $task){

        }
    }

/*    public function getBaseDataForTaskBoards()
    {
        foreach (Task::all() as $task) {
            if($task->taskBoard == null){
                $taskBoard = new TaskBoard();
                $taskBoard->title = '';
                $taskBoard->save();
                $task->addTaskToTaskBoard($taskBoard->id);
                echo "task processed";
            }
        }
    }*/
}