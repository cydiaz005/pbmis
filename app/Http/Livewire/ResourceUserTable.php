<?php

namespace App\Http\Livewire;

use App\Models\ResourceAccount;
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
final class ResourceUserTable extends PowerGridComponent
{
    use ActionButton;

    //Messages informing success/error data is updated.
    public bool $showUpdateMessages = true;

    /*
    |--------------------------------------------------------------------------
    |  Features Setup
    |--------------------------------------------------------------------------
    | Setup Table's general features
    |
    */
    public function setUp(): void
    {
        $this->showCheckBox()
            ->showPerPage()
            ->showSearchInput()
            ->showExportOption('download', ['excel', 'csv']);
    }

    /*
    |--------------------------------------------------------------------------
    |  Datasource
    |--------------------------------------------------------------------------
    | Provides data to your Table using a Model or Collection
    |
    */
    public function datasource(): ?Builder
    {
       $user = @Auth::user()->roles->first();
        $resource =  ResourceAccount::query();
        if($user){
            if($user->id == 1){
                return $resource;
            }else {
                return  $resource->where("role_id",$user->id )->orWhere("creator_id", $user->id );
            }
        }
        return $resource;
    }

    /*
    |--------------------------------------------------------------------------
    |  Relationship Search
    |--------------------------------------------------------------------------
    | Configure here relationships to be used by the Search and Table Filters.
    |
    */

    /**
     * Relationship search.
     *
     * @return array<string, array<int, string>>
     */
    public function relationSearch(): array
    {
        return [];
    }

    /*
    |--------------------------------------------------------------------------
    |  Add Column
    |--------------------------------------------------------------------------
    | Make Datasource fields available to be used as columns.
    | You can pass a closure to transform/modify the data.
    |
    */
    public function addColumns(): ?PowerGridEloquent
    {
        return PowerGrid::eloquent()
            ->addColumn('id')
            ->addColumn('resource_account', function(ResourceAccount $model){
                return '<div class="d-flex flex-column w-100 border-top p-1">
                <div class="d-flex w-100 justify-content-start align-items-center " >
                    <i class="fa fa-user" aria-hidden="true"></i>
                    <span class="ml-1">'.$model->username.'</span>
                    <span class="ml-1 user-clip" onclick="userClip(\''.$model->username.'\')"  style="color: #03c2fc; cursor: pointer" id="'.$model->username.'" >copy</span>
                </div>
                <div class="mt-1 d-flex w-100 justify-content-start align-items-center">
                    <i class="fa fa-key" aria-hidden="true"></i>
                    <span class="ml-1">'.str_repeat("*", strlen(substr($model->password, 0, 8))).'</span>
                    <span class="ml-1 password-clip" onclick="passwordClip(\''.$model->password.'\')" style="color: #03c2fc; cursor: pointer" id="'.$model->password.'" >copy</span>
                </div>
            </div>'; 
            })
           
            ->addColumn('created_at_formatted', function(ResourceAccount $model) { 
                return Carbon::parse($model->created_at)->format('d/m/Y H:i:s');
            });
          
    }

    /*
    |--------------------------------------------------------------------------
    |  Include Columns
    |--------------------------------------------------------------------------
    | Include the columns added columns, making them visible on the Table.
    | Each column can be configured with properties, filters, actions...
    |
    */

     /**
     * PowerGrid Columns.
     *
     * @return array<int, Column>
     */
    public function columns(): array
    {
        return [
            Column::add()
                ->title('ID')
                ->field('id')
                ->makeInputRange(),
            Column::add()
                ->title('Resource Account')
                ->field('resource_account', 'username')
                ->makeInputText(),
            Column::add()
                ->title('CREATED AT')
                ->field('created_at_formatted', 'created_at')
                ->searchable()
                ->sortable()
                ->makeInputDatePicker('created_at'),

            

        ]
;
    }

    /*
    |--------------------------------------------------------------------------
    | Actions Method
    |--------------------------------------------------------------------------
    | Enable this section only when you have defined routes for these actions.
    |
    */

     /**
     * PowerGrid ResourceAccount action buttons.
     *
     * @return array<int, \PowerComponents\LivewirePowerGrid\Button>
     */

    
    public function actions(): array
    {
       $buttonAll = [
           Button::add('edit')
           ->caption("<i class='fas fa-edit text-primary'></i>")
           ->class('btn btn-relief-success round button-edit')
           ->can('edit')
           ->emit('ActionEventEdit',  ['id' => 'id']),
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
        return $isTrue ? $buttonAll : [];
    }
    
    protected function getListeners()
    {
        return array_merge(
            parent::getListeners(), [
                'eventX',
                'eventY',
                'ActionEventEdit',
                'ActionEventDelete',
            ]);
    }
    public function ActionEventEdit($params): void
    {   
        $resouceAccount = ResourceAccount::where("id", $params['id'])->first();
        $this->dispatchBrowserEvent('ActionEventEdit', ['resouceAccount' => $resouceAccount]);
    }
 

    public function ActionEventDelete($params): void
    {
        $resouceAccount = ResourceAccount::where("id", $params['id'])->first();
        $this->dispatchBrowserEvent('ActionEventDelete', ['resouceAccount' => $resouceAccount]);
    }
    
}
