<?php

namespace App\Http\Livewire;

use App\Models\Resources;
use Illuminate\Support\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\Builder;
use PowerComponents\LivewirePowerGrid\Button;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridEloquent;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use PowerComponents\LivewirePowerGrid\Traits\ActionButton;
use Auth;
final class VidResourceTable extends PowerGridComponent
{
    use ActionButton;

    //Messages informing success/error data is updated.
    public bool $showUpdateMessages = true;

    
    public function setUp(): void
    {
        $this
            ->showPerPage()
            ->showSearchInput();
    }

 
    public function datasource(): ?Builder
    {
        $user = @Auth::user()->roles->first();
       $resource = Resources::query()
       ->leftJoin("resource_accesses" ,"resource_accesses.resource_id", "resources.id")
      ->leftJoin("resource_accounts", "resource_accounts.id", "resource_accesses.access_id")
       ->where("status", "vid")
       ->groupBy("resources.id")
       ->select([
            'resources.*',
            "resource_accounts.username as username",
            "resource_accounts.password as password",
            "resource_accounts.role_id as role"
        ]);
       if($user){
            if($user->id == 1){
                return $resource
                ;
            }else {
                return  $resource->whereRelation("resourceAccount", function($access) use($user){
                   
                   $access->whereRelation("access", function($role) use($user) {
                    $role->where("role_id", @$user->id)->orWhere("creator_id", $user->id);
                   });
                });
                return $resource
                ;
            }
        }

      
       return  $resource;
    }


    public function relationSearch(): array
    {
        return [];
    }

    public function addColumns(): ?PowerGridEloquent
    {
        return PowerGrid::eloquent()
            ->addColumn('resource_id', function(Resources $model){
                return  $model->id;
            })
            ->addColumn('title', function(Resources $model){
                return '<div style="width: 150px">
                <p> '.strlen($model->title) > 50 ? substr($model->title, 0, 50).'...': $model->title.'</p>
            </div>';
            })
            ->addColumn("description", function(Resources $model){
                return '<div style="width: 150px">
                    <p>'.strlen($model->description) > 50 ? substr($model->description, 0, 50).'...': $model->description.'</p>
                </div>';
            })
            ->addColumn("link", function(Resources $model){
                return 
                '<div style="width: 100px">
                     <a target="_blank" class="hover text-primary" href="'.$model->link.'">Visit This Link</a>
                </div>';
            })
            ->addColumn("resouce_accounts", function (Resources $model){
                $div = '<div class="d-flex flex-column w-100 justify-content-center align-items-center">';
                $tapangLa = Resources::where("id", $model->id)->first();
               
                $user = Auth::user()->roles->first();
        
                
                foreach ( @$tapangLa->resource_holder  as $key => $value) {
                        if(@$user->id == 1){
                            $div  = $div.'
                        <div class="d-flex flex-column w-100 border-top p-1">
                            <div class="d-flex w-100 justify-content-start align-items-center " >
                                <i class="fa fa-user" aria-hidden="true"></i>
                                <span class="ml-1">'.$value->username.'</span>
                                <span class="ml-1 user-clip" onclick="userClip(\''.$value->username.'\')"  style="color: #03c2fc; cursor: pointer" id="'.$value->username.'" >copy</span>
                            </div>
                            <div class="mt-1 d-flex w-100 justify-content-start align-items-center">
                                <i class="fa fa-key" aria-hidden="true"></i>
                                <span class="ml-1">'.str_repeat("*", strlen(substr($value->password, 0, 8))).'</span>
                                <span class="ml-1 password-clip" onclick="passwordClip(\''.$value->password.'\')" style="color: #03c2fc; cursor: pointer" id="'.$value->password.'" >copy</span>
                            </div>
                        </div>
                        ';
                        }else if (@$user->id == $value->role){
                            $div  = $div.'
                            <div class="d-flex flex-column w-100 border-top p-1">
                                <div class="d-flex w-100 justify-content-start align-items-center " >
                                 <i class="fa fa-user" aria-hidden="true"></i>
                                 <span class="ml-1">'.$value->username.'</span>
                                 <span class="ml-1 user-clip" onclick="userClip(\''.$value->username.'\')" style="color: #03c2fc; cursor: pointer" id="'.$value->username.'" >copy</span>
                                </div>
                                <div class="mt-1 d-flex w-100 justify-content-start align-items-center">
                                    <i class="fa fa-key" aria-hidden="true"></i>
                                    <span class="ml-1">'.str_repeat("*", strlen(substr($value->password, 0, 8))).'</span>
                                    <span class="ml-1 password-clip" onclick="passwordClip(\''.$value->password.'\')"  style="color: #03c2fc; cursor: pointer" id="'.$value->password.'" >copy</span>
                                </div>
                            </div>
                            ';
                        }
                }
                
                return  $div.'</div>';
            })
            ->addColumn('created_at_formatted', function(Resources $model) { 
                return Carbon::parse($model->created_at)->format('d/m/Y H:i:s');
            })
            ->addColumn('updated_at_formatted', function(Resources $model) { 
                return Carbon::parse($model->updated_at)->format('d/m/Y H:i:s');
            });
    }
    public function columns(): array
    {
        return [
            Column::add()
                ->title('ID')
                ->field('resource_id', "resources.id")
                ->makeInputText(),
             Column::add()
                ->title('Title')
                ->field('title', "resources.title")
                ->makeInputText(),
                Column::add()
                ->title('Description')
                ->field('description',  "resources.description")
                ->makeInputText(),
                Column::add()
                ->title('Resource Account')
                ->field('resouce_accounts',  "resource_accounts.username")
                ->makeInputText(),
                Column::add()
                ->title('link')
                ->field('link', "resources.description")
                ->makeInputText(),               
            Column::add()
                ->title('CREATED AT')
                ->field('created_at_formatted', 'resources.created_at')
                ->searchable()
                ->sortable()
                ->makeInputDatePicker('created_at'),

        ]
;
    }

    
    
    public function actions(): array
    {
       $buttonAll =  [
        Button::add('edit')
        ->caption("<i class='fas fa-edit text-primary'></i>")
        ->class('btn btn-relief-success round button-edit')
        ->can('edit')
        ->emit('ActionEventEdit',  ['id' => 'id']),
        Button::add('view')
            ->caption("<i class='fas fa-eye text-primary'></i>")
            ->class('btn btn-relief-success round button-edit')
            ->can('view')
            ->emit('ActionView',  ['id' => 'id']),
        Button::add('destroy')
        ->caption("<i class='fas fa-trash text-danger'></i>")
        ->class('btn btn-relief-danger round button-delete')
        ->can('delete')
        ->emit('ActionEventDelete', ['id' => 'id']),
        ];
        $isTrue = false;
        $user = Auth::user();

        foreach ($user->roles as $key => $value) {
            if($value->id == 1){
                $isTrue = true;
            }
        }
        return $isTrue ? $buttonAll : [$buttonAll[1]];
    }
    
    protected function getListeners()
    {
        return array_merge(
            parent::getListeners(), [
                'eventX',
                'eventY',
                'ActionEventEdit',
                'ActionEventDelete',
                'ActionView'
            ]);
    }
    public function ActionEventEdit($params): void
    {   
        $resouceAccount = Resources::where("id", $params['id'])->with("resourceAccount")->first();
        $this->dispatchBrowserEvent('ActionEventEdit', ['resource' => $resouceAccount]);
    }
    public function ActionView($params):void
    {
        $resouceAccount = Resources::where("id", $params['id'])->with("resourceAccount")->first();
        $this->dispatchBrowserEvent('ActionView', ['resource' => $resouceAccount]);  
    }

    public function ActionEventDelete($params): void
    {
        $resouceAccount = Resources::where("id", $params['id'])->with("resourceAccount")->first();
        $this->dispatchBrowserEvent('ActionEventDelete', ['resource' => $resouceAccount]);
    }
   

}
