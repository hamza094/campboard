<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Project;

use Auth;

class ProjectsController extends Controller
{
    
    public function index(){
        
        $projects=auth()->user()->accesibleProjects();
        return view('projects.index',compact('projects'));
    }
    
    public function create(){
        return view('projects.create');
    }
    
    
    public function store(Request $request){
        
         $this->validate($request, [
           'title'=>'required',
           'description'=>'required',
           'notes'=>'max:255'
            
        ]);
              
        $project = Project::create([
                'user_id'=>auth()->id(),
                'title'=>request('title'),
                'slug'=>str_slug($request->title), 
                'description'=>request('description'),
                'notes'=>request('notes')
                ]);
        
        if ($tasks = request('tasks')) {
            $project->addTasks($tasks);
        }
        
        if(request()->wantsJson()){
            return ['message'=>$project->path()];
        }
        
        return redirect($project->path());
    }
    
      
    public function show(Project $project)
    {
        $this->authorize('update',$project);
        return view('projects.show',compact('project'));
    }
    
      public function update(Project $project){
        $this->authorize('update',$project);
       $project->update($this->validateRequest());
    }
    
    public function edit(Project $project){
        return view('projects.edit',compact('project'));
    }
    
    public function destroy(Project $project){
        $this->authorize('manage',$project);
        $project->delete();
        return redirect('/projects');
    }
    
    protected function validateRequest(){
        return request()->validate([
        'title'=>'sometimes|required',
           'description'=>'sometimes|required',
           'notes'=>'nullable'    
        ]);
        
    }
}
