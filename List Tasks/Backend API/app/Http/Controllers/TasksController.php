<?php

namespace App\Http\Controllers;

use Auth;
use Exception;
use Validator;
use App\Models\Tasks;
use Illuminate\Http\Request;
use App\Traits\ResponseTrait;
use App\Traits\Requests\TestAuth;
use App\Http\Controllers\Controller;
use App\Traits\validator\ValidatorTrait;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

class TasksController extends Controller
{
    use ResponseTrait , TestAuth , ValidatorTrait;
  


    /**
     * todo return all tasks on this categories.
     */
    public function index(Request $request){
        $task = Tasks::where("cat_id",$request->catId)->with('categories')->get();
        return $this->returnData("tasks",$task);
    }


   /**
     * todo Store a new tasks in this list.
     */
    public function store(Request $request)
    {
        // ! valditaion
        $rules = $this->rulesStoreTask();    
        $validator = $this->validate($request,$rules);
        if($validator !== true){return $validator;}
        
        // todo Add New Task //    
        $task = Tasks::create([
            'title' => $request->title,
            'description' => $request->description,
            'status' => strtolower($request ->status),
            'due_dates' => $request->due_dates,
            'cat_id' => $request->cat_id,
            'user_id' => auth()->user()->id,
        ]);

        if($task){return $this->returnSuccessMessage("Create Task Successfully .");}
        else{return $this->returnError('T001','Some Thing Wrong .');}
     }



    /**
     * todo Show the tasks i want edit it.
     */
    public function edit(Request $request)
    {
      $task = Tasks::where("user_id",auth()->user()->id)->where("id",$request->taskId)->get();
      return $this->returnData("tasks",$task);

    }



    /**
     * todo Update the tasks.
     */
    public function update(Request $request)
    {

      // ! valditaion
      $rules = $this->rulesUpdateTask();
      $validator = $this->validate($request,$rules);
      if($validator !== true){return $validator;}
      
      $task = Tasks::find($request->taskId);
      $task->update([
            'title' => $request->title,
            'description' => $request->description,
            'status' => strtolower($request ->status),
            'due_dates' => $request->due_dates,
            'cat_id' => $request->cat_id,
          ]); 
      $msg = " Update Task : ".$task->title." successfully .";
      return $this->returnSuccessMessage($msg); 

    }



    /**
     * todo Remove the Tasks in trasheing.
     */
    public function destroy(Request $request)
    {

      // ! valditaion
      $rules = ["taskId"=> "required|exists:tasks,id",];
      $validator = $this->validate($request,$rules);
      if($validator !== true){return $validator;}

      // ? soft delete task //
      $task = Tasks::with(['user' => function ($query) {
      $query->select('id','name');  }]) //? Select only 'id' and 'name' columns from the users table
      ->find($request->taskId);

      $msg = " delete task : ".$task->title . " , sir : " .$task->user->name . "  " ."successfully .";
      if($task){$task->delete();return $this->returnSuccessMessage($msg);}
      else{return $this->returnError("T404" , "This tasks not fount");}

    }



    /**
     * todo Filtering the Tasks in this categories.
     */
    public function filter(Request $request)
    {
      $task = Tasks::where("user_id",auth()->user()->id)->where("status",strtolower($request->filter))->where("cat_id",$request->catId)->get();
      return $this->returnData("tasks",$task);
    }



    /**
     * todo return all categories its trashed .
     */
    public function restoreindex()
    {
       $tasks = Tasks::where('user_id',auth()->user()->id)->onlyTrashed()->with('user','categories')->get();
       return $this->returnData("tasksTrashed",$tasks);
    }



   /**
     * todo restore the tasks on this categories.
     */
    public function restore(Request $request)
    {
       // ! valditaion
       $rules = ['taskId' => 'required|exists:tasks,id',];
       $validator = $this->validate($request,$rules);
       if($validator !== true){return $validator;}

       $task = Tasks::withTrashed()->find($request->taskId);
       $this->checkTasks($task);  //? check its your take or not & found tasks
       $task->restore();
       return $this->returnSuccessMessage("Restore Tasks Successfully .");
    }



    /**
     * todo Autocomplete Search the specified resource from storage.
     */
    public function autocolmpletesearch(Request $request)
    {
        // ! valditaion
        $rules = ["query" => "required"];
        $validator = $this->validate($request,$rules);
        if($validator !== true){return $validator;}

        // ? search by title || description // 
        $query = $request->get('query');
        $filterResult = Tasks::where('user_id', auth()->user()->id)
            ->where(function ($q) use ($query) {
            $q->where('title', 'LIKE', '%'.$query.'%')
            ->orWhere('description', 'LIKE', '%'.$query.'%');})
            ->get();
        return $this->returnData("tasks",$filterResult);
    
    }
}
