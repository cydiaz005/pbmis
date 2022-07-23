<?php

namespace App\Http\Livewire\Tables;

use App\Models\Announcement;
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
use function __;
use function auth;
final class AnnouncementTable extends PowerGridComponent
{
    use ActionButton;

    //Messages informing success/error data is updated.
    public bool $showUpdateMessages = true;

   
    public function setUp(): void
    {
        $this->showCheckBox()
            ->showPerPage()
            ->showSearchInput()
            ->showExportOption('download', ['excel', 'csv'])
            ->showSearchInput();
    }
  
   
    public function datasource(): ?Builder
    {
        return Announcement::query()->where("user_id", @Auth::user()->id);
    }

  
    public function relationSearch(): array
    {
        return [];
    }
    public function editx(){
        dd("hello World");
    }

   
    
    public function addColumns(): ?PowerGridEloquent
    {
        return PowerGrid::eloquent()
            ->addColumn('id')
            ->addColumn('subject', function(Announcement $model){
                if(strlen($model->subject) > 20){
                    return substr($model->subject, 0, 19).'...';
                }
                return $model->subject;
            })
            ->addColumn('content', function (Announcement $model) {
                return  substr(strip_tags( $model->content ), 0, 7) . '...'; ;
             })
            ->addColumn('start_date_f', function(Announcement $model) { 
                return Carbon::parse($model->start_date)->toDateString();
            })
            ->addColumn('end_date_f', function(Announcement $model) { 
                return $model->end_date ?  Carbon::parse($model->end_date)->toDateString() : "";
            });
    }

    public function columns(): array
    {
        return [
            Column::add()
                ->title('ID')
                ->field('id')
                ->makeInputRange(),
            Column::add()
                ->title('Subject')
                ->field('subject')
                ->sortable()
                ->searchable()
                ->makeInputText(),
            Column::add()
                ->title('CONTENT')
                ->field('content')
                ->sortable()
                ->searchable()
                ->makeInputText(),

            Column::add()
                ->title('Start Date')
                ->field('start_date_f', 'start_date')
                ->sortable()
                ->searchable()
                ->makeInputText(),

            Column::add()
                ->title('End Date')
                ->field('end_date_f', 'end_date')
                ->sortable()
                ->searchable()
                ->makeInputText(),
               

        ]
;
    }

  
    
    public function actions(): array
    {
       return [
           Button::add('edit')
           ->caption("<i class='fas fa-edit text-primary'></i>")
           ->class('btn btn-relief-success round button-edit')
           
           ->can('announcement_edit')
           ->emit('ActionEventEdit',  ['id' => 'id']),

           Button::add('destroy')
           ->caption("<i class='fas fa-trash text-danger'></i>")
           ->class('btn btn-relief-danger round button-delete')
           ->can('announcement_delete')
           ->emit('ActionEventDelete', ['id' => 'id']),
        ];
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
        $annoucement = Announcement::find($params['id']);
       

        $this->dispatchBrowserEvent('activeEventEdit', ['announcement' => $annoucement]);
    }
 

    public function ActionEventDelete($params): void
    {
        $annoucement = Announcement::find($params['id']);
        $this->dispatchBrowserEvent('activeEvenDelete', ['announcement' => $annoucement]);
    }
   
    public function update (array $data): bool {
		try {
			$updated = Announcement::query()->find($data['id'])?->update(
				[
					$data['content'] => $data['value'],
				]);
		} catch (QueryException $exception) {
			$updated = false;
		}

		return $updated;
	}

   
    public function template (): ?string {
		return null;
	}
}
